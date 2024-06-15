<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function get_all_invoices(){
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();
        return response()->json([
            'invoices' => $invoices
        ],200);
    }

    public function get_all_invoices_by_search(Request $request){
        $val = $request->get('s');
        $invoices = Invoice::with('customer')->where('id','LIKE','%'.$val.'%')->get();
        return response()->json([
            'invoices' => $invoices
        ],200);
    }
}
