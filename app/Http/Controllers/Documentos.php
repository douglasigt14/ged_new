<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class Documentos extends Controller
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
       
        $lista_arquivos = [];//$this->read_dir($path);
        $lista_arquivos_geral = [];//$this->read_dir($path_geral);

        // $lista_arquivos_geral = $this->manipular_lista($lista_arquivos_geral,$path_geral);
        
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
            $cor = '#FFA500';
            $resultado = $this->verifica_cor($cor);
            $cor_texto = $resultado > 128 ? 'black' : 'white';

            $lista->status = '<center><p style="background-color: '.$cor.';color: '.$cor_texto.'" class="label label-warning status-span">'.$lista->status_desc.'</p></center>';
            $lista->processos_img = Storage::url($lista->processos_img); 
        }

        $setor_caminho = strtoupper($setor);
        $sql = "SELECT 
                    documentos.*
                    ,status_lista.descricao status_desc
                FROM 
                    documentos 
                    INNER JOIN status_lista ON
                    documentos.status_id = status_lista.id
                WHERE 
                    processo_id IS NULL
                AND documentos.caminho LIKE '%$setor_caminho%'";

        $lista_arquivos_geral = DB::select($sql);

        foreach ($lista_arquivos_geral as $key => $lista) {
            $lista->status = '<center><p class="label label-info status-span">'.$lista->status_desc.'</p></center>';
        }

       return view('documentos', compact(["lista_arquivos","lista_arquivos_geral","qtde_setores","qtde_funcionarios","qtde_processos","qtde_status","processos","setor"]));
    }
}
