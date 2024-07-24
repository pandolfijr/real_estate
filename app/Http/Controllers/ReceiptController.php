<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\AccountService;

class ReceiptController extends Controller
{
    private $accountService;
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
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
            $result = $this->accountService->getInstallmentById($id);
            $installment = $result->getData();
            $mount_view = 'dashboard.receipt.'. $view;
            $html = view($mount_view, compact('installment'))->render();
            echo $html;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
