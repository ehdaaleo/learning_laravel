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

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">All Posts</a>
                    <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">Edit</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
