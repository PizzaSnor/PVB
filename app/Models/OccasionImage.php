<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccasionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'occasion_id',
        'path'
    ];

    public function occasion()
    {
        return $this->belongsTo(Occasion::class);
    }
}
