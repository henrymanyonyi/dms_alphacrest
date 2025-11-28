<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPoint extends Model
{
    /** @use HasFactory<\Database\Factories\DataPointFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'data_source',
        'data_indicator',
        'is_active',
        'price',
        'data_parameter_id',
        'created_by',
        'source_url',
        'data_date'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Str::slug($model->name) . '-' . uniqid();
            }
        });
    }


    public function parameter()
    {
        return $this->belongsTo(DataParameter::class, 'data_parameter_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments()
    {
        return $this->hasMany(DataPointAttachment::class);
    }

    // Add to DataPoint Model (app/Models/DataPoint.php)
    // Add this relationship method:
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function totalRevenue()
    {
        return $this->purchases()
            ->where('status', 'completed')
            ->sum('amount');
    }

    public function totalPurchases()
    {
        return $this->purchases()
            ->where('status', 'completed')
            ->count();
    }
}
