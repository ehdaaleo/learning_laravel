@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-3xl">
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-500">Hyper UI Form</p>
        <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">Edit Post</h1>
        <p class="mt-2 text-sm text-slate-600">Update the post content and save the changes to the database.</p>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @include('posts.form', ['post' => $post])
                </form>
    </div>
</section>
@endsection
