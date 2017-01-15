<?php

namespace App;

use App\Runs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{

    use SoftDeletes;

    protected $guarded = [];


    public function scopeUsername($query,$username)
    {
        return $query->where("username","=",$username);
    }

    public function scopeIsPublic($query)
    {
        return $query->where("public","=",1);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }
}
