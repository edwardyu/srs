<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
  public function mainPage(Request $request){
    return view('welcome') -> with('isloggedin',true);
  }
}
