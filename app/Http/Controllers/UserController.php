<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\NotificationLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {
    /**
     * Display user list of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function list(){

        // Retrieve the number of users created today
        $today = User::whereDate('created_at', Carbon::today())->count();

        // Retrieve the number of users created yesterday
        $yesterday = User::whereDate('created_at', Carbon::yesterday())->count();

        // Retrieve the number of users created this month
        $thisMonth = User::whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month)->count();

        $users   = User::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy('name', 'ASC')->pluck('name', 'id');
        $total_users = User::count();

        $title = "Users";
        $description = "Add, View, Update, Delete Users";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.settings.user.list',compact(
            'title',
            'description',
            'users',
            'roles',
            'total_users',
            'today',
            'yesterday',
            'thisMonth',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Store a newly created user resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users',
            'phonenumber' => 'required|numeric|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ],  [
            'password.regex' => 'The password needs to have at least 1 uppercase letter, 1 lowercase letter, 1 numeric value, and 1 special character.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'add user', 0, null, $request->name . ' failed to be added. Validation Error.');

            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phonenumber = $request->phonenumber;
                $user->role_id = $request->role;
                $user->password = Hash::make($request->password);
                $user->save();

                $this->logAudit($request->user()->id, 'add user', 1, $user->id, $user->name . ' has been added.');

                DB::commit();

                return redirect()->back()->with('success', 'User created successfully!');
            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'add user', 0, null, $user->name . ' failed to be added. Error on storing data.');
                Log::error('Error creating user: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to create user. Please try again.')->withInput();
            }
        }
    }

    /**
     * Update user resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $language, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'phonenumber' => ['required', 'numeric', Rule::unique('users')->ignore($id)],
            'role' => 'nullable|exists:roles,id'
        ], [
            'phonenumber.numeric' => 'The phone number need to be in numeric!',
            'phonenumber.required' => 'The phone number field is required!',
            'role.exists' => 'The selected role is invalid.'
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'edit user', 0, $user->id, $user->name . ' failed to be updated. Validation Error.');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->phonenumber  = $request->phonenumber;
            $user->role_id = $request->role;

            $user->save();

            $this->logAudit($request->user()->id, 'edit user', 1, $user->id, $user->name . ' has been updated.');
            DB::commit();
            return redirect()->back()->with('success', 'User updated successfully!');

            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'edit user', 0, $user->id, $user->name .' failed to be update. Error on updating data.');
                Log::error('Error updating user: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to update user. Please try again.')->withInput();
            }
        }
    }

    /**
     * Delete a user resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete($language, $id)
    {
        $find_user = User::find($id);
        if (!$find_user) {
            return redirect()->back()->with('error', 'User not found!');
        }

        DB::beginTransaction();

        try {
            $userName = $find_user->name; // Store the name of the user for the log description

            // Update related activity logs
            DB::table('activity_log')
                ->where('user_id_affected', $id)
                ->update(['user_id_affected' => null]);

            if ($find_user->delete()) {

                $this->logAudit(auth()->user()->id, 'delete user', 1, null, $userName . ' has been deleted.');
                DB::commit();
                return redirect()->back()->with('success', 'User deleted successfully!');
            } else {
                DB::rollBack();

                $this->logAudit(auth()->user()->id, 'delete user', 0, null, $userName . ' failed to be deleted.');
                return redirect()->back()->with('error', 'Unable to delete user. Please try again.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logAudit(auth()->user()->id, 'delete user', 0, null, $userName .' failed to be deleted. Error on deleting data.');
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Store a audit log resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function logAudit($user, $eventType, $eventStatus, $userIdAffected = null, $description)
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

            if($eventStatus == 1){
                NotificationLog::insert($notificationData);
            }
        } catch (\Exception $e) {
            Log::error('Error logging audit: ' . $e->getMessage());
            throw $e;
        }
    }
}
