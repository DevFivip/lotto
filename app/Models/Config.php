<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'value',
    ];
    public $timestamps = false;
    static function createOrUpdate($name, $value): void
    {
        $conf = self::where('name', $name)->first();
        if ($conf) {
            //update
            $conf->value = $value;
            $conf->update();
        } else {
            //create
            self::create([
                'name' => $name,
                'value' => $value,
            ]);
        }
    }
}
