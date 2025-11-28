<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPointAttachment extends Model
{
    /** @use HasFactory<\Database\Factories\DataPointAttachmentFactory> */
    use HasFactory;

    protected $fillable = [
        'data_point_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'description',
        'uploaded_by',
    ];

    public function dataPoint()
    {
        return $this->belongsTo(DataPoint::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
