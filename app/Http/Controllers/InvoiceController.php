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
        $invoice = $request->validated();

        if ($request->hasFile('image')) {

            if ($model->image && Storage::exists($model->image)) {
                Storage::delete($model->image);
            }

            $model->image = $request->file('image')->store('invoices');
        }

        $model->update([$invoice]);

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
