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
               if($value['level']== 3 and ($value['type']== 'open' or $value['type']== 'complete') ){
                 var_dump($value);
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
