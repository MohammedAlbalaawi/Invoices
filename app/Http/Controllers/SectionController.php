<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::get();
        return  view('dashboard.sections.index',compact('sections'));
    }


    public function store(SectionRequest $request)
    {

        Section::create($request->all());

        return redirect()
            ->route('sections.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    public function edit(Section $model){
        return view('dashboard.sections.edit', compact('model'));
    }

    public function update(SectionRequest $request, Section $model)
    {

        $model->update($request->all());

        return redirect()
            ->route('sections.index')
            ->with('success', 'تم تعديل القسم بنجاح');
    }

    public function destroy(Section $model)
    {
        $model->delete();

        return redirect()
            ->route('sections.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }
}
