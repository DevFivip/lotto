<?php

namespace App\Models\Hipismo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HipismoRemateHead extends Model
{
    use HasFactory;

    public $fillable = [
        "total",
        "pagado",
        "status",
        "fixture_race_id",
        "user_id",
        "admin_id",
    ];

    protected $table = 'hipismo_remate_heads';

    public function remates()
    {
        return $this->hasMany(HipismoRemate::class);
    }
}
