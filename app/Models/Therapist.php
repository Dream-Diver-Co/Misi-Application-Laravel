<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function worktime()
    {
        return $this->hasOne('App\Models\WorkDayTime');
    }

    public function leaves()
    {
        return $this->hasMany('App\Models\LeaveSchedule');
    }
}
