<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditLogController;


/************************ Audit Log Routes Start ******************************/
Route::group(['middleware'=>'auth'],function(){
    Route::group(['prefix'=>'{language}'],function(){
        Route::group(['prefix'=>'auditlog','as'=>'auditlog.'],function(){
            Route::get('auth',[AuditLogController::class,'auth'])->name('auth')->middleware('auth','permission:log_auth');
            Route::get('activity',[AuditLogController::class,'activity'])->name('activity')->middleware('auth','permission:log_activity');
        });
    });
});
/************************ Audit Log Routes Ends ******************************/
