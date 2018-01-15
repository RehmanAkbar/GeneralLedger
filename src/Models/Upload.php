<?php

namespace Softpyramid\GeneralLedger\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploads';
    public $timestamps = true;

    protected $fillable = [
        'path',
        'original_name',
        'media_type',
        'uploadable_id',
        'uploadable_type',
        'uploaded_by_user_id',
        'deleted_by_user_id',
    ];

    public function uploadable() {
        return $this->morphTo();
    }
}
