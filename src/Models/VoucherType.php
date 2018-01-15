<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherType extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'voucher_types';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id','user_id','office_id','type', 'description', 'prepared_by', 'checked_by', 'approved_by', 'accepted_by'];


    public function voucher(){
        return $this->hasMany(Voucher::class,'voucher_type_id','id');
    }
}
