<?php

namespace App\Models\Hipismo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hipodromo extends Model
{
    use HasFactory;

    public $fillable = ['name', 'country', 'flag', 'status'];
}
