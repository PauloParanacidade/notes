<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login ()
    {
        return view('login');
    }

    public function loginSubmit (Request $request)// quando o formulário é enviado, o método loginSubmit é chamado
    {
        // form validation
        $request->validate(
            //rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],

            //error messages
            [
                'text_username.required' => 'O nome de usuário é obrigatório!',
                'text_username.email' => 'O nome de usuário deve ser um e-mail válido!',
                'text_password.required' => 'A senha é obrigatória!',
                'text_password.min' => 'A senha deve ter no mínimo :min caracteres',
                'text_password.max' => 'A senha deve ter no máximo :max caracteres'
            ]
        );

        // get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // check if user exists
        $user = user::where('username',$username)
                        ->where('deleted_at', NULL)
                        ->first();
        if(!$user){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError','Nome de usuário ou senha incorretos!');
        }

        // check if password is correct
        if(!password_verify($password, $user->password)){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError','Nome de usuário ou senha incorretos!');
        
        }

        // update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // login user mantendo ele na seção
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        return redirect('/');
        //echo 'LOGIN EFETUADO COM SUCESSO';
        //print_r($user);
       


        // get all the users from the database
        //$users = User::all()-> toArray();

        // ou dá pra fazer pelo método abaixo 
        //as an object instance of the model's class
        // $userModel = new User();
        // $users = $userModel-> all()->toArray();

        // echo '<pre>';
        // print_r($users);

        //echo 'ok';

        // test database connection
        // try{
        //     DB::connection()->getPdo();// é o método que vai fazer o teste de conexão
        //     echo 'Connection is OK!';
        // } catch (\PDOException $e){
        //     echo "Connection failed: " . $e->getMessage();
        // }

        // echo "FIM!";

        //echo $request->input('text_username');
        //echo '<br>';
        //echo $request->input('text_password');
        
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
        // logout from the application
        session()->forget('user');
        return redirect()->to('/login');
    }
}
 