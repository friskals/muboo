<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontsite\AddMusicRequest;
use App\Http\Requests\Frontsite\Music\GetListRequest;
use App\Http\Utils\ApiResponse;
use App\Models\BookMusic;
use App\Models\MusicFan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MusicController extends Controller
{
    public function search(Request $request)
    {
        $api_key = config('services.youtube.api_key');

        $q = $request->input('q');

        $uri = "https://youtube.googleapis.com/youtube/v3/search?key={$api_key}&q={$q}&type=video&part=snippet";

        $response = Http::get($uri);

        if ($response->clientError() || $response->serverError()) {
            return ApiResponse::format([], $response->status(), [
                'message' => 'something went wrong',
                'success' => false
            ]);
        }

        $result = $response->json();

        $videos = [];

        foreach ($result['items'] as $item) {
            $video = [];
            $video['id'] = $item['id']['videoId'];
            $video['title'] = $item['snippet']['title'];
            $video['thumbnail'] = $item['snippet']['thumbnails']['default']['url'];
            $video['channel_name'] = $item['snippet']['channelTitle'];
            array_push($videos, $video);
        }

        return ApiResponse::format($videos, 200, ['success' => true]);
    }

    public function addMusic(AddMusicRequest $request)
    {
        $request = $request->validated();
        $dispayed = true;

        $addedMusic = BookMusic::where(['book_id' => $request['book_id'], 'external_music_id' => $request['external_music_id']])->first();

        if ($addedMusic) {
            $addedMusic->increment('fans');
            $addedMusic->refresh();
            $dispayed = false;
        } else {
            $request['fans'] = 1;
            $addedMusic =  BookMusic::create($request);
        }

        MusicFan::create([
            'music_id' => $addedMusic->id,
            'user_id' => Auth::user()->id
        ]);

        return ApiResponse::format([
            'music_id' => $addedMusic->id,
            'displayed' => $dispayed
        ],  200, ['success' => true]);
    }

    public function show($id)
    {
        $music = BookMusic::findOrFail($id);

        return ApiResponse::format([$music], 200, ['success' => true]);
    }

    public function getMusicList($bookId, GetListRequest $request){
        $music = BookMusic::where('book_id', $bookId)->limit($request->limit)->get();

        return ApiResponse::format($music->toArray(), 200, ['success' => true]);
    }
}
