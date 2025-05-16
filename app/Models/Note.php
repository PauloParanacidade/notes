<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public function user()
    {
        //1 nota pertence a 1 usuário, consequentemente será 1:n, ou seja, muitas notas pertencem a apenas 1 user
        return $this->belongsTo(User::class);
    }
}
