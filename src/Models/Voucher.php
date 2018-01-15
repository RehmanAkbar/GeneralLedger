<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class Voucher extends Model implements LogsActivityInterface
{
    use SoftDeletes, LogsActivity;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vouchers';

    protected $dates = ['voucher_date'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['voucher_type_id', 'voucher_code', 'voucher_date', 'remarks','office_id','company_id','user_id','remarks'];

    public function type(){

        return $this->belongsTo(VoucherType::class,'voucher_type_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    public function details(){

        return $this->hasMany(VoucherDetails::class);
    }
    
    public function office(){

        return $this->belongsTo(Office::class);
    }

    public function scopeVoucherTypeId($query,$type_id)
    {
        return $query->where('voucher_type_id',  $type_id);
    }
    public function uploads()
    {
        return $this->morphMany(Upload::class, 'uploadable');
    }

    public function getFilesAttribute()
    {
        $files = $this->uploads()->get();
        if(count($files)){

            return $files;
        }

        return null;

    }

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'Voucher ('. $this->voucher_code .') for ' . $this->company->name . '  was created';
        }

        if ($eventName == 'updated')
        {
            return 'Voucher ('. $this->voucher_code .') was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Voucher ('. $this->voucher_code .') was deleted';
        }

        return '';
    }
}
