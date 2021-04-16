<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;

class Setores extends BaseController
{
    public function index() {
        $setores = DB::select("SELECT 
                                    setores.*
                                   ,usuarios.rotulo
                               FROM 
                                    setores LEFT JOIN usuarios ON
                                    setores.lider_id = usuarios.id");
        
        foreach ($setores as $key => $setor) {
            $lista_usuarios = DB::select("SELECT 
                                                id
                                               ,rotulo
                                            FROM 
                                                usuarios
                                            WHERE
                                               setor_id = '$setor->id'");
            $setor->lista_usuarios = $lista_usuarios;
        }

        return view('setores', compact(["setores"]));
    }
    public function inserir(Request $request){
        $dados = (object) $request->all();
        DB::table('setores')->insert([
            'descricao' => $dados->descricao,
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
                    ,'lider_id' => $dados->lider_id
                    ]);
        return back();
    }
}
