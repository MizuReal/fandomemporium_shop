<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'order_status_history';

    protected $fillable = [
        'order_id',
        'status',
        'comment',
        'created_by_id',
        'created_at'
    ];

    // We want to manage created_at but don't need updated_at
    const UPDATED_AT = null;

    // Cast created_at to a datetime
    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * Get the order that owns the status record.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user who created this status record.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
} 