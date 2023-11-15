<?php

namespace App\Http\Controllers;
use App\Models\ActivityLog;
use App\Models\AuthLog;
use App\Models\NotificationLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class AuditLogController extends Controller
{
    public function auth(Request $request){
        // Filter function
        $dateFrom = $request->input('date-range-from');
        $dateTo = $request->input('date-range-to');

        $query = AuthLog::with(['user' => function ($query) {
            $query->withTrashed();
        }, 'user.role'])
            ->orderBy('created_at', 'DESC');

        if ($dateFrom && $dateTo) {
            $query->whereBetween('created_at', [
                Carbon::parse($dateFrom)->startOfDay(),
                Carbon::parse($dateTo)->endOfDay(),
            ]);
        }

        $auth_log = $query->get();

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();

        $successfulToday = DB::table('auth_log')->where('type', 1)->whereDate('created_at', $today)->count();
        $successfulYesterday = DB::table('auth_log')->where('type', 1)->whereDate('created_at', $yesterday)->count();
        $successfulThisMonth = DB::table('auth_log')->where('type', 1)->whereDate('created_at', '>=', $startOfMonth)->count();
        $successfulLastMonth = DB::table('auth_log')->where('type', 1)->whereDate('created_at', '>=', $startOfLastMonth)->whereDate('created_at', '<', $startOfMonth)->count();
        $failedToday = DB::table('auth_log')->where('type', 0)->whereDate('created_at', $today)->count();
        $failedYesterday = DB::table('auth_log')->where('type', 0)->whereDate('created_at', $yesterday)->count();
        $failedThisMonth = DB::table('auth_log')->where('type', 0)->whereDate('created_at', '>=', $startOfMonth)->count();
        $failedLastMonth = DB::table('auth_log')->where('type', 0)->whereDate('created_at', '>=', $startOfLastMonth)->whereDate('created_at', '<', $startOfMonth)->count();

        $title = "Authentication Log";
        $description = "View authentication log.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.audit_log.auth',compact(
            'title',
            'description',
            'auth_log',
            'successfulToday',
            'successfulYesterday',
            'successfulThisMonth',
            'successfulLastMonth',
            'failedToday',
            'failedYesterday',
            'failedThisMonth',
            'failedLastMonth',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    public function activity(Request $request){
        // Filter function
        $dateFrom = $request->input('date-range-from');
        $dateTo = $request->input('date-range-to');

        $query = ActivityLog::with(['user' => function ($query) {
            $query->withTrashed();
        }, 'userAffected.role'])
            ->orderBy('created_at', 'DESC');

        if ($dateFrom && $dateTo) {
            $query->whereBetween('created_at', [
                Carbon::parse($dateFrom)->startOfDay(),
                Carbon::parse($dateTo)->endOfDay(),
            ]);
        }

        $activity_log = $query->get();

        $today = Carbon::today();

        $userSuccessful = DB::table('activity_log')->where('event_type', 'LIKE', '%User%')->where('event_status', 1)->whereDate('created_at', $today)->count();
        $userFailed = DB::table('activity_log')->where('event_type', 'LIKE', '%User%')->where('event_status', 0)->whereDate('created_at', $today)->count();
        $roleSuccessful = DB::table('activity_log')->where('event_type', 'LIKE', '%Role%')->where('event_status', 1)->whereDate('created_at', $today)->count();
        $roleFailed = DB::table('activity_log')->where('event_type', 'LIKE', '%Role%')->where('event_status', 0)->whereDate('created_at', $today)->count();

        $title = "Activity Log";
        $description = "View activity log.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.audit_log.activity',compact(
            'title',
            'description',
            'activity_log',
            'userSuccessful',
            'userFailed',
            'roleSuccessful',
            'roleFailed',
            'notifications',
            'unreadNotificationsCount'
        ));
    }
}
