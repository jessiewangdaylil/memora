<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Road extends Model
{
    use HasFactory;
    public function City()
    {
        return $this->belongsTo(City::class);
    }
}
