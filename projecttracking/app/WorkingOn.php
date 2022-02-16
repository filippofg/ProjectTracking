<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingOn extends Model
{
    protected $table = 'working_on';
    protected $fillable = ['user_id', 'project_id'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
