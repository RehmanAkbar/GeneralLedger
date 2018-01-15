<?php

namespace Softpyramid\GeneralLedger;

use Illuminate\Support\ServiceProvider;
class GeneralLedgerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadTranslationsFrom(__DIR__.'/lang/en', 'generalledger');

        $this->publishes([
            __DIR__.'/migrations' => base_path('database/migrations'),
        ]);

        $this->publishes([
            __DIR__.'/lang/en' => resource_path('lang/en'),
        ]);

        $this->loadViewsFrom(__DIR__.'/views', 'generalledger');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/'),
        ]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Softpyramid\GeneralLedger\Controllers\AccountsController');
        $this->app->make('Softpyramid\GeneralLedger\Controllers\AccountGroupsController');
        $this->app->make('Softpyramid\GeneralLedger\Controllers\AccountTypesController');
        $this->app->make('Softpyramid\GeneralLedger\Controllers\CitiesController');
        $this->app->make('Softpyramid\GeneralLedger\Controllers\CompaniesController');
        $this->app->make('Softpyramid\GeneralLedger\Controllers\CountriesController');
        $this->app->make('Softpyramid\GeneralLedger\Controllers\VoucherDetailsController');
        $this->app->make('Softpyramid\GeneralLedger\Controllers\VouchersController');
        $this->app->make('Softpyramid\GeneralLedger\Controllers\VoucherTypesController');
    }
}
