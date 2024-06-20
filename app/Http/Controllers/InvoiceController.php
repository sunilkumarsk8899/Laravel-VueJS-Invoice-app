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

    public function show_invoice($id){
        $data = Invoice::with(['customer','invoice_items.product'])->find($id);
        return response()->json([
            'invoice' => $data,
            'id' => $id
        ],200);
    }

    public function edit_invoice($id){
        $data = Invoice::with(['customer','invoice_items.product'])->find($id);
        return response()->json([
            'invoice' => $data,
            'id' => $id
        ],200);
    }

    public function delete_invoice_item($id){
        $invoiceItem = InvoiceItem::findOrFail($id);
        $invoiceItem->delete();
        return response()->json([
            'invoice' => $invoiceItem,
            'id' => $id
        ],200);
    }

    public function update_invoice(Request $request,$id){

        $invoice = Invoice::where('id',$id)->first();

        $invoice->sub_total = $request->input('sub_total');
        $invoice->total = $request->input('total');
        $invoice->customer_id = $request->input('customer_id');
        $invoice->number = $request->input('numero');
        $invoice->date = $request->input('date');
        $invoice->due_date = $request->input('due_date');
        $invoice->discount = $request->input('discount');
        $invoice->reference = $request->input('reference');
        $invoice->terms_and_conditions = $request->input('terms_conditions');

        $invoice->update($request->all());

        $invoiceitem = $request->input('invoice_items');

        $invoice->invoice_items()->delete();

 // Assuming you get the JSON string from POST data
 $err = 'nothing error';
$invoiceitem = $_POST['invoice_items'] ?? null;

if ($invoiceitem) {
    $decodedItems = json_decode($invoiceitem);

    if (json_last_error() === JSON_ERROR_NONE && (is_array($decodedItems) || is_object($decodedItems))) {
        foreach ($decodedItems as $item) {
            if (is_object($item) && isset($item->product_id, $item->quantity, $item->unit_price)) {
                $itemdata['product_id'] = $item->product_id;
                $itemdata['invoice_id'] = $invoice->id;
                $itemdata['quantity'] = $item->quantity;
                $itemdata['unit_price'] = $item->unit_price;

                InvoiceItem::create($itemdata);
            } else {
                // Handle invalid item structure
                $err = "Invalid item structure: " . print_r($item, true);
            }
        }
    } else {
        // Handle JSON decoding error
        $err = "JSON decoding error: " . json_last_error_msg();
    }
} else {
    // Handle missing invoice_items
    $err = "Missing invoice_items in POST data";
}



        return response()->json([
            // 'data' => $request->all(),
            // 'invoice' => $invoice,
            // 'itemdata' => print_r($decodedItems),
            'err' => $err
        ]);
        die();


    }

}
