<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsTestimonial;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestimonialsController extends Controller
{

    public function index()
    {
        $testimonials = CmsTestimonial::get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());die;
        $testimonial = CmsTestimonial::create($request->all());

        return redirect()->route('admin.testimonials.create');
    }

    public function edit(CmsTestimonial $testimonial)
    {  
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, CmsTestimonial $testimonial)
    {

        $testimonial->update($request->all());
        
        return redirect()->route('admin.testimonials.index');
    }

    public function show(Testimonial $testimonial)
    {

        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function destroy(Testimonial $testimonial)
    {

        $testimonial->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        CmsTestimonial::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    } 
}