<?php

namespace App\Http\Controllers;
use App\Services\TagService;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $authUser = $request->user();
        $tagService = new TagService();
        $tags = $tagService->getUserTags($authUser);
        return TagResource::collection($tags);
    }
}
