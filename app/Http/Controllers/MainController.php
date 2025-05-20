<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\operations;
use Dotenv\Parser\Value;
//use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

use function Illuminate\Database\Eloquent\get;


class MainController extends Controller
{
    public function index()
    {
        // load user's notes
        $id = session('user.id');
        //$user = User::find($id)->toArray();
        $notes = User::find($id)
                    ->notes()
                    ->whereNull('deleted_at')
                    ->get()
                    ->toArray();

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
        // validate request 
        $request->validate(
            //rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],

            //error messages
            [
                'text_title.required' => 'O título de usuário é obrigatório!',
                'text_title.min' => 'O título deve ter no mínimo :min caracteres',
                'text_title.max' => 'O título deve ter no máximo :max caracteres',
                
                'text_note.required' => 'A nota é obrigatória!',
                'text_note.min' => 'A nota deve ter no mínimo :min caracteres',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres'
            ]
        );
        // get user id
        $id = session('user.id');

        // create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // redirect to home
        return redirect()->route('home');

        //echo "I'm creating a new note";
    }

    public function editNote($id)
    {
        //$id = $this->decryptId($id);
        $id = operations::decryptId($id);

        if($id === null){
            return redirect()->route('home');
        }
        
        // load note
        $note = Note::find($id);

        // show edit note view
        return view('edit_note', ['note' => $note]);
        
        //echo "I'm editing note with id = $id";
    }

    public function editNoteSubmit(Request $request)
    {
        // validate request
        $request->validate(
            //rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],

            //error messages
            [
                'text_title.required' => 'O título de usuário é obrigatório!',
                'text_title.min' => 'O título deve ter no mínimo :min caracteres',
                'text_title.max' => 'O título deve ter no máximo :max caracteres',
                
                'text_note.required' => 'A nota é obrigatória!',
                'text_note.min' => 'A nota deve ter no mínimo :min caracteres',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres'
            ]
        );

        // check if note_id exists
        if($request->note_id == null){
            return redirect()->route('home');
        }

        // decrypt note_id
        $id = operations::decryptId($request->note_id);
        $note = Note::find($id);// código novo
        if (!$note) {
        return redirect()->route('home')->with('error', 'Nota não encontrada');
        }

        // load note // código duplicado para carregar o conteúdo quando a tela é carregada
        //$note = Note::find($id);

        // update note
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // redirect to home
        return redirect()->route('home');
    }

    public function deleteNote($id)
    {
        //$id = $this->decryptId($id);
        //echo "I'm deleting note with id = $id";

        $id = operations::decryptId($id);
                if($id === null){
            return redirect()->route('home');
        }

        // load note
        $note = Note::find($id);

        // show delete note confirmation
        return view('delete_note',['note' => $note]);
    }

    public function deleteNoteConfirm($id)
    {
        // check if $id is encrypted
        $id = operations::decryptId($id);
                if($id === null){
            return redirect()->route('home');
        }

        // load note
        $note = Note::find($id);

        // 1. hard delete
        // $note->delete();

        // 2. soft delete
        // $note->deleted_at = date('Y:m:d H:i:s');
        // $note->save();

        // 3. soft delete (property SoftDeletes in model)
        //$note->delete();

        // 4. hard delete (property SoftDeletes in model)
        $note->forceDelete();

        // redirect to home
        return redirect()->route('home');
    }

    public function sendEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'title' => 'required|string',
        'text' => 'required|string',
    ]);

    Mail::raw($request->text, function ($message) use ($request) {
        $message->to($request->email)
                ->subject($request->title);
    });

    return back()->with('success', 'Nota enviada por e-mail com sucesso!');
}


}
