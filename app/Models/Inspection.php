<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'condition',
        'notes',
        'photos',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
