<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    function categoryPage()
    {
        return view("pages.dashboard.category-page");
    }

    function categoryList(Request $request)
    {
        $user_id = $request->header('id');
        return Category::where('user_id', '=', $user_id)->get();
    }

    function categoryCreate(Request $request)
    {
        $user_id = $request->header('id');
        Category::create([
            'name'    => $request->input('name'),
            'user_id' => $user_id
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'category created successfully'
        ], 200);
    }

    function categoryDelete(Request $request)
    {
        $user_id     = $request->header('id');
        $category_id = $request->input('id');
        Category::where('user_id', '=', $user_id)
            ->where('id', '=', $category_id)
            ->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'category deleted successfully'
        ], 200);
    }

    function categoryUpdate(Request $request)
    {
        $user_id     = $request->header('id');
        $category_id = $request->input('id');
        Category::where('user_id', '=', $user_id)
            ->where('id', '=', $category_id)
            ->update([
                'name' => $request->input('name')
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'category updated successfully'
        ], 200);
    }

    function categoryById(Request $request)
    {
        $user_id     = $request->header('id');
        $category_id = $request->input('id');

        return Category::where('user_id', '=', $user_id)
            ->where('id', '=', $category_id)
            ->first();
    }
}
