<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Carbon\Carbon;
use App\User;
use App\Card;
use App\Subscription;
use DB;

class RegisterController extends Controller
{
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Register new account
        $userData = $request->all();

        // Validate use data
        $validate = $this->validator($userData);
        if ($validate->fails()) {
            return $this->jsonResponse(false, $validate->errors()->first(), 200);
        }

        if (User::isMacDuplicate($userData['mac_ethernet'], $userData['mac_wifi'])) {
            return $this->jsonResponse(false, "Mac Address has already been register", 200);
        }

        // check card
        if (Card::isValid($userData['card_number'])) {
            // create user
            $user = $this->createUser($userData);

            if ($user) {
                // get card data
                $card = Card::where('card_number', $userData['card_number'])->first();

                switch ($card->topup_type_id) {
                	case 1:
                		# prepaid card
                		$subscription = $this->prepaid($user, $card);
                		break;
                	case 2:
                		# memberships
                		break;
                	case 3:
                		# truemoney
                		break;
                	case 4:
                		# activate code
                		break;
                    case 5:
                		# trial code
                		break;
                	default:
                		# code...
                		break;
                }

                if ($subscription) {
                    return $this->jsonResponse(true, "Register and subscription success", 200);
                } else {
                    return $this->jsonResponse(true, "Register success, subscription failed", 200);
                }
            } else {
                return $this->jsonResponse(false, "Create account failed", 200);
            }

        } else {
            return $this->jsonResponse(false, "Card invalid", 200);
        }
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

    private function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|min:6|max:12|unique:users',
            'password' => 'required|min:6|confirmed',
            'card_number' => 'required|min:10|max:14',
            'mac_ethernet' => 'required',
            'mac_wifi' => 'required',
        ]);
    }

    private function createUser(array $data)
    {
        if ($data['mac_ethernet'] == "")
            $data['mac_ethernet'] = null;
        if ($data['mac_wifi'] == "")
            $data['mac_wifi'] = null;

        $user = User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'role_id' => 5,
            'mac_ethernet' => $data['mac_ethernet'],
            'mac_wifi' => $data['mac_wifi'],
            'active' => 1,
        ]);

        return $user;
    }

    private function prepaid($user, $card)
    {
        switch ($card->package_id) {
        	case 1:
        		// normal
        		$prepaid[] = $this->subscription($user, $card);
        		return $prepaid;
        		break;
        	case 2:
        		// vip
        		$prepaid[] = $this->subscription($user, $card);
                // normal
        		$card->package_id = 1;
        		$prepaid[] = $this->subscription($user, $card);
        		return $prepaid;
        		break;
        	case 3:
        		// trial
        		# code...
        		break;
        	default:
        		# code...
        		break;
        }
    }

    private function subscription($user, $card)
    {
    	$data['card_id'] = $card->id;
    	$data['package_id'] = $card->package_id;
        $data['started_at'] = Carbon::now();
        $started_at = Carbon::now();
    	$data['status'] = 1;

    	# Calculat ended_at
    	switch ($card->plan_id) {
    		case 1:
    			// yearly
    			$data['ended_at'] = $started_at->addYear($card->quantity);
                // $data['plan'] = $card->quantity . " years";
    			break;
    		case 2:
    			// monthly
    			$data['ended_at'] = $started_at->addMonths($card->quantity);
                // $data['plan'] = $card->quantity . " months";
    			break;
    		case 3:
    			// daily
            	$data['ended_at'] = $started_at->addDays($card->quantity);
                // $data['plan'] = $card->quantity . " days";
    			break;
    		case 4:
    			// hourly
    			$data['ended_at'] = $started_at->addHours($card->quantity);
                // $data['plan'] = $card->quantity . " hours";
    			break;
    		case 5:
    			// fixed expired
    			$data['ended_at'] = new Carbon($card->expired);
                // $data['plan'] = "expire " . $card->expired;
                break;
    		default:
    			# code...
    			break;
    	}

    	$subscription = $user->subscriptions()->create($data);
        if ($subscription) {
        	$card->status = 1;
            $card->save();
            return $subscription;
        } else {
            return false;
        }
    }

    private function jsonResponse($success, $message, $code)
    {
    	return response()->json([
	            'success' => $success,
	            'message' => $message,
	        ], $code);
    }
}
