<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kbcentral extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
    ];
}
