<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Subscription;
use App\Title;
use App\Protect;
use DB;
use Illuminate\Support\Collection;

class TitlesController extends Controller
{
    protected $rows = 100;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show($kind_id, $genre_id)
    {
    	if ($genre_id > 0) {
            $titles = Title::where('kind_id', $kind_id)
                    ->where('genre_id', $genre_id)
                    ->where('active', 1)
                    ->orderBy('id', 'desc')
                    ->take($this->rows)
                    ->get();
    	} else {
            $titles = Title::where('kind_id', $kind_id)
                    ->where('active', 1)
                    ->orderBy('id', 'desc')
                    ->take($this->rows)
                    ->get();
    	}

    	if ($titles) {
            $titles = $titles->makeHidden(['kind_id', 'genre_id', 'episode_of_id', 'season', 'episode',
                'series_started_year', 'series_ended_year', 'stream_url', 'stream_url_en', 'protect_id',
                'active', 'created_at', 'updated_at']);
    		$count = $titles->count();
    		return $this->jsonResponse(true,
                    $count,
                    $titles,
                    200);
    	} else {
    		return $this->jsonResponse(false, 0, [], 404);
    	}
    }

    public function showBeforeId($kind_id, $genre_id, $id)
    {
        if ($genre_id > 0) {
            $titles = Title::where('kind_id', $kind_id)
                    ->where('genre_id', $genre_id)
                    ->where('id', '<', $id)
                    ->where('active', 1)
                    ->orderBy('id', 'desc')
                    ->take($this->rows)
                    ->get();
    	} else {
            $titles = Title::where('kind_id', $kind_id)
                    ->where('id', '<', $id)
                    ->where('active', 1)
                    ->orderBy('id', 'desc')
                    ->take($this->rows)
                    ->get();
    	}

        if ($titles) {
            $titles = $titles->makeHidden(['kind_id', 'genre_id', 'episode_of_id', 'season', 'episode',
                'series_started_year', 'series_ended_year', 'stream_url', 'stream_url_en', 'protect_id',
                'active', 'created_at', 'updated_at']);
            $count = $titles->count();
            return $this->jsonResponse(true,
                    $count,
                    $titles,
                    200);
        } else {
            return $this->jsonResponse(false, 0, [], 404);
        }
    }

    public function showAfterId($kind_id, $genre_id, $id)
    {
        if ($genre_id > 0) {
            $titles = Title::where('kind_id', $kind_id)
                    ->where('genre_id', $genre_id)
                    ->where('id', '>', $id)
                    ->where('active', 1)
                    ->take($this->rows)
                    ->get();
    	} else {
            $titles = Title::where('kind_id', $kind_id)
                    ->where('id', '>', $id)
                    ->where('active', 1)
                    ->take($this->rows)
                    ->get();
    	}

        if ($titles) {
            $titles = $titles->makeHidden(['kind_id', 'genre_id', 'episode_of_id', 'season', 'episode',
                'series_started_year', 'series_ended_year', 'stream_url', 'stream_url_en', 'protect_id',
                'active', 'created_at', 'updated_at']);
            $collection = collect($titles);
    		$titles = $collection->sortByDesc('id');
            $count = $titles->count();
            return $this->jsonResponse(true,
                    $count,
                    $titles->values()->all(),
                    200);
        } else {
            return $this->jsonResponse(false, 0, [], 404);
        }
    }

    public function episodeList(Request $request, $title)
    {
    	$episodes = Title::where('episode_of_id', $title)
    			->where('active', 1)
    			->orderBy('episode')
    			->get();

        $count = $episodes->count();

		if ($count > 0) {
	        return response()->json([
	            'success' => true,
	            'count' => $counts,
	            'data' => $episodes,
	        ], 200);
		} else {
	        return response()->json([
	            'success' => false,
	            'count' => 0,
	            'data' => [],
	        ], 200);
		}
    }

    public function search($title, $kind_id)
    {
        $titles = Title::where('name', 'like', '%'.$title.'%')
                ->where('kind_id', $kind_id)
                ->where('active', 1)
                ->orWhere('name_local', 'like', '%'.$title.'%')
                ->where('kind_id', $kind_id)
                ->where('active', 1)
                ->orderBy('name', 'asc')
                ->take($this->rows)
                ->get();

        if ($titles) {
            $titles = $titles->makeHidden(['kind_id', 'genre_id', 'episode_of_id', 'season', 'episode',
                'series_started_year', 'series_ended_year', 'stream_url', 'stream_url_en', 'protect_id',
                'active', 'created_at', 'updated_at']);
    		$count = $titles->count();
    		return $this->jsonResponse(true,
                    $count,
                    $titles,
                    200);
    	} else {
    		return $this->jsonResponse(false, 0, [], 200);
    	}
    }

    private function jsonResponse($success, $count, $data, $code)
    {
    	return response()->json([
                'success' => $success,
                'count' => $count,
                'data' => $data,
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
    // public function show($id)
    // {
    //     //
    // }

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

    public function showStreamUrl(Request $request, $id, $language = 0)
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

        $title = Title::findOrFail($id);

        if ($title) {
            if ($language == 0) {
                if (!($title->stream_url == "" || $title->stream_url == null))
                    $title->stream_url = Protect::protectUrl($title->stream_url, $title->protect_id, $user->username);
            } elseif ($language == 1) {
                if (!($title->stream_url_en == "" || $title->stream_url_en == null))
                    $title->stream_url_en = Protect::protectUrl($title->stream_url_en, $title->protect_id, $user->username);
            }

            $title->makeHidden(['kind_id', 'genre_id', 'episode_of_id', 'season', 'episode',
                'series_started_year', 'series_ended_year', 'protect_id', 'active', 'created_at', 'updated_at']);
            return response()->json([
                'success' => true,
                'data' => $title,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
            ], 200);
        }
    }
}
