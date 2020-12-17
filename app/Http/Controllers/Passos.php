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
       $passos_processo_fluxo = DB::select("SELECT 
                                            pp_princial.*
                                           ,pp_de.nome nome_de
                                           ,pp_para.nome nome_para
                                      FROM 
                                        passos_processo pp_princial LEFT JOIN passos_processo pp_de ON 
                                            pp_princial.de = pp_de.id_bpmn 
                                        LEFT JOIN passos_processo pp_para ON
                                        	pp_princial.para = pp_para.id_bpmn
                                    WHERE pp_princial.processo_id = 22
                                      AND pp_princial.tipo = 'BPMN:SEQUENCEFLOW' ");
       return view('passos_processo', compact(["passos_processo_fluxo"]));
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
