<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
	public function mainPage(Request $request)
	{
		if(!Auth::check())
			return view('welcome');
		else
			return view('deck.create')->with(['user' => Auth::user()]);
	}
}
