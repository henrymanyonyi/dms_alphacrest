<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataParameter extends Model
{
    /** @use HasFactory<\Database\Factories\DataParameterFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'data_sector_id',
        'created_by',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Str::slug($model->name) . '-' . uniqid();
            }
        });
    }


    public function sector()
    {
        return $this->belongsTo(DataSector::class, 'data_sector_id');
    }

    public function points()
    {
        return $this->hasMany(DataPoint::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
