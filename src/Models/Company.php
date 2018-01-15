<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';
    public $timestamps = true;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'name', 'abbreviation', 'address', 'phone', 'fax', 'email', 'sales_tax', 'registration_no', 'ntn','image'];

    public function user(){
        return $this->hasOne(User::class);
    }

    public function offices(){
        return $this->hasMany(Office::class);
    }

    public function account(){
        return $this->hasMany(Account::class);
    }

    public function voucher(){
        return $this->hasMany(Voucher::class);
    }
}
