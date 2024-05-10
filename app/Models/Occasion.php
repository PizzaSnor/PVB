<?php

namespace App\Models;

use Database\Factories\OccasionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occasion extends Model
{
    use HasFactory;

    protected $factory = [
        OccasionFactory::class
    ];
    protected $fillable = [
        'id',
        'title',
        'description',
        'price',
        'licence_plate',
        'odometer',
        'sold',
        'show_when_sold',
        'brand',
        'model',
        'color',
        'year',
        'body',
        'fuel_type',
        'power',
        'doors',
        'seats',
        'apk_end_date',
        'fuel_efficiency',
        'cc',
        'weight',
        'tax',
    ];

    public function images()
    {
        return $this->hasMany(OccasionImage::class);
    }
}
