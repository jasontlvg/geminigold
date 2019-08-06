<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta');
    }
}
