<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripletaDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'tripleta_id',
        'animal_1',
        'animal_2',
        'animal_3',
        'position_last_sorteo',
        'sorteo_left',
        'animal_1_has_win',
        'animal_2_has_win',
        'animal_3_has_win',
        'sorteo_id',
        'total',
    ];

    public function sorteo()
    {
        return $this->belongsTo(SorteosType::class, 'sorteo_id');
    }

    public function tripleta()
    {
        return $this->belongsTo(Tripleta::class, 'tripleta_id');
    }
}
