<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    public function galleryImages()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('order');
    }

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'address',
        'city',
        'region',
        'zip_code',
        'bedrooms',
        'bathrooms',
        'floor_area',
        'monthly_rate',
        'security_deposit',
        'rate_type',
        'description',
        'is_available',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
