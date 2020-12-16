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

        $url_img = $img->store('images/'.$ultimo_id ,'public') ?? NULL;    
        $url_bpmn = $bpmn->store('images/'.$ultimo_id ,'public') ?? NULL;   

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
