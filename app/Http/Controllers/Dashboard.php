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

        $path_geral = $usuario[0]->pasta."\\INICIAR";
       
        $lista_arquivos = $this->read_dir($path);
        $lista_arquivos_geral = $this->read_dir($path_geral);

        $lista_arquivos_geral = $this->manipular_lista($lista_arquivos_geral,$path_geral);
        
        $qtde_setores = DB::select("SELECT count(*) as qtde FROM setores");
        $qtde_setores = $qtde_setores[0]->qtde;

        $qtde_funcionarios = DB::select("SELECT count(*) as qtde FROM usuarios");
        $qtde_funcionarios = $qtde_funcionarios[0]->qtde;

        $qtde_processos = DB::select("SELECT count(*) as qtde FROM processos");
        $qtde_processos = $qtde_processos[0]->qtde;

        $qtde_status = DB::select("SELECT count(*) as qtde FROM status_lista");
        $qtde_status = $qtde_status[0]->qtde;

        $processos = DB::select("SELECT * FROM processos");

       

        $sql = "SELECT 
                    documentos.* 
                ,s_atual.descricao setor_atual
                ,s_anterior.descricao setor_anterior
                ,processos.descricao descricao_processo
                ,processos.img processos_img
                ,status_lista.descricao status_desc
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
                WHERE 
                    s_atual.id  = $setor_id
                AND finalizado = 0";
        $lista_arquivos = DB::select($sql);

        foreach ($lista_arquivos as $key => $lista) {
            $lista->status = '<center><p class="label label-info status-span">'.$lista->status_desc.'</p></center>';
            $lista->processos_img = Storage::url($lista->processos_img); 
        }

        $sql = "SELECT 
                    documentos.*
                    ,status_lista.descricao status_desc
                FROM 
                    documentos 
                    INNER JOIN status_lista ON
                    documentos.status_id = status_lista.id
                WHERE 
                    processo_id IS NULL";

        $lista_arquivos_geral = DB::select($sql);

        foreach ($lista_arquivos_geral as $key => $lista) {
            $lista->status = '<center><p class="label label-info status-span">'.$lista->status_desc.'</p></center>';
        }

       return view('inicial', compact(["lista_arquivos","lista_arquivos_geral","qtde_setores","qtde_funcionarios","qtde_processos","qtde_status","processos","setor"]));
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
                    , 'status_id' => 1
                    , 'caminho' =>  $path."\\".$lista_arquivos[$i]],
                   ['descricao' => $lista_arquivos[$i]]);
            }
            

            
        }

        return $lista_arquivos;
    }
}
