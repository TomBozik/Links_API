<?php

namespace App\Http\Controllers;
use App\Services\ResourceService;
use App\Http\Resources\ResourceResource;
use App\Resource;
use App\Exports\ResourceExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $authUser = $request->user();
        $categoryId = $request->query('category');
        $tags = $request->query('tags');
        $resourceService = new ResourceService();
        $resources = $resourceService->getUserResources($authUser, $categoryId, $tags);
        return ResourceResource::collection($resources);
    }


    public function store(Request $request)
    {
        $authUser = $request->user();
        $data = request()->validate([
            'name' => ['required'],
            'description' => [''],
            'url' => ['required', 'url'],
            'category_id' => ['required'],
            'tags' => ['required']
        ]);
        $resourceService = new ResourceService();
        $resource = $resourceService->createResource($authUser, $data);
        return new ResourceResource($resource);
    }


    public function update(Request $request, $id)
    {
        $authUser = $request->user();
        $resource = Resource::findOrFail($id);
        // TODO: check if user can update
        $data = request()->validate([
            'id' => ['required'],
            'name' => ['required'],
            'description' => [''],
            'url' => ['required', 'url'],
            'category_id' => ['required'],
            'tags' => ['required'],
        ]);
        $resourceService = new ResourceService();
        $updatedResource = $resourceService->updateResource($authUser, $resource, $data);
        return new ResourceResource($updatedResource);
    }

    public function destroy(Request $request, $id)
    {
        $authUser = $request->user();
        $resource = Resource::findOrFail($id);
        // TODO: check if user can delete
        $resourceService = new ResourceService();
        $resourceService->deleteResource($resource);
        return response()->json(null, 204);
    }

    public function export(request $request)
    {
        $authUser = $request->user();
        return Excel::download(new ResourceExport($authUser->id), 'links.csv');
    }

}
