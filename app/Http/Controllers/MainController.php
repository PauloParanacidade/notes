<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\operations;
use Dotenv\Parser\Value;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        //show new note view
        return view('new_note');
        //echo "I'm creating a new note!";
    }

    public function newNoteSubmit(Request $request)
    {
        echo "I'm creating a new note";
    }

    public function editNote($id)
    {
        //$id = $this->decryptId($id);
        $id = operations::decryptId($id);
        echo "I'm editing note with id = $id";
    }

        public function deleteNote($id)
    {
        //$id = $this->decryptId($id);
        $id = operations::decryptId($id);
        echo "I'm deleting note with id = $id";
    }


}
