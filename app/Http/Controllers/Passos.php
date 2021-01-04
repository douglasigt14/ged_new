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
                                      FROM 
                                        passos_processo pp_princial
                                    WHERE pp_princial.processo_id = $processo_id 
                                      AND pp_princial.tipo NOT LIKE '%SEQUENCEFLOW%' ");

        for ($i=0; $i < sizeof($passos_processo_fluxo); $i++) { 
            $passos_processo_fluxo[$i]->tipo = 'SEQUENCIA DO FLUXO';
        }
        for ($i=0; $i < sizeof($passos_processo); $i++) { 
            if($passos_processo[$i]->tipo == 'BPMN:STARTEVENT')
                $passos_processo[$i]->tipo = 'EVENTO INICIAL';
            else if($passos_processo[$i]->tipo == 'BPMN:TASK')
                $passos_processo[$i]->tipo = 'SETOR';
            else if($passos_processo[$i]->tipo == 'BPMN:EXCLUSIVEGATEWAY')
                $passos_processo[$i]->tipo = 'DECISSÃO';
            else if($passos_processo[$i]->tipo == 'BPMN:ENDEVENT')
                $passos_processo[$i]->tipo = 'EVENTO FINAL';
            
            if($passos_processo[$i]->tipo == 'SETOR'){
                $passo_id = $passos_processo[$i]->id;
                $status_lista = DB::select("SELECT 
                            status_lista.* 
                        FROM 
                            passos_status
                            ,status_lista
                        WHERE 
                            passos_status.status_id = status_lista.id
                        AND passos_status.passo_id = $passo_id");
            }

            $passos_processo[$i]->status_lista = $status_lista ?? [];
        }


         $processos_img = DB::select("SELECT img FROM processos WHERE id = $processo_id ");
         $img = $processos_img[0]->img ?? NULL;
         $img  = Storage::url($img); 

        $status = DB::select("SELECT * FROM status_lista");

       return view('passos_processo', compact(["passos_processo_fluxo","passos_processo","img","status"]));
    }
    
    public function vincular_status(Request $request){
         $dados = (object) $request->all();
         
         $ultimo_id =  DB::table('passos_status')->updateOrInsert([
            'passo_id' => $dados->passo_id,
            'status_id' => $dados->status_id
        ]);

        return back();
    }
}
