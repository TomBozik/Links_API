<?php

namespace App\Services;
use Illuminate\Support\Facades\App;
use App\Resource;

class ResourceService
{
    public function getUserResources($user, $categoryId)
    {
        return Resource::where('user_id', $user->id)->where('category_id', $categoryId)->get();
    }


    public function createResource($user, $data)
    {
        $resource = Resource::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'url' => $data['url'],
            'category_id' => $data['category_id'],
            'user_id' => $user->id
        ]);
        return $resource;
    }


    public function updateResource($resource, $data)
    {
        return tap($resource)->update($data);
    }


    public function deleteResource($resource)
    {
        $resource->delete();
    }
}