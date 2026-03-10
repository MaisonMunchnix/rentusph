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
        'customer_address',
        'special_requests',
        'payment_status',
        'payment_method',
        'proof_of_payment',
        'rental_amount',
        'security_deposit',
        'commission_rate',
        'platform_commission',
        'affiliate_earnings',
        'deposit_deducted',
        'deposit_refunded',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $appends = ['deposit_refunded_amount'];

    public function getDepositRefundedAmountAttribute()
    {
        return ($this->security_deposit ?? 0) - ($this->deposit_deducted ?? 0);
    }

    public function bookable()
    {
        return $this->morphTo()->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inspection()
    {
        return $this->hasOne(Inspection::class);
    }
}
