<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index() {
        // return 3d map view
        return view('map');
    }
  
}
