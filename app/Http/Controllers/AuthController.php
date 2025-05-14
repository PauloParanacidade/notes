<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login ()
    {
        return view('login');
    }

    public function loginSubmit (Request $request)// quando o formulário é enviado, o método loginSubmit é chamado
    {
        echo $request->input('text_username');
        echo '<br>';
        echo $request->input('text_password');
        
        //dd($request);
        //dd() é uma função de depuração que exibe o conteúdo de uma variável, array ou objeto e interrompe a execução do 
        //código. É uma combinação de var_dump() (que mostra as informações da variável) e die() (que para a execução do script).
        //É uma ferramenta muito útil para inspecionar dados durante o desenvolvimento
        //me dá uma visão de um conjunto de uma determinada informação: variável, array, coleção, classe, etc
        
        //$_POST['text_username']        
        // echo "Login Submit";
    }

    public function logout ()
    {
        echo "Logout";
    }
}
 