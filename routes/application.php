<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\SocialAppController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\SoftwareDeploymentController;

/************************ Application Routes Start ******************************/
Route::group(['middleware'=>'auth'],function(){
    Route::group(['prefix'=>'{language}'],function(){
        Route::group(['prefix'=>'applications'],function(){
            // Profile
            Route::group(['prefix'=>'social','as'=>'social.'],function(){
                Route::get('profile-settings',[SocialAppController::class,'profileSetting'])->name('profile_settings');
                Route::post('updateProfile',[SocialAppController::class,'updateProfile'])->name('updateProfile');
                Route::post('updatePassword',[SocialAppController::class,'updatePassword'])->name('updatePassword');
                Route::post('markAllasRead',[SocialAppController::class,'markAllasRead'])->name('markAllasRead');
                Route::post('markAsRead/{id}',[SocialAppController::class,'markAsRead'])->name('markAsRead');
                Route::post('clearNotification',[SocialAppController::class,'clearNotification'])->name('clearNotification');
            });

            //Agent
            Route::group(['prefix'=>'agent','as'=>'agent.'],function(){
                Route::get('overview',[AgentController::class,'overview'])->name('overview')->middleware('auth', 'permission:agent');
                Route::get('agent',[AgentController::class,'deployment'])->name('deployment')->middleware('auth', 'permission:agent');
                Route::post('agent/store',[AgentController::class,'agentStore'])->name('agentStore')->middleware('auth', 'permission:agent');
                Route::post('sendEmail',[AgentController::class,'sendEmail'])->name('sendEmail')->middleware('auth', 'permission:agent');
            });

            // Computer
            Route::group(['prefix'=>'computer','as'=>'computer.'],function(){
                Route::get('device', [ComputerController::class, 'device'])->name('device')->middleware('auth', 'permission:computer_device');
                Route::post('addDevice',[ComputerController::class,'addDevice'])->name('addDevice');
                Route::get('device/details/{id}', [ComputerController::class, 'deviceDetails'])->name('device_detail')->middleware('auth', 'permission:computer_device_detail', 'checkDeviceExists');
                Route::get('group', [ComputerController::class, 'group'])->name('group')->middleware('auth', 'permission:computer_group');
                Route::post('group/store', [ComputerController::class, 'groupStore'])->name('groupStore');
                Route::get('group/edit/{id}', [ComputerController::class, 'groupEdit'])->name('groupEdit');
                Route::post('group/updateDetails/{id}', [ComputerController::class, 'updateDetails'])->name('updateDetails');
                Route::post('group/addDevices/{groupId}',[ComputerController::class, 'addDevices'])->name('addDevices');
                Route::post('group/deleteDevice/{groupId}', [ComputerController::class, 'deleteDevice'])->name('deleteDevice');
                Route::post('group/deleteAllDevices', [ComputerController::class, 'deleteAllDevices'])->name('deleteAllDevices');
                Route::post('group/delete/{id}', [ComputerController::class, 'groupDelete'])->name('groupDelete');
            });

            // Software Management
            Route::group(['prefix'=>'software-management','as'=>'software-management.'],function(){
                Route::get('overview',[SoftwareController::class,'overview'])->name('overview');
                Route::get('osupdate',[SoftwareController::class,'osupdate'])->name('osupdate')->middleware('auth', 'permission:software_osupdate');
                Route::post('sendReminderOSUpdate',[SoftwareController::class,'sendReminderOSUpdate'])->name('sendReminderOSUpdate')->middleware('auth', 'permission:software_osupdate');
                Route::post('sendReminderGroupOSUpdate',[SoftwareController::class,'sendReminderGroupOSUpdate'])->name('sendReminderGroupOSUpdate')->middleware('auth', 'permission:software_osupdate');
                Route::get('licensedsoftware',[SoftwareController::class,'licensedsoftware'])->name('licensedsoftware')->middleware('auth', 'permission:software_licensedSoftware');
                Route::post('updateSoftwareLicense',[SoftwareController::class,'updateSoftwareLicense'])->name('updateSoftwareLicense')->middleware('auth', 'permission:software_licensedSoftware');
                Route::get('licensedsoftware/{id}',[SoftwareController::class,'licensedsoftware_detail'])->name('licensedsoftware_detail')->middleware('auth', 'permission:software_licensedSoftware', 'checkLicensed');
                Route::get('licensedsoftware/{id}/exportDevicesWithSoftware',[SoftwareController::class,'exportDevicesWithSoftware'])->name('exportDevicesWithSoftware')->middleware('auth', 'permission:software_licensedSoftware', 'checkLicensed');
                Route::get('licensedsoftware/{id}/exportDevicesWithoutSoftware',[SoftwareController::class, 'exportDevicesWithoutSoftware'])->name('exportDevicesWithoutSoftware')->middleware('auth', 'permission:software_licensedSoftware', 'checkLicensed');
                Route::get('licensedsoftware/{id}/{groupId}/exportGroupDevicesWithSoftware',[SoftwareController::class,'exportGroupDevicesWithSoftware'])->name('exportGroupDevicesWithSoftware')->middleware('auth','permission:software_licensedSoftware', 'checkLicensed');
                Route::get('licensedsoftware/{id}/{groupId}/exportGroupDevicesWithoutSoftware',[SoftwareController::class,'exportGroupDevicesWithoutSoftware'])->name('exportGroupDevicesWithoutSoftware')->middleware('auth','permission:software_licensedSoftware', 'checkLicensed');
                Route::get('prohibitedsoftware',[SoftwareController::class,'prohibitedsoftware'])->name('prohibitedsoftware')->middleware('auth', 'permission:software_prohibitedSoftware');
                Route::post('updateSoftwareRestriction',[SoftwareController::class,'updateSoftwareRestriction'])->name('updateSoftwareRestriction')->middleware('auth', 'permission:software_prohibitedSoftware');
                Route::get('prohibitedsoftware/{id}',[SoftwareController::class,'prohibitedsoftware_detail'])->name('prohibitedsoftware_detail')->middleware('auth', 'permission:software_prohibitedSoftware', 'checkProhibited');
                Route::post('sendReminderProhibited',[SoftwareController::class,'sendReminderProhibited'])->name('sendReminderProhibited')->middleware('auth', 'permission:software_prohibitedSoftware');
                Route::post('sendReminderGroupProhibited',[SoftwareController::class,'sendReminderGroupProhibited'])->name('sendReminderGroupProhibited')->middleware('auth', 'permission:software_prohibitedSoftware');
            });

            // Software Deployment
            Route::group(['prefix'=>'software-deployment','as'=>'software-deployment.'],function(){
                Route::get('overview',[SoftwareDeploymentController::class,'overview'])->name('overview')->middleware('auth', 'permission:software_deployment');
                Route::get('package',[SoftwareDeploymentController::class,'deployment'])->name('deployment')->middleware('auth', 'permission:software_deployment');
                Route::get('package/{id}/download',[SoftwareDeploymentController::class,'downloadFile'])->name('downloadFile')->middleware('auth', 'permission:software_deployment');
                Route::post('package/store',[SoftwareDeploymentController::class,'packageStore'])->name('packageStore')->middleware('auth', 'permission:software_deployment');
                Route::post('package/{id}/update',[SoftwareDeploymentController::class,'packageUpdate'])->name('packageUpdate')->middleware('auth', 'permission:software_deployment');
                Route::post('package/{id}/delete',[SoftwareDeploymentController::class,'packageDelete'])->name('packageDelete')->middleware('auth', 'permission:software_deployment');
                Route::get('package/{id}',[SoftwareDeploymentController::class,'deployment_detail'])->name('deployment_detail')->middleware('auth', 'permission:software_deployment');
                Route::get('download/{filename}', [SoftwareDeploymentController::class, 'downloadThruAPI'])->name('downloadThruAPI')->middleware('auth', 'permission:software_deployment');
            });
        });
    });
});
/************************ Application Routes Ends ******************************/
