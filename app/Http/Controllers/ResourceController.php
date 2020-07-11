<?php

namespace App\Http\Controllers;
use App\Services\ResourceService;
use App\Http\Resources\ResourceResource;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $authUser = $request->user();
        $categoryId = $request->query('category');

        $resourceService = new ResourceService();
        $resources = $resourceService->getUserResources($authUser, $categoryId);

        return ResourceResource::collection($resources);
    }

    public function store(Request $request)
    {
        $authUser = $request->user();

        $data = request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'url' => ['required', 'url'],
            'category_id' => ['required'],
            
        ]);

        $resourceService = new ResourceService();
        $resources = $resourceService->createResource($authUser, $data);

        return ResourceResource::collection($resources);
    }
}
