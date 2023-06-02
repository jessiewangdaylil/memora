<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Items()
    {
        return $this->belongsToMany(Item::class);
    }
}
