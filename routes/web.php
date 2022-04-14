<?php

use App\Http\Controllers\LikesController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\UsersController;
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
require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('Home/hello');
});

Route::get('/home', [UsersController::class, "getRandom"])->middleware(['auth'])->name('home');

Route::post('/home/like/{user}', [LikesController::class, "like"])
    ->name('like');

Route::post('/home/dislike/{user}', [LikesController::class, "dislike"])
    ->name('dislike');

Route::post('users/{user}/profiles', [ProfilesController::class, 'store'])
    ->name('users.profiles.store');

Route::get('/liked', function () {
    return view('Matches/liked');
})->middleware(['auth'])->name('liked');;

Route::get('/matches', function () {
    return view('Matches/matched', [
        'matches' => auth()->user()->matches()
    ]);
})->middleware(['auth'])->name('matches');;

Route::get('profiles/{user}/edit', function () {
    return view('Profile/profile_edit', [
        'user' => auth()->user()
    ]);
})->middleware(['auth']);

Route::get('profiles/{user}', [ProfilesController::class, 'show'])
    ->name("profile");


Route::post('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('user.edit');

Route::get('profiles/{user}/user/edit', function () {
    return view('User/user_edit', [
        'user' => auth()->user()
    ]);
});

Route::post('profiles/{user}/delete-photo',[ProfilesController::class, 'delete']);



//Route::get('/about', function () {
//    return view('Home/about');
//})->name('about');


//Route::get('/test1', [\App\Http\Controllers\HelloController::class, 'sendHi']);
//Route::get('/test2', [\App\Http\Controllers\HelloController::class, 'sendHello']);






