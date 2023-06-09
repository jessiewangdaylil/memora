<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempAddress extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'path', 'data', 'create_data', 'delete_data', 'delete_data'];
}
