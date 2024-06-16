<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
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

    public function add_invoice(Request $request){
        $invoiceItem = $request->input('invoice_item');

        $invoiceData['sub_total'] = $request->input('sub_total');
        $invoiceData['total'] = $request->input('total');
        $invoiceData['customer_id'] = $request->input('customer_id');
        $invoiceData['number'] = "INV-".$request->input('numero');
        $invoiceData['date'] = $request->input('date');
        $invoiceData['due_date'] = $request->input('due_date');
        $invoiceData['discount'] = $request->input('discount');
        $invoiceData['reference'] = $request->input('reference');
        $invoiceData['terms_and_conditions'] = $request->input('terms_conditions');

        $invoice = Invoice::create($invoiceData);

        foreach(json_decode($invoiceItem) as $item){
            $itemdata['product_id'] = $item->id;
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemdata);
        }
    }
}
