<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'vehicles_submitted',
        'commission_rate',
        'owner_id_1',
        'owner_id_2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
