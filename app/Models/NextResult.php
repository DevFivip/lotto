<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextResult extends Model
{
    use HasFactory;


    public $fillable = [
        'animal_id',
        'animal_number',
        'schedule',
    ];


    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

}
