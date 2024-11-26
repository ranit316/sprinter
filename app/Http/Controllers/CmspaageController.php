<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cms_pages;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FaqCategoryExport;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
class CmspaageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shows = Cms_pages::get();
        return view('cms_page.index',compact('shows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('cms_page.insert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
    
        $page = Cms_pages::create(['title' => $request->input('name'),'description' => $request->input('description') ]);
    
        if($page->save())
        {
        return redirect()->route('cms_pages.index') ->with('success','Page Links created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $page = Cms_pages::where('id', $id)->first();
        //dd($page);
        return view('cms_page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $pages = Cms_pages::find($id);

        $pages->title = $request->input('name');
        $pages->description = $request->input('description');
        $pages->save();
        return redirect()->route('cms_pages.index')->with('success', 'Page Links updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //return($id);
        //dd($id);
        $page = Cms_pages::where('id', $id)->first();
        $page->delete();

        return redirect()->route('cms_pages.index')->with('success', 'Page Links deleted successfully');
    }
}
