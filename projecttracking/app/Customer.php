<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['vat_number', 'business_name', 'referent_name', 'referent_surname', 'referent_email', 'ssid', 'pec'];

    protected $primaryKey = 'vat_number';
    public $incrementing = false;           // primary key non incrementabile, senza cast ad integer

    public function projects()
    {
        return $this->hasMany('App\Project');
    }
}
