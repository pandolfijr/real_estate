<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\AccountService;
use App\Interfaces\Service\TransactionService;

class ReceiptController extends Controller
{
    private $accountService;
    private $transactionService;
    public function __construct(AccountService $accountService, TransactionService $transactionService)
    {
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }

    /**
     *
     * @param string $id
     * @param string $view
     * @return void
     */
    public function generate(string $id, string $view)
    {
        try {
            if ($view == 'keys_return') {
                $result = $this->transactionService->getTransactionById($id);
                $transaction = $result->getData();
                $mount_view = 'dashboard.receipt.' . $view;
                $html = view($mount_view, compact('transaction'))->render();
            } else {
                $result = $this->accountService->getInstallmentById($id);
                $installment = $result->getData();
                $mount_view = 'dashboard.receipt.' . $view;
                $html = view($mount_view, compact('installment'))->render();
            }

            echo $html;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
