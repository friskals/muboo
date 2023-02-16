<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Http\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Http;

class MusicController extends Controller
{
    public function search(Request $request)
    {
        $api_key = config('services.youtube.api_key');

        $q = $request->input('q');

        $uri = "https://www.googleapis.com/youtube/v3/search?key={$api_key}&q={$q}&type=video&part=snippet";

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
}
