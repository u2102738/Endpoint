<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/************************ Dashboard Routes Start ******************************/
Route::group(['middleware'=>'auth'],function(){
    Route::group(['prefix'=>'{language}'],function(){
        Route::get('home',[DashboardController::class,'index'])->name('home');
    });
});
/************************ Dashboard Routes Ends ******************************/
