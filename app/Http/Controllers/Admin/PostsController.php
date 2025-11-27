<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class PostsController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::with(['categories', 'tags'])->get();

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id');

        $tags = Tag::pluck('name', 'id');

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $data['title'] = $request->title;
        $data['slug'] = Str::slug($request->title);
        $data['description'] = $request->description;

        $markupFixer  = new \TOC\MarkupFixer();
        $contentmenu = $markupFixer->fix($request->content);
        $data['content'] = $contentmenu;

        $data['photo'] = $request->photo;
        $data['is_feature'] = $request->is_feature;
        $post = Post::create($data);

        $post->categories()->sync($request->input('categories', []));
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.posts.index');
    }

    public function edit(Post $post)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id');

        $tags = Tag::pluck('name', 'id');

        $post->load('categories', 'tags');

        return view('admin.posts.edit', compact('categories', 'post', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data['title'] = $request->title;
        $data['slug'] = Str::slug($request->title);
        $data['description'] = $request->description;

        $markupFixer  = new \TOC\MarkupFixer();
        $contentmenu = $markupFixer->fix($request->content);
        $data['content'] = $contentmenu;

        $data['photo'] = $request->photo;
        $data['is_feature'] = $request->is_feature;

        Post::where('id', $post->id)->update($data);

        $post->categories()->sync($request->input('categories', []));
        $post->tags()->sync($request->input('tags', []));


        return redirect()->route('admin.posts.index');
    }

    public function show(Post $post)
    {
        abort_if(Gate::denies('post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->load('categories', 'tags');

        return view('admin.posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        abort_if(Gate::denies('post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostRequest $request)
    {
        Post::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}