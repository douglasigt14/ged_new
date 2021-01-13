<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
class Anexos_Obs extends Controller
{
    public function index($documento_id = null) {
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
                WHERE 
                    documentos.id = $documento_id";
       
        $documentos = DB::select($sql);
        $anexos =  DB::select("SELECT * FROM anexos WHERE documento_id = $documento_id");
        for ($i=0; $i < sizeof($anexos); $i++) {
             $anexos[$i]->caminho  = Storage::url($anexos[$i]->caminho); 
        }


        return view('anexos_obs', compact(["anexos","documentos","documento_id"]));
    }
    public function inserir_anexo(Request $request) {
         $dados = (object) $request->all();
         $documento =  $request->file('documento');
         
         $ultimo_id = DB::table('anexos')->insertGetId([
                            'descricao' => $dados->descricao
                            , 'documento_id' =>  $dados->documento_id
                        ]);
        $caminho = $documento ? $documento->store('docs/'.$dados->documento_id.'/anexos/'.$ultimo_id ,'public') : NULL;    

        DB::table('anexos')
            ->where('id', $ultimo_id)
            ->update([
                'caminho' =>  $caminho
        ]);

        return back();
    }
    public function deletar_anexo(Request $request){
         $dados = (object) $request->all();
         DB::table('anexos')->where('id', '=', $dados->id )->delete();
        return back();
    }

    public function inserir_obs(Request $request) {
        $dados = (object) $request->all();
        DB::table('obs')->insert([
            'descricao' => $dados->descricao
            , 'documento_id' =>  $dados->documento_id
        ]);

        return back();
    }
}
