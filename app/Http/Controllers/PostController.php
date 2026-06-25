<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::with('user')->get(); // Eager load the user relationship
        // $posts = Post::get(); // Lazy load the user relationship


        // foreach ($posts as $post) {
        //     echo $post->user->name .'<br>';
        // }
        // return response()->json($posts);
        // Load posts with related user and comments, newest first
        $posts = Post::with('user', 'comments.user')->latest()->get();
        $name = 'Afiqah'; // Example name, you can replace this with dynamic data as needed
        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'name' => $name,
        ]);
        // return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
       // Create and save a new post associated with the authenticated user
       $post = $request->user()->posts()->latest()->create([
           'content' => $request->input('content'),
       ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }
    public function message()
    {
        return [
            'content.required' => 'Sis, fill in the post content. Danke.',
            'content.string' => 'Must be string ah.',
            'content.min' => 'Min 3 characters.',
            'content.max' => 'Max is 255 ny.',
        ];
    }
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return Inertia::render('Posts/Edit', [
            'post' => [
                'id' => $post->id,
                'content' => $post->content,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->content = $request->input('content');
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
