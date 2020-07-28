<?php

namespace App\Services;
use Illuminate\Support\Facades\App;
use App\Category;

class CategoryService
{
    public function getUserCategories($user)
    {
        return Category::where('user_id', $user->id)->orderBy('name', 'ASC')->get();
    }

    
    // For API
    public function createCategory($user, $categoryName)
    {
        $category = Category::where('user_id', $user->id)->where('name', $categoryName)->get();

        if (count($category) > 0){
            abort(response()->json(['error' => 'Category already exists.'], 402));
        }
        
        Category::create([
            'name' => $categoryName,
            'user_id' => $user->id
        ]);
        return $this->getUserCategories($user);
    }


    // For ResourceService
    public function createOrFindUserCategory($user, $categoryName){
        return Category::firstOrCreate(
            ['user_id' => $user->id, 'name' => $categoryName],
            ['user_id' => $user->id, 'name' => $categoryName]
        );
    }


    public function deleteCategory($category)
    {
        $category->resources()->forceDelete();
        $category->forceDelete();
    }
}