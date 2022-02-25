<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Category\Collection;
use App\Http\Resources\Category\Resource;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;

use App\Models\Category;


class CategoryController extends Controller
{
    public function index(): Collection
    {
        $categories = Category::all();
        return new Collection($categories);
    }

    public function store(StoreRequest $request): Resource
    {
        $data = $request->validated();
        return new Resource(Category::create($data));
    }

    public function update(UpdateRequest $request, Category $category): Resource
    {
        $data = $request->validated();
        $category->update($data);
        return new Resource($category);
    }

    public function show(Category $category): Resource
    {
        return new Resource($category);
    }

    public function delete(Category $category): Resource
    {
        $category->delete();
        return new Resource($category);
    }

}
