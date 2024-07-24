<?php

namespace App\Services;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Helpers\Utils;
use App\Interfaces\Repository\AccountRepository;
use App\Interfaces\Repository\PropertyRepository;
use App\Interfaces\Repository\TransactionRepository;
use App\Interfaces\Service\TransactionService;
use App\Models\Property;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionServiceImpl implements TransactionService
{
    private $transactionRepository;
    private $propertyRepository;
    private $accountRepository;

    public function __construct(
        TransactionRepository $transactionRepository,
        PropertyRepository $propertyRepository,
        AccountRepository $accountRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->propertyRepository = $propertyRepository;
        $this->accountRepository = $accountRepository;
    }

    public function getTransactions(array $input, bool $paginate = false): Result
    {
        return $this->transactionRepository->getTransactions($input, $paginate);
    }

    /**
     *
     * @param array $input
     * @return Result
     */
    public function saveTransaction(array $input): Result
    {
        try {
            return DB::transaction(function () use ($input) {
                $input['administrative_tax'] = ctype_digit($input['administrative_tax'])  ?  strval($input['administrative_tax'] . '.00') : $input['administrative_tax'];
                $input['final_value'] =  ctype_digit($input['final_value'])  ?  strval($input['final_value'] . '.00') : $input['final_value'];
                $input['iptu_value'] =  ctype_digit($input['iptu_value'])  ?  strval($input['iptu_value'] . '.00') : $input['iptu_value'];
                $input['property_value'] =  ctype_digit($input['property_value'])  ?  strval($input['property_value'] . '.00') : $input['property_value'];
                $input['penalty_value'] =  ctype_digit($input['penalty_value'])  ?  strval($input['penalty_value'] . '.00') : $input['penalty_value'];
                $input['other_transfers'] =  ctype_digit($input['other_transfers'])  ?  strval($input['other_transfers'] . '.00') : $input['other_transfers'];
                $input['insurance_value'] =  ctype_digit($input['insurance_value'])  ?  strval($input['insurance_value'] . '.00') : $input['insurance_value'];
                $input['created_at'] = Carbon::now();
                $result = $this->transactionRepository->saveTransaction($input);
                if (!$result->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'TransactionService > saveTransaction > saveTransaction',
                            'Erro ao salvar transação',
                            422,
                        )
                    );

                $id_transaction = $result->getData();
                if ($input['transaction_type'] == Transaction::TRANSACTION_RENT) { // aluguel
                    $result_installment = $this->generateInstallments($input, $id_transaction, Transaction::TRANSACTION_RENT);
                    if (!$result_installment->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'TransactionService > saveTransaction > generateInstallments',
                                'Erro ao gerar parcelas',
                                422,
                            )
                        );

                    $result_property = $this->propertyRepository->updateProperty(['status' => Property::RENTED, 'id_transaction' => $id_transaction, 'id_renter' => $input['id_renter']], $input['id_property']);
                    if (!$result_property->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'TransactionService > saveTransaction > updateProperty',
                                'Erro atualizar o status do imóvel',
                                422,
                            )
                        );

                    if ($input['modality'] == Transaction::MODALITY_DEPOSIT) {
                        $result_account_pay = $this->generateAccountReceiveDeposit($input, $id_transaction);
                        if (!$result_account_pay->isSuccess())
                            return Result::error(
                                new ErrorApplication(
                                    'TransactionService > saveTransaction > generateAccountReceiveDeposit',
                                    'Erro ao gerar conta à receber',
                                    422,
                                )
                            );
                    }
                } else if ($input['transaction_type'] == Transaction::TRANSACTION_SALE) {
                    $result_installment = $this->generateInstallments($input, $id_transaction, Transaction::TRANSACTION_SALE);
                    if (!$result_installment->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'TransactionService > saveTransaction > generateInstallments',
                                'Erro ao gerar parcelas',
                                422,
                            )
                        );
                    $result_property = $this->propertyRepository->updateProperty(['status' => Property::SOLD], $input['id_property']);
                    if (!$result_property->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'TransactionService > saveTransaction > updateProperty',
                                'Erro atualizar o status do imóvel',
                                422,
                            )
                        );
                }
                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionService > saveTransaction',
                    'Erro ao salvar transação: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateTransaction(array $input, string $id_transaction): Result
    {
        return $this->transactionRepository->updateTransaction($input, $id_transaction);
    }

    public function cancelTransaction(array $input, string $id_transaction): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_transaction) {

                $result_property = $this->propertyRepository->getPropertyById($input['id_property']);
                if (!$result_property->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'TransactionService > cancelTransaction > getInstallmentsByIdTransaction',
                            'Erro ao buscar as parcelas restantes',
                            422,
                        )
                    );
                $property = $result_property->getData();

                $result_update_property = $this->propertyRepository->updateProperty(['status' => 1, 'id_renter' => null], $property['id']);
                if (!$result_update_property->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'TransactionService > cancelTransaction > updateProperty',
                            'Erro ao atualizar o status do imóvel',
                            422,
                        )
                    );


                if ($input['generate_penalty'] && $input['total_remaining_installments'] > 0) {
                    $result = $this->accountRepository->getInstallmentsByIdTransaction($id_transaction, ['status' => 1]);

                    if (!$result->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'TransactionService > cancelTransaction > getInstallmentsByIdTransaction',
                                'Erro ao buscar as parcelas restantes',
                                422,
                            )
                        );
                    $installments = $result->getData();

                    $total_installments = $installments->pluck('installment_total_value')->sum();

                    $result_update_installments = $this->transactionRepository->deleteInstallmentsByIdTransaction($id_transaction);
                    if (!$result_update_installments->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'TransactionService > cancelTransaction > getInstallmentsByIdTransaction',
                                'Erro ao buscar as parcelas restantes',
                                422,
                            )
                        );

                    $array_installments = [
                        "description" => 'Multa Rescisória referente à transação: ' . $id_transaction . ' - [' . $property['reference'] . '] ',
                        "observations" => 'Multa gerada após finalização/cancelamento do contrato. Imóvel: ' . $property['reference'],
                        "original_value" => $total_installments,
                        "final_value" => $total_installments,
                        "type" => Transaction::TRANSACTION_TO_RECEIVE,
                        "status" => Transaction::STATUS_PENDING,
                        "payment_method" => 1,
                        "category" => 31, // DEPOSIT
                        "expect_date" => Carbon::now()->format('Y-m-d'),
                        "id_property" => intval($input['id_property']),
                        "id_transaction" => intval($id_transaction),
                        "id_renter" =>  intval($input['id_renter']),
                    ];
                    $this->transactionRepository->generateAccountReceive($array_installments);
                }
                return $this->transactionRepository->updateTransaction($input, $id_transaction);
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionService > cancelTransaction',
                    'Erro ao cancelar/finalizar contrato: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    public function getTransactionById(string $id): Result
    {
        return $this->transactionRepository->getTransactionById($id);
    }
    public function deleteTransaction(string $id_supplier): Result
    {
        return $this->transactionRepository->deleteTransaction($id_supplier);
    }
    public function restoreTransaction(string $id_supplier): Result
    {
        return $this->transactionRepository->restoreTransaction($id_supplier);
    }

    /**
     *
     * @param array $input
     * @param string $id_transaction
     * @return Result
     */
    private function generateInstallments(array $input, string $id_transaction, int $transaction_type): Result
    {
        try {
            $first_due_date = $this->treatDayDate($input['contract_start_date'], $input['due_day']);
            for ($i = 1; $i <= $input['number_installments']; $i++) {
                $date_installment = $first_due_date->copy();
                $date_installment->addMonths($i - 1);

                $array_installment = [
                    "current_installment" => $i,
                    "total_installments" => $input['number_installments'],
                    "status" => Transaction::CONTRACT_ACTIVE,  // contract status = 1 ATIVO
                    "due_date" => $date_installment->format('Y-m-d'),
                    "type_installment" => $transaction_type, // transaction type = 2 ALUGUEL
                    "id_transact" => $id_transaction,
                    "id_locator" => $input['id_locator'],
                    "id_property" => $input['id_property'],
                    "id_renter" => $input['id_renter'],
                    "payment_method" => $input['type_of_charge'],
                    "installment_value" => $input['final_value'],
                    "description" => $transaction_type == Transaction::TRANSACTION_RENT ? "Aluguel de Imóvel" : "Venda de Imóvel"
                ];

                if ($input['responsible_insurance'] == Transaction::RESPONSIBLE_INSURANCE_COMPANY) {
                    $array_installment['insurance_value'] = $input['insurance_value'];
                    $array_installment['insurance_number'] = strval($input['insurance_number']);
                    $total_value =  $input['final_value'] + $input['insurance_value'];
                    $array_installment['installment_total_value'] = ctype_digit($total_value)  ?  strval($total_value . '.00') : $total_value;
                } else {
                    $array_installment['installment_total_value'] = $input['final_value'];
                }

                $installment = $this->transactionRepository->saveInstallment($array_installment);
                if (!$installment->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'TransactionService > generateInstallments > saveInstallment',
                            'Erro ao salvar parcelas',
                            422,
                        )
                    );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionService > generateInstallments',
                    'Erro ao salvar parcelas: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param array $input
     * @param string $id_transaction
     * @return Result
     */
    private function generateAccountReceiveDeposit(array $input, string $id_transaction): Result
    {
        try {
            $expect_date = $this->treatDayDate($input['contract_start_date'], $input['due_day']);
            $result_property = $this->propertyRepository->getPropertyById($input['id_property']);
            if (!$result_property->isSuccess())
                return Result::error(
                    new ErrorApplication(
                        'TransactionService > cancelTransaction > getInstallmentsByIdTransaction',
                        'Erro ao buscar informações do imóvel para gerar transação',
                        422,
                    )
                );
            $property = $result_property->getData();
            $array_account = [
                "description" => 'Caução referente à transação: ' . $id_transaction . ' - Imóvel [' . $property['reference'] . '] ',
                "original_value" => $input['security_deposit'],
                "final_value" => $input['security_deposit'],
                "type" => Transaction::TRANSACTION_TO_RECEIVE,
                "status" => Transaction::STATUS_PENDING,
                "payment_method" => $input['type_of_charge'],
                "category" => 29, // DEPOSIT
                "expect_date" => $expect_date->format('Y-m-d'),
                "id_property" => intval($input['id_property']),
                "id_transaction" => $id_transaction,
                "id_renter" =>  $input['id_renter']
            ];
            $this->transactionRepository->generateAccountReceive($array_account);
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionService > generateInstallments',
                    'Erro ao salvar parcelas: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param string $initial_date
     * @param string $due_day
     * @return object
     */
    private function treatDayDate(string $initial_date, string $due_day): object
    {
        $final_date = Carbon::createFromFormat('Y-m-d', $initial_date);
        return $final_date->day($due_day);
    }
}
