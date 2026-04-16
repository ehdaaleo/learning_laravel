<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::withTrashed()->latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($validated);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validatePost($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post moved to trash successfully.');
    }

    public function trashed(): View
    {
        $posts = Post::onlyTrashed()->latest('deleted_at')->paginate(10);

        return view('posts.trashed', compact('posts'));
    }

    public function restore(int $id): RedirectResponse
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.trashed')->with('success', 'Post restored successfully.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('posts.trashed')->with('success', 'Post permanently deleted.');
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ], [
            'title.required' => 'Please enter a title for the post.',
            'title.max' => 'The post title must not be longer than 255 characters.',
            'description.required' => 'Please enter a description for the post.',
            'image.image' => 'The selected file must be a valid image.',
            'image.max' => 'The image size must not exceed 2 MB.',
        ], [
            'title' => 'post title',
            'description' => 'post description',
            'image' => 'post image',
        ]);
    }
}
