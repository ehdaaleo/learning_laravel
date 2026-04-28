<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        $this->authorize('create', Post::class);

        return view('posts.create', ['post' => null]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->authorize('create', Post::class);

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($validated);

        if ($request->filled('tags')) {
            $tags = explode(',', $request->tags);
            $post->syncTags($tags);
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post): View
    {
        $post->load(['comments.user']);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            if ($post->image && ! filter_var($post->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($post->image);
            }

            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        if ($request->filled('tags')) {
            $tags = explode(',', $request->tags);
            $post->syncTags($tags);
        } else {
            $post->detachTags();
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        if ($post->image && ! filter_var($post->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post moved to trash successfully.');
    }

    public function trashed(): View
    {
        Gate::authorize('admin');

        $posts = Post::onlyTrashed()->latest('deleted_at')->paginate(10);

        return view('posts.trashed', compact('posts'));
    }

    public function restore(int $id): RedirectResponse
    {
        Gate::authorize('admin');

        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.trashed')->with('success', 'Post restored successfully.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        Gate::authorize('admin');

        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('posts.trashed')->with('success', 'Post permanently deleted.');
    }
}
