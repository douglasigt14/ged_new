<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use DB;

class Dashboard extends BaseController
{
    public function index() {
        $id_usuario = $_SESSION['id'];
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

        $qtde_setores = DB::select("SELECT count(*) as qtde FROM setores");
        $qtde_setores = $qtde_setores[0]->qtde;

        $qtde_funcionarios = DB::select("SELECT count(*) as qtde FROM usuarios");
        $qtde_funcionarios = $qtde_funcionarios[0]->qtde;

        $qtde_processos = DB::select("SELECT count(*) as qtde FROM processos");
        $qtde_processos = $qtde_processos[0]->qtde;

        $qtde_status = DB::select("SELECT count(*) as qtde FROM status_lista");
        $qtde_status = $qtde_status[0]->qtde;

        $qtde_documentos = DB::select("SELECT count(*) as qtde FROM documentos");
        $qtde_documentos = $qtde_documentos[0]->qtde;
        

       return view('inicial', compact(["qtde_setores","qtde_funcionarios","qtde_processos","qtde_status","qtde_documentos","setor"]));
    }

   private  function read_dir($dir) {
            $array = array();
            $d = dir($dir);
            while (false !== ($entry = $d->read())) {
                
                if($entry!='.' && $entry!='..') {
                    $arquivo = $entry;
                    $entry = $dir.'/'.$entry;
                    
                    
                    if(is_dir($entry)) {
                        $array[] = '*'.$arquivo;
                        //$array = array_push($array, $this->read_dir($entry));
                    } else {
                        
                        $array[] = $arquivo;
                    }
                }
            }
            $d->close();
   return $array;   
}     
    private function manipular_lista($lista_arquivos,$path){
        for ($i=0; $i < sizeof($lista_arquivos); $i++) {
            $haystack = $lista_arquivos[$i];
            $needle   = '*';

            $pos      = strripos($haystack, $needle);

            $lista_arquivos[$i] = str_replace("*","",$lista_arquivos[$i]);

            if($pos === false){
                DB::table('documentos')->updateOrInsert([
                      'descricao' => $lista_arquivos[$i]
                    , 'status_id' => 1
                    , 'caminho' =>  $path."\\".$lista_arquivos[$i]],
                   ['descricao' => $lista_arquivos[$i]]);
            }
            

            
        }

        return $lista_arquivos;
    }
}
