<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PictureController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('album',AlbumController::class);

Route::get('albums/{album}/confirmDelete', [AlbumController::class, 'confirmDelete'])->name('albums.confirmDelete');
Route::post('albums/{album}/movePictures', [AlbumController::class, 'movePictures'])->name('albums.movePictures');
