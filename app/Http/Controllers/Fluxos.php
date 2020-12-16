<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;

class Fluxos extends BaseController
{
    public function index() {
        $fluxos = [];
       return view('desenho_fluxos', compact(["fluxos"]));
    }
}
