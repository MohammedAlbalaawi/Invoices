<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::get();
        return view('dashboard.invoices.index', compact('invoices'));
    }

    public function showProducts($id)
    {
        $products = Product::where('section_id', $id)->pluck('name', 'id');
        return json_decode($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::get();
        return view('dashboard.invoices.create', compact('sections'));
    }

    public function store(InvoiceRequest $request)
    {
        $invoice = $request->validated();
        $invoice['image'] = $request->file('image')->store('invoices');

        Invoice::create($invoice);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'تم إضافة الفاتورة بنجاح');
    }

    public function edit(Invoice $model)
    {
        $sections = Section::get();
        $products = Product::where('section_id', $model->section_id)->get();
        return view('dashboard.invoices.edit', compact('model', 'sections', 'products'));
    }

    public function update(InvoiceRequest $request, Invoice $model)
    {


        if ($request->hasFile('image')) {

            if ($model->image && Storage::exists($model->image)) {
                Storage::delete($model->image);
            }

            $model->image = $request->file('image')->store('invoices');
        }

        $model->update([
            'section_id' => $request->section_id,
            'product_id' => $request->product_id,
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->due_date,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'note' => $request->note,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'تم تعديل الفاتورة بنجاح');
    }

    public function destroy(Invoice $model)
    {
        if ($model->image && Storage::exists($model->image)) {
            Storage::delete($model->image);
        }

        $model->delete();
        return redirect()
            ->route('invoices.index')
            ->with('success', 'invoice deleted successfully');
    }
}
