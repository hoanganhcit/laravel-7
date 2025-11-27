<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostComment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class PostCommentController extends Controller
{
    public function index () {
        $comments = PostComment::get();
        return view('admin.comments.index', compact('comments'));
    }

    public function edit () {
        $comments = PostComment::get();
        return view('admin.comments.index', compact('comments'));
    }

    public function update () {
        $comments = PostComment::get();
        return view('admin.comments.index', compact('comments'));
    }

    public function active (Request $request) {
        $comment_id = $request->comment_id;
        $status = $request->status;
        $comments = PostComment::where('id', $comment_id)->update([
            'status' => $status
        ]);
    }

    public function destroy (Request $request, PostComment $postcomment) {
        $postcomment->delete();
        return back();
    }

    public function massDestroy(Request $request)
    {
        PostComment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
