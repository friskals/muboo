<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Content\DestroyRequest;
use App\Http\Requests\Api\Content\StoreRequest;
use App\Http\Requests\Api\Content\UpdateRequest;
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
            'content_id' => $content->id
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $request = $request->validated();
        $user =  Auth::user();

        $content = Content::where([
            'id' => $request['content_id'],
            'user_id' => Auth::user()->id
        ])->first();

        $content->update(['content' => $request['content']]);

        return response()->json(['success' => true]);
    }

    public function destroy(DestroyRequest $request)
    {
        Content::where([
            'id' => $request->content_id,
            'user_id' => Auth::user()->id
        ])->delete();

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $content =  Content::findOrFail($id);
        return response()->json([
            'success' => 'true',
            'data' => $content
        ]);
    }
}
