<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductosController;


// Url para obtener los productos
Route::get('productos', [ProductosController::class, 'index']);




Route::middleware(['auth:sanctum'])->group(function(){

    // Crear un nuevo producto
    Route::post('Agregar_producto', [ProductosController::class, 'AgregarProd']);

    // Mostrar un producto específico
    Route::get('producto/{id}', [ProductosController::class, 'VerPro']);

    // Actualizar un producto existente
    Route::put('productos/{id}', [ProductosController::class, 'EditarPro']);

    // Eliminar un producto
    Route::delete('productos/{id}', [ProductosController::class, 'EliminarPro']);

});