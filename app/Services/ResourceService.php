<?php

namespace App\Services;
use Illuminate\Support\Facades\App;
use App\Resource;
use App\Services\TagService;
use App\Services\CategoryService;
use Maatwebsite\Excel\Facades\Excel;

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

        return $resources->paginate(6)->appends('category', $categoryId);
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


    public function importResources($user, $file)
    {
        $resource_names = [];
        $urls = [];
        $descriptions = [];
        $categories = [];
        $tags = [];

        $h = fopen($file, "r");
        fgetcsv($h, 1000, ","); // headers
        while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
        {
            array_push($resource_names, $data[0]);
            array_push($urls, $data[1]);
            array_push($descriptions, $data[2]);
            array_push($categories, $data[3]);
            array_push($tags, $data[4]);
        }
        fclose($h);

        $categoryService = new CategoryService();
        $tagService = new TagService();

        // create categories for user
        foreach(array_unique($categories) as $categoryName){
            $categoryService->createOrFindUserCategory($user, $categoryName);
        }

        $userCategories = $categoryService->getUserCategories($user);

        foreach(range(0, sizeof($resource_names)-1) as $i){
            $data = [];
            $data['name'] = $resource_names[$i];
            $data['url'] = $urls[$i];
            $data['description'] = $descriptions[$i];
            $data['category_id'] = $userCategories->firstWhere('name', $categories[$i])->id;

            $tags[$i] = explode(",",$tags[$i]);
            $data['tags'] = array_map(function($tag){
                return str_replace(array("[","]",'"'), "", $tag);
            },$tags[$i]);

            $this->createResource($user, $data);
        }
    }
}