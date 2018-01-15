<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cities';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    public $timestamps = true;

    protected $fillable = ['country_id', 'name'];

    public function country(){

        return $this->belongsTo(Country::class);

    }

    public function account(){

        return $this->hasMany(Account::class,'city_id');
    }
}
