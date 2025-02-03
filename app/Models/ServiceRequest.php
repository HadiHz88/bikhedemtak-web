<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'service_id', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function serviceOffers()
    {
        return $this->hasMany(ServiceOffer::class);
    }
}