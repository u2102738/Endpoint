<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TermsConditionController;
use App\Http\Controllers\BlogController;

/************************ Pages Routes Start ******************************/
Route::group(['middleware'=>'auth'],function(){
    Route::group(['prefix'=>'{language}'],function(){
        Route::group(['prefix'=>'pages','as'=>'pages.'],function(){
            Route::get('setting',[PageController::class,'setting'])->name('setting');
            Route::get('403',[PageController::class,'unauthorized'])->name('403');
            Route::get('404',[PageController::class,'not_found'])->name('404');
        });
    });
});
/************************ Pages Routes Ends ******************************/
