<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class Config extends Controller
{
    public function index($documento_id = null) {
        $documento = DB::select("SELECT * FROM documentos WHERE id = $documento_id");
        $log_documentos = DB::select("SELECT * FROM log_documentos WHERE documento_id = $documento_id");
        $doc_descricao = $documento[0]->descricao ?? NULL;
        $dt_vencimento = $documento[0]->dt_vencimento ?? NULL;
        $num_pedido = $documento[0]->num_pedido ?? NULL;
        $empr_id = $documento[0]->empr_id ?? NULL;
        //dd($dt_vencimento);
        $empresas  = DB::connection("oracle")->select("SELECT * FROM FOCCO3i.tempresas");

        

        for ($i=0; $i < sizeof($log_documentos); $i++) { 
            $log_documentos[$i]->caminho = Storage::url($log_documentos[$i]->caminho); 

            $partes = explode(" ",$log_documentos[$i]->systemdate);
            $data = $partes[0];
            $hora = $partes[1];
            $partes = explode("-",$data);
            $data = $partes[2]."/".$partes[1].'/'.$partes[0];
            $log_documentos[$i]->systemdate = $data.' '.$hora;
        }

        return view('config', compact(["documento_id","documento","doc_descricao","log_documentos","dt_vencimento","num_pedido","empresas","empr_id"]));
    }
    public function editar_descricao (Request $request){
        $dados = (object) $request->all();
         DB::table('documentos')
              ->where('id', $dados->id)
              ->update([
                    'descricao' => $dados->descricao
                    ,'dt_vencimento' => $dados->dt_vencimento
                    ,'num_pedido' => $dados->num_pedido
                    ,'empr_id' => $dados->empr_id
         ]);

        return back()->with('sucesso-descricao', 'Informações alteradas com Sucesso');
    }

    public function inserir_doc(Request $request){
        $dados = (object) $request->all();
        $documento =  $request->file('documento');
       // dd($dados);
        $caminho = $documento ? $documento->store('docs/'.$dados->id ,'public') : NULL;  

        DB::table('log_documentos')->insert([
            'documento_id' =>  $dados->id
            , 'caminho' => $caminho
            ,'is_principal' => 0
            ,'obs' => $dados->obs
            ,'upload_usuario_id' => $dados->usuario_id
        ]);

        return back()->with('sucesso-doc', 'Documento upado com Sucesso');
    }

    public function trocar_principal(Request $request){
        $dados = (object) $request->all();
        $log_documentos = DB::select("SELECT * FROM log_documentos WHERE id= $dados->log_documento_id");
        $caminho = $log_documentos[0]->caminho ?? NULL;
        
        DB::table('log_documentos')
            ->where('documento_id', $dados->id)
            ->update([
                'is_principal' =>  0
        ]);
        
        DB::table('log_documentos')
            ->where('id', $dados->log_documento_id)
            ->update([
                'is_principal' =>  1 
        ]);

        DB::table('documentos')
            ->where('id', $dados->id)
            ->update([
                'caminho' =>  $caminho 
        ]);

        return back()->with('sucesso-doc', 'Documento alterador com Sucesso');
    }
}
