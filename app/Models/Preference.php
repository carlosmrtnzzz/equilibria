<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = [
        'user_id',
        'is_celiac',
        'is_lactose_intolerant',
        'is_fructose_intolerant',
        'is_histamine_intolerant',
        'is_sorbitol_intolerant',
        'is_casein_intolerant',
        'is_egg_intolerant',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
