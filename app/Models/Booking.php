<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'bookable_id',
        'bookable_type',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'special_requests',
        'payment_status',
        'payment_method',
        'proof_of_payment',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function bookable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
