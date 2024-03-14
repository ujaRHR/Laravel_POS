<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;


class DashboardController extends Controller
{
    public function dashboardPage(Request $request)
    {
        return view('pages.dashboard.dashboard-page');
    }

    public function dashboardSummary(Request $request)
    {
        $user_id        = $request->header('id');
        $total_product  = Product::where('user_id', $user_id)->count();
        $total_category = Category::where('user_id', $user_id)->count();
        $total_customer = Customer::where('user_id', $user_id)->count();
        $total_invoice  = Invoice::where('user_id', $user_id)->count();
        $total_amount   = Invoice::where('user_id', $user_id)->sum('total');
        $total_vat      = Invoice::where('user_id', $user_id)->sum('vat');
        $total_payable  = Invoice::where('user_id', $user_id)->sum('payable');

        

        return response()->json([
            "total_product"  => $total_product,
            "total_category" => $total_category,
            "total_customer" => $total_customer,
            "total_invoice"  => $total_invoice,
            "total_amount"   => round($total_amount, 2),
            "total_vat"      => round($total_vat, 2),
            "total_payable"  => round($total_payable, 2)
        ]);
    }
}