<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Product\Collection;
use App\Http\Resources\Product\Resource;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;

use App\Models\Product;

class ProductController extends Controller
{
    public function index(): Collection
    {
        $products = Product::all();
        return new Collection($products);
    }

    public function store(StoreRequest $request): Resource
    {
        $data = $request->validated();
        return new Resource(Product::create($data));
    }

    public function update(UpdateRequest $request, Product $product): Resource
    {
        $data = $request->validated();
        $product->update($data);
        return new Resource($product);
    }

    public function show(Product $product): Resource
    {
        return new Resource($product);
    }

    public function delete(Product $product): Resource
    {
        $product->delete();
        return new Resource($product);
    }

}
