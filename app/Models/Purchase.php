<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'user_id',
        'customer_email',
        'customer_phone',
        'data_point_id',
        'amount',
        'currency',
        'payment_method',
        'status',
        'transaction_id',
        'mpesa_receipt',
        'payment_details',
        'download_count',
        'last_downloaded_at',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'last_downloaded_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->order_id)) {
                $model->order_id = 'ORD-' . strtoupper(uniqid());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dataPoint()
    {
        return $this->belongsTo(DataPoint::class);
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function canDownload()
    {
        return $this->isCompleted() &&
            (!$this->expires_at || $this->expires_at->isFuture());
    }

    public function incrementDownload()
    {
        $this->increment('download_count');
        $this->update(['last_downloaded_at' => now()]);
    }
}
