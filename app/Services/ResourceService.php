<?php

namespace App\Services;
use Illuminate\Support\Facades\App;
use App\Resource;
use App\Services\TagService;

class ResourceService
{
    public function getUserResources($user, $categoryId, $tags)
    {
        $resources = Resource::with('tags')
                        ->where('user_id', $user->id)
                        ->where('category_id', $categoryId)
                        ->latest();

        if(!empty($tags)){
            foreach($tags as $tagName){
                $resources->whereHas('tags', function($q) use ($tagName){
                    $q->where('name', $tagName);
                });
            }
        }

        return $resources->paginate(5)->appends('category', $categoryId);
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