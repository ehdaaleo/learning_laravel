@extends('layouts.app')

@section('content')
@php
    $image = $post->image;
    $imageUrl = null;

    if ($image) {
        $imageUrl = filter_var($image, FILTER_VALIDATE_URL) ? $image : asset('storage/' . $image);
    }
@endphp

<section class="mx-auto max-w-4xl">
    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="bg-slate-100">
                @if($imageUrl)
                    <img src="{{ $imageUrl }}"
                         class="h-full w-full object-cover"
                         alt="{{ $post->title }}">
                @else
                    <div class="flex h-full min-h-80 items-center justify-center bg-gradient-to-br from-sky-100 to-emerald-100 p-8 text-center text-slate-500">
                        No image was uploaded for this post.
                    </div>
                @endif
            </div>

            <div class="space-y-6 p-6 sm:p-8">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Post Details</p>
                    <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $post->title }}</h1>
                </div>

                <dl class="grid gap-4 rounded-2xl bg-slate-50 p-4 text-sm text-slate-600">
                    <div>
                        <dt class="font-semibold text-slate-900">Author</dt>
                        <dd>{{ $post->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-900">Created At</dt>
                        <dd>{{ $post->created_at?->isoFormat('dddd, MMMM D, YYYY [at] h:mm A') }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-900">Relative Time</dt>
                        <dd>{{ $post->created_at?->diffForHumans() }}</dd>
                    </div>
                </dl>

                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Description</h2>
                    <p class="mt-3 text-base leading-7 text-slate-700">{{ $post->description }}</p>
                </div>

                @if($post->tags && $post->tags->count() > 0)
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Tags</h2>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">All Posts</a>
                    <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">Edit</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">Comments</h2>
        </div>

        <div class="divide-y divide-slate-200">
            @forelse($post->comments as $comment)
                <div class="px-6 py-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <span class="font-semibold text-slate-900">{{ $comment->user->name }}</span>
                                <span class="text-sm text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mt-1 text-slate-700">{{ $comment->content }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-slate-500">
                    No comments yet.
                </div>
            @endforelse
        </div>

        @auth
        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <label for="content" class="block text-sm font-medium text-slate-700">Add a comment</label>
                    <textarea id="content" name="content" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500" placeholder="Write your comment here..."></textarea>
                    @error('content')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-700">Post Comment</button>
                </div>
            </form>
        </div>
        @else
        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4 text-center">
            <p class="text-sm text-slate-600">Please <a href="{{ route('login') }}" class="text-sky-600 hover:text-sky-700">log in</a> to add a comment.</p>
        </div>
        @endauth
    </div>
            </div>
        </div>
    </div>
</section>
@endsection
