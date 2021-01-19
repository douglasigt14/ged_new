<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MyLogin extends Controller
{
    public function index() {
         $user = DB::select("SELECT nome FROM usuarios ");
        return view('login_tela');
    }

    public function login() {
        session_start();
        $name = $_POST['name'];
        $user = DB::select("SELECT * FROM usuarios WHERE nome = '$name'");
        if (!empty($user)) {
            $user = $user[0];
        }
    
        if($user and
            password_verify($_POST['password'], $user->senha)
        ) {
            // Cria a sessao
            $_SESSION['usuario'] = $user->rotulo;
            $_SESSION['id'] = $user->id;
            $_SESSION['is_admin'] = $user->is_admin ?? NULL;
            $_SESSION['login'] = $name;
            if($user->is_admin) 
                return redirect('/');
            else
               return redirect('/documentos');
        } else {
            \Session::flash('login_erro', 'Dados incorretos');
            return redirect('/login');
        }
    }

    public function logout() {
        session_start();
        unset($_SESSION['usuario']);
        unset($_SESSION['id']);
        unset($_SESSION['login']);
        return redirect('/login');
    }
    
    public function mudarSenha(Request $request) {
        $dados = (object) $request->all();
       
        $msg = "";
        $msg_tipo = "";
        $user = DB::select("SELECT * FROM usuarios WHERE id = '$dados->id'");
        if (!empty($user)) {
            $user = $user[0];
        }
    
        if($user and password_verify($dados->senha_atual , $user->senha)) {
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

        }
        else{
             $msg_tipo = "error";
             $msg = "A senha atual está incorreta";
        }
        
       
        return back()->with($msg_tipo,$msg);
        
    }
}
