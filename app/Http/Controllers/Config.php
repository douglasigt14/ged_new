<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class Config extends Controller
{
    public function index($documento_id = null) {
        $documento = DB::select("SELECT * FROM documentos WHERE id = $documento_id");
        $log_documentos = DB::select("SELECT * FROM log_documentos WHERE documento_id = $documento_id");
        $doc_descricao = $documento[0]->descricao ?? NULL;

        return view('config', compact(["documento_id","documento","doc_descricao","log_documentos"]));
    }
    public function editar_descricao (Request $request){
        $dados = (object) $request->all();
         DB::table('documentos')
              ->where('id', $dados->id)
              ->update([
                    'descricao' => $dados->descricao
         ]);

        return back()->with('sucesso-descricao', 'Descrição Alterada com Sucesso');
    }
}
