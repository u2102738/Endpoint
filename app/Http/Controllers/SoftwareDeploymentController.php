<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DevicePackage;
use App\Models\DeviceState;
use App\Models\NotificationLog;
use App\Models\Package;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SoftwareDeploymentController extends Controller
{
    /**
     * Display overview of software deployment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function overview(){
        $title = "Software Deployment - Overview";
        $description = "Overview of Software Deployment.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();

        return view('pages.applications.software-deployment.overview',compact(
            'title',
            'description',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Display list of packages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deployment(){
        $packages   = Package::orderBy('name', 'ASC')->get();

        $title = "Software Deployment - Package";
        $description = "Overview of Software Deployment.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();

        return view('pages.applications.software-deployment.deployment',compact(
            'title',
            'description',
            'packages',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Store a package details in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function packageStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'version' => 'required',
            'file' => 'required|file',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'add package', 0, null, 'Package [ ' . $request->name  .' ] failed to be added. Validation Error.','software_deployment');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
                $file = $request->file('file');
                $originalFileName = $file->getClientOriginalName();
                $filePath = $file->store('public/files');

                $package = new Package();
                $package->name = $request->name;
                $package->version = $request->version;
                $package->file_path = $filePath;
                $package->file_name = $originalFileName;
                $package->save();

                $this->logAudit($request->user()->id, 'add package', 1, null, 'Package [ ' . $request->name . ' ] has been added.','software_deployment');

                DB::commit();

                return redirect()->back()->with('success', 'Package added successfully!');
            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'add package', 0, null, 'Package [ ' . $request->name . ' ] failed to be added. Error on storing data.','software_deployment');
                Log::error('Error adding package: ' . $e->getMessage());
                $errorMessage = 'Unable to add package. Please try again. Error: ' . $e->getMessage();

                return redirect()->back()->with('error', 'Unable to add package. Please try again.'. $errorMessage)->withInput();
            }
        }
    }

    /**
     * Download package file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request, $language, $id){
        $package = Package::findOrFail($id);

        $filePath = storage_path('app/' . $package->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath, $package->file_name);
        } else {
            abort(404);
        }
    }

    /**
     * Update specified package.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function packageUpdate(Request $request, $language, $id){
        $package = Package::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'version' => 'required',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'edit package', 0, null, 'Package [ ' . $request->name . ' ] failed to be updated. Validation Error.','software_deployment');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();
            try {
                $package->name = $request->name;
                $package->version = $request->version;
                $package->save();

                $this->logAudit($request->user()->id, 'edit package', 1, null, 'Package [ ' . $request->name . ' ] has been updated.','software_deployment');
                DB::commit();
                return redirect()->back()->with('success', 'Package updated successfully!');
            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'edit package', 0, null, 'Package [ ' . $request->name . ' ] failed to be updated. Error on storing data.','software_deployment');
                Log::error('Error updating package: ' . $e->getMessage());
                $errorMessage = 'Unable to update package. Please try again. Error: ' . $e->getMessage();

                return redirect()->back()->with('error', 'Unable to update package. Please try again.'. $errorMessage)->withInput();
            }
        }
    }

    /**
     * Delete specified package.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function packageDelete(Request $request, $language, $id){
        $package = Package::findOrFail($id);

        DB::beginTransaction();

        try {
            $packageName = $package->name;
            $package->devicePackages()->delete();
            if($package->delete()){
                Storage::delete($package->file_path);
                // DevicePackage::where('package_id', $id)->delete();

                $this->logAudit(auth()->user()->id, 'delete package', 1, null, 'Package [ ' . $packageName . ' ] has been deleted.','software_deployment');
                DB::commit();
                return redirect()->back()->with('success', 'Package deleted successfully!');
            } else {
                DB::rollBack();

                $this->logAudit(auth()->user()->id, 'delete package', 0, null, 'Package [ ' . $packageName . ' ] failed to be deleted.','software_deployment');
                return redirect()->back()->with('error', 'Unable to delete package. Please try again.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logAudit(auth()->user()->id, 'delete user', 0, null, 'Package [ ' . $packageName . ' ] failed to be deleted. Error on deleting data','software_deployment');
            Log::error('Error deleting package: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display specified package detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deployment_detail(Request $request, $language, $id){
        $package = Package::findOrFail($id);

        $latestDeviceStates = DeviceState::whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('device_state')
                ->groupBy('device_id');
        })->where('state', 1)->get();

        $deviceIdsWithLatestState = $latestDeviceStates->pluck('device_id');

        // Get devices that do not have the specified package and currently active
        $devices = Device::whereDoesntHave('devicePackage', function ($query) use ($id) {
            $query->where('package_id', $id);
        })->whereIn('id', $deviceIdsWithLatestState)->get();

        $title = "Software Deployment - Package Detail";
        $description = "Overview of Software Deployment.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();

        return view('pages.applications.software-deployment.deployment_detail',compact(
            'title',
            'description',
            'package',
            'devices',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Store a audit log resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function logAudit($user, $eventType, $eventStatus, $userIdAffected = null, $description, $permissionName){
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

    public function downloadThruAPI(Request $request, $filename)
    {
        $validators = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validators->fails()) {
            return response()->json(['error' => 'Please fill the form.'], 400);
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $package = Package::find($filename);
                // Determine the file's storage path
                $filePath = storage_path('app/' . $package->file_path);
        
                // Check if the file exists
                if (!file_exists($filePath)) {
                    return response()->json(['message' => $filePath], 404);
            }
                // Define the response headers
                $headers = [
                    'Content-Type' => 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename="' . $package->file_name . '"',
                ];
                // Return the file response
                return response()->file($filePath, $headers);
            } else {
                return response()->json(['error' => 'Email / Password is incorrect!'], 401);
            }
        }
    }

        /**
     * Send reminder to devices of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function deploySoftwareClick(Request $request)
    {
        $apiEndpoint = env('SOFTWAREDEPLOYMENT_API_ENDPOINT');

        $validator = Validator::make($request->all(), [
            'device' => 'required|array',
            'device.*' => 'numeric',
        ], [
            'device.required' => 'Please select a device.',
            'device.array' => 'Please select a valid device.',
            'device.*.numeric' => 'Please select a valid device.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'Software Deployment', 0, null, 'Software deployment was unsuccessful. Validation Error.', 'software_deployment');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'No device is chosen.');
        }

        DB::beginTransaction();
        $deviceCount = count($request->input('device'));

        try {
            $deviceIds = $request->input('device');
            $softwareId = $request->input('software');

            $devices = Device::whereIn('id', $deviceIds)->get();

            if ($devices->count() > 0) {
                $requestData = [
                    'ids' => json_encode($deviceIds),
                    'software_id' => json_encode($softwareId),
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

                    $this->logAudit($request->user()->id, 'Software Deployment', 1, null, 'Software successfully deploy to ' . $deviceCount . ' device(s).', 'software_deployment');
                    DB::commit();
                    return redirect()->back()->with('success', 'Software successfully deploy to ' . $deviceCount . ' device(s).' . $response);
                } else {
                    // API call failed
                    $errorMessage = curl_error($curl);

                    $this->logAudit($request->user()->id, 'Software Deployment', 0, null, 'Software failed to be deployed to ' . $deviceCount . ' device(s).', 'software_deployment');
                    Log::error('API Error: ' . $errorMessage);

                    return redirect()->back()->with('error', 'Software failed to be deployed to ' . $deviceCount . ' device(s). Please try again.')->withInput();
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logAudit($request->user()->id, 'Software Deployment', 0, null, 'Software failed to be deployed to ' . $deviceCount . ' device(s).', 'software_deployment');
            Log::error('Error sending reminder: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Software failed to be deployed to ' . $deviceCount . ' device(s). Please try again.')->withInput();
        }
    }
}
