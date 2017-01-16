<?php

namespace App\Http\Controllers;


use App\Runs;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RunsController extends Controller
{

    public function show($run_id)
    {
        $run = Runs::isPublic()->find($run_id);
        $view = $run ? "run" : "unpublished";
        return view($view, ['run' => $run]);
    }

    public function store()
    {
        $this->validate(request(), [
            "user_id" => ["required","numeric", "min:1"],
            "distance" => ["required","numeric", "min:1"],
            "distance_units_id" => ["required","numeric", "min:1"],
            "duration" => ["required","numeric", "min:1"],
        ]);

        $run = Runs::create([
            "user_id" => request('user_id'),
            "distance" => request('distance'),
            "distance_units_id" => request('distance_units_id'),
            "duration" => request('duration'),
            "location" => request('location'),
            "date" => request('date')
        ]);
        return json_encode(['created' => ($run)]);
    }
}
