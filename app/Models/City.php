<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Road;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public function Road()
    {
        return $this->hasMany(Road::class);
    }
    public function Country()
    {
        return $this->belongsTo(Country::class);
    }
}