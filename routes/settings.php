<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SoftwareController;

/************************ Settings Routes Start ******************************/
Route::group(['middleware'=>'auth'],function(){
    Route::group(['prefix'=>'{language}'],function(){
        Route::group(['prefix'=>'settings','as'=>'settings.','middleware' => ['auth', 'role:1']],function(){
            // User
            Route::group(['prefix'=>'user','as'=>'user.'],function(){
                Route::get('list',[UserController::class,'list'])->name('list');
                Route::post('store', [UserController::class, 'store'])->name('store');
                Route::get('edit/{id}',[UserController::class,'edit'])->name('edit');
                Route::post('update/{id}',[UserController::class,'update'])->name('update');
                Route::post('delete/{id}',[UserController::class,'delete'])->name('delete');
            });

            // Roles
            Route::group(['prefix'=>'role','as'=>'role.'],function(){
                Route::get('list',[RoleController::class,'index'])->name('list');
                Route::get('create',[RoleController::class,'create'])->name('create');
                Route::post('store',[RoleController::class,'store'])->name('store');
                Route::get('edit/{id}',[RoleController::class,'edit'])->name('edit')->middleware('checkRoleExists');
                Route::post('updateDetails/{id}',[RoleController::class,'updateDetails'])->name('updateDetails')->middleware('checkRoleExists');
                Route::post('updateAccess/{id}',[RoleController::class,'updateAccess'])->name('updateAccess')->middleware('checkRoleExists');
                Route::post('delete/{id}',[RoleController::class,'delete'])->name('delete')->middleware('checkRoleExists');
            });

            Route::group(['prefix'=>'software','as'=>'software.'],function(){
                Route::get('osversion',[SoftwareController::class,'index'])->name('osversion');
                Route::post('update/osversion', [SoftwareController::class, 'updateOSVersion'])->name('updateOSVersion');
            });
        });
    });
});
/************************ Settings Routes Ends ******************************/
