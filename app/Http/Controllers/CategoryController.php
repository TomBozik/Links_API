<?php

namespace App\Http\Controllers;
use App\Services\CategoryService;
use App\Http\Resources\CategoryResource;

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
}
