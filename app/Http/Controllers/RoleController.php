<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\NotificationLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display manage roles of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(){
        $roles = Role::with('permissionRoles')->orderBy('name', 'ASC')->get();
        $permissions = Permission::orderBy('name', 'ASC')->get();
        $totalPermissions = Permission::count();

        $title = "Roles";
        $description = "Add, Edit, Delete User Roles.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();
        return view('pages.settings.role.list',compact(
            'title',
            'description',
            'roles',
            'permissions',
            'totalPermissions',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Store a newly created role resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|regex:/^[a-zA-Z\s]+$/',
            'description' => 'required',
            'permissions' => 'array|min:0',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'permissions.*.exists' => 'Invalid permission selected.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'add role', 0, null, 'Role [ ' . $request->name . ' ] failed to be added. Validation Error.');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
                $role = new Role();
                $role->name = ucwords($request->name);
                $role->description = $request->description;
                $role->save();
                $role->permission()->attach($request->permissions);

                $this->logAudit($request->user()->id, 'add role', 1, null, 'Role [ ' . $request->name . ' ] has been added.');

                DB::commit();

                return redirect()->back()->with('success', 'Role created successfully!');
            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'add role', 0, null, 'Role [ ' . $request->name . ' ] failed to be added. Error on storing data.');
                Log::error('Error creating role: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to create role. Please try again.')->withInput();
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $id){
        $find_role     = Role::where('id', $id)->get();
        $role          = Role::findOrFail($id);

        // Retrieve all permissions from the database
        $permissions = Permission::orderBy('name', 'ASC')->get();
        $rolePermissionIds = $role->permission()->pluck('permissions.id')->toArray();

        $title         = 'Edit Role';
        $description   = 'Edit Role Details';
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();

        return view('pages.settings.role.edit', compact(
            'title',
            'description',
            'find_role',
            'permissions',
            'rolePermissionIds',
            'notifications',
            'unreadNotificationsCount'
        ));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateDetails (Request $request, $language, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required',Rule::unique('roles')->ignore($id),'regex:/^[a-zA-Z\s]+$/'],
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'edit role', 0, null, 'Role [ ' . $request->name . ' ] details failed to be updated. Validation Error.');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
            $role = Role::findOrFail($id);
            $role->name = ucwords($request->name);
            $role->description = $request->description;
            $role->save();

            $this->logAudit($request->user()->id, 'edit role', 1, null, 'Role [ ' . $request->name . ' ] details has been updated.');
            DB::commit();

            return redirect()->back()->with('success', 'Role details updated successfully!');
            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'edit role', 0, null, 'Role [ ' . $request->name . ' ] details failed to be update. Error on updating data.');
                Log::error('Error updating role: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to update role. Please try again.')->withInput();
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAccess (Request $request, $language, $id)
    {
        $validator = Validator::make($request->all(), [
            'permissions' => 'array|min:1',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'permissions.*.exists' => 'Invalid permission selected.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'edit role', 0, null, 'Role [ ' . $request->name . ' ] permissions failed to be updated. Validation Error.');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
            $role = Role::findOrFail($id);
            $role->permission()->sync($request->permissions);
            $role->save();

            $this->logAudit($request->user()->id, 'edit role', 1, null, 'Role [ ' . $role->name . ' ] permissions has been updated.');
            DB::commit();

            return redirect()->back()->with('success', 'Role permissions updated successfully!');
            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'edit role', 0, null, 'Role [ ' . $role->name . ' ] permissions failed to be update. Error on updating data.');
                Log::error('Error updating role: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Unable to update role. Please try again.')->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($language, $id){
        $find_role = Role::find($id);
        if (!$find_role) {
            return redirect()->back()->with('error', 'Role not found!');
        }

        $roleName = $find_role->name; // Store the name of the role for the log description

        // Check if there are users assigned to this role
        $usersWithRole = User::where('role_id', $id)->count();
        if ($usersWithRole > 0) {
            $this->logAudit(auth()->user()->id, 'delete role', 0, null, 'Role [ ' . $roleName . ' ] failed to be deleted. Exists user with the role.');
            return redirect()->back()->with('error', 'There exists user(s) with this role! Please assign a new role to the user(s) first.');
        }

        DB::beginTransaction();

        try {
            if ($find_role->delete()) {
                // Update related activity logs after deleting the role
                DB::table('activity_log')
                    ->where('user_id_affected', $id)
                    ->update(['user_id_affected' => null]);

                $this->logAudit(auth()->user()->id, 'delete role', 1, null, 'Role [ ' . $roleName . ' ] has been deleted.');
                DB::commit();
                return redirect()->back()->with('success', 'Role deleted successfully!');
            } else {
                DB::rollBack();
                $this->logAudit(auth()->user()->id, 'delete role', 0, null, 'Role [ ' . $roleName . ' ] failed to be deleted. Error on deleting.');
                return redirect()->back()->with('error', 'Unable to delete role. Please try again.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting role: ' . $e->getMessage());

            $this->logAudit(auth()->user()->id, 'delete role', 0, null, 'Role [ ' . $roleName . ' ] failed to be deleted. Error on deleting data.');
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Store a audit log resource in storage.
     *
     * @return
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
