<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\TweetLikesController;
use App\Http\Controllers\Auth\LoginController;
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


Route::middleware('auth')->group(function(){
	Route::get('/tweet',[TweetController::class,'index'])->name('home');
    Route::post('/tweet',[TweetController::class,'store']);
    Route::get('/profiles/{user:username}',[ProfileController::class,'show'])->name('profile');
    Route::post('/profiles/{user:username}/follow',[FollowsController::class,'store']);
    Route::get('/profiles/{user:username}/edit',[ProfileController::class,'edit'])->middleware('can:edit,user');
    Route::patch('/profiles/{user:username}',[ProfileController::class,'update'])->middleware('can:edit,user')->name('profile');

    Route::post('/tweets/{tweet}/like', [TweetLikesController::class,'store']);
    Route::delete('/tweets/{tweet}/like', [TweetLikesController::class,'destroy']);
    Route::get('/explore',[ExploreController::class,'index']);
});

//socailite route for github and google
Route::get('login/{provider}', [LoginController::class,'redirectToProvider']);
Route::get('login/{provider}/callback', [LoginController::class,'handleProviderCallback']);



Auth::routes();


