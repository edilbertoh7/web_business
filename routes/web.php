<?php

use Illuminate\Support\Facades\Route;
// crear los roles de usuario: admin y cliente
//use Spatie\Permission\Models\Role;
//Role::create(['name'=>'admin']);
//Role::create(['name'=>'cliente']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
