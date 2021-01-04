<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;

class Status extends BaseController
{
    public function index() {
        $status = DB::select("SELECT * FROM status_lista");
       return view('status', compact(["status"]));
    }
    public function inserir(Request $request){
        $dados = (object) $request->all();
        DB::table('status_lista')->insert([
            'descricao' => $dados->descricao
        ]);
        return back();
    }
    public function deletar(Request $request){
         $dados = (object) $request->all();
         DB::table('status_lista')->where('id', '=', $dados->id )->delete();
        return back();
    }
    public function editar(Request $request){
         $dados = (object) $request->all();
         DB::table('status_lista')
              ->where('id', $dados->id)
              ->update([
                    'descricao' => $dados->descricao
                    ]);
        return back();
    }
}
