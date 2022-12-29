<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Attachments
Route::get('attachment/view/{id}', [InvoiceController::class,'viewAttachment'])->name('viewAttachment');
Route::get('attachment/download/{id}', [InvoiceController::class,'downloadAttachment'])->name('downloadAttachment');

Route::get('show-products/{id}', [InvoiceController::class,'showProducts']);
Route::resource('invoices',InvoiceController::class)
    ->parameters(['invoices' => 'model'])
    ->middleware(['auth']);

Route::resource('sections',SectionController::class)
    ->parameters(['sections' => 'model'])
    ->middleware(['auth']);

Route::resource('products',ProductController::class)
    ->parameters(['products' => 'model'])
    ->middleware(['auth']);

Route::controller(AdminController::class)
    ->group(function (){
        Route::get('/{page}', 'index');
    });

