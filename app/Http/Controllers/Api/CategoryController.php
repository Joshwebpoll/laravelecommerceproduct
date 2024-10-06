<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            "name" => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = '';
        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            // $image->move('uploads/category/', $imageName);
            $image->move(public_path() . '/uploads/', $imageName);
        } else {
            return  response()->json([
                'message' => 'Image uploaded failed',
                'status' => false,
            ]);
        }

        Category::create([
            "name" => $request->name,
            'image' => $imageName
        ]);
        // $imagePaths = [];

        // foreach ($request->file('image') as $image) {
        //     $imageName = time() . '_' . $image->getClientOriginalName();
        //     $image->move(public_path() . '/uploads/', $imageName);
        //     $imagePaths[] =  $imageName;
        // }

        // Save images to database
        // Category::create([
        //     'name' => $request->name,
        //     'image' => json_encode($imagePaths),
        // ]);

        // return response()->json([
        //     'message' => 'Images uploaded successfully',
        //     "path" => asset('uploads/' . $imageName)
        // ], 201);









        return  response()->json([
            'message' => 'Image uploaded successfully',
            'status' => true,
        ]);
    }
    public function getcategory()
    {
        $category = Category::all();
        return  response()->json([
            'message' => 'Image uploaded successfully',
            'status' => true,
            "category" => $category
        ]);
    }
}
