<?php

namespace App\Http\Controllers;


use App\Models\Agent;
use App\Models\NotificationLog;
use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class AgentController extends Controller
{
    /**
     * Display overview of agent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function overview(){
        $title = "Agent - Overview";
        $description = "Overview of Agent.";
        // Notification.
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();

        return view('pages.applications.agent.overview',compact(
            'title',
            'description',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Display list of agents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deployment(Request $request)
    {
        //$agents = Agent::orderBy('username', 'ASC')->get();
        $agents = Agent::orderBy('created_at', 'desc')->get();

        $title = "Agent - Deploy";
        $description = "Overview of Agent.";
    
        $user = Auth::user();
        $notifications = NotificationLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        $unreadNotificationsCount = NotificationLog::where('user_id', $user->id)->where('is_read', 0)->count();

    
        $searchKeyword = $request->input('search_keyword'); 
        $ldapData = [];

        $ldapServer = env('LDAP_SERVER');
        $ldapPort = env('LDAP_PORT');
        $ldapUsername = env('LDAP_USERNAME');
        $ldapPassword = env('LDAP_PASSWORD');
        $ldapBaseDn = env('LDAP_BASE_DN');
   
        $ldapConn = ldap_connect($ldapServer, $ldapPort);
        
        if ($ldapConn) {
            $ldapBind = ldap_bind($ldapConn, $ldapUsername, $ldapPassword);

            if ($ldapBind) {
                $ldapFilter = "(&(uid={$searchKeyword}*))"; // Search filter

                $ldapSearch = ldap_search($ldapConn, $ldapBaseDn, $ldapFilter);

                if ($ldapSearch) {
                    $ldapEntries = ldap_get_entries($ldapConn, $ldapSearch);

                    if ($ldapEntries['count'] > 0) {
                        $ldapData = []; // Prepare an array to store LDAP entries for view

                        for ($i = 0; $i < $ldapEntries['count']; $i++) {
                            $ldapData[] = [
                                'dn' => $ldapEntries[$i]['dn'],
                                'uid' => isset($ldapEntries[$i]['uid'][0]) ? $ldapEntries[$i]['uid'][0] : 'N/A',
                                'cn' => isset($ldapEntries[$i]['cn'][0]) ? $ldapEntries[$i]['cn'][0] : 'N/A',
                            ];
                        }

                        return view('pages.applications.agent.agent', [
                            'title' => $title,
                            'description' => $description,
                            'agents' => $agents,
                            'notifications' => $notifications,
                            'unreadNotificationsCount' => $unreadNotificationsCount,
                            'ldapData' => $ldapData, // Pass LDAP search results to the view
                            'searchKeyword' => $searchKeyword, // Send the search keyword back to the form
                        ]);
                    } else {
                        return redirect()->back()->with('error', 'No entries found.');
                    }
                } else {
                    return redirect()->back()->with('error', 'LDAP search failed.');
                }
            } else {
                return redirect()->back()->with('error', 'LDAP bind failed.');
            }

            ldap_close($ldapConn);
        } else {
            return redirect()->back()->with('error', 'Unable to connec tot LDAP server.');
        }
    }

    
    /**
     * Store an agent details in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agentStore(Request $request){
        $validator = Validator::make($request->all(), [
            'ldap' => 'required|array',
            'ldap.*' => 'required',
        ]);

        if ($validator->fails()) {
            $this->logAudit($request->user()->id, 'assign agent', 0, null, 'agent [ ' . $request->name  .' ] failed to be assigned. Validation Error.','agent');
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'There were some errors with your submission. Please fix them and try again.');
        } else {
            DB::beginTransaction();

           
            $selectedLdapEntries = $request->input('ldap') ;

            $newlyAddedAgents = [];

            try {
                foreach ($selectedLdapEntries as $selectedLdapEntry) {

                    // Search for "uid=" followed by characters of not comma
                    preg_match('/uid=([^,]+)/', $selectedLdapEntry, $matches);

                    if (count($matches) >= 2) {
                        $uid = $matches[1]; // Extracted 'uid' value
                        $agent = new Agent();
                        $agent->status = 'Requested';
                        $agent->username = $uid; // Save 'uid' as 'username' in Agent table
                        $agent->save();
                        $newlyAddedAgents[] = $uid; // Add 'uid' to the list of newly added agents

                        $this->logAudit($request->user()->id, 'assign agent', 1, null, 'Agent [ ' . $uid . ' ] has been assigned.','agent');
                    
                    } else {
                        $this->logAudit($request->user()->id, 'assign agent', 0, null, 'Failed to extract uid from LDAP entry: ' . $selectedLdapEntry, 'agent');
                    }   
                
                }
                DB::commit();
               
                $agents = Agent::whereIn('username', $newlyAddedAgents)->get()->unique('username');

                $filePath = 'agent/agents.xlsx';
                Excel::store(new UsersExport($agents), $filePath, 'local');
               
                
                return redirect()->back()->with('success', 'Agent assigned successfully!');

            } catch (\Exception $e) {
                DB::rollBack();

                $this->logAudit($request->user()->id, 'assign agent', 0, null, 'Agent [ ' . $request->name . ' ] failed to be assigned. Error on storing data.','agent');
                Log::error('Error assigning agent: ' . $e->getMessage());
                $errorMessage = 'Unable to assign agent. Please try again. Error: ' . $e->getMessage();

                return redirect()->back()->with('error', 'Unable to assign agent. Please try again.'. $errorMessage)->withInput();
            }
        }
    }
    
    /**
     * Send email attachment to user based on selected agent(s)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request){

       // Validate the request
       $agentIds = $request->input('agent', []);

       // Validate if agents were selected
       if (empty($agentIds)) {
           return redirect()->back()->with('error', 'No agents selected.');
       }

        // Get agents with selected IDs
        $agents = Agent::whereIn('id', $agentIds)->get();

        // Loop through each agent and send an email
        foreach ($agents as $agent) {
            $email = $agent->username . '@sains.com.my';
            $attachmentPath = $agent->link_path;

            // Use Laravel's built-in Mail functionality to send the email with attachment
            Mail::send('emails.send-email', ['agent' => $agent], function ($message) use ($email, $attachmentPath) {
                $message->to($email)
                        ->subject('Subject of the Email')
                        ->attach($attachmentPath);
            });
        }

        return redirect()->back()->with('success', 'Emails sent successfully.');

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
                // Since only admin able to access, then only admin users' notification will be assigned.
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
