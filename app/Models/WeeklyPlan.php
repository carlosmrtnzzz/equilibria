<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlan extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'meals_json',
        'pdf_url',
        'changes_left',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
