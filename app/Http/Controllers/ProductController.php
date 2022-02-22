<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

use App\Models\Product;

class ProductController extends Controller
{
    public function index(): ProductCollection
    {
        $products = Product::all();
        return new ProductCollection($products);
    }

    public function store(ProductStoreRequest $request): ProductResource
    {
        $data = $request->validated();
        return new ProductResource(Product::create($data));
    }

    public function update(ProductUpdateRequest $request, Product $product): ProductResource
    {
        $data = $request->validated();
        $product->update($data);
        return new ProductResource($product);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function delete(Product $product): ProductResource
    {
        $product->delete();
        return new ProductResource($product);
    }

}
