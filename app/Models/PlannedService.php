<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlannedService extends Model
{
    use HasFactory;

    protected $table = 'planned_service';
    protected $fillable = [
        'id',
        'car_id',
        'completed',
        'service_date',
        'description',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
