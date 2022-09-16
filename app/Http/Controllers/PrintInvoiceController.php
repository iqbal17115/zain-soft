<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintInvoiceController extends Controller
{
    public function payment_invoice()
    {
        return view('print-invoice.payment-invoice');
    }
}
