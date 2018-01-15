<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





//Route::group(['middleware' => ['auth']], function () {






    /********************************************************** General Ledger *******************************************************/

    Route::namespace('Softpyramid\GeneralLedger\Controllers')->prefix('general-ledger')->group(function (){

        Route::group(['prefix'=>'setup'],function (){
            Route::resource('accounts', 'AccountsController');
            Route::resource('accountgroups', 'AccountGroupsController');
            Route::resource('types', 'AccountTypesController');
            Route::resource('vouchertypes', 'VoucherTypesController');

            Route::get('accounts-search', 'AccountsController@searchAccounts')->name('accounts_search');
            Route::get('opening-balance/search', 'AccountsController@getAccounts')->name('getAccount');
            Route::get('switch-company', 'AccountsController@switchCompany')->name('switch-company');
        });

        Route::get('vouchers/download', 'VouchersController@downloadVoucher')->name('download.vouchers');

        Route::group(['prefix'=>'transactions'],function (){

            Route::resource('vouchers', 'VouchersController');
            Route::post('voucher/update/{id}', 'VouchersController@updateVoucher')->name('updateVoucher');
            Route::get('voucher/printing', 'VouchersController@printing')->name('voucher.printing');
            Route::get('preview/printing', 'VouchersController@previewVoucherForPrinting')->name('voucher.preview_printing');
            Route::resource('voucher-details', 'VoucherDetailsController');
            Route::post('last-voucher/{id}','VouchersController@lastVouchers')->name('last_vouchers');
            Route::get('voucher/{voucher_id}/details', 'VouchersController@printVoucher')->name('print_voucher');
            Route::get('voucher/{voucher_id}/download', 'VouchersController@downloadVoucherPdf')->name('download_voucher');
            Route::post('voucher/file/download/{id}', 'VouchersController@downloadVoucherFile')->name('voucherFile.download');
            Route::post('voucher/file/delete/{id}', 'VouchersController@deleteVoucherFile')->name('voucherFile.destroy');
            Route::post('voucher/file/create/{id}', 'VouchersController@uploadVoucherFile')->name('voucherFile.create');

            Route::get('listing', 'VouchersController@transactionsListing')->name('voucher.listing');
            Route::get('preview/listing', 'VouchersController@transactionsListingPreview')->name('voucher.preview_listing');

        });

        Route::group(['prefix' => 'reports'] , function(){

            Route::get('general-ledger/criteria', 'VouchersController@ledgerCriteriaForm')->name('voucher-ledger-criteria');
            Route::get('general-ledger/download', 'VouchersController@downloadGeneralLedger')->name('voucher.glDownload');
            Route::get('preview/general-ledger', 'VouchersController@generalLedgerPreview')->name('voucher-general-ledger');


            Route::get('trial-balance/criteria', 'VouchersController@trialBalanceCriteriaForm')->name('voucher.trialBalanceCriteria');
            Route::get('preview/trial/balance',  'VouchersController@trialBalancePreview')->name('voucher.trialBalance');
            Route::get('trial/balance/download', 'VouchersController@trialBalanceDownload')->name('voucher.trialBalanceDownload');


        });
    });


    /********************************************************** End General Ledger ****************************************************/

    Route::post('save/opening-balance','AccountsController@savOpeningBalance')->name('save_opening_balance');
    Route::get('account/opening-balance','AccountsController@openingBalance')->name('opening_balance');



//});

