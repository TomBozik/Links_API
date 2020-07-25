<?php

namespace App\Http\Controllers;
use App\Services\CategoryService;
use App\Http\Resources\CategoryResource;
use App\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $authUser = $request->user();
        $categoryService = new CategoryService();
        $categories = $categoryService->getUserCategories($authUser);
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $authUser = $request->user();
        $data = request()->validate([
            'name' => ['required'],
        ]);
        $categoryService = new CategoryService();
        $categories = $categoryService->createCategory($authUser, $data['name']);
        return CategoryResource::collection($categories);
    }


    public function destroy(Request $request, $id)
    {
        $authUser = $request->user();
        $category = Category::findOrFail($id);
        // TODO: check if user can delete
        $categoryService = new CategoryService();
        $categoryService->deleteCategory($category);
        return response()->json(null, 204);
    }
}
