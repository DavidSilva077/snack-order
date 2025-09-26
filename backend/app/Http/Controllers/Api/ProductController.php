<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function index(Request $request) {
    $q = Product::query();
    if ($s = $request->get('search')) {
      $q->where('nome', 'ilike', "%{$s}%")
        ->orWhere('categoria', 'ilike', "%{$s}%");
    }
    return $q->orderBy('id','desc')->get();
  }

  public function store(ProductStoreRequest $request) {
    $product = Product::create($request->validated());
    return response()->json($product, 201);
  }

  public function show(Product $product) { return $product; }

  public function update(ProductUpdateRequest $request, Product $product) {
    $product->update($request->validated());
    return $product;
  }

  public function destroy(Product $product) {
    $product->delete();
    return response()->noContent();
  }
}
