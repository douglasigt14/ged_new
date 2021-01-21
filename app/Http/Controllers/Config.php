<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class Config extends Controller
{
    public function index($documento_id = null) {
        $documento = DB::select("SELECT * FROM documentos WHERE id = $documento_id");
        $doc_descricao = $documento[0]->descricao ?? NULL;

        return view('config', compact(["documento_id","documento","doc_descricao"]));
    }
}
