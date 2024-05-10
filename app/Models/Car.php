<?php

namespace App\Models;

use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $factory = [
        CarFactory::class
    ];
    protected $fillable = [
        'id',
        'user_id',
        'licence_plate',
        'odometer',
        'brand',
        'model',
        'color',
        'year',
        'body',
        'fuel_type',
        'transmission',
        'power',
        'doors',
        'seats',
        'apk_end_date',
        'fuel_efficiency',
        'cc',
        'weight',
        'tax',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function planned_service()
    {
        return $this->hasMany(PlannedService::class);
    }
}
