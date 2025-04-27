<?php

namespace App\Http\Controllers\Notice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notice\NoticeStoreRequest;
use App\Http\Requests\Notice\NoticeUpdateRequest;
use App\Http\Requests\Topic\TopicStoreRequest;
use App\Http\Requests\Topic\TopicUpdateRequest;
use App\Http\Resources\Notice\NoticeResource;
use App\Http\Resources\Topic\TopicResource;
use App\Models\Editor;
use App\Models\Notice;
use App\Models\Topic;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();

        return response()->json(NoticeResource::collection($notices), 200);
    }

    public function store(NoticeStoreRequest $request)
    {
        $notice = Notice::create(
            [
                'topic_id' => $request->topicId,
                'content' => $request->content,
            ]
        );

        return response()->json(NoticeResource::make($notice), 201);
    }

    public function update(NoticeUpdateRequest $request, Notice $notice)
    {
        $notice->update([
            'topic_id' => $request->topicId,
            'content' => $request->content,
        ]);
        $notice->refresh();

        return response()->json(NoticeResource::make($notice), 200);
    }

    public function show(Notice $notice)
    {
        return response()->json(NoticeResource::make($notice), 200);
    }

    public function destroy(Notice $notice) {
        $notice->delete();

        return response()->json(null, 204);
    }
}
