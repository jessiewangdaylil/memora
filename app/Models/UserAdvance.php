<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdvance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'country_id',
        'city_id',
        'town_id',
        'road_id',
        'phone_code_id',
        'local_phone_code_id',
        'auth_level_id',
    ];
}