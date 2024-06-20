<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/get_all_invoices',[InvoiceController::class,'get_all_invoices']);
Route::get('/get_all_invoices_by_search',[InvoiceController::class,'get_all_invoices_by_search']);
Route::get('/get_all_customer',[CustomerController::class,'get_all_customer']);
Route::get('/products',[ProductController::class,'all_products']);
Route::post('/add_invoice',[InvoiceController::class,'add_invoice']);
Route::get('/show_invoice/{id}',[InvoiceController::class,'show_invoice']);
Route::get('/edit_invoice/{id}',[InvoiceController::class,'edit_invoice']);
Route::get('/delete_invoice_item/{id}',[InvoiceController::class,'delete_invoice_item']);
Route::post('/update_invoice/{id}',[InvoiceController::class,'update_invoice']);
