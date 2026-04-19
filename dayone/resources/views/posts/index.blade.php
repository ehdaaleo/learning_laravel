@extends('layouts.app')

@section('content')
<section class="space-y-6">
    <div class="flex flex-col gap-4 rounded-[2rem] bg-slate-900 p-6 text-white shadow-xl sm:flex-row sm:items-end sm:justify-between sm:p-8">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-300">Lab 2</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight">Posts Dashboard</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">
                CRUD, soft deletes, restore, pagination, and formatted dates using a HyperUI-style table.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('posts.trashed') }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10">Trash Only</a>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">Create Post</a>
        </div>
    </div>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                 <tr>
                     <th class="px-6 py-4 text-left font-semibold text-slate-600">Title</th>
                     <th class="px-6 py-4 text-left font-semibold text-slate-600">Slug</th>
                     <th class="px-6 py-4 text-left font-semibold text-slate-600">Description</th>
                     <th class="px-6 py-4 text-left font-semibold text-slate-600">Created At</th>
                     <th class="px-6 py-4 text-left font-semibold text-slate-600">Status</th>
                     <th class="px-6 py-4 text-right font-semibold text-slate-600">Actions</th>
                 </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                 @forelse($posts as $post)
                     <tr class="align-top">
                         <td class="px-6 py-4">
                             <div class="font-semibold text-slate-900">{{ $post->title }}</div>
                         </td>
                         <td class="px-6 py-4 text-slate-600">{{ $post->slug }}</td>
                         <td class="px-6 py-4 text-slate-600">{{ \Illuminate\Support\Str::limit($post->description, 80) }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            <div>{{ $post->created_at?->isoFormat('MMM D, YYYY') }}</div>
                            <div class="text-xs text-slate-400">{{ $post->created_at?->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($post->trashed())
                                <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Deleted</span>
                            @else
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Active</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex flex-wrap justify-end gap-2">
                                <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center justify-center rounded-xl border border-sky-300 bg-sky-50 px-3 py-2 text-sm font-semibold text-sky-700 transition hover:bg-sky-100">View</a>

                                @if($post->trashed())
                                    <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                                        @csrf
                                        <x-button type="success" size="sm" buttonType="submit">Restore</x-button>
                                    </form>

                                    <form action="{{ route('posts.force-delete', $post->id) }}" method="POST" data-confirm-delete data-confirm-message="Delete this post permanently? This action cannot be undone.">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="danger" size="sm" buttonType="submit">Delete Forever</x-button>
                                    </form>
                                @else
                                    <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-3 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">Edit</a>

                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" data-confirm-delete data-confirm-message="Move this post to trash?">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="danger" size="sm" buttonType="submit">Delete</x-button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                 @empty
                     <tr>
                         <td colspan="6" class="px-6 py-10 text-center text-slate-500">No posts found.</td>
                     </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="rounded-2xl bg-white px-4 py-4 shadow-sm">
        {{ $posts->links() }}
    </div>
</section>
@endsection
