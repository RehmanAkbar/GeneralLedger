<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountType extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'account_types';

    public $timestamps = true;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    public function account(){
        return $this->hasMany(Account::class,'account_type_id');
    }
}
