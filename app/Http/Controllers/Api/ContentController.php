<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Content\StoreRequest;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function store(StoreRequest $request)
    {
        $request = $request->validated();
        $request['user_id'] = Auth::user()->id;
        $content = Content::create($request);

        return response()->json([
            'success' => true,
            'content_id' => $content
        ]);
    }
}
