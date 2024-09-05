<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::post('/users', [UserController::class, 'adicionar']);
Route::get('/mostrar', [UserController::class, 'mostrar']);
Route::get('/pegarUser/{id}', [UserController::class,'pegarUser']);
Route::delete('/deletar/{id}', [UserController::class, 'deletar']);
Route::put('/editar/{id}', [UserController::class, 'atualizar']);
