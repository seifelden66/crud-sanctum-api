<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(
            Product::where('user_id', Auth::user()->id)->get()
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'slug'=>'required',
            'price'=>'required'
        ]);

        $product =  Product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'user_id' => Auth::user()->id,
        ]);
        return new ProductResource ($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->isNotAuthorized($product) ? $this->isNotAuthorized($product) : new ProductResource($product);    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        return $product->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Product::destroy($id);
    }
    //search
    public function search(string $name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }
}
