<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $userData = $request->all();

        $validate = $this->validator($request->all());

        // check $validate;
        if ($validate->fails()) {
            return $this->jsonResponse(false, $validate->errors()->first(), 200);
        }

        $credentials = $this->credentials($request);

        if ($login = $this->guard()->attempt($credentials, $request->has('remember'))) {
            // return $this->sendLoginResponse($request);

        	$user = User::where('username', $request->username)->first();
            $loginData['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $loginData['ipaddress'] = $_SERVER['REMOTE_ADDR'];

            // Check valid macaddress
            $mac_ethernet = strtolower($request->mac_ethernet);
            $mac_wifi = strtolower($request->mac_wifi);

            if ($mac_ethernet == "" || $mac_ethernet == "none") {
                $mac_ethernet = "sportlive";
            }

            if ($mac_wifi == "" || $mac_wifi == "none") {
                $mac_wifi = "sportlive";
            }

            if ( ((strtolower($user->mac_ethernet) == $mac_ethernet)
                || (strtolower($user->mac_wifi) == $mac_wifi)) ) {

                $user->remember_token = str_random(10);
            	$user->save();

                $loginData['status'] = 1;
            	$user->loginLogs()->create($loginData);

                return $this->jsonResponse(true, "Login success", $user->remember_token, 200);
            } else {
                $loginData['status'] = 2;
                $user->loginLogs()->create($loginData);
                return $this->jsonResponse(false, "Login failed macaddress invalid", "", 200);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->jsonResponse(false, "Login failed", "", 200);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|min:6|max:12',
            'password' => 'required|min:6',
            'mac_ethernet' => 'required',
            'mac_wifi' => 'required',
        ]);
    }

    private function jsonResponse($success, $message, $remember_token, $code)
    {
    	return response()->json([
	            "success" => $success,
	            "message" => $message,
                "remember_token" => $remember_token,
	        ], $code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
