<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use Illuminate\Database\Eloquent\Collection;

use App\Interfaces\Repository\LocalizationRepository;
use App\Interfaces\Repository\SupplierRepository;
use App\Models\City;
use App\Models\Supplier;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SupplierRepositoryImpl implements SupplierRepository
{


    public function getSuppliers(array $input, bool $paginate): Result
    {
        try {
            $db = Supplier::orderBy('name');
            if (isset($input['search'])) {
                $db->where('name', 'LIKE', '%' . $input['search'] . '%')
                    ->orWhere('email', 'LIKE', '%' . $input['search'] . '%')
                    ->orWhere('cellphone', 'LIKE', '%' . $input['search'] . '%')
                    ->orWhere('telephone', 'LIKE', '%' . $input['search'] . '%');
            }

            if (isset($input['status']) && !empty($input['status'])) {
                if ($input['status'] == Supplier::INACTIVE)
                    $db->onlyTrashed();
                elseif ($input['status'] == Supplier::ALL)
                    $db->withTrashed();
            }

            $suppliers = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($suppliers);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SupplierRepositoryImpl > getSuppliers',
                    'Erro ao buscar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function saveSupplier(array $input): Result
    {
        try {
            $supplier = Supplier::create($input);
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'SupplierRepositoryImpl > saveSupplier > create',
                        'Não foi possível criar o proprietário',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SupplierRepositoryImpl > saveSupplier',
                    'Erro ao salvar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateSupplier(array $input, string $id_supplier): Result
    {
        try {
            $supplier = Supplier::where('id', $id_supplier)->withTrashed()->first();
            $supplier->fill($input);
            $supplier->update();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'SupplierRepositoryImpl > updateSupplier >  update',
                        'Não foi possível atualizar o proprietário',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SupplierRepositoryImpl > updateSupplier',
                    'Erro ao atualizar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getSupplierById(string $id): Result
    {
        try {
            $supplier = Supplier::where('id', $id)->withTrashed()->first();
            return Result::success($supplier);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SupplierRepositoryImpl > getSupplierById',
                    'Erro ao buscar locadore: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function deleteSupplier(string $id_supplier): Result
    {
        try {
            $supplier = Supplier::where('id', $id_supplier)->first();
            $supplier->delete();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'SupplierRepositoryImpl > deleteSupplier > supplier > delete',
                        'Não foi possível remover o proprietário',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SupplierRepositoryImpl > deleteSupplier',
                    'Erro ao excluir proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function restoreSupplier(string $id_supplier): Result
    {
        try {
            $supplier = Supplier::where('id', $id_supplier)->onlyTrashed()->first();
            $supplier->restore();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'SupplierRepositoryImpl > deleteSupplier > supplier > delete',
                        'Não foi possível remover o proprietário',
                        500,
                    )
                );
            }

            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SupplierRepositoryImpl > restoreSupplier',
                    'Erro ao restaurar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
}
