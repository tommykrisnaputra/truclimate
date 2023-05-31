<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;

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
    return ['Laravel' => app()->version()];
});

//Twitter Authentication Routes
Route::get('auth/twitter', [SocialController::class, 'twitterRedirect'])->name('login.twitter');
Route::get('auth/twitter/callback', [SocialController::class, 'twitterCallback']);

require __DIR__.'/auth.php';
