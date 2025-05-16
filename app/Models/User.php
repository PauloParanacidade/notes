<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //1 para muitos, 1 usuário para muitas notas
    public function notes(){
        return $this->hasMany(Note::class);
    }
}
