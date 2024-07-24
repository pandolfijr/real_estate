<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('site.form');
});
Route::get('/about', function () {
    return view('site.form');
});
Route::get('/all_properties', function () {
    return view('site.form');
});
Route::get('/property_details/{id}', function () {
    return view('site.form');
});

Route::get('/properties-site', [App\Http\Controllers\PropertyController::class, 'index'])->name('properties-site');
Route::get('/properties-detail-site/{id}', [App\Http\Controllers\PropertyController::class, 'show'])->name('properties-detail-site');
Route::get('/cities-site', [App\Http\Controllers\CityController::class, 'index'])->name('cities-site');
// Route::resource('/', App\Http\Controllers\SiteController::class);
// Route::post('/', [App\Http\Controllers\SiteController::class, 'index'])->name('imoveis.search');
// Route::get('/sobre', [App\Http\Controllers\SiteController::class, 'sobre'])->name('sobre');
// Route::get('/imoveis', [App\Http\Controllers\SiteController::class, 'propriedades'])->name('propriedades');
// Route::post('/imoveis', [App\Http\Controllers\SiteController::class, 'propriedades'])->name('propriedades');
// Route::get('/propriedade_detalhe/{id}',  [App\Http\Controllers\SiteController::class, 'show'])->name('site.imovel.propriedade');
Route::get('/admin', function () {
    return view('dashboard.login');
});
Route::post('/login-admin', [App\Http\Controllers\LoginController::class, 'login'])->name('login-admin');
Route::get('/logout-admin', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout-admin');




Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('dashboard.form');
    });
    Route::get('/get-info-properties', [App\Http\Controllers\HomeController::class, 'index']);

    Route::get('/users-total', [App\Http\Controllers\UserController::class, 'total']);
    Route::get('/users-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/users', App\Http\Controllers\UserController::class);
    Route::get('/user/edit/{id}', function () {
        return view('dashboard.form');
    });
    Route::get('user/{id}/edit_user', function () {
        return view('dashboard.form');
    });
    Route::get('/user/create', function () {
        return view('dashboard.form');
    });
    Route::post('/user/{id}/restore', [App\Http\Controllers\UserController::class, 'restore'])->name('user.restore');

    Route::get('/locators-total', [App\Http\Controllers\LocatorController::class, 'total']);
    Route::get('/locators-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/locators', App\Http\Controllers\LocatorController::class);
    Route::get('locator/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/locator/create', function () {
        return view('dashboard.form');
    });
    Route::post('/locator/{id}/restore', [App\Http\Controllers\LocatorController::class, 'restore'])->name('locator.restore');


    Route::get('/property-total', [App\Http\Controllers\PropertyController::class, 'total']);
    Route::get('/properties-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/properties', App\Http\Controllers\PropertyController::class);
    Route::get('property/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/property/create', function () {
        return view('dashboard.form');
    });
    Route::post('/property/{id}/restore/', [App\Http\Controllers\PropertyController::class, 'restore']);
    Route::get('/property-by-locator/{id}', [App\Http\Controllers\PropertyController::class, 'getPropertiesByIdLocator']);


    Route::post('/property/picture', [App\Http\Controllers\PropertyController::class, 'editPictures'])->name('pictures.property');
    Route::get('/picture-properties-list', function () {
        return view('dashboard.form');
    });
    Route::put('/picture_properties/{id}', [App\Http\Controllers\PropertyController::class, 'updatePicture']);



    Route::get('/condos-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/condos', App\Http\Controllers\CondoController::class);
    Route::get('condo/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/condo/create', function () {
        return view('dashboard.form');
    });
    Route::post('/condo/{id}/restore/', [App\Http\Controllers\CondoController::class, 'restore']);


    Route::get('/suppliers-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/suppliers', App\Http\Controllers\SupplierController::class);
    Route::get('supplier/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/supplier/create', function () {
        return view('dashboard.form');
    });
    Route::post('/supplier/{id}/restore/', [App\Http\Controllers\SupplierController::class, 'restore']);


    Route::get('/transactions-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
    Route::get('transaction/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/transaction/create', function () {
        return view('dashboard.form');
    });
    Route::post('/transaction/{id}/cancel-finish-transaction/', [App\Http\Controllers\TransactionController::class, 'cancelTransaction']);


    Route::get('/bank-accounts-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/bank-accounts', App\Http\Controllers\BankAccountController::class);
    Route::get('bank-account/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/bank-account/create', function () {
        return view('dashboard.form');
    });
    Route::post('/bank-accounts/{id}/restore/', [App\Http\Controllers\BankAccountController::class, 'restore']);

    Route::get('/casher-account', [App\Http\Controllers\BankAccountController::class, 'getCasherAccount']);




    Route::get('/accounts-pay-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/accounts-pay', App\Http\Controllers\AccountPayController::class);
    Route::get('account-pay/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('account-pay/{id}/pay-off', function () {
        return view('dashboard.form');
    });
    Route::get('/account-pay/create', function () {
        return view('dashboard.form');
    });
    Route::post('/accounts-pay/{id}/restore/', [App\Http\Controllers\AccountPayController::class, 'restore']);


    Route::get('/installments-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/installment', App\Http\Controllers\InstallmentController::class);
    Route::get('installment/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('installment/{id}/pay-off', function () {
        return view('dashboard.form');
    });
    Route::get('/installment/create', function () {
        return view('dashboard.form');
    });
    Route::post('/installment/{id}/restore/', [App\Http\Controllers\InstallmentController::class, 'restore']);


    Route::resource('/installments', App\Http\Controllers\InstallmentController::class);



    Route::get('installment/{id}/pay-off', function () {
        return view('dashboard.form');
    });

    Route::get('/transfers-list', function () {
        return view('dashboard.form');
    });
    Route::get('transfer/{id}/pay-off', function () {
        return view('dashboard.form');
    });
    Route::post('/transfer/{id}/send-transfer/', [App\Http\Controllers\InstallmentController::class, 'sendTransfer']);


    Route::get('/accounts-receive-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/accounts-receive', App\Http\Controllers\AccountReceiveController::class);
    Route::get('account-receive/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('account-receive/{id}/pay-off', function () {
        return view('dashboard.form');
    });
    Route::get('/account-receive/create', function () {
        return view('dashboard.form');
    });
    Route::post('/accounts-receive/{id}/restore/', [App\Http\Controllers\AccountReceiveController::class, 'restore']);






    Route::get('/checks-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/check', App\Http\Controllers\CheckController::class);
    Route::get('check/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/check/create', function () {
        return view('dashboard.form');
    });
    Route::post('/check/{id}/restore/', [App\Http\Controllers\CheckController::class, 'restore']);



    Route::get('/cashflow-list', function () {
        return view('dashboard.form');
    });
    Route::get('cashflow/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::resource('/cashflow', App\Http\Controllers\CasherController::class);


    Route::get('/cities-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/cities', App\Http\Controllers\CityController::class);
    Route::get('city/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/city/create', function () {
        return view('dashboard.form');
    });
    Route::get('/states', [App\Http\Controllers\CityController::class, 'getStates']);


    Route::get('/renters-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/renters', App\Http\Controllers\RenterController::class);
    Route::get('renter/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/renter/create', function () {
        return view('dashboard.form');
    });
    Route::post('/renter/{id}/restore', [App\Http\Controllers\RenterController::class, 'restore'])->name('renter.restore');


    Route::get('/renters-total', [App\Http\Controllers\RenterController::class, 'total']);
    Route::get('/renters-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/renters', App\Http\Controllers\RenterController::class);
    Route::get('renter/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/renter/create', function () {
        return view('dashboard.form');
    });




    Route::get('/guarantors-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/guarantors', App\Http\Controllers\GuarantorController::class);
    Route::get('guarantor/{id}/edit', function () {
        return view('dashboard.form');
    });
    Route::get('/guarantor/create', function () {
        return view('dashboard.form');
    });
    Route::post('/guarantor/{id}/restore', [App\Http\Controllers\GuarantorController::class, 'restore']);



    Route::get('/setting-list', function () {
        return view('dashboard.form');
    });
    Route::resource('/settings', App\Http\Controllers\SettingController::class);
    Route::get('setting/{id}/edit', function () {
        return view('dashboard.form');
    });



    Route::get('/reports-list', function () {
        return view('dashboard.form');
    });

    Route::resource('/reports', App\Http\Controllers\ReportController::class);

    Route::get('/people/{id}/get-by-cpf',[App\Http\Controllers\PeopleController::class, 'getPeopleByCpf']);
    Route::get('/receipt/{id}/{view}', [App\Http\Controllers\ReceiptController::class, 'generate'])->name('generate');

});

Auth::routes();
