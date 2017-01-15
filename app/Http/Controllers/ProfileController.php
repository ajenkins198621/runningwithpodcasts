<?php

namespace App\Http\Controllers;

use App\Profile;


use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function show($username)
    {
        $profile = Profile::username($username)->first();
        $view = $profile->public ? "profile" : "unpublished";
        return view($view, ["profile" => $profile]);
    }

}
