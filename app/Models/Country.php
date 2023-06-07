<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public function City()
    {
        return $this->hasMany(City::class);
    }
}