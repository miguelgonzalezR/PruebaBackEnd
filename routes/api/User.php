<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UsuariosController;


// Url para login 
Route::post('login', [UsuariosController::class, 'login']);

Route::post('PrimerUser', [UsuariosController::class, 'registrar'])->middleware('primeru');


Route::get('check-users', [UsuariosController::class, 'checkUsers']);


Route::middleware(['auth:sanctum'])->group(function(){


    // url para registrar usuarios
    //Route::post('registrarUser', [UsuariosController::class, 'registrar']);

    Route::get('Users', [UsuariosController::class, 'index'])->middleware('admin');

    // Mostrar usuario específico
    Route::get('VerPro/{id}', [UsuariosController::class, 'VerPro'])->middleware('admin');

    Route::post('registrarUser', [UsuariosController::class, 'registrar'])->middleware('admin');

    Route::put('EditarUser/{id}', [UsuariosController::class, 'EditarUser'])->middleware('admin');
    Route::delete('EliminarUser/{id}', [UsuariosController::class, 'EliminarUser'])->middleware('admin');



    // Url para logout 
    Route::get('logout', [UsuariosController::class, 'logout']);

});