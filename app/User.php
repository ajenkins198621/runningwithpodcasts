<?php

namespace App;

use App\Runs;
use App\Profile;

use Illuminate\Notifications\Notifiable;
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

    public function runs()
    {
        return $this->hasMany(Runs::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function createRun($distance, $distance_units_id, $duration, $location = "", $date = null)
    {
        $date = !$date ? date("Y-m-d H:i:s") : $date;
        $run = $this->runs()->create([
            'distance' => $distance,
            'distance_units_id' => $distance_units_id,
            'duration' => $duration,
            'location' => $location,
            'date' => $date
        ]);
        return $run;
    }
}
