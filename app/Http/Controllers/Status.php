<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Documentos;
use DB;

class Status extends BaseController
{
    public function index() {
        $id_usuario = $_SESSION['id'];
        $status = DB::select("SELECT * FROM status_lista");

        foreach ($status as $key => $st) {
            if($st->cor != NULL){
                    $resultado = Documentos::verifica_cor($st->cor);
                    $cor_texto = $resultado > 128 ? 'black' : 'white';

                    $st->span_cor = '<center><p style="background-color: '.$st->cor.';color: '.$cor_texto.'" class="label label-warning status-span">&nbsp;</p></center>';
            }
            else{
                $st->span_cor = NULL;
            }

            $usuario_status = DB::select("SELECT * FROM usuario_status WHERE status_lista_id = $st->id AND usuario_id = $id_usuario");
            if($usuario_status){
                $st->visualizacao = 'mostrar'; //é ao contrario
            }
            else{
                $st->visualizacao = 'esconder';
            }
        }
       return view('status', compact(["status"]));
    }
    public function inserir(Request $request){
        $dados = (object) $request->all();
        DB::table('status_lista')->insert([
            'descricao' => $dados->descricao
           ,'cor' => $dados->cor
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
                    ,'cor' => $dados->cor
                    ]);
        return back();
    }
    public function gerenciar_visulizacao(Request $request) {
        $dados = (object) $request->all();
        if($dados->tipo == 'esconder'){
            DB::table('usuario_status')->insert([
                'status_lista_id' => $dados->id
                ,'usuario_id' => $dados->usuario_id
            ]);
        }
        else if($dados->tipo == 'mostrar'){
            DB::table('usuario_status')->where([
                'status_lista_id' => $dados->id
                ,'usuario_id' => $dados->usuario_id
            ])->delete();
        }
        return back();
    }
}
