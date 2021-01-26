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


            $xml_img = Storage::disk('public')->exists( $img_temp ) ? Storage::disk('public')->get($img_temp) : NULL;
            $simple_img = $xml_img;
            $p_img = xml_parser_create();
            xml_parse_into_struct($p_img, $simple_img, $vals_img, $index);
            xml_parser_free($p_img);
            foreach ($vals_img as $key => $value) {
                if($value['level']==3 and $value['tag'] == 'G'){
                   //var_dump($value);
                }
            }

            
            $url_bpmn = substr($processos[$i]->bpmn, 1);
            $url_svg = substr($processos[$i]->img, 1); //tirar a primeira Barra

            $carregador_xml = simplexml_load_file($url_svg);
            
            foreach ($carregador_xml->g as $key => $item) {
               
                $id_svg = $item->g["data-element-id"];
                $nome = $item->g->g->text->tspan;
                $nome = $nome[0].''.$nome[1].''.$nome[2];
                
                DB::table('passos_processo')
                    ->where([
                                'processo_id' => $processos[$i]->id,
                                'nome' => $nome 
                            ])
                    ->update([
                            'id_svg' =>  $id_svg,
                ]);
            }
           
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
        if(!$dados->processo_id){
            return back()->with('error-iniciar', 'Selecione um Processo para Iniciar o Fluxo');
        }
        $tem_bifurcacao = $dados->tem_bifurcacao ?? NULL;
        $sqlFluxo = "SELECT 
                        pp_princial.*
                        ,pp_de.nome nome_de
                        ,pp_para.nome nome_para
                        ,pp_de.id_bpmn id_de
                        ,pp_para.id_bpmn id_para 
                        ,pp_de.tipo tipo_de
                        ,pp_para.tipo tipo_para
                    FROM 
                    passos_processo pp_princial LEFT JOIN passos_processo pp_de ON 
                        pp_princial.de = pp_de.id_bpmn 
                    LEFT JOIN passos_processo pp_para ON
                        pp_princial.para = pp_para.id_bpmn
                    WHERE pp_princial.processo_id = $dados->processo_id
                        AND pp_princial.tipo LIKE '%SEQUENCEFLOW%'";

        $proc = DB::select("SELECT img FROM processos WHERE id = $dados->processo_id");
        $url_svg = $proc[0]->img;
        $url = 'svgs/'.$dados->id.'/'.$url_svg;

        if($tem_bifurcacao){//Decissões (Com id) 
            $sqlFluxo = $sqlFluxo." AND pp_princial.id = '$dados->passo_processo_id'";
        }    
        else if($dados->passo_processo_id != '0'){ //Os Demais (Com id_bpmn "de")
            $sqlFluxo = $sqlFluxo." AND pp_princial.de = '$dados->passo_processo_id'";
        }
        else{ //Quando é o Primeiro 
            
            $sqlFluxo = $sqlFluxo." AND pp_de.tipo LIKE '%STARTEVENT%'";
            Storage::disk('public')->copy($url_svg,$url);
        
            
            //Descobrir quais são os Setores que participam do Fluxo
            $sqlFluxo_setores =  "SELECT 
                        pp_princial.nome                        
                    FROM 
                    passos_processo pp_princial LEFT JOIN passos_processo pp_de ON 
                        pp_princial.de = pp_de.id_bpmn 
                    LEFT JOIN passos_processo pp_para ON
                        pp_princial.para = pp_para.id_bpmn
                    WHERE pp_princial.processo_id = $dados->processo_id
                        AND pp_princial.tipo LIKE '%TASK%'";
            
             $setores_fluxo = DB::select($sqlFluxo_setores);
             
             $setor_id_array = [];
             foreach ($setores_fluxo as $key => $s_f) {
                $setor_consulta = DB::select("SELECT * FROM setores WHERE descricao = '$s_f->nome' "); 
                array_push($setor_id_array,$setor_consulta[0]->id ?? NULL);
             } 
             $setores_fluxo = implode(",",$setor_id_array);
             
             DB::table('documentos')
              ->where('id', $dados->id)
              ->update([
                    'setores_fluxo' => $setores_fluxo,
                    'caminho_svg' => $url,
                    'status' => 2
            ]);
            //Descobrir quais são os Setores que participam do Fluxo
        }


        $passos_processo_fluxo = DB::select($sqlFluxo);
        $id_para_passo = $passos_processo_fluxo[0]->id_para;
        $id_de_passo = $passos_processo_fluxo[0]->id_de;

        $tipo_para = $passos_processo_fluxo[0]->tipo_para;
        $tipo_de = $passos_processo_fluxo[0]->tipo_de;

        $setor = strtoupper($passos_processo_fluxo[0]->nome_para);

        $url_storage = 'storage/'.$url;
        $carregador_xml = simplexml_load_file($url_storage );

        foreach ($carregador_xml->g as $key => $item) {
            
            $id_svg = $item->g["data-element-id"];
            
            // var_dump($id_svg .'|'.$dados->passo_processo_id);
            if($id_svg == $id_de_passo){
                $item->g->g->rect['style'] = str_replace('fill: white;','',$item->g->g->rect['style']);
                $item->g->g->rect['style'] = str_replace('fill: #BEBEBE;','',$item->g->g->rect['style']);
                $item->g->g->rect['style'] = $item->g->g->rect['style'].'fill:  #BEBEBE;';

                $item->g->g->circle['style'] = str_replace('fill: white;','',$item->g->g->circle['style']);
                $item->g->g->circle['style'] = str_replace('fill:  #BEBEBE;','',$item->g->g->circle['style']);
                $item->g->g->circle['style'] = $item->g->g->circle['style'].'fill:  #BEBEBE;';

                $item->g->g->polygon['style'] = str_replace('fill: white;','',$item->g->g->polygon['style']);
                $item->g->g->polygon['style'] = str_replace('fill:  #BEBEBE;','',$item->g->g->polygon['style']);
                $item->g->g->polygon['style'] = $item->g->g->polygon['style'].'fill:  #BEBEBE;';
                
            }
            if($id_svg == $id_para_passo){
                $item->g->g->rect['style'] = str_replace('fill: white;','',$item->g->g->rect['style']);
                $item->g->g->rect['style'] = str_replace('fill: #41B314;','',$item->g->g->rect['style']);
                $item->g->g->rect['style'] = str_replace('fill: #BEBEBE;','',$item->g->g->rect['style']);
                $item->g->g->rect['style'] = $item->g->g->rect['style'].'fill:  #41B314;';

                $item->g->g->circle['style'] = str_replace('fill: white;','',$item->g->g->circle['style']);
                $item->g->g->circle['style'] = str_replace('fill:  #41B314;','',$item->g->g->circle['style']);
                $item->g->g->circle['style'] = str_replace('fill: #BEBEBE;','',$item->g->g->circle['style']);
                $item->g->g->circle['style'] = $item->g->g->circle['style'].'fill:  #41B314;';

                $item->g->g->polygon['style'] = str_replace('fill: white;','',$item->g->g->polygon['style']);
                $item->g->g->polygon['style'] = str_replace('fill:  #41B314;','',$item->g->g->polygon['style']);
                $item->g->g->polygon['style'] = str_replace('fill: #BEBEBE;','',$item->g->g->polygon['style']);
                $item->g->g->polygon['style'] = $item->g->g->polygon['style'].'fill:  #41B314;';
                
            }
            if($tipo_para == 'ENDEVENT' or  $tipo_para == 'BPMN:ENDEVENT'){
                if($id_svg == $id_para_passo){
                    $item->g->g->circle['style'] = str_replace('fill: white;','',$item->g->g->circle['style']);
                    $item->g->g->circle['style'] = str_replace('fill:  #BEBEBE;','',$item->g->g->circle['style']);
                    $item->g->g->circle['style'] = $item->g->g->circle['style'].'fill:  #BEBEBE;';
                }
            }
        }
        
        $newString = $carregador_xml->asXML();
        $arquivo = fopen($url_storage ,'w');
        fwrite($arquivo,$newString);
        
        if($tipo_para == 'ENDEVENT' or  $tipo_para == 'BPMN:ENDEVENT'){
            $setor = strtoupper($passos_processo_fluxo[0]->nome_de);
            $setor = DB::select("SELECT * FROM setores WHERE descricao = '$setor' ");
            $setor_id = $setor[0]->id ?? NULL; 
            $finalizado = 1;
            $status = 3;

             DB::table('documentos')
              ->where('id', $dados->id)
              ->update([
                    'status_id' => $status
                    ,'finalizado' => $finalizado
            ]);
        }
        else{
            $setor = strtoupper($passos_processo_fluxo[0]->nome_para);
            $setor = DB::select("SELECT * FROM setores WHERE descricao = '$setor' ");
            $setor_id = $setor[0]->id ?? NULL; 
            $setor_anterior = $dados->setor_atual_id ?? NULL;

            DB::table('documentos')
              ->where('id', $dados->id)
              ->update([
                    'setor_anterior_id' => $setor_anterior
            ]);
        }
        

        $atualizar = DB::table('documentos')
              ->where('id', $dados->id)
              ->update([
                    'processo_id' => $dados->processo_id
                    ,'setor_atual_id' => $setor_id ?? NULL
                    ,'passo_processo_id' => $id_para_passo
         ]);
         
         $usuario_id = $dados->usuario_id;
         $ip = $_SERVER['REMOTE_ADDR'];

        if($atualizar){
            DB::table('log_fluxo')->insert([
                    'usuario_id' =>  $usuario_id
                   ,'ip' => $ip
                   ,'processo_id' => $dados->processo_id
                   ,'id_bpmn_de' => $passos_processo_fluxo[0]->id_de
                   ,'id_bpmn_para' => $passos_processo_fluxo[0]->id_para
                   ,'nome_de' => $passos_processo_fluxo[0]->nome_de
                   ,'nome_para' => $passos_processo_fluxo[0]->nome_para
                   ,'documento_id' => $dados->id
                   ,'nome_seta' => $passos_processo_fluxo[0]->nome ?? NULL
            ]);
        }                

         $documento = DB::select("SELECT * FROM documentos WHERE id = $dados->id");
         $desc_documento = $documento[0]->descricao ?? NULL;

        return back()->with('sucesso-seguir', 'Arquivo ('.$desc_documento.') movimentou-se <br>De: '.$passos_processo_fluxo[0]->nome_de.' Para: '.$passos_processo_fluxo[0]->nome_para);
    }
    
    public function desvincular_processo(Request $request){
        $dados = (object) $request->all();
        $caminho_svg = str_replace("/storage/","", $dados->caminho_svg );
        $arquivo = Storage::disk('public')->exists( $caminho_svg ) ? Storage::disk('public')->delete($caminho_svg) : NULL;

        DB::table('documentos')
              ->where('id', $dados->id)
              ->update([
                    'setores_fluxo' => NULL,
                    'caminho_svg' => NULL,
                    'setor_anterior_id' => NULL,
                    'setor_atual_id' => NULL,
                    'status_id' => 1,
                    'processo_id' => NULL
        ]);

         return back()->with('desvincular', 'Arquivo foi desvinculado do processo e zerado');
    }
}
