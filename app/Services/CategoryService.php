<?php

namespace App\Services;
use Illuminate\Support\Facades\App;
use App\Category;

class CategoryService
{
    public function getUserCategories($user)
    {
        return Category::where('user_id', $user->id)->get();
    }

    public function createCategory($user, $categoryName)
    {
        $userCategories = $this->getUserCategories($user);
        $categoriesNames = $userCategories->pluck('name')->toArray();

        if(!in_array($categoryName, $categoriesNames)){
            $category = Category::create([
                'name' => $categoryName,
                'user_id' => $user->id
            ]);
            return $this->getUserCategories($user);
        } else{
            abort(response()->json(['error' => 'Category already exists.'], 402));
        }

    }
}