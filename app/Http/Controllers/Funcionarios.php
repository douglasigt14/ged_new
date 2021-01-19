<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;

class Funcionarios extends BaseController
{
    public function index() {
        $sql = "SELECT 
                    usuarios.* 
                   ,setores.descricao setor
                FROM 
                    usuarios LEFT JOIN setores  ON 
                    usuarios.setor_id = setores.id";
        $funcionarios = DB::select($sql);
        $setores = DB::select("SELECT * FROM setores");
        return view('funcionarios', compact(["funcionarios","setores"]));
    }
    public function inserir(Request $request){
        $dados = (object) $request->all();

        $dados->setor_id = $dados->setor_id ?? NULL;
        
        $dados->senha = password_hash( $dados->senha, PASSWORD_BCRYPT);

        DB::table('usuarios')->insert([
            'rotulo' => $dados->rotulo,
            'nome' => $dados->nome,
            'senha' => $dados->senha,
            'setor_id' => $dados->setor_id
        ]);
        return back();
    }
    public function deletar(Request $request){
         $dados = (object) $request->all();
         DB::table('usuarios')->where('id', '=', $dados->id )->delete();
        return back();
    }
    public function editar(Request $request){
         $dados = (object) $request->all();
         DB::table('usuarios')
              ->where('id', $dados->id)
              ->update([
                    'rotulo' => $dados->rotulo
                   ,'nome' => $dados->nome
                   ,'setor_id' => $dados->setor_id
                    ]);
        return back();
    }

     public function mudar_senha(Request $request){
        $dados = (object) $request->all();
        $msg = "";
        $msg_tipo = "";
        if($dados->senha == $dados->confirmar_senha){
                $dados->senha = password_hash( $dados->senha, PASSWORD_BCRYPT);
                DB::table('usuarios')
                ->where('id', $dados->id)
                ->update([
                        'senha' => $dados->senha
                    ]);
            $msg_tipo = "sucesso";
            $msg = "Senha alterada com sucesso";
        }
        else{
            $msg_tipo = "error";
            $msg = "As senhas não são iguais";
        }
        return back()->with($msg_tipo,$msg);
     }
}
