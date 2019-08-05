<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    public function empleado()
    {
        return $this->belongsTo('App\User');
    }
}
