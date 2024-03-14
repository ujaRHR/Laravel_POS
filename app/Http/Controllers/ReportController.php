<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Barryvdh\DomPDF\PDF;


class ReportController extends Controller
{
    public function reportPage()
    {
        return view('pages.dashboard.report-page');
    }

    public function salesReport(Request $request, $fromDate, $toDate)
    {
        $user_id   = $request->header('id');
        $startDate = date('Y-m-d', strtotime($fromDate));
        $endDate   = date('Y-m-d', strtotime($toDate));

        $total    = Invoice::where('user_id', $user_id)->whereBetween('created_at', [$startDate, $endDate])->sum('total');
        $discount = Invoice::where('user_id', $user_id)->whereBetween('created_at', [$startDate, $endDate])->sum('discount');
        $vat      = Invoice::where('user_id', $user_id)->whereBetween('created_at', [$startDate, $endDate])->sum('vat');
        $payable  = Invoice::where('user_id', $user_id)->whereBetween('created_at', [$startDate, $endDate])->sum('payable');

        $list = Invoice::where('user_id', $user_id)->whereBetween('created_at', [$startDate, $endDate])->with('customer')->get();

        $data = [
            'total'    => $total,
            'discount' => $discount,
            'vat'      => $vat,
            'payable'  => $payable,
            'fromDate' => $request->fromDate,
            'toDate'   => $request->toDate,
            'list'     => $list
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('report.SalesReport', $data);

        return $pdf->download('invoice.pdf');
    }
}
