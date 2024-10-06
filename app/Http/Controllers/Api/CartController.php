<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function createCart(Request $request)
    {
        // $request->validate([
        //     "productid" => 'required|string',
        //     "quantity" => 'required|string'

        // ]);


        if (auth('sanctum')->user()->id) {

            $productid = $request->productid;
            $quantity = $request->quantity;
            $userid = auth('sanctum')->user()->id;

            $productcheck = Product::where("id", $productid)->first();

            if ($productcheck) {
                if (Cart::where("productid", $productid)->where('userid', $userid)->exists()) {
                    return  response()->json([
                        'message' => 'Product Already exist',
                        'status' => 201,
                    ], 201);
                } else {

                    Cart::create([
                        "userid" => $userid,
                        'productid' => $productid,
                        "quantity" => $quantity
                    ]);
                    return  response()->json([
                        'message' => 'Product Added Succesfully',
                        'status' => 200,
                    ]);
                }
            } else {
                return  response()->json([
                    'message' => 'Product Not Found',
                    'status' => false,
                ]);
            }
        } else {
            return  response()->json([
                'message' => 'login to Continue ',
                'status' => false,
            ]);
        }
    }

    public function getCart()
    {

        $product = Cart::where('userid', auth('sanctum')->user()->id)->get();
        return  response()->json([
            'message' => 'success ',
            'status' => true,
            "cart" => $product
        ]);
    }

    public function updateCart($cartid, $scope)
    {
        $cartupdate = Cart::where('id', $cartid)->where('userid', auth('sanctum')->user()->id)->first();

        if ($scope == 'increase') {
            $cartupdate->quantity += 1;
        }
        if ($scope == 'decrease') {
            $cartupdate->quantity -= 1;
        }
        $cartupdate->update();
        return  response()->json([
            'message' => 'Updated successfully ',
            'status' => true,
        ]);
    }

    public function deleteCart($deleteid)
    {
        $cartupdate = Cart::where('id', $deleteid)->where('userid', auth('sanctum')->user()->id)->first();
        if ($cartupdate) {
            $cartupdate->delete();
            return  response()->json([
                'message' => 'Deleted Successfuly successfully ',
                'status' => true,
            ]);
        } else {
            return  response()->json([
                'message' => 'Something went Wrong ',
                'status' => true,
            ]);
        }
    }
}
