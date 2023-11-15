<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller {

    /**
     * Display login of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function login(){
        $title = "Login";
        $description = "Some description for the page";
        return view('auth.login',compact('title','description'));
    }

    public function authenticate(Request $request){
        $validators=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validators->fails()){
            $this->logAudit(null, 0, 'Validation Error.');
            return redirect()->route('login')->withErrors($validators)->withInput()->with('error', 'Please fill the form.');
        } else {
            DB::beginTransaction();

            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                $this->logAudit($request->user()->id, 1, null);

                DB::commit();

                $accessToken = $request->user()->createToken('authToken')->accessToken;
                return redirect()->intended(route('home', 'en'))->with('success', 'Welcome back!');
                // // $user = Auth::user();
                // $token = $request->user()->createToken('MyApp')->accessToken;
                // if (Str::startsWith(request()->path(), 'api')) {
                //     return response()->json(['token' => $token], 200);
                // } else {
                //     return redirect()->intended(route('home', 'en'))->with('success', 'Welcome back!' . $accessToken);
                // }
            } else {
                DB::rollBack();

                $this->logAudit(null, 0, 'Wrong Credentials.');

                return redirect()->route('login')->with('error', 'Email / Password is incorrect!');

                // if ($request->ajax() || Str::startsWith(request()->path(), 'api')) {
                //     return response()->json(['error' => 'Email / Password is incorrect!'], 401);
                // } else {
                //     return redirect()->route('login')->with('error', 'Email / Password is incorrect!');
                // }
            }
        }
    }

    public function authenticateToken(Request $request){
        $validators = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validators->fails()) {
            return response()->json(['error' => 'Please fill the form.'], 400);
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $token = $request->user()->createToken('MyApp')->accessToken;
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['error' => 'Email / Password is incorrect!'], 401);
            }
        }
    }

    /**
     * make the user able to logout
     *
     * @return
     */
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('message','Successfully Logged out !');
    }

    /**
     * Authentication log
     *
     * @return
     */
    private function logAudit($user, $type, $description)
    {
        try {
            $data = [
                'created_at' => now()->timezone('Asia/Kuala_Lumpur'),
                'user_id' => $user,
                'type' => $type,
                'description' => $description,
            ];

            DB::table('auth_log')->insert($data);
        } catch (\Exception $e) {
            Log::error('Error logging audit: ' . $e->getMessage());
            throw $e;
        }
    }
}
