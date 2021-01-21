<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Config extends Controller
{
    public function index($documento_id = null) {

         return view('config', compact(["documento_id"]));
    }
}
