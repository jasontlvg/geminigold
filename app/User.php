<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departamento(){
        return $this->belongsTo('App\Departamento');
    }

    public function resultados()
    {
//        return $this->hasMany('App\Resultado','empleado_id','id')->where('encuesta_id',1); //XxX
        return $this->hasMany('App\Resultado','empleado_id','id')->select('id','encuesta_id','pregunta_id','respuesta_id','empleado_id');
    }

}
