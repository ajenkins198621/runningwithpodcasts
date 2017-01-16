<?php

namespace App\Http\Controllers;

use App\DistanceUnits;
use App\Runs;

use Illuminate\Http\Request;

class RunsController extends Controller
{

    public function show($run_id) {
        $run = Runs::isPublic()->find($run_id);
        $view = $run ? "run" : "unpublished";
        return view($view, ['run' => $run]);
    }
}
