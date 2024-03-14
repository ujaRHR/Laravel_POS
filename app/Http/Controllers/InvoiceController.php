<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class InvoiceController extends Controller
{
    public function invoicePage()
    {
        return view("pages.dashboard.invoice-page");
    }

    public function salePage()
    {
        return view("pages.dashboard.sale-page");
    }

    public function createInvoice(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id     = $request->header('id');
            $customer_id = $request->input('customer_id');
            $total       = $request->input('total');
            $discount    = $request->input('discount');
            $vat         = $request->input('vat');
            $payable     = $request->input('payable');

            $invoice = Invoice::create([
                'user_id'     => $user_id,
                'customer_id' => $customer_id,
                'total'       => $total,
                'discount'    => $discount,
                'vat'         => $vat,
                'payable'     => $payable
            ]);

            $invoiceID = $invoice->id;
            $products  = $request->input('products');

            foreach ($products as $product) {
                InvoiceProduct::create([
                    'invoice_id' => $invoiceID,
                    'user_id'    => $user_id,
                    'product_id' => $product['id'],
                    'qty'        => $product['qty'],
                    'sale_price' => $product['sale_price']
                ]);

                // Changing Products Unit
                $product_id  = $product['id'];
                $product_qty = $product['qty'];

                Product::where('user_id', $user_id)->where('id', $product_id)
                    ->decrement('unit', $product_qty);
            }

            DB::commit();
            return 1;

        } catch (Exception $e) {
            DB::rollback();
            return 0;
        }
    }

    public function selectInvoice(Request $request)
    {
        $user_id = $request->header('id');
        return Invoice::where('user_id', $user_id)->with('customer')->get();
    }

    public function invoiceDetails(Request $request)
    {
        $user_id          = $request->header('id');
        $invoice_id       = $request->input('invoice_id');
        $cus_info         = Customer::where('user_id', $user_id)->where('id', $request->input('cus_id'))->first();
        $invoice_info     = Invoice::where('user_id', $user_id)->where('id', $invoice_id)->first();
        $invoice_products = InvoiceProduct::where('user_id', $user_id)->where('invoice_id', $invoice_id)->with('product')->get();

        return array(
            'customer' => $cus_info,
            'invoice'  => $invoice_info,
            'products' => $invoice_products
        );
    }

    public function invoiceDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id    = $request->header('id');
            $invoice_id = $request->input('inv_id');
            InvoiceProduct::where('invoice_id', $invoice_id)->where('user_id', $user_id)->delete();
            Invoice::where('id', $invoice_id)->where('user_id', $user_id)->delete();
            DB::commit();
            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }
}