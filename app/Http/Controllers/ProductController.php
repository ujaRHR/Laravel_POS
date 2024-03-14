<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function productPage()
    {
        return view('pages.dashboard.product-page');
    }

    public function productList(Request $request)
    {
        $user_id = $request->header('id');
        return Product::where('user_id', '=', $user_id)->with('category')
            ->get();
    }

    public function createProduct(Request $request)
    {
        $user_id     = $request->header('id');
        $category_id = $request->input('category_id');
        $name        = $request->input('name');
        $price       = $request->input('price');
        $unit        = $request->input('unit');

        // Set File Name and Upload
        $img       = $request->file('img');
        $time      = time();
        $file_name = $img->getClientOriginalName();
        $img_name  = "{$user_id}-{$time}-{$file_name}";
        $img_url   = "uploads/{$img_name}";

        $img->move(public_path('uploads'), $img_name);

        Product::create([
            'user_id'     => $user_id,
            'category_id' => $category_id,
            'name'        => $name,
            'price'       => $price,
            'unit'        => $unit,
            'img_url'     => $img_url
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'product created successfully'
        ], 201);
    }

    public function deleteProduct(Request $request)
    {
        $user_id    = $request->header('id');
        $product_id = $request->input('id');
        $file_path  = $request->input('file_path');

        Product::where('user_id', '=', $user_id)
            ->where('id', '=', $product_id)
            ->delete();

        // Delete the file
        File::delete(public_path($file_path));

        return response()->json([
            'status'  => 'success',
            'message' => 'product deleted successfully'
        ], 200);
    }

    public function productById(Request $request)
    {
        $user_id    = $request->header('id');
        $product_id = $request->input('id');

        return Product::where('user_id', '=', $user_id)
            ->where('id', '=', $product_id)
            ->first();
    }

    public function updateProduct(Request $request)
    {
        $user_id     = $request->header('id');
        $category_id = $request->input('category_id');
        $product_id  = $request->input('id');
        $name        = $request->input('name');
        $price       = $request->input('price');
        $unit        = $request->input('unit');
        $file_path   = $request->input('file_path');

        if ($request->hasFile('img')) {
            $img       = $request->file('img');
            $time      = time();
            $file_name = $img->getClientOriginalName();
            $img_name  = "{$user_id}-{$time}-{$file_name}";
            $img_url   = "uploads/{$img_name}";

            $img->move(public_path('uploads'), $img_name);

            File::delete($file_path);

            Product::where('id', '=', $product_id)
                ->where('user_id', '=', $user_id)
                ->update([
                    'name'        => $name,
                    'price'       => $price,
                    'unit'        => $unit,
                    'category_id' => $category_id,
                    'img_url'     => $img_url
                ]);
        } else {
            Product::where('id', '=', $product_id)
                ->where('user_id', '=', $user_id)
                ->update([
                    'name'        => $name,
                    'price'       => $price,
                    'unit'        => $unit,
                    'category_id' => $category_id
                ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'product deleted successfully'
        ], 200);
    }
}
