<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $guarded = [];


    public function scopeUsername($query,$username) {
        return $query->where("username","=",$username);
    }

    public function getFullNameAttribute() {
        return $this->first_name." ".$this->last_name;
    }
}
