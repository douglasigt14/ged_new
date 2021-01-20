<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class Documentos extends Controller
{
    public function index($mostrar_finalizados = null, $mostrar_outros_setores = null) {
        $id_usuario = $_SESSION['id'];
        //dd($mostrar_outros_setores);
        $usuario = DB::select("SELECT 
                                    usuarios.*
                                    ,setores.pasta
                                    ,setores.descricao setor
                                    ,setores.id setor_id
                                FROM usuarios INNER JOIN setores ON 
                                    usuarios.setor_id = setores.id 
                            WHERE 
                                usuarios.id = $id_usuario");
        $path = $usuario[0]->pasta;
        $setor = $usuario[0]->setor;
        $setor_id = $usuario[0]->setor_id;

        $path_geral = $usuario[0]->pasta."\\INICIAR";
       
        $lista_arquivos = [];//$this->read_dir($path);
        $lista_arquivos_geral = [];//$this->read_dir($path_geral);

        // $lista_arquivos_geral = $this->manipular_lista($lista_arquivos_geral,$path_geral);
        

        $processos = DB::select("SELECT  
                          processos.id
                         ,processos.descricao                    
                    FROM 
                    passos_processo pp_princial LEFT JOIN passos_processo pp_de ON 
                        pp_princial.de = pp_de.id_bpmn 
                    LEFT JOIN passos_processo pp_para ON
                        pp_princial.para = pp_para.id_bpmn
                    INNER JOIN processos ON
                    	processos.id = pp_princial.processo_id
                    WHERE 
                            pp_princial.tipo LIKE '%SEQUENCEFLOW%'
                        AND pp_de.tipo LIKE '%STARTEVENT%'
                        AND pp_para.nome = '$setor'");

       

        $sql = "SELECT 
                    documentos.* 
                ,s_atual.descricao setor_atual
                ,s_anterior.descricao setor_anterior
                ,processos.descricao descricao_processo
                ,processos.img processos_img
                ,status_lista.descricao status_desc
                ,status_lista.cor cor
                ,passos_processo.tipo tipo_passo
                ,passos_processo.nome nome_passo
                ,s_quem_decide.descricao quem_decide
                FROM 
                    documentos 
                    LEFT JOIN setores s_atual ON
                    documentos.setor_atual_id = s_atual.id
                    LEFT JOIN setores s_anterior ON
                    documentos.setor_anterior_id = s_anterior.id
                    INNER JOIN processos ON
                    processos.id = documentos.processo_id
                    INNER JOIN status_lista ON
                    	documentos.status_id = status_lista.id
                    INNER JOIN passos_processo ON
                        documentos.passo_processo_id = passos_processo.id_bpmn
                    LEFT JOIN setores s_quem_decide ON
                    passos_processo.quem_decide = s_quem_decide.id
                    WHERE 1";
        if(!$mostrar_finalizados){
            $sql = $sql." AND documentos.finalizado = 0";
        }
        if(!$mostrar_outros_setores){
            $sql = $sql." AND (documentos.setor_atual_id = $setor_id) OR 
            ( (passos_processo.tipo LIKE '%EXCLUSIVEGATEWAY%') AND (passos_processo.quem_decide = $setor_id) )";
        }
        $finalizados_checked =  $mostrar_finalizados ? true : false;
        $outros_setores_checked =  $mostrar_outros_setores ? true : false;

        $lista_arquivos = DB::select($sql);
        $lista_processo = [];
        foreach ($lista_arquivos as $key => $lista) {
            $sufixo_lista_processo = ($lista->tipo_passo != 'BPMN:EXCLUSIVEGATEWAY' and $lista->tipo_passo != 'EXCLUSIVEGATEWAY') ? ' |  No Setor de <b>'.$lista->setor_atual.'</b>' : '<b style="color: red"> | EM DECISSÃO</b>';
            if(in_array($setor_id,explode(',',$lista->setores_fluxo))){
               array_push($lista_processo,$lista->descricao_processo);
            }
            else{
                unset($lista_arquivos[$key]);
            }

            if($lista->tipo_passo == 'BPMN:EXCLUSIVEGATEWAY' or $lista->tipo_passo == 'EXCLUSIVEGATEWAY'){
                $lista->bifurcacoes = DB::select("SELECT 
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
                    WHERE pp_princial.processo_id = $lista->processo_id
                        AND pp_princial.tipo LIKE '%SEQUENCEFLOW%'
                        AND pp_princial.de = '$lista->passo_processo_id'");
            }
            $lista->caminho = Storage::url($lista->caminho); 
            $cor = $lista->cor ?? '#d3d3d3';
            $resultado = $this->verifica_cor($cor);
            $lista->cor_texto = $resultado > 128 ? 'black' : 'white';
            $lista->status_lista = DB::select("SELECT * FROM status_lista WHERE id NOT IN (1,3,$lista->status_id) ");
            $lista->processos_img = Storage::url($lista->processos_img); 
            $lista->caminho_svg = Storage::url($lista->caminho_svg); 
        }
        $lista_processo = array_unique($lista_processo);

        $lista_arquivos = collect($lista_arquivos)->sortBy('setor_atual_id')->reverse()->toArray();

        $setor_caminho = strtoupper($setor);
        $sql = "SELECT 
                    documentos.*
                    ,status_lista.descricao status_desc
                    ,status_lista.cor cor
                FROM 
                    documentos 
                    INNER JOIN status_lista ON
                    documentos.status_id = status_lista.id
                WHERE 
                    processo_id IS NULL
                AND documentos.upload_usuario_id = $id_usuario";

        $lista_arquivos_geral = DB::select($sql);

        foreach ($lista_arquivos_geral as $key => $lista) {
            $lista->caminho = Storage::url($lista->caminho); 
            
            $cor = $lista->cor ?? '#d3d3d3';
            $resultado = $this->verifica_cor($cor);
            $cor_texto = $resultado > 128 ? 'black' : 'white';
            $lista->status = '<center><p style="background-color: '.$cor.';color: '.$cor_texto.'" class="label label-warning status-span">'.$lista->status_desc.'</p></center>';

            
        }

        
        

       return view('documentos', compact(["lista_arquivos","lista_arquivos_geral","processos","setor","lista_processo","finalizados_checked","outros_setores_checked"]));
    }

    public static function verifica_cor($cor){
        $red = hexdec(substr($cor, 1, 2));
        $green = hexdec(substr($cor, 3, 2));
        $blue = hexdec(substr($cor, 5, 2));
        $resultado = (($red * 299) + ($green * 587) + ($blue * 114)) / 1000;

        return $resultado;
    }
    public function inserir(Request $request){
        $dados = (object) $request->all();
        $documento =  $request->file('documento');

        
        $ultimo_id = DB::table('documentos')->insertGetId([
                            'descricao' => $dados->descricao
                            , 'status_id' => 1
                            ,'upload_usuario_id' => $dados->usuario_id
                        ]);
        $caminho = $documento ? $documento->store('docs/'.$ultimo_id ,'public') : NULL;    

        DB::table('documentos')
            ->where('id', $ultimo_id)
            ->update([
                'caminho' =>  $caminho
        ]);

        return back();
    }
    public function deletar(Request $request){
         $dados = (object) $request->all();
         DB::table('documentos')->where('id', '=', $dados->id )->delete();
        return back();
    }
    public function alterar_status(Request $request){
        $dados = (object) $request->all();
        DB::table('documentos')
            ->where('id', $dados->id)
            ->update([
                'status_id' =>  $dados->status_id
        ]);
        return back();
    }
}
