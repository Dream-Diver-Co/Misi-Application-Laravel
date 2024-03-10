<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public function form()
    {
        return $this->belongsTo('App\Models\Form');
    }

    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }
}
