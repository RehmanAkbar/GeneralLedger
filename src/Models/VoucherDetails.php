<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class VoucherDetails extends Model
{
    // use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'voucher_details';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['voucher_id', 'company_id', 'office_id', 'account_id','narration','cheque_no','debit','credit'];

    public function voucher(){

        return $this->belongsTo(Voucher::class);
    }

    public function account(){

        return $this->belongsTo(Account::class);
    }


}
