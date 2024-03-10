<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAppointment extends Model
{
    use HasFactory;

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function intakes()
    {
        return $this->hasMany('App\Models\Intake', 'appointment_id');
    }
}
