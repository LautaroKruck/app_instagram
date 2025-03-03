<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'post_id' => $validatedData['post_id'],
            'content' => $validatedData['content'],
        ]);

        return response()->json($comment, 201);
    }
    public function show($postId)
    {
        $post = Post::findOrFail($postId);
        $comments = $post->comments;
        return response()->json($comments);
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
