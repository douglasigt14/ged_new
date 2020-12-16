<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;

class Dashboard extends BaseController
{
    public function index() {
        $path = "\\\srv-arquivos\GED\COMPRAS";
       
        $lista_arquivos = $this->read_dir($path);

        for ($i=0; $i < sizeof($lista_arquivos); $i++) {
            $haystack = $lista_arquivos[$i];
            $needle   = '*';

            $pos      = strripos($haystack, $needle);

            $lista_arquivos[$i] = str_replace("*","",$lista_arquivos[$i]);

            if($pos === false){
                DB::table('documentos')->updateOrInsert([
                      'descricao' => $lista_arquivos[$i]
                    , 'status' => 'NOVO'
                    , 'caminho' =>  $path."\\".$lista_arquivos[$i]],
                   ['descricao' => $lista_arquivos[$i]]);
            }

            $lista_arquivos[$i] = $pos === false ? 
                array( 'descricao' => $lista_arquivos[$i]
                        ,'caminho' => $path."\\".$lista_arquivos[$i]
                        ,'tipo' => 'arquivo'
                        ,'setor_anterior' => null
                        ,'setor_atual' => null
                        ,'status' => '<center><p class="label label-info status-span">NOVO</p></center>') : 
                array( 'descricao' => "<a href='/'>$lista_arquivos[$i]</>"
                       ,'caminho' =>  $path."\\".$lista_arquivos[$i]
                       ,'tipo' => 'pasta'
                       ,'setor_anterior' => null
                       ,'setor_atual' => null
                       ,'status' => null );	
        }
        
        $qtde_setores = DB::select("SELECT count(*) as qtde FROM setores");
        $qtde_setores = $qtde_setores[0]->qtde;

        $qtde_funcionarios = DB::select("SELECT count(*) as qtde FROM usuarios");
        $qtde_funcionarios = $qtde_funcionarios[0]->qtde;

        $qtde_processos = DB::select("SELECT count(*) as qtde FROM processos");
        $qtde_processos = $qtde_processos[0]->qtde;

       return view('inicial', compact(["lista_arquivos","qtde_setores","qtde_funcionarios","qtde_processos"]));
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
}
