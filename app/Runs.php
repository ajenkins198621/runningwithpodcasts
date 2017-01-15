<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Runs extends Model
{

    use SoftDeletes;

    protected $guarded = [];


    public function scopeIsPublic($query)
    {
        return $query->where('public','=',1);
    }

    public function getDistanceInTextAttribute()
    {
        return number_format(($this->distance / 100), 2);
    }

    public function getDurationInTextAttribute()
    {
        return date($this->formatTimeString($this->duration),$this->duration);
    }

    private function formatTimeString($seconds)
    {
        if($seconds < 3600) {
            return "i:s";
        }
        return "H:i:s";
    }

}
