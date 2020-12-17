<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;

class Passos extends BaseController
{
    public function index($processo_id = null) {
       $passos_processo = DB::select("SELECT * FROM passos_processo WHERE processo_id = $processo_id");
       dd($passos_processo);
       return view('passos_processo', compact(["passos_processo"]));
    }
    public function inserir(Request $request){
        $dados = (object) $request->all();
        DB::table('setores')->insert([
            'descricao' => $dados->descricao,
            'pasta' => $dados->pasta
        ]);
        return back();
    }
    public function deletar(Request $request){
         $dados = (object) $request->all();
         DB::table('setores')->where('id', '=', $dados->id )->delete();
        return back();
    }
    public function editar(Request $request){
         $dados = (object) $request->all();
         DB::table('setores')
              ->where('id', $dados->id)
              ->update([
                    'descricao' => $dados->descricao
                   ,'pasta' => $dados->pasta
                    ]);
        return back();
    }
}
