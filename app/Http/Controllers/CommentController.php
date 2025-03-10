<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:255',
        ]);

        Comment::create([
            'post_id' => $validatedData['post_id'],
            'user_id' => Auth::user()->id,
            'content' => $validatedData['content'],
        ]);

        return redirect()->route('posts.home')->with('success', 'Comentario añadido correctamente.');
    }


    public function show($postId)
    {
        $post = Post::findOrFail($postId);
        $comments = $post->comments;
        return response()->json($comments);
    }
}
