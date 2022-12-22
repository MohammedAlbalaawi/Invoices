<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::resource('invoices',InvoiceController::class)
    ->parameters(['invoices' => 'model']);

Route::resource('sections',SectionController::class)
    ->parameters(['sections' => 'model']);

Route::controller(AdminController::class)
    ->group(function (){
        Route::get('/{page}', 'index');
});

