<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Parser\Value;
use Illuminate\Http\Request;

use function Illuminate\Database\Eloquent\get;

class MainController extends Controller
{
    public function index()
    {
        // load user's notes
        $id = session('user.id');
        //$user = User::find($id)->toArray();
        $notes = User::find($id)->notes()->get()->toArray();

        // echo '<pre>';
        // print_r($user);
        // print_r($notes);
        // die();

        // show home view
        return view('home',['notes' => $notes]);
        
        //echo "I'm inside the app!";
    }

    public function newNote()
    {
        echo "I'm creating a new note!";
    }
}
