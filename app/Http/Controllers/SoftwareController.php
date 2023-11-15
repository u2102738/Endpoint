<?php

namespace App\Http\Controllers;

use App\Exports\DeviceExport;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Device;
use App\Models\AllSoftware;
use App\Models\DeviceState;
use App\Models\Group;
use App\Models\User;
use App\Models\NotificationLog;
use Carbon\Carbon;
use Countable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SoftwareController extends Controller
{
    /**
     * Display recommended OS Version page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $title = "OS Version";
        $description = "Manage OS Version.";

        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();

        $osVersion = Setting::where('name', 'OSVersion')->value('value');

        return view('pages.settings.software.osversion',compact(
            'title',
            'description',
            'osVersion',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Update recommended OS Version.
     *
     * @return \Illuminate\View\View
     */
    public function updateOSVersion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'version' => 'required',
        ]);

        $newOSVersion = $request->input('version');

        if ($validator->fails()) {
            $this->logAudit(Auth::user()->id, 'OS Version', 0, null, 'OS Version failed to be updated. Validation Error.', null);
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
                // Save the new OSVersion with the user ID
                $user = Auth::user();
                $setting = Setting::where('name', 'OSVersion')->first();
                $setting->value = $newOSVersion;
                $setting->user_id = $user->id;
                $setting->save();

                $this->logAudit(Auth::user()->id, 'OS Version', 1, null, 'Recommended OS Version has been updated to ' . $newOSVersion ,null);
                DB::commit();
                return redirect()->back()->with('success', 'Recommended OS Version updated successfully!');

            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit(Auth::user()->id, 'OS Version', 0, null, 'OS Version failed to be update. Error on updating data.', null);
                Log::error('Error updating user: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to update recommended OS Version. Please try again.')->withInput();
            }
        }
    }

    /**
     * Display software management overview.
     *
     * @return \Illuminate\View\View
     */
    public function overview()
    {
        $title = "Software Management - Overview";
        $description = "Overview of Software Management.";

        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();

        $osVersion = Setting::where('name', 'OSVersion')->value('value');

        return view('pages.applications.software-management.overview',compact(
            'title',
            'description',
            'osVersion',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Display devices with outdated os of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function osupdate()
    {
        // Get the OSVersion from the settings table
        $osVersion = Setting::where('name', 'OSVersion')->value('value');

        // Get the latest device states for all devices
        $latestDeviceStates = DeviceState::whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('device_state')
                ->groupBy('device_id');
        })->where('state', 1)->get();

        // Get the IDs of devices with the latest state
        $deviceIdsWithLatestState = $latestDeviceStates->pluck('device_id');

        // Get devices with outdated OS that have the latest state and accepted status.
        $devices = Device::with(['hardware'])
            ->where('status', 1)
            ->whereIn('id', $deviceIdsWithLatestState)
            ->whereHas('hardware', function ($query) use ($osVersion) {
                $query->where('OS_Version', '<', $osVersion);
            })
            ->orderBy('name', 'ASC')
            ->get();

        // Get groups with devices that have outdated OS and active status
        $groupsWithOutdatedDevices = Group::whereHas('devices', function ($query) use ($osVersion) {
            $query->whereHas('hardware', function ($subquery) use ($osVersion) {
                $subquery->where('OS_Version', '<', $osVersion);
            })->where('status', 1);
        })->with(['devices' => function ($query) use ($osVersion) {
            $query->whereHas('hardware', function ($subquery) use ($osVersion) {
                $subquery->where('OS_Version', '<', $osVersion);
            })->whereHas('deviceState', function ($subquery) {
                $subquery->where('state', 1);
            });
        }])->withCount(['devices' => function ($query) use ($osVersion) {
            $query->whereHas('hardware', function ($subquery) use ($osVersion) {
                $subquery->where('OS_Version', '<', $osVersion);
            })->whereHas('deviceState', function ($subquery) {
                $subquery->where('state', 1);
            });
        }])->get();

        // Get the count of devices for each group
        $groupTotalDevices = Group::withCount('devices')->get()->pluck('devices_count', 'id');

        $title = "OS Update";
        $description = "Operating System Update.";

        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.applications.software-management.osupdate',compact(
            'title',
            'description',
            'devices',
            'groupsWithOutdatedDevices',
            'groupTotalDevices',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Send reminder to devices of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function sendReminderOSUpdate(Request $request)
    {
        $apiEndpoint = env('OSUPDATE_API_ENDPOINT');

        $validator = Validator::make($request->all(), [
            'device' => 'required|array',
            'device.*' => 'numeric',
        ], [
            'device.required' => 'Please select a device.',
            'device.array' => 'Please select a valid device.',
            'device.*.numeric' => 'Please select a valid device.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'OS Update Reminder', 0, null, 'OS Update Reminder was unsuccessful. Validation Error.', 'software_osupdate');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'No device is chosen.');
        }

        DB::beginTransaction();
        $deviceCount = count($request->input('device'));

        try {
            $deviceIds = $request->input('device');

            $devices = Device::whereIn('id', $deviceIds)->get();

            if ($devices->count() > 0) {
                $requestData = [
                    'ids' => json_encode($deviceIds),
                ];

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $apiEndpoint,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => http_build_query($requestData),
                    CURLOPT_HTTPHEADER => array(
                        'api-key: ' . env('API_KEY'),
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                if ($response !== false) {
                    // API call was successful

                    $this->logAudit($request->user()->id, 'OS Update Reminder', 1, null, 'OS Update reminder successfully sent to ' . $deviceCount . ' device(s).', 'software_osupdate');
                    DB::commit();
                    return redirect()->back()->with('success', 'OS Update reminder successfully sent to ' . $deviceCount . ' device(s).' . $response);
                } else {
                    // API call failed
                    $errorMessage = curl_error($curl);

                    $this->logAudit($request->user()->id, 'OS Update Reminder', 0, null, 'OS Update reminder failed to be sent to ' . $deviceCount . ' device(s).', 'software_osupdate');
                    Log::error('API Error: ' . $errorMessage);

                    return redirect()->back()->with('error', 'OS Update reminder failed to be sent to ' . $deviceCount . ' device(s). Please try again.')->withInput();
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logAudit($request->user()->id, 'OS Update Reminder', 0, null, 'OS Update reminder failed to be sent to ' . $deviceCount . ' device(s).', 'software_osupdate');
            Log::error('Error sending reminder: ' . $e->getMessage());

            return redirect()->back()->with('error', 'OS Update reminder failed to be sent to ' . $deviceCount . ' device(s). Please try again.')->withInput();
        }
    }

    /**
     * Check devices with outdated OS in group(s).
     *
     * @return \Illuminate\View\View
     */
    public function checkDevicesWithOutdatedOSInGroups(array $groupIds)
    {
        // Get the latest device states for all devices
        $latestDeviceStates = DeviceState::whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('device_state')
                ->groupBy('device_id');
        })->where('state', 1)->get();

        // Get the IDs of devices with the latest state
        $deviceIdsWithLatestState = $latestDeviceStates->pluck('device_id')->toArray();

        // Get the OS version setting value
        $osVersion = Setting::where('name', 'OSVersion')->value('value');

        $deviceIds = [];

        // Loop through each group ID and find devices with outdated OS in each group
        foreach ($groupIds as $groupId) {
            // Get all devices in the current group with outdated OS (Active Devices Only)
            $devices = Device::with(['hardware'])
                ->whereHas('groups', function ($query) use ($groupId) {
                    $query->where('group_id', $groupId);
                })
                ->whereIn('id', $deviceIdsWithLatestState)
                ->whereHas('hardware', function ($query) use ($osVersion) {
                    $query->where('OS_Version', '<', $osVersion);
                })
                ->where('status', 1)
                ->pluck('id')
                ->toArray();

            // Merge the device IDs into the main array
            $deviceIds = array_merge($deviceIds, $devices);
        }

        // Return the array of device IDs with outdated OS in all groups
        return $deviceIds;
    }

    /**
     * Send reminder to groups' devices of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function sendReminderGroupOSUpdate(Request $request)
    {
        $apiEndpoint = env('OSUPDATE_API_ENDPOINT');

        $groupIds = $request->input('groups');

        $validator = Validator::make($request->all(), [
            'groups' => 'required|array',
            'groups.*' => 'numeric',
        ], [
            'group.required' => 'Please select a group.',
            'group.array' => 'Please select a valid group.',
        ]);
        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'OS Update Reminder', 0, null, 'OS Update Reminder was unsuccessful. Validation Error.', 'software_osupdate');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'No group is chosen.');
        }

        $deviceIdsWithOutdatedOS = $this->checkDevicesWithOutdatedOSInGroups($groupIds);
        $deviceIdsWithOutdatedOS = $deviceIdsWithOutdatedOS ?? [];

        DB::beginTransaction();

        try {
            if (!empty($deviceIdsWithOutdatedOS)) {
                $requestData = [
                    'ids' => json_encode($deviceIdsWithOutdatedOS),
                ];

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $apiEndpoint,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => http_build_query($requestData),
                    CURLOPT_HTTPHEADER => array(
                        'api-key: ' . env('API_KEY'),
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                if ($response !== false) {
                    // API call was successful

                    $this->logAudit($request->user()->id, 'OS Update Reminder', 1, null, 'OS Update reminder successfully sent to ' . count($deviceIdsWithOutdatedOS) . ' device(s).', 'software_osupdate');
                    DB::commit();
                    return redirect()->back()->with('success', 'OS Update reminder successfully sent to ' . count($deviceIdsWithOutdatedOS) . ' device(s).' . $response);
                } else {
                    // API call failed
                    $errorMessage = curl_error($curl);

                    $this->logAudit($request->user()->id, 'OS Update Reminder', 0, null, 'OS Update reminder failed to be sent to ' . count($deviceIdsWithOutdatedOS) . ' device(s).', 'software_osupdate');
                    Log::error('API Error: ' . $errorMessage);

                    return redirect()->back()->with('error', 'OS Update reminder failed to be sent to ' . count($deviceIdsWithOutdatedOS) . ' device(s). Please try again.')->withInput();
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logAudit($request->user()->id, 'OS Update Reminder', 0, null, 'OS Update reminder failed to be sent to ' . count($deviceIdsWithOutdatedOS) . ' device(s).', 'software_osupdate');
            Log::error('Error sending reminder: ' . $e->getMessage());

            return redirect()->back()->with('error', 'OS Update reminder failed to be sent to ' . count($deviceIdsWithOutdatedOS) . ' device(s). Please try again.')->withInput();
        }
    }


    /**
     * Display licensed softwares of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function licensedsoftware(){
        $allSoftware   = AllSoftware::orderBy('name', 'ASC')->get();
        $licensedSoftware = AllSoftware::where('type', 1)
        ->orderBy('name', 'ASC')
        ->get();

        $allSoftwareCount = $allSoftware->count();
        $licensedSoftwareCount = $licensedSoftware->count();
        $totalDevices = Device::where('status', 1)->count();

        $title = "Licensed Software";
        $description = "Manage Software License.";

        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.applications.software-management.licensedsoftware',compact(
            'title',
            'description',
            'allSoftware',
            'allSoftwareCount',
            'licensedSoftware',
            'licensedSoftwareCount',
            'totalDevices',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Update software license of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function updateSoftwareLicense(Request $request){
        $validator = Validator::make($request->all(), [
            'software' => 'required|not_in:',
        ], [
            'software.required' => 'Please select a software.',
            'software.not_in' => 'Please select a valid software.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'software license', 0, null, '[  ] license failed to be updated. Validation Error.','software_licensedSoftware');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {

                $softwareId = $request->input('software');
                $licenseType = $request->input('license') ? 1 : 0; // Convert checkbox value to 1 or 0

                // Find the software by ID
                $software = AllSoftware::find($softwareId);

                if ($software) {
                    $software->type = $licenseType;
                    $software->save();

                    $this->logAudit($request->user()->id, 'software license', 1, null, 'Software [ ' . $software->name . ' ] license has been updated.','software_licensedSoftware');
                    DB::commit();
                    return redirect()->back()->with('success', 'Software license updated successfully!');
                }
            }catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'software license', 0, null, 'Software [ ' . $software->name . ' ] license failed to be update. Error on updating data.','software_licensedSoftware');
                Log::error('Error updating software license: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to update software license. Please try again.')->withInput();
            }
        }
    }

    /**
     * Display list of devices of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function licensedsoftware_detail(Request $request){
        $softwareId = $request->id;

        $software = AllSoftware::findOrFail($softwareId);

         // Get devices that have the specified software with status 'licensed'
        $devices = Device::whereHas('deviceSoftware', function($query) use ($softwareId) {
                $query->where('status',1);
                $query->where('all_software_id', $softwareId);
            })
            ->with('groups')
            ->orderBy('name', 'ASC')
            ->get();

        // Get groups with devices that have the specified software with status 'licensed'
        $groupsWithLicensedSoftware = Group::whereHas('devices', function ($query) use ($softwareId) {
            $query->whereHas('deviceSoftware', function ($subquery) use ($softwareId) {
                $subquery->where('status', 1);
                $subquery->where('all_software_id', $softwareId);
            });
        })
        ->withCount(['devices' => function ($query) use ($softwareId) {
            $query->whereHas('deviceSoftware', function ($subquery) use ($softwareId) {
                $subquery->where('status', 1);
                $subquery->where('all_software_id', $softwareId);
            });
        }])
        ->with(['devices' => function ($query) use ($softwareId) {
            $query->whereHas('deviceSoftware', function ($subquery) use ($softwareId) {
                $subquery->where('status', 1);
                $subquery->where('all_software_id', $softwareId);
            })->with('latestDeviceState');
        }])
        ->get();

        // Get the count of devices for each group
        $groupTotalDevices = Group::withCount('devices')->get()->pluck('devices_count', 'id');

        $title = "Licensed Software - Device List";
        $description = "List of device with the software.";

        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.applications.software-management.licensedsoftware_detail',compact(
            'title',
            'description',
            'software',
            'devices',
            'groupsWithLicensedSoftware',
            'groupTotalDevices',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Generate report of devices having the software.
     *
     * @return \Illuminate\View\View
     */
    public function exportDevicesWithSoftware($language, $id)
    {
        $software = AllSoftware::findOrFail($id);
        $softwareName = $software->name;
        $date = now()->format('Y-m-d H:i:s');
        $fileName = 'With' . '_' . $softwareName . '_' . $date;

        $devices = Device::where('status', 1)
            ->whereHas('deviceSoftware', function ($query) use ($id) {
                $query->where('all_software_id', $id);
            })
            ->orderBy('name', 'ASC')
            ->get();

        return Excel::download(new DeviceExport($devices, $softwareName, $date), $fileName . '.xlsx');
    }

    /**
     * Generate report of devices NOT having the software.
     *
     * @return \Illuminate\View\View
     */
    public function exportDevicesWithoutSoftware($language, $id)
    {
        $software = AllSoftware::findOrFail($id);
        $softwareName = $software->name;
        $date = now()->format('Y-m-d H:i:s');
        $fileName = 'Without' . '_' . $softwareName . '_' . $date;

        $devices = Device::where('status', 1)
            ->whereDoesntHave('deviceSoftware', function ($query) use ($id) {
                $query->where('all_software_id', $id);
            })
            ->orderBy('name', 'ASC')
            ->get();

        return Excel::download(new DeviceExport($devices, $softwareName, $date), $fileName . '.xlsx');
    }

    /**
     * Generate report of devices NOT having the software.
     *
     * @return \Illuminate\View\View
     */
    public function exportGroupDevicesWithSoftware($language, $id, $groupId)
    {
        $software = AllSoftware::findOrFail($id);
        $group = Group::findOrFail($groupId);
        $softwareName = $software->name;
        $date = now()->format('Y-m-d H:i:s');
        $fileName = 'With' . '_' . $softwareName . '_' . $group->name . '_' . $date;

        $devices = $group->devices()->where('status', 1)
            ->whereHas('deviceSoftware', function ($query) use ($id) {
                $query->where('all_software_id', $id);
            })
            ->orderBy('name', 'ASC')
            ->get();

        return Excel::download(new DeviceExport($devices, $softwareName, $date), $fileName . '.xlsx');
    }

    /**
     * Generate report of devices NOT having the software.
     *
     * @return \Illuminate\View\View
     */
    public function exportGroupDevicesWithoutSoftware($language, $id, $groupId)
    {
        $software = AllSoftware::findOrFail($id);
        $group = Group::findOrFail($groupId);
        $softwareName = $software->name;
        $date = now()->format('Y-m-d H:i:s');
        $fileName = 'Without' . '_' . $softwareName . '_' . $group->name . '_' . $date;

        $devices = $group->devices()->where('status', 1)
            ->whereDoesntHave('deviceSoftware', function ($query) use ($id) {
                $query->where('all_software_id', $id);
            })
            ->orderBy('name', 'ASC')
            ->get();

        return Excel::download(new DeviceExport($devices, $softwareName, $date), $fileName . '.xlsx');
    }

    /**
     * Display prohibited software of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function prohibitedsoftware()
    {
        $allSoftware   = AllSoftware::orderBy('name', 'ASC')->get();
        $prohibitedSoftware = AllSoftware::where('restriction', 0)
        ->orderBy('name', 'ASC')
        ->get();

        $allSoftwareCount = $allSoftware->count();
        $prohibitedSoftwareCount = $prohibitedSoftware->count();

        $totalDevices = Device::where('status', 1)->count();

        $title = "Prohibited Software";
        $description = "Manage prohibited software.";

        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.applications.software-management.prohibitedsoftware',compact(
            'title',
            'description',
            'allSoftware',
            'allSoftwareCount',
            'prohibitedSoftware',
            'prohibitedSoftwareCount',
            'totalDevices',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Update software restriction of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function updateSoftwareRestriction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'software' => 'required|not_in:',
        ], [
            'software.required' => 'Please select a software.',
            'software.not_in' => 'Please select a valid software.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'software restriction', 0, null, '[  ] restriction failed to be updated. Validation Error.','software_prohibitedSoftware');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {

                $softwareId = $request->input('software');
                $restrictionType = $request->input('restriction') ? 1 : 0; // Convert checkbox value to 1 or 0

                // Find the software by ID
                $software = AllSoftware::find($softwareId);

                if ($software) {
                    $software->restriction = $restrictionType;
                    $software->save();

                    $this->logAudit($request->user()->id, 'software restriction', 1, null, 'Software [ ' . $software->name . ' ] restriction has been updated.','software_prohibitedSoftware');
                    DB::commit();
                    return redirect()->back()->with('success', 'Software restriction updated successfully!');
                }
            }catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'software restriction', 0, null, 'Software [ ' . $software->name . ' ] restriction failed to be update. Error on updating data.','software_prohibitedSoftware');
                Log::error('Error updating software restriction: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to update software restriction. Please try again.')->withInput();
            }
        }
    }

    /**
     * Display device list of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function prohibitedsoftware_detail(Request $request)
    {
        $softwareId = $request->id;

        $software = AllSoftware::findOrFail($softwareId);

        // Get devices that have the specified software that is 'prohibited'
        $devices = Device::whereHas('deviceSoftware.allSoftware', function($query) use ($softwareId) {
                $query->where('restriction', 0);
                $query->where('all_software_id', $softwareId);
            })
            ->orderBy('name', 'ASC')
            ->get();

        // Get groups with devices that have the specified software and is 'prohibited'
        $groupsWithProhibitedSoftware = Group::whereHas('devices', function ($query) use ($softwareId) {
            $query->whereHas('deviceSoftware.allSoftware', function ($subquery) use ($softwareId) {
                $subquery->where('restriction', 0);
                $subquery->where('all_software_id', $softwareId);
            });
        })->withCount(['devices' => function ($query) use ($softwareId) {
            $query->whereHas('deviceSoftware.allSoftware', function ($subquery) use ($softwareId) {
                $subquery->where('restriction', 0);
                $subquery->where('all_software_id', $softwareId);
            });
        }])
        ->with(['devices' => function ($query) use ($softwareId) {
            $query->whereHas('deviceSoftware', function ($subquery) use ($softwareId) {
                $subquery->where('status', 1);
                $subquery->where('all_software_id', $softwareId);
            })->with('latestDeviceState');
        }])
        ->get();

        // Get the count of devices for each group
        $groupTotalDevices = Group::withCount('devices')->get()->pluck('devices_count', 'id');

        $title = "Prohibited Software - Device List";
        $description = "List of device with the prohibited software.";

        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.applications.software-management.prohibitedsoftware_detail',compact(
            'title',
            'description',
            'software',
            'devices',
            'groupsWithProhibitedSoftware',
            'groupTotalDevices',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Send reminder to devices of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function sendReminderProhibited(Request $request)
    {

        $apiEndpoint = env('PROHIBITED_API_ENDPOINT');

        $validator = Validator::make($request->all(), [
            'device' => 'required|not_in:',
        ], [
            'device.required' => 'Please select a device.',
            'device.not_in' => 'Please select a valid device.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'Prohibited Software Reminder', 0, null, 'Prohibited Software Reminder was unsuccessful. Validation Error.','software_prohibitedSoftware');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'No device is chosen.');
        } else {
            DB::beginTransaction();
            $deviceCount = count($request->input('device'));

            try {
                $deviceIds = $request->input('device');

                $devices = Device::whereIn('id', $deviceIds)->get();

                $latestDeviceStates = DeviceState::whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('device_state')
                        ->groupBy('device_id');
                })->whereIn('device_id', $deviceIds)->get();

                foreach ($latestDeviceStates as $latestDeviceState) {
                    if ($latestDeviceState->state == 0) {
                        return redirect()->back()->with('error', 'Sending reminder to a disconnected device(s) is not allowed.');
                    }
                }

                if ($devices->count() > 0) {
                    $requestData = [
                        'ids' => '[' . implode(',', $deviceIds) . ']',
                    ];

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $apiEndpoint,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => false,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => http_build_query($requestData),
                        CURLOPT_HTTPHEADER => array(
                            'api-key: ' . env('API_KEY'),
                        ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);

                    if ($response !== false) {
                        // API call was successful

                        $this->logAudit($request->user()->id, 'Prohibited Software Reminder', 1, null, 'Prohibited Software reminder successfully sent to ' . $deviceCount . ' device(s).', 'software_prohibitedSoftware');
                        DB::commit();
                        return redirect()->back()->with('success', 'Prohibited Software reminder successfully sent to ' . $deviceCount . ' device(s).' . $response);
                    } else {
                        // API call failed
                        $errorMessage = curl_error($curl);

                        $this->logAudit($request->user()->id, 'Prohibited Software Reminder', 0, null, 'Prohibited Software reminder failed to be sent to ' . $deviceCount . ' device(s).', 'software_prohibitedSoftware');
                        Log::error('API Error: ' . $errorMessage);

                        return redirect()->back()->with('error', 'Prohibited Software reminder failed to be sent to ' . $deviceCount . ' device(s). Please try again.')->withInput();
                    }
                }
            }catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'Prohibited Software Reminder', 0, null, 'Prohibited Software reminder failed to be sent to ' . $deviceCount . ' device(s).','software_prohibitedSoftware');
                Log::error('Error sending reminder: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Prohibited Software reminder failed to be sent to ' . $deviceCount . ' device(s). Please try again.')->withInput();
            }
        }
    }

    /**
     * Send reminder to devices of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function checkDevicesWithProhibitedSoftware(array $groupIds, $softwareId)
    {
        // Get the latest device states for all devices
        $latestDeviceStates = DeviceState::whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('device_state')
                ->groupBy('device_id');
        })->where('state', 1)->get();

        // Get the IDs of devices with the latest state
        $deviceIdsWithLatestState = $latestDeviceStates->pluck('device_id')->toArray();

        $deviceIds = [];

        foreach ($groupIds as $groupId) {
            // Find devices in the current group with the specified software that is 'licensed'
            $devices = Device::with('deviceSoftware')
                ->whereHas('groups', function ($query) use ($groupId) {
                    $query->where('group_id', $groupId);
                })
                ->whereIn('id', $deviceIdsWithLatestState)
                ->where('status', 1) // Assuming '1' represents the active status
                ->whereHas('deviceSoftware', function ($query) use ($softwareId) {
                    $query->where('all_software_id', $softwareId);
                })
                ->get();

            // Filter the devices that have the specified software
            $devicesWithSoftware = $devices->filter(function ($device) use ($softwareId) {
                return $device->deviceSoftware->contains('all_software_id', $softwareId);
            });

            // Get the IDs of devices with the specified software
            $deviceIdsWithSoftware = $devicesWithSoftware->pluck('id')->toArray();

            // Merge the device IDs with the specified software into the main array
            $deviceIds = array_merge($deviceIds, $deviceIdsWithSoftware);
        }

        return $deviceIds;
    }

    /**
     * Send reminder to devices of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function sendReminderGroupProhibited(Request $request)
    {
        $apiEndpoint = env('PROHIBITED_API_ENDPOINT');

        $groupIds = $request->input('groups');
        $softwareId = $request->input('software_id');

        $validator = Validator::make($request->all(), [
            'groups' => 'required|array',
            'groups.*' => 'numeric',
        ], [
            'group.required' => 'Please select a group.',
            'group.array' => 'Please select a valid group.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'Prohibited Software Reminder', 0, null, 'Prohibited Software Reminder was unsuccessful. Validation Error.','software_prohibitedSoftware');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'No group is chosen.');
        }
        $deviceIdsWithProhibitedSoftware = $this->checkDevicesWithProhibitedSoftware($groupIds, $softwareId);
        $deviceIdsWithProhibitedSoftware = $deviceIdsWithProhibitedSoftware ?? [];

        DB::beginTransaction();

        try {
            if (!empty($deviceIdsWithProhibitedSoftware)) {
                $requestData = [
                    'ids' => '[' . implode(',', $deviceIdsWithProhibitedSoftware) . ']',
                ];

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $apiEndpoint,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => http_build_query($requestData),
                    CURLOPT_HTTPHEADER => array(
                        'api-key: ' . env('API_KEY'),
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                if ($response !== false) {
                    // API call was successful

                    $this->logAudit($request->user()->id, 'Prohibited Software Reminder', 1, null, 'Prohibited Software reminder successfully sent to ' . count($deviceIdsWithProhibitedSoftware) . ' device(s).', 'software_prohibitedSoftware');
                    DB::commit();
                    return redirect()->back()->with('success', 'Prohibited Software reminder successfully sent to ' . count($deviceIdsWithProhibitedSoftware) . ' device(s).' . $response);
                } else {
                    // API call failed
                    $errorMessage = curl_error($curl);

                    $this->logAudit($request->user()->id, 'Prohibited Software Reminder', 0, null, 'Prohibited Software reminder failed to be sent to ' . count($deviceIdsWithProhibitedSoftware) . ' device(s).', 'software_prohibitedSoftware');
                    Log::error('API Error: ' . $errorMessage);

                    return redirect()->back()->with('error', 'Prohibited Software reminder failed to be sent to ' . count($deviceIdsWithProhibitedSoftware) . ' device(s). Please try again.')->withInput();
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();

            $this->logAudit($request->user()->id, 'Prohibited Software Reminder', 0, null, 'Prohibited Software reminder failed to be sent to ' . count($deviceIdsWithProhibitedSoftware) . ' device(s).','software_prohibitedSoftware');
            Log::error('Error sending reminder: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Prohibited Software reminder failed to be sent to ' . count($deviceIdsWithProhibitedSoftware) . ' device(s). Please try again.')->withInput();
        }
    }

    /**
     * Store a audit log resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function logAudit($user, $eventType, $eventStatus, $userIdAffected = null, $description, $permissionName)
    {
        try {
            $data = [
                'created_at' => now()->timezone('Asia/Kuala_Lumpur'),
                'event_type' => ucwords($eventType),
                'user_id' => $user,
                'event_status' => $eventStatus,
                'description' => $description,
                'user_id_affected' => $userIdAffected, // Assign the provided value or NULL
            ];

            $activity = DB::table('activity_log')->insertGetId($data);

            if($permissionName != NULL){
                $usersWithAccess = User::whereHas('role.permission', function ($query) use ($permissionName) {
                    $query->where('name', $permissionName);
                })->pluck('id');

                $notificationData = [];
                foreach ($usersWithAccess as $userId) {
                    $notificationData[] = [
                        'user_id' => $userId,
                        'activity_id' => $activity,
                        'is_read' => false,
                        'created_at' => now()->timezone('Asia/Kuala_Lumpur'),
                    ];
                }
            } else {
                $notificationData = [];
                // Since only admin able to access, then only admin users' notification will be added.
                $adminUsers = User::where('role_id', 1)->pluck('id');

                foreach ($adminUsers as $userId) {
                    $notificationData[] = [
                        'user_id' => $userId,
                        'activity_id' => $activity,
                        'is_read' => false,
                        'created_at' => now()->timezone('Asia/Kuala_Lumpur'),
                    ];
                }
            }

            if($eventStatus == 1){
                NotificationLog::insert($notificationData);
            }
        } catch (\Exception $e) {
            Log::error('Error logging audit: ' . $e->getMessage());
            throw $e;
        }
    }
}

