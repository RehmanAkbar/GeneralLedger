<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:28 PM
 */

namespace Softpyramid\GeneralLedger\Repositories;


use Softpyramid\GeneralLedger\Models\Account;
use Softpyramid\GeneralLedger\Models\VoucherDetails;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccountRepository extends Repository
{

    public function model()
    {
       return Account::class;
    }

    public function createAccount($account_data)
    {
        $account = $this->model->create($account_data);
        return $account;

    }

    public function updateBalance($account_data)
    {

        $account = $this->model->find($account_data['id']);
        $account->update($account_data);
    }

    public function getAccountsFromCode($from_account, $to_account)
    {

        $format = 'Y-m-d';

        $date = parseDate(request()->from_date);
        $date_from = $date->format($format);

        $date = parseDate(request()->to_date);
        $date_to = $date->format($format);


        //get transactions

         return $transactions = $this->model->with(['voucherDetails' => function($query) use ($date_from, $date_to) {

            $query->with(['voucher' => function($query) use ($date_from , $date_to) {

                $query->whereBetween('voucher_date',[$date_from , $date_to])

                    ->orderBy('voucher_date', 'asc');

            }]);
        }])
            ->whereBetween('code', [$from_account, $to_account])
            ->orderBy('code', 'asc')
            ->get();
        // get balance
        $opening_balance = Account::with(['voucherDetails' => function($query) use ($date_from, $date_to) {

            $query->with(['voucher' => function($q) use ($date_from , $date_to) {

                $q->whereBetween('voucher_date',[$date_from , $date_to]);

            }])  
                ->select  (
                    'voucher_details.account_id',
                    'voucher_details.voucher_id',
                    'voucher_details.narration',
                    'voucher_details.cheque_no',
                    DB::raw('SUM(voucher_details.debit - voucher_details.credit) AS opening')
                )
                ->groupBy ('account_id', 'voucher_id' , 'narration' , 'cheque_no');

        }])
            ->whereBetween('code', [$from_account, $to_account])
            ->orderBy('code', 'asc')
            ->select('id')
            ->get();


    }

}