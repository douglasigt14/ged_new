<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HistMov extends Controller
{
    public function index($documento_id = null) {
        $hist_mov = DB::select("SELECT 
                                    log_fluxo.* 
                                   ,processos.descricao proceso_descricao
                                   ,usuarios.rotulo
                                   ,documentos.descricao doc_descricao
                                FROM 
                                 log_fluxo INNER JOIN processos ON
                                 processos.id = log_fluxo.processo_id
                                 INNER JOIN usuarios ON
                                    usuarios.id = log_fluxo.usuario_id
                                INNER JOIN documentos ON
                                    documentos.id = log_fluxo.documento_id
                               WHERE 
                                    documento_id = $documento_id");
        $doc_descricao = "";
        for ($i=0; $i < sizeof($hist_mov); $i++) {
            $partes = explode(" ",$hist_mov[$i]->systemdate);
            $data = $partes[0];
            $hora = $partes[1];
            $partes = explode("-",$data);
            $data = $partes[2]."/".$partes[1].'/'.$partes[0];
            $hist_mov[$i]->systemdate = $data.' '.$hora;

            $doc_descricao = $hist_mov[$i]->doc_descricao;
        }
        return view('hist_mov', compact(["hist_mov","doc_descricao"]));
    }
}
