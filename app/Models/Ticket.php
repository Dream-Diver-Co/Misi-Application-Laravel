<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function therapist()
    {
        return $this->belongsTo('App\Models\Therapist');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function histories()
    {
        return $this->hasMany('App\Models\TicketHistory');
    }

    public function forms()
    {
        return $this->hasMany('App\Models\Form');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\TicketAppointment');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\Attachment');
    }
}
