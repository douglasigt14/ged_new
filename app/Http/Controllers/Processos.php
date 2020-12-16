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
        $images =  $request->file('img');
        //dd($images);
     
        $url = $images->store('images' ,'public');     
           dd($url);
        DB::table('processos')->insert([
            'descricao' => $dados->descricao,
            'bpmn' => $dados->bpmn,
            'img' => $dados->img
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
