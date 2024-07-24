<?php

namespace App\Providers;

use App\Interfaces\Repository\AccountRepository;
use App\Interfaces\Repository\BankAccountRepository;
use App\Interfaces\Repository\CheckRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\LocalizationRepositoryImpl;
use App\Repositories\FinalidadeImoveisRepositoryImpl;
use App\Repositories\PropertyRepositoryImpl;
use App\Repositories\PeopleRepositoryImpl;
use App\Repositories\StatusImoveisRepositoryImpl;
use App\Repositories\TipoImoveisRepositoryImpl;
use App\Repositories\ImagensImovelRepositoryImpl;

use App\Interfaces\Repository\PropertyRepository;
use App\Interfaces\Repository\TipoImoveisRepository;
use App\Interfaces\Repository\StatusImoveisRepository;
use App\Interfaces\Repository\FinalidadeImoveisRepository;
use App\Interfaces\Repository\LocalizationRepository;
use App\Interfaces\Repository\ImagensImovelRepository;
use App\Interfaces\Repository\PeopleRepository;
use App\Interfaces\Repository\SettingRepository;
use App\Interfaces\Repository\SupplierRepository;
use App\Interfaces\Repository\TransactionRepository;
use App\Interfaces\Repository\UserRepository;
use App\Interfaces\Service\AccountService;
use App\Interfaces\Service\BankAccountService;
use App\Interfaces\Service\CheckService;
use App\Interfaces\Service\LocalizationService;
use App\Interfaces\Service\PeopleService;
use App\Interfaces\Service\PropertyService;
use App\Interfaces\Service\ReportService;
use App\Interfaces\Service\SettingService;
use App\Interfaces\Service\SupplierService;
// use App\Interfaces\Service\ImagensImovelService;
use App\Interfaces\Service\TipopropertyService;
use App\Interfaces\Service\TransactionService;
use App\Interfaces\Service\UserService;
use App\Repositories\AccountRepositoryImpl;
use App\Repositories\BankAccountRepositoryImpl;
use App\Repositories\CheckRepositoryImpl;
use App\Repositories\SettingRepositoryImpl;
use App\Repositories\SupplierRepositoryImpl;
use App\Repositories\TransactionRepositoryImpl;
use App\Repositories\UserRepositoryImpl;
use App\Services\AccountServiceImpl;
use App\Services\BankAccountServiceImpl;
use App\Services\CheckServiceImpl;
use App\Services\LocalizationServiceImpl;
use App\Services\PeopleServiceImpl;
// use App\Services\ImagensImovelServiceImpl;
use App\Services\TipopropertyServiceImpl;
use App\Services\PropertyServiceImpl;
use App\Services\ReportServiceImpl;
use App\Services\SettingServiceImpl;
use App\Services\SupplierServiceImpl;
use App\Services\TransactionServiceImpl;
use App\Services\UserServiceImpl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(PropertyRepository::class, PropertyRepositoryImpl::class);
        $this->app->bind(PropertyService::class, PropertyServiceImpl::class);

        $this->app->bind(PeopleRepository::class, PeopleRepositoryImpl::class);
        $this->app->bind(PeopleService::class, PeopleServiceImpl::class);

        $this->app->bind(ReportService::class, ReportServiceImpl::class);

        $this->app->bind(LocalizationRepository::class, LocalizationRepositoryImpl::class);
        $this->app->bind(LocalizationService::class, LocalizationServiceImpl::class);

        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);

        $this->app->bind(SettingService::class, SettingServiceImpl::class);
        $this->app->bind(SettingRepository::class, SettingRepositoryImpl::class);

        $this->app->bind(SupplierService::class, SupplierServiceImpl::class);
        $this->app->bind(SupplierRepository::class, SupplierRepositoryImpl::class);

        $this->app->bind(AccountService::class, AccountServiceImpl::class);
        $this->app->bind(AccountRepository::class, AccountRepositoryImpl::class);

        $this->app->bind(BankAccountService::class, BankAccountServiceImpl::class);
        $this->app->bind(BankAccountRepository::class, BankAccountRepositoryImpl::class);

        $this->app->bind(CheckService::class, CheckServiceImpl::class);
        $this->app->bind(CheckRepository::class, CheckRepositoryImpl::class);

        $this->app->bind(TransactionService::class, TransactionServiceImpl::class);
        $this->app->bind(TransactionRepository::class, TransactionRepositoryImpl::class);
    }
}

