<?php

use App\Http\Controllers\ProfilesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home', [
        'matches' => auth()->user()->matches(),
        'user' => auth()->user(),
        'randomUser' => auth()->user()->getRandom()
    ]);
})->middleware(['auth'])->name('home');

require __DIR__.'/auth.php';

Route::post('users/{user}/profiles', [ProfilesController::class, 'store'])->name('users.profiles.store');

Route::get('/liked', function () {
    return view('Matches/liked');
})->middleware(['auth']);;

Route::get('/matches', function () {
    return view('Matches/matched', [
        'matches' => auth()->user()->matches()
    ]);
})->middleware(['auth']);;

Route::get('profiles/{user}/edit', function(){
    return view('Profile/profile_edit',[
        'user'=>auth()->user()
    ]);
});

Route::get('profiles/{user}', [ProfilesController::class, 'show']);


Route::get('/test1', [\App\Http\Controllers\HelloController::class, 'sendHi']);
Route::get('/test2', [\App\Http\Controllers\HelloController::class, 'sendHello']);






