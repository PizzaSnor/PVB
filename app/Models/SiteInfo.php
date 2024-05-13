<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    use HasFactory;
    protected $table = 'site_info';

    protected $fillable = [
        'id',
        'main_content',
        'contact_email',
        'contact_number',
        'max_cars_per_day'
    ];
}
