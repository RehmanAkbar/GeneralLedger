<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';
    public $timestamps = true;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'currency', 'rate'];

    public function cities(){

        return $this->hasMany(City::class);

    }

}
