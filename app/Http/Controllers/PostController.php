<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

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

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            //'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'title.required' => 'El titulo is obligatorio.',
            'title.max' => 'EL titulo debe tener menos de 255 caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            //'image.required' => 'La imagen es obligatoria.',
            //'image.image' => 'El archivo debe ser una imagen.',
            //'image.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
            //'image.max' => 'La imagen debe pesar menos de 2MB.',
        ]
        );

        if ($validator->fails()) {
            return redirect()->route('posts.form')
                     ->withErrors($validator)
                     ->withInput();
        }
/*
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/posts'); // Guarda en storage/app/public/posts
            $imageName = str_replace('public/', '', $imagePath); // Para obtener la ruta relativa
        } else {
            $imageName = null;
        }
*/
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        //$post->file_path = $imageName;
        $post->user_id = Auth::id();
        $post->save();

        return redirect()->route('posts.home')
                         ->with('success', 'Post creado correctamente.');
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.home')
                         ->with('success', 'Post eliminado correctamente.');
    }
}
