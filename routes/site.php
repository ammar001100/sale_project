<?php

use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
return view('home');
});
 */

//Auth::routes();

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//موقت فقط

Route::get('/', function () {
    return redirect()->route('admin.login');
})->name('home');
