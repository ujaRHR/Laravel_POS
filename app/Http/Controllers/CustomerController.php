<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function customerPage()
    {
        return view('pages.dashboard.customer-page');
    }

    public function customerList(Request $request)
    {
        $user_id = $request->header('id');
        return Customer::where('user_id', '=', $user_id)
            ->get();
    }

    public function createCustomer(Request $request)
    {
        $user_id = $request->header('id');
        Customer::create([
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'mobile'  => $request->input('mobile'),
            'user_id' => $user_id

        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'customer created successfully'
        ], 201);
    }

    public function deleteCustomer(Request $request)
    {
        $user_id     = $request->header('id');
        $customer_id = $request->input('id');
        Customer::where('user_id', '=', $user_id)
            ->where('id', '=', $customer_id)
            ->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'customer deleted successfully'
        ], 200);
    }

    public function updateCustomer(Request $request)
    {
        $user_id     = $request->header('id');
        $customer_id = $request->input('id');
        Customer::where('user_id', '=', $user_id)
            ->where('id', '=', $customer_id)
            ->update([
                'name'   => $request->input('name'),
                'email'  => $request->input('email'),
                'mobile' => $request->input('mobile')
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'customer updated successfully'
        ], 200);
    }

    public function customerById(Request $request)
    {
        $user_id     = $request->header('id');
        $customer_id = $request->input('id');

        return Customer::where('user_id', '=', $user_id)
            ->where('id', '=', $customer_id)
            ->first();
    }
}
