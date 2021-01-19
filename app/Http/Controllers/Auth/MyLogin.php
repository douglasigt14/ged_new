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
            return redirect('/');
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
        session_start();
        $nova_senha = $request->all();
        $senha_crip = password_hash($nova_senha['nova_senha'], PASSWORD_BCRYPT);
        $id = $_SESSION['id'];
        DB::update("UPDATE usuarios SET senha = ? WHERE id = ?", [$senha_crip, $id]);
        return back();
    }
}
