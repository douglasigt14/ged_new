<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    function __construct(){
        $this->cards =  array(
            (object) [
                "titulo"=>"Campanhas Abertas",
                "descricao"=>"",
                "rota"=>"/campanhas_abertas",
                "classe"=>"bg-success",
                "dado"=>null,
                "icone"=>"pe-7s-speaker"
            ],
            (object) [
                "titulo"=>"Campanhas Fechadas",
                "descricao"=>"",
                "rota"=>"/campanhas_fechadas",
                "classe"=>"bg-danger",
                "dado"=>null,
                "icone"=>"pe-7s-lock"
            ],
            (object) [
                "titulo"=>"Tipos de Item",
                "descricao"=>"",
                "rota"=>"/tipos-item",
                "classe"=>"bg-info",
                "dado"=>null,
                "icone"=>"pe-7s-box1"
            ],
            (object) [
                "titulo"=>"Fornecedores",
                "descricao"=>"",
                "rota"=>"/fornecedores",
                "classe"=>"bg-warning",
                "dado"=>null,
                "icone"=>"pe-7s-user"
            ],
            (object) [
                "titulo"=>"Tipos de Campanhas",
                "descricao"=>"",
                "rota"=>"/tipos_campanhas",
                "classe"=>"bg-info",
                "dado"=>null,
                "icone"=>"pe-7s-user"
            ]
        );
    }   
}
