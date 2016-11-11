<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Carbon\Carbon;
use App\User;
use App\Card;
use App\Subscription;

class SubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
        $validate = $this->validator($request->all());

        if ($validate->fails()) {
        	return $this->jsonResponse(false, $validate->errors()->first(), [], 200);
        }

        $user = $request->user();
        $card_number = $request->card_number;

        if (Card::isValid($card_number)) {
            $card = Card::where('card_number', $card_number)->first();

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
        } else {
            return $this->jsonResponse(false, "Card invalid", [], 200);
        }

        // // switch topup type id
        // $topup_type_id = $request->topup_type;
        // switch ($topup_type_id) {
        // 	case 1:
        // 		# prepaid
        // 		$subscription = $this->prepaid($user, $card);
        // 		break;
        // 	case 2:
        // 		# code...
        // 		break;
        // 	case 3:
        // 		# code...
        // 		break;
        // 	case 4:
        // 		# code...
        // 		break;
        //
        // 	default:
        // 		# code...
        // 		break;
        // }

        if ($subscription) {
        	return $this->jsonResponse(true, "Subscription success", $subscription, 200);
        } else {
        	return $this->jsonResponse(false, "Can't subscription, Card number invalid", [], 200);
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'topup_type' => 'required',
            'card_number' => 'required|min:10|max:14',
        ]);
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
                // repeat normal
        		$card->package_id = 1;
        		$prepaid[] = $this->subscription($user, $card);
        		return $prepaid;
        		break;
        	case 3:
            return 3;
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
    	$data['status'] = 1;

        # check last subscription
    	$last_subscription = Subscription::where('user_id', $user->id)
    				->where('package_id', $card->package_id)
    				->where('status', 1)
    				->orderBy('id', 'desc')
    				->first();

    	# calculate started_at
    	if ($last_subscription) {
    		// last sub not expire
            if ($last_subscription->ended_at < Carbon::now()) {
            	// expire
            	// now
                $started_at = Carbon::now();
                $data['started_at'] = Carbon::now();

            } else {
                // not expire
                $started_at = new Carbon($last_subscription->ended_at);
                $data['started_at'] = new Carbon($last_subscription->ended_at);
            }
    	} else {
    		// new subscription
    		$started_at = Carbon::now();
            $data['started_at'] = Carbon::now();
    	}

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

            $subscription->started_at = $subscription->started_at->toDateTimeString();
            $subscription->ended_at = $subscription->ended_at->toDateTimeString();

            return $subscription;
        } else {
            return false;
        }
    }

    private function jsonResponse($success, $message, $data, $code)
    {
    	return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ], $code);
    }
}
