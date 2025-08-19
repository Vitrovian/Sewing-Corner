<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObserveController extends Controller
{
    public function show(){
        return view('pages.observe-user');
    }

}
