<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
//    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accounts';
    public $timestamps = true;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'description','user_id','company_id','office_id', 'is_parent', 'account_type_id', 'account_group_id', 'contact_person', 'phone', 'fax', 'email', 'address_1','address_2', 'address_3','region_id' , 'city_id', 'gst_no', 'nid_no' ,'ntn', 'other', 'bank_ac_no', 'open_debit', 'open_credit', 'credit_days','nlevel','parent_id'];

    public function type(){

        return $this->belongsTo(AccountType::class);

    }

    public function group(){

        return $this->belongsTo(AccountGroup::class);
    }

    public function city(){

        return $this->belongsTo(City::class);

    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function voucherDetails(){
        return $this->hasMany(VoucherDetails::class);
    }

    public function level2(){

        return $this->hasMany(Account::class, 'parent_id' , 'id')->where('nlevel' , 2);

    }

    public function level3(){

        return $this->hasMany(Account::class , 'parent_id' , 'id')->where('nlevel' , 3);

    }

    public function openingBalance($from_date = null)
    {
        if(!$from_date){

            $from_date = date('Y-m-d 00:00:00');
        }
        $code  = $this->code;

        $from_date = parseDate($from_date)->format('Y-m-d 00:00:00');

        $transactions = VoucherDetails::with('voucher','account');

        //filter accounts
        $transactions = $transactions->whereHas('account',function ($accounts)use($code) {
            $accounts->where('code', $code);
        });

        //filter voucher transaction by dates
        $transactions= $transactions->whereHas('voucher',function ($vouchers)use($from_date) {
            $vouchers->whereDate('voucher_date', '<', $from_date);
        });

        $sumOfDebit  = $transactions->sum('debit');
        $sumOfCredit = $transactions->sum('credit');

        $openingBalance = $sumOfDebit - $sumOfCredit;

        $openingBalance += ($this->open_debit - $this->open_credit);

        return $openingBalance;
    }

}
