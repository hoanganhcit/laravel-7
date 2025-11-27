<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data['title'] = $request->title;
        $data['slug'] = Str::slug($request->title);
        $data['content'] = $request->content;

        $page = Page::create($data);

        return redirect()->route('admin.pages.create');
    }

    public function edit(Page $page)
    { 
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data['title'] = $request->title;
        $data['slug'] = Str::slug($request->title);
        $data['content'] = $request->content;

        Page::where('id', $page->id)->update($data);

        return redirect()->route('admin.pages.index');
    }

    public function show(Page $page)
    { 

        return view('admin.pages.show', compact('Page'));
    }

    public function destroy(Page $page)
    { 

        $page->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Page::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}