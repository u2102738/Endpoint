<?php

namespace App\Http\Controllers;

use App\Models\AllSoftware;
use App\Models\Device;
use App\Models\NotificationLog;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {

    /**
     * Display dashbnoard demo one of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $title = "Dashboard";
        $description = "Dashboard";

        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $allNotifications = NotificationLog::withTrashed()
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)
            ->where('is_read', 0)
            ->count();

        // Fetch the total device count and active device count
        $totalDevicesCount = DB::table('devices')
            ->where('devices.status', 1) // Accepted
            ->count();

        $activeDevicesCount = DB::table('devices')
            ->join('device_state', function ($join) {
                $join->on('devices.id', '=', 'device_state.device_id')
                    ->whereRaw('device_state.id = (
                        SELECT MAX(id) FROM device_state
                        WHERE device_id = devices.id
                    )');
            })
            ->where('device_state.state', 1) // Active
            ->count();

        // Calculate the percentage of active users over total accepted users
        $activePercentage = 0;
        if ($totalDevicesCount > 0) {
            $activePercentage = ($activeDevicesCount / $totalDevicesCount) * 100;
            $activePercentage = round($activePercentage);
        }

        $osVersion = Setting::where('name', 'OSVersion')->value('value');

        // Check if the "osVersion" setting exists in the settings table
        $osVersionSetting = Setting::where('name', 'OSVersion')->first();

        $outdatedOSdevices = 0; // Initialize the count to 0

        if ($osVersionSetting) {
            // Fetch the outdated OS devices only if the "osVersion" setting exists
            $outdatedOSdevices = Device::with('hardware')
                ->where('status', 1)
                ->whereHas('deviceState', function ($query) {
                    $query->where('state', 1);
                })
                ->whereHas('hardware', function ($query) use ($osVersionSetting) {
                    $query->where('OS_Version', '<', $osVersionSetting->value);
                })
                ->count();
        }

        // Total count of prohibited software
        $prohibitedSoftwareCount = AllSoftware::where('restriction', 0)
            ->count();

        // Total count of prohibited software with devices
        $prohibitedSoftwareWithDevices = AllSoftware::where('restriction', 0)
            ->whereHas('deviceSoftware')
            ->count();


        // Fetch the device counts based on status and month for the current year
        $year = date('Y');
        $acceptedCounts = DB::table('devices')
            ->select(DB::raw('COUNT(*) as count, MONTH(created_at) as month'))
            ->where('status', 1) // Accepted
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $rejectedCounts = DB::table('devices')
            ->select(DB::raw('COUNT(*) as count, MONTH(created_at) as month'))
            ->where('status', 0) // Rejected
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Populate the data arrays with 0 values for missing months
        $acceptedData = [];
        $rejectedData = [];
        for ($month = 1; $month <= 12; $month++) {
            $acceptedData[] = $acceptedCounts[$month] ?? 0;
            $rejectedData[] = $rejectedCounts[$month] ?? 0;
        }

        return view('pages.home', compact(
            'title',
            'description',
            'notifications',
            'allNotifications',
            'unreadNotificationsCount',
            'totalDevicesCount',
            'activeDevicesCount',
            'activePercentage',
            'osVersion',
            'outdatedOSdevices',
            'prohibitedSoftwareCount',
            'prohibitedSoftwareWithDevices',
            'acceptedData',
            'rejectedData'
        ));
    }
}
