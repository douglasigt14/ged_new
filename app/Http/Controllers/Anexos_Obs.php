<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Anexos_Obs extends Controller
{
    public function index($id = null) {
        return 'Anexos e Obs: '.$id;
    }
}
