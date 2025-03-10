<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function showAll()
    {
        $posts = Post::all();
        $user = Auth::user();
        return view('posts_views.home', compact('posts','user'));
    }

    public function show()
    {
        $user = Auth::user();
        return view('posts_views.create', compact('user'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título debe tener menos de 255 caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
            'image.max' => 'La imagen debe pesar menos de 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('posts.form')
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('posts');
        }

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->image = $image;
        $post->user_id = Auth::id();
        $post->save();

        return redirect()->route('posts.home')
            ->with('success', 'Post creado correctamente.');
    }

    public function like(Request $request){
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|integer',
        ],[
            'post_id.required' => 'El id del post es obligatorio.',
            'post_id.integer' => 'El id del post debe ser un número entero.',
        ]
        );
        if ($validator->fails()) {
            return redirect()->route('posts.home')
                     ->withErrors($validator)
                     ->withInput();
        }
        $post = Post::findOrFail($request->post_id);
        $post->n_likes++;
        $post->save();
        return redirect()->route('posts.home');
    }

    public function delete($id)
    {   
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|exists:App\Models\Post,id']
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // Obtener el post y verificar si existe
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back()->with('error', 'El post no existe.');
        }

        // Eliminar comentarios asociados
        Comment::where("post_id", $id)->delete();

        // Eliminar imagen si existe
        if ($post->image) {
            Storage::delete('posts/' . $post->image);
        }

        // Eliminar el post
        $post->delete();

        return redirect()->route('posts.home')
            ->with('success', 'Post eliminado correctamente.');
    }
}
