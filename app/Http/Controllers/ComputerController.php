<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceGroup;
use App\Models\DeviceState;
use App\Models\Group;
use App\Models\Hardware;
use App\Models\Setting;
use App\Models\NotificationLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ComputerController extends Controller
{
    /**
     * Display computer device of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function device(){

        $devices = Device::select('devices.*')
        ->leftJoin('device_state', function ($join) {
            $join->on('devices.id', '=', 'device_state.device_id')
                ->whereRaw('device_state.created_at = (SELECT MAX(created_at) FROM device_state WHERE device_id = devices.id)');
        })
        ->orderBy('devices.name', 'ASC')
        ->get();

        // Count the total number of devices
        $total_devices = Device::count();

        // Get the number of devices with status accepted or rejected
        $accepted = Device::where('status', 1)->count();
        $rejected = Device::where('status', 0)->count();

        $latestDeviceStates = DeviceState::whereIn('created_at', function ($query) {
            $query->select(DB::raw('MAX(created_at)'))
                ->from('device_state')
                ->groupBy('device_id');
        })->get();


        // Get the number of devices with state active or inactive
        $active = $latestDeviceStates->where('state', 1)->count();
        $disconnected = $latestDeviceStates->where('state', 0)->count();

        // Get the OSVersion from the settings table
        $osVersion = Setting::where('name', 'OSVersion')->value('value');

        // Count the number of devices with OS_Version lower than the OSVersion in settings
        $total_outdatedOS = Device::where('status', 1)
        ->whereHas('hardware', function ($query) use ($osVersion) {
            $query->where('OS_Version', '<', $osVersion);
        })
        ->count();

        // Get the number of devices with valid or invalid ERP
        $valid_ERP = Hardware::where('erp_owner', 1)->count();
        $invalid_ERP = Hardware::where('erp_owner', 0)->count();

        foreach ($devices as $device) {
            $device->hasOutdatedOS = $device->status && $device->hardware->OS_Version < $osVersion;
        }

        $title = "Device";
        $description = "Add, Edit, Delete Computer Device";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.applications.computer.device',compact(
            'title',
            'description',
            'devices',
            'total_devices',
            'accepted',
            'rejected',
            'active',
            'disconnected',
            'total_outdatedOS',
            'valid_ERP',
            'invalid_ERP',
            'notifications',
            'unreadNotificationsCount'
            ));
    }

    /**
     * Display device details of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function deviceDetails($language, $id){
        $find_device = Device::with(['latestDeviceState' => function ($query) {
            $query->latest('created_at');
        }])
        ->where('id', $id)
        ->get();

        $devices = Device::with(['latestDeviceState' => function ($query) {
            $query->latest('created_at');
        }])
        ->where('id', $id)
        ->first()
        ->deviceSoftware()
        ->orderBy('all_software_id')
        ->get();

        $recommendedOSVersion = Setting::where('name', 'OSVersion')->value('value');

        $title = "Device Details";
        $description = "View details of device.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.applications.computer.device_details', compact(
            'title',
            'description',
            'find_device',
            'devices',
            'recommendedOSVersion',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Display group details of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function group(Request $request){
        $devices = Device::orderBy('name', 'ASC')->get();
        $groups = Group::orderBy('name', 'ASC')->get();

        $title = "Device Group";
        $description = "Manage Device Groups.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.applications.group.group',compact(
            'title',
            'description',
            'devices',
            'groups',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Store group details of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function groupStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:groups|regex:/^[a-zA-Z\s]+$/',
            'description' => 'required',
            'device' => 'array|min:0',
            'devices.*' => 'exists:devices,id',
        ], [
            'devices.*.exists' => 'Invalid device selected.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'add group', 0, null, 'Group [ ' . $request->name . ' ] failed to be added. Validation Error.','computer_group');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
                $group = new Group();
                $group->name = ucwords($request->name);
                $group->description = $request->description;
                $group->save();
                $group->deviceGroups()->attach($request->devices);

                $this->logAudit($request->user()->id, 'add group', 1, null, 'Group [ ' . $request->name . ' ] has been added.','computer_group');

                DB::commit();

                return redirect()->back()->with('success', 'Group created successfully!');
            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'add group', 0, null, 'Group [ ' . $request->name . ' ] failed to be added. Error on storing data.','computer_group');
                Log::error('Error creating group: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to create group. Please try again.' . $e->getMessage())->withInput();
            }
        }
    }

    /**
     * Display edit group of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function groupEdit($language, $id){
        $find_group     = Group::where('id', $id)->get();
        $group          = Group::findOrFail($id);

        $devicesInGroup = Device::join('device_group', 'devices.id', '=', 'device_group.device_id')
                ->where('device_group.group_id', $group->id)
                ->orderBy('devices.name', 'asc') // Order devices by name in ascending order
                ->get(['devices.id', 'devices.name', 'devices.device_owner']);

        $devicesNotInGroup = Device::whereNotIn('id', function($query) use ($group) {
                $query->select('device_id')
                      ->from('device_group')
                      ->where('group_id', $group->id);
                })
                ->orderBy('name', 'asc')
                ->get(['id', 'name', 'device_owner']);

        $title = "Edit Group";
        $description = "Edit Group Details.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.applications.group.edit',compact(
            'title',
            'description',
            'find_group',
            'group',
            'devicesInGroup',
            'devicesNotInGroup',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Update group details of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function updateDetails(Request $request,$language,$id){
        $validator = Validator::make($request->all(), [
            'name' => ['required',Rule::unique('groups')->ignore($id),'regex:/^[a-zA-Z\s]+$/'],
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'edit group details', 0, null, 'Group [ ' . $request->name . ' ] details failed to be updated. Validation Error.', 'computer_group');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
            $group = Group::findOrFail($id);
            $group->name = ucwords($request->name);
            $group->description = $request->description;
            $group->save();

            $this->logAudit($request->user()->id, 'edit group details', 1, null, 'Group [ ' . $request->name . ' ] details has been updated.', 'computer_group');
            DB::commit();

            return redirect()->back()->with('success', 'Group details updated successfully!');
            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'edit group details', 0, null, 'Group [ ' . $request->name . ' ] details failed to be update. Error on updating data.', 'computer_group');
                Log::error('Error updating group details: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to update group. Please try again.')->withInput();
            }
        }
    }

    /**
     * Add group devices of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function addDevices(Request $request, $language, $groupId){
        $group = Group::find($groupId);
        $groupName = $group->name;
        $deviceIds = $request->input('devices');

        if (!$group) {
            return redirect()->back()->with('error', 'Group not found.');
        }

        // Check if devices array is empty
        if (empty($deviceIds)) {
            $validator = Validator::make($request->all(), [
                'devices' => 'required|array|min:1',
                'devices.*' => 'exists:devices,id',
            ], [
                'devices.required' => 'No devices selected.',
                'devices.*.exists' => 'Invalid device selected.',
            ]);

            if ($validator->fails()) {
                $this->logAudit($request->user()->id, "add group's device", 0, null, 'Device failed to be added to group [ ' . $groupName . ' ]. Validation Error.', 'computer_group');
                return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
            }
        } else {
            // Retrieve the devices based on the selected IDs
            $devices = Device::whereIn('id', $deviceIds)->get();
            $deviceNames = $devices->pluck('name')->toArray();
        }

        DB::beginTransaction();

        try {
            $deviceCount = count($deviceIds);
            $group->devices()->attach($deviceIds);

            $logDescription = $deviceCount . ' devices [' . implode(', ', $deviceNames) . '] have been added to group [' . $groupName . ']';
            $this->logAudit($request->user()->id, "add group's device", 1, null, $logDescription, 'computer_group');

            DB::commit();

            return redirect()->back()->with('success', $deviceCount . ' device(s) added successfully into ' . $groupName . '!');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logAudit($request->user()->id, "add group's device", 0, null, 'Device failed to be added to group [' . $groupName . ']. Error on storing data.', 'computer_group');
            Log::error('Error adding device to group: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Unable to add device to group. Please try again.' . $e->getMessage())->withInput();
        }
    }


    /**
     * Delete group device of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function deleteDevice($language, $groupId, Request $request){
        $deviceIds = $request->input('device');
        if (empty($deviceIds)) {
            return redirect()->back()->with('error', 'No devices selected!');
        }

        $groupName = Group::find($groupId)->name;
        $groupId = $request->input('group_id');

        DB::beginTransaction();

        try {
            $devices = Device::whereIn('id', $deviceIds)->get();
            $deviceCount = count($deviceIds);

            DeviceGroup::where('group_id', $groupId)
            ->whereIn('device_id', $deviceIds)
            ->delete();

            $logDescription = $deviceCount . ' devices [ ' . implode(', ', $devices->pluck('name')->toArray()) . ' ] have been removed from group [ ' . $groupName . ' ]';
            $this->logAudit(auth()->user()->id, "remove group's devices", 1, null, $logDescription, 'computer_group');

            DB::commit();
            return redirect()->back()->with('success', $deviceCount . ' devices removed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error removing device from group: ' . $e->getMessage());

            $this->logAudit(auth()->user()->id, "remove group's devices", 0, null, 'Failed to remove devices from group [ ' . $groupName . ' ]. Error: ' . $e->getMessage(), 'computer_group');
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Delete group of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function groupDelete($language, $id){
        $find_group = Group::find($id);
        if (!$find_group) {
            return redirect()->back()->with('error', 'Group not found!');
        }

        $groupName = $find_group->name; // Store the name of the group for the log description

        // Check if there are users assigned to this group
        $devicesInGroup = DeviceGroup::where('group_id', $id)->count();
        if ($devicesInGroup > 0) {
            $this->logAudit(auth()->user()->id, 'delete device group', 0, null, 'Group [ ' . $groupName . ' ] failed to be deleted. Exists device in the group.', 'computer_group');
            return redirect()->back()->with('error', 'There exists device(s) in this group! Please assign a new group to the device(s) first or remove the device(s).');
        }

        DB::beginTransaction();

        try {
            if ($find_group->delete()) {

                $this->logAudit(auth()->user()->id, 'delete device group', 1, null, 'Group [ ' . $groupName . ' ] has been deleted.', 'computer_group');
                DB::commit();
                return redirect()->back()->with('success', 'Group deleted successfully!');
            } else {
                DB::rollBack();

                $this->logAudit(auth()->user()->id, 'delete device group', 0, null, 'Group [ ' . $groupName . ' ] failed to be deleted. Error on deleting data.', 'computer_group');
                return redirect()->back()->with('error', 'Unable to delete group. Please try again.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting group: ' . $e->getMessage());

            $this->logAudit(auth()->user()->id, 'delete device group', 0, null, 'Group [ ' . $groupName . ' ] failed to be deleted. Error on deleting data.', 'computer_group');
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
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

            if($eventStatus == 1){
                NotificationLog::insert($notificationData);
            }
        } catch (\Exception $e) {
            Log::error('Error logging audit: ' . $e->getMessage());
            throw $e;
        }
    }
}
