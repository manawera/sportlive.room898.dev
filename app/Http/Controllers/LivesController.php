<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Subscription;
use App\Live;
use App\TvGenre;
use App\Protect;

class LivesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show($genre_id)
    {
        $lives = TvGenre::findOrFail($genre_id)
            ->lives()
            ->where('active', 1)
            ->get();

    	$counts = $lives->count();

		if ($lives && $counts > 0) {
	        return response()->json([
	            'success' => true,
	            'count' => $counts,
	            'data' => $lives->makeHidden(['channel_number', 'sort', 'tv_genre_id', 'stream_url', 'protect_id', 'active', 'created_at', 'updated_at']),
	        ], 200);
		} else {
	        return response()->json([
	            'success' => false,
	            'count' => $counts,
	            'data' => [],
	        ], 200);
		}
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
    public function showStreamUrl(Request $request, $id)
    {
        $user = $request->user();
        $package_id = 1;

        // check subscription expire
        if (!Subscription::isSubscription($user->id, $package_id)) {
            return response()->json([
                "success" => false,
                "data" => [],
            ], 200);
        }

        $live = Live::findOrFail($id);

        if ($live) {
            $live->stream_url = Protect::protectUrl($live->stream_url, $live->protect_id, $user->username);

            return response()->json([
                'success' => true,
                'data' => $live->makeHidden(['channel_number', 'sort', 'tv_genre_id', 'protect_id', 'active', 'created_at', 'updated_at']),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
            ], 200);
        }
    }
}
