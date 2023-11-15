<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaginationController;
use Illuminate\Routing\Route as RoutingRoute;

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

Route::group(['middleware'=>'guest'],function(){
    Route::get('/',[AuthController::class,'login'])->name('login');
    Route::post('/authenticate',[AuthController::class,'authenticate'])->name('authenticate');
});
Route::group(['middleware' => 'auth'], function() {
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});

Route::get('/lang/{lang}',[ LanguageController::class,'switchLang'])->name('switch_lang');
Route::get('/pagination-per-page/{per_page}',[ PaginationController::class,'set_pagination_per_page'])->name('pagination_per_page');
