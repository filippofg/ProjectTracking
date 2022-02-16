<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'surname', 'email', 'password', 'is_admin', 'created_at', 'updated_at'];
    //protected $hidden = ['password'];

    /*
    protected $primaryKey = 'email';
    public $incrementing = false;       // primary key non incrementabile, senza cast ad integer
    */
    public function working_on()
    {
        return $this->hasMany('App\WorkingOn');
    }
    public function timesheets()
    {
        return $this->hasMany('App\Timesheet');
    }
}
