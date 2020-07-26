<?php

namespace App\Services;
use Illuminate\Support\Facades\App;
use App\Resource;
use App\Services\TagService;

class ResourceService
{
    public function getUserResources($user, $categoryId)
    {
        return Resource::with('tags')->where('user_id', $user->id)->where('category_id', $categoryId)->get();
    }


    public function createResource($user, $data)
    {
        $resource = Resource::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'url' => $data['url'],
            'category_id' => $data['category_id'],
            'user_id' => $user->id,
        ]);

        $tags = collect([]);
        $tagService = new TagService();
        foreach($data['tags'] as $tagName){
            // TODO: bulk
            $tag = $tagService->createTag($user, $tagName);
            $tags->push($tag);
        }
        $resource->tags()->attach($tags->pluck('id'));

        return $resource;
    }



    public function updateResource($user, $resource, $data)
    {
        $resource->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'url' => $data['url'],
            'category_id' => $data['category_id'],
            'user_id' => $user->id,
        ]);


        $tags = collect([]);
        $tagService = new TagService();
        foreach($data['tags'] as $tagName){
            // TODO: bulk
            $tag = $tagService->createTag($user, $tagName);
            $tags->push($tag);
        }
        $resource->tags()->sync($tags->pluck('id'));
        return $resource;
    }


    public function deleteResource($resource)
    {
        $resource->tags()->detach();
        $resource->forceDelete();
    }
}