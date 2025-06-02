<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataSegment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'sector_id',
        'created_by',
        'deleted_by',
    ];
}
