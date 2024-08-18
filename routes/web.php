<?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Http\Request;
    use App\Http\Controllers\ProductosController;


Route::get('/', function () {
    return view('welcome');
});

