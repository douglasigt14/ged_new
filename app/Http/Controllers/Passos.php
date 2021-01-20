<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                                    WHERE pp_princial.processo_id = $processo_id 
                                      AND pp_princial.tipo LIKE '%SEQUENCEFLOW%' ");
        
        $passos_processo = DB::select("SELECT 
                                            pp_princial.*
                                           ,setores.descricao setor
                                      FROM 
                                        passos_processo pp_princial LEFT JOIN setores ON
                                          setores.id =   pp_princial.quem_decide
                                    WHERE pp_princial.processo_id = $processo_id 
                                      AND pp_princial.tipo NOT LIKE '%SEQUENCEFLOW%' ");

        for ($i=0; $i < sizeof($passos_processo_fluxo); $i++) { 
            $passos_processo_fluxo[$i]->tipo = 'SEQUENCIA DO FLUXO';
        }

        for ($i=0; $i < sizeof($passos_processo); $i++) { 
            if($passos_processo[$i]->tipo == 'BPMN:STARTEVENT' or $passos_processo[$i]->tipo == 'STARTEVENT')
                $passos_processo[$i]->tipo = 'EVENTO INICIAL';
            else if($passos_processo[$i]->tipo == 'BPMN:TASK' or $passos_processo[$i]->tipo == 'TASK')
                $passos_processo[$i]->tipo = 'SETOR';
            else if($passos_processo[$i]->tipo == 'BPMN:EXCLUSIVEGATEWAY' or $passos_processo[$i]->tipo == 'EXCLUSIVEGATEWAY')
                $passos_processo[$i]->tipo = 'DECISSÃO';
            else if($passos_processo[$i]->tipo == 'BPMN:ENDEVENT' or $passos_processo[$i]->tipo == 'ENDEVENT')
                $passos_processo[$i]->tipo = 'EVENTO FINAL';
            
            if($passos_processo[$i]->tipo == 'SETOR'){
                $passo_id = $passos_processo[$i]->id;
                $status_lista = DB::select("SELECT 
                            status_lista.* 
                        FROM 
                            status_lista LEFT JOIN passos_status ON
                            passos_status.status_id = status_lista.id AND passos_status.passo_id = $passo_id
                        WHERE 
                            IFNULL(passos_status.passo_id,0) = 0");
                
                $status_lista_selecionados = DB::select("SELECT 
                            status_lista.* 
                           ,passos_status.id passos_status_id
                        FROM 
                            status_lista INNER JOIN passos_status ON
                            passos_status.status_id = status_lista.id 
                        WHERE 
                            passos_status.passo_id = $passo_id");
            }

            $passos_processo[$i]->status_lista = $status_lista ?? [];
            $passos_processo[$i]->status_lista_selecionados = $status_lista_selecionados ?? [];
        }

        $setores = DB::select("SELECT * FROM setores");

         $processos_img = DB::select("SELECT img FROM processos WHERE id = $processo_id ");
         $img = $processos_img[0]->img ?? NULL;
         $img  = Storage::url($img); 

       

       return view('passos_processo', compact(["passos_processo_fluxo","passos_processo","img","setores"]));
    }
    
    public function vincular_status(Request $request){
         $dados = (object) $request->all();
         
         DB::table('passos_status')->updateOrInsert([
            'passo_id' => $dados->passo_id,
            'status_id' => $dados->status_id
        ]);

        return back();
    }
    public function desvincular_status($id = null){
        DB::table('passos_status')->where('id', '=', $id )->delete();
        return back();
    }

     public function gerenciar_quem_decide(Request $request){
            $dados = (object) $request->all();
            
             DB::table('passos_processo')
              ->where('id', $dados->passo_id)
              ->update([
                    'quem_decide' => $dados->setor_id
                    ]);

        return back();
     }
}
