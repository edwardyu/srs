<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    //

    public function getSettings()
    {
        return view('settings.main');
    }

}
