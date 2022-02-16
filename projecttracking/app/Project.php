<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'notes', 'cost_per_hour', 'created_at', 'customer_vat_number'];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_vat_number', 'vat_number');
    }
    public function working_on()
    {
        return $this->hasMany('App\WorkingOn');
    }
    public function timesheets()
    {
        return $this->hasMany('App\Timesheet');
    }
}
