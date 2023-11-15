<?php

namespace App\Http\Controllers;

use App\Models\NotificationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller {
    /**
     * Display 403 of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function unauthorized(){
        $title = "Error 403";
        $description = "Error page due to unauthorized!";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.403.403',compact(
            'title',
            'description',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    public function not_found(){
        $title = "Error 404";
        $description = "Error page due to data not found!";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.403.404',compact(
            'title',
            'description',
            'notifications',
            'unreadNotificationsCount'
        ));
    }
}
