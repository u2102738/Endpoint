<?php

namespace App\Http\Controllers;

use App\Models\NotificationLog;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SocialAppController extends Controller {

    /**
     * Display social app profile setting of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function profileSetting(){
        $user = Auth::user();

        $title = "Profile Setting";
        $description = "View and edit profile";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();

        return view('pages.applications.social.profile_setting',compact(
            'title',
            'description',
            'user',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Update user profile.
     *
     * @return \Illuminate\View\View
     */
    public function updateProfile(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($id)],
            'phonenumber' => ['sometimes', 'required', 'numeric', Rule::unique('users')->ignore($id)],
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'update profile', 0, $id, $request->name . ' failed to update profile. Validation Error.');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

            try {
                $user = User::findOrFail($id);

                $user->name         = $request->name;
                $user->email        = $request->email;
                $user->phonenumber  = $request->phonenumber;

                $user->save();

                $this->logAudit($request->user()->id, 'update profile', 1, $user->id, $user->name . ' profile has been updated.');
                DB::commit();
                return redirect()->back()->with('success', 'Profile updated successfully!');
            }catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'update profile', 0, $user->id, $request->name .' failed to update profile. Error on updating data.');
                Log::error('Error updating user: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Unable to update profile. Please try again.')->withInput();
            }
        }
    }

    /**
     * Update user password.
     *
     * @return \Illuminate\View\View
     */
    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'old-password' => 'required|string',
            'new-password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ],  [
            'old-password.required' => 'The old password cannot be empty.',
            'new-password.required' => 'The new password cannot be empty.',
            'new-password.regex' => 'The password need to have at least 1 uppercase letter, 1 lowercase letter, 1 numeric value and 1 special character.',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'update password', 0, $id, $request->user()->name . ' failed to update password. Validation Error.');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {

            DB::beginTransaction();

            try {
                $user = User::findOrFail($id);

                // Check if old password matches current password
                if (!Hash::check($request->input('old-password'), $user->password)) {
                    return redirect()->back()->withErrors(['old-password' => 'The old password is incorrect.'])->withInput();
                }

                $user->password = Hash::make($request->input('new-password'));

                $user->save();

                $this->logAudit($request->user()->id, 'update password', 1, $user->id, $user->name . ' password has been updated.');
                DB::commit();
                return redirect()->back()->with('success', 'Password updated successfully!');

            }catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'update profile', 0, $user->id, $request->user()->name .' failed to update password. Error on updating data.');
                Log::error('Error updating user: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Unable to update password. Please try again.')->withInput();
            }
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

            DB::table('activity_log')->insert($data);
        } catch (\Exception $e) {
            Log::error('Error logging audit: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Mark all unread notification as read.
     *
     * @return \Illuminate\View\View
     */
    public function markAllasRead(){
        $user = Auth::user();
        NotificationLog::where('user_id', $user->id)
                        ->where('is_read', 0)
                        ->update(['is_read' => 1]);

        return redirect()->back();
    }

    /**
     * Mark clicked notification as read.
     *
     * @return \Illuminate\View\View
     */
    public function markAsRead($locale, $notificationId)
    {
        $notification = NotificationLog::find($notificationId);
        $notification -> update(['is_read' => 1]);

        // Redirect to the appropriate route based on the notification type
        $redirectRoute = '';

        if (Str::contains($notification->activity->event_type, 'User')) {
            $redirectRoute = route('settings.user.list', $locale);
        } elseif (Str::contains($notification->activity->event_type, 'Role')) {
            $redirectRoute = route('settings.role.list', $locale);
        } elseif (Str::contains($notification->activity->event_type, 'OS Version')) {
            $redirectRoute = route('settings.software-management.osversion', $locale);
        } elseif (Str::contains($notification->activity->event_type, 'Group')) {
            $redirectRoute = route('computer.group', $locale);
        } elseif (Str::contains($notification->activity->event_type, 'OS Update')) {
            $redirectRoute = route('software-management.osupdate', $locale);
        } elseif (Str::contains($notification->activity->event_type, 'Software License')) {
            $redirectRoute = route('software-management.licensedsoftware', $locale);
        } elseif (Str::contains($notification->activity->event_type, 'Software Restriction') || Str::contains($notification->activity->event_type, 'Prohibited')) {
            $redirectRoute = route('software-management.prohibitedsoftware', $locale);
        } elseif (Str::contains($notification->activity->event_type, 'Package')) {
            $redirectRoute = route('software-deployment.deployment', $locale);
        }

        return redirect($redirectRoute);
    }

    /**
     * Clear all notification at top navigation bar.
     *
     * @return \Illuminate\View\View
     */
    public function clearNotification(){
        $user = Auth::user();
        NotificationLog::where('user_id', $user->id)->delete();

        return redirect()->back();
    }
}
