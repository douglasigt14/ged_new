<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class Processos extends BaseController
{
    public function index() {
        $processos = DB::select("SELECT * FROM processos");
        for ($i=0; $i < sizeof($processos); $i++) { 
             $img_temp = $processos[$i]->img;
             $bpmn_temp = $processos[$i]->bpmn;
             $processos[$i]->img = Storage::url($processos[$i]->img); 
             $processos[$i]->bpmn = Storage::url($processos[$i]->bpmn); 

            $xml = Storage::disk('public')->exists( $bpmn_temp ) ? Storage::disk('public')->get($bpmn_temp) : NULL;
            $simple = $xml;
            $p = xml_parser_create();
            xml_parse_into_struct($p, $simple, $vals, $index);
            xml_parser_free($p);
            foreach ($vals as $key => $value) {
               if($value['level']== 3 and ($value['type']== 'open' or $value['type']== 'complete') and $value['tag'] != 'BPMNDI:BPMNPLANE'){
                 DB::table('passos_processo')->updateOrInsert([
                    'tipo' => $value['tag'],
                    'id_bpmn' =>  $value['attributes']['ID'],
                    'nome' =>  $value['attributes']['NAME'] ?? NULL,
                    'de' =>  $value['attributes']['SOURCEREF'] ?? NULL,
                    'para' =>  $value['attributes']['TARGETREF'] ?? NULL,
                    'processo_id' =>  $processos[$i]->id,
                ],
                   ['id_bpmn' => $value['attributes']['ID'] ]
                );
        
               }
            }

            $processos[$i]->xml = $xml;
        }
        return view('processos', compact(["processos"]));
    }
    public function inserir(Request $request){
        $dados = (object) $request->all();
        $img =  $request->file('img');
        $bpmn =  $request->file('bpmn');

          

       $ultimo_id =  DB::table('processos')->insertGetId([
            'descricao' => $dados->descricao,
            'bpmn' => NULL,
            'img' => NULL
        ]);
        
        $url_img = $img ? $img->store('images/'.$ultimo_id ,'public') : NULL;    
        $url_bpmn = $bpmn ? $bpmn->store('images/'.$ultimo_id ,'public'): NULL;   

         DB::table('processos')
              ->where('id', $ultimo_id)
              ->update([
                    'bpmn' =>  $url_bpmn,
                    'img' =>  $url_img
                ]);

        return back();
    }
    public function deletar(Request $request){
         $dados = (object) $request->all();
         DB::table('processos')->where('id', '=', $dados->id )->delete();
         DB::table('passos_processo')->where('processo_id', '=', $dados->id )->delete();
        return back();
    }
    public function editar(Request $request){
         $dados = (object) $request->all();
         DB::table('processos')
              ->where('id', $dados->id)
              ->update([
                    'descricao' => $dados->descricao
                    ]);
        return back();
    }
    public function seguir_fluxo(Request $request){
        $dados = (object) $request->all();
        // passo_processo_id
        $sqlFluxo = "SELECT 
                        pp_princial.*
                        ,pp_de.nome nome_de
                        ,pp_para.nome nome_para
                        ,pp_de.id_bpmn id_de
                        ,pp_para.id_bpmn id_para                        
                    FROM 
                    passos_processo pp_princial LEFT JOIN passos_processo pp_de ON 
                        pp_princial.de = pp_de.id_bpmn 
                    LEFT JOIN passos_processo pp_para ON
                        pp_princial.para = pp_para.id_bpmn
                    WHERE pp_princial.processo_id = $dados->processo_id
                        AND pp_princial.tipo LIKE '%SEQUENCEFLOW%'";

        
        if($dados->passo_processo_id != '0'){
            $sqlFluxo = $sqlFluxo." AND pp_princial.de = '$dados->passo_processo_id'";
        }

        // dd($sqlFluxo);

        $passos_processo_fluxo = DB::select($sqlFluxo);
        $id_para_passo = $passos_processo_fluxo[0]->id_para;
        $setor = strtoupper($passos_processo_fluxo[0]->nome_para);
        
        if($setor == 'Fim' or $setor == 'FIM' or $setor == 'Final'){
            $setor = strtoupper($passos_processo_fluxo[0]->nome_de);
            $setor = DB::select("SELECT * FROM setores WHERE descricao = '$setor' ");
            $setor_id = $setor[0]->id ?? NULL; 
            $setor_pasta = $setor[0]->pasta."\\".'FINALIZADOS' ?? NULL; 
            $finalizado = 1;
            $status = 3;
        }
        else{
            $setor = strtoupper($passos_processo_fluxo[0]->nome_para);
            $setor = DB::select("SELECT * FROM setores WHERE descricao = '$setor' ");
            $setor_id = $setor[0]->id ?? NULL; 
            $setor_pasta = $setor[0]->pasta ?? NULL; 
            $finalizado = 0;
            $status = 2;
            $setor_anterior = $dados->setor_atual_id ?? NULL;

            DB::table('documentos')
              ->where('id', $dados->id)
              ->update([
                    'setor_anterior_id' => $setor_anterior
            ]);
        }
        
        

        // $fonte = $dados->caminho;
        // $copia = $setor_pasta."\\".$dados->arquivo;
        // $res = copy($fonte , $copia);
        // $res = unlink($fonte);

        DB::table('documentos')
              ->where('id', $dados->id)
              ->update([
                    'processo_id' => $dados->processo_id
                    ,'setor_atual_id' => $setor_id ?? NULL
                    ,'status_id' => $status
                    ,'finalizado' => $finalizado
                    ,'passo_processo_id' => $id_para_passo
         ]);
         


         

        return back();
    }
}
