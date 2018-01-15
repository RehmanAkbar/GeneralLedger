<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'offices';
    public $timestamps = true;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id','branch_code', 'name', 'abbreviation', 'address', 'phone', 'fax', 'email', 'sales_gl_code', 'sales_tax_code', 'sed_gl_code', 'earning_gl_code'];


    public function company(){

        return $this->belongsTo(Company::class);
    }
}
