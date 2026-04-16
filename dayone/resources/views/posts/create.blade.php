@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-3xl">
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Hyper UI Form</p>
        <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">Create Post</h1>
        <p class="mt-2 text-sm text-slate-600">Add a new post and store it directly in the database.</p>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @include('posts.form')
                </form>
    </div>
</section>
@endsection
