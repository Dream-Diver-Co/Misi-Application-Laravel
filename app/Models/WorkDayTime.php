<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDayTime extends Model
{
    use HasFactory;

    public function therapist()
    {
        return $this->belongsTo('App\Models\Therapist');
    }
}
