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
        $id_usuario = $_SESSION['id'];
        $usuario = DB::select("SELECT 
                                    usuarios.*
                                    ,setores.pasta
                                    ,setores.descricao setor
                                FROM usuarios INNER JOIN setores ON 
                                    usuarios.setor_id = setores.id 
                            WHERE 
                                usuarios.id = $id_usuario");
        $path = $usuario[0]->pasta;
        $setor = $usuario[0]->setor;

        $path_geral = "\\\srv-arquivos\GED\GERAL";
       
        $lista_arquivos = $this->read_dir($path);
        $lista_arquivos_geral = $this->read_dir($path_geral);

        $lista_arquivos = $this->manipular_lista($lista_arquivos,$path);
        $lista_arquivos_geral = $this->manipular_lista($lista_arquivos_geral,$path_geral);
        
        $qtde_setores = DB::select("SELECT count(*) as qtde FROM setores");
        $qtde_setores = $qtde_setores[0]->qtde;

        $qtde_funcionarios = DB::select("SELECT count(*) as qtde FROM usuarios");
        $qtde_funcionarios = $qtde_funcionarios[0]->qtde;

        $qtde_processos = DB::select("SELECT count(*) as qtde FROM processos");
        $qtde_processos = $qtde_processos[0]->qtde;

        $processos = DB::select("SELECT * FROM processos");

       return view('inicial', compact(["lista_arquivos","lista_arquivos_geral","qtde_setores","qtde_funcionarios","qtde_processos","processos","setor"]));
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
    private function mover(){
        // $fonte = $path."\\".$lista_arquivos[$i];
        // $copia = $path_2."\\".$lista_arquivos[$i];
        // $res = copy($fonte , $copia);
        // $res = unlink($fonte);
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

        return $lista_arquivos;
    }
}
