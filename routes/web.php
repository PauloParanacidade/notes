<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

//auth routes

//são dois grupos de rotas: 
Route::middleware([CheckIsNotLogged::class])->group(function(){
    //estas duas serão executadas se o usuário não estiver logado
    Route::get('/login',[AuthController::class, 'login']);
    Route::post('/loginSubmit',[AuthController::class, 'loginSubmit']);
});

// 🔒 Trata tentativa de acesso via GET à /loginSubmit
Route::get('/loginSubmit', function () {
    // Se o usuário estiver logado, permanece na aplicação
    if (session('user')) {
        return redirect('/');
    }

    // Se não estiver logado, redireciona para o login
    return redirect('/login');
});

Route::middleware([CheckIsLogged::class])->group(function(){
    //e estas só serão executadas se houve um usuário logado
    Route::get('/',[MainController::class, 'index'])->name('home');
    Route::get('/newNote',[MainController::class, 'newNote'])->name('new');
    Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
});

