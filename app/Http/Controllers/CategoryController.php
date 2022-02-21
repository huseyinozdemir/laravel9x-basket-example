<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

use App\Models\Category;


class CategoryController extends Controller
{
    public function index(): CategoryCollection
    {
        $categories = Category::all();
        return new CategoryCollection($categories);
    }

    public function store(CategoryStoreRequest $request): CategoryResource
    {
        $data = $request->validated();
        return new CategoryResource(Category::create($data));
    }

    public function update(CategoryUpdateRequest $request, Category $category): CategoryResource
    {
        $data = $request->validated();
        $category->update($data);
        return new CategoryResource($category);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function delete(Category $category): CategoryResource
    {
        $category->delete();
        return new CategoryResource($category);
    }

}
