<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function createproduct(Request $request)
    {
        $request->validate([

            'title' => 'required|string',
            'price' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            // 'quantity' => 'required|string',
            'rating' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'

        ]);

        $imagePaths = [];

        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path() . '/productImages/', $imageName);
            $imagePaths[] =  $imageName;
        }


        $imageName = '';
        if ($request->file('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '.' . $image->extension();
            // $image->move('uploads/category/', $imageName);
            $image->move(public_path() . '/productImages/', $imageName);
        }

        // Save images to database

        Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'category' => $request->category,
            // 'quantity' => $request->quantity,
            'rating' => $request->rating,
            'thumbnail' =>  $imageName,
            'images' => json_encode($imagePaths),
        ]);
        return response()->json([
            'message' => 'Product Added Successfully',
            "status" => true,
            // "path" => asset('uploads/' . $imageName)
        ], 201);
    }
    // public function getproduct()
    // {
    //     $product = Product::all();

    //     return response()->json([
    //         'message' => "Hello word",
    //         'status' => true,
    //         "product" => $product,

    //     ]);
    // }
    public function getproduct()
    {
        $product = Product::where('title', '!=', '');
        $product = $product->paginate(5);

        return response()->json([
            'message' => "Hello word",
            'status' => true,
            "product" => $product,

        ]);
    }
    public function singleProduct($singleproduct)
    {
        $product = Product::where('id', $singleproduct)->first();

        return response()->json([
            'message' => "Single Product Fetched",
            'status' => true,
            "product" => $product,

        ]);
    }
}
