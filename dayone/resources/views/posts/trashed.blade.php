@extends('layouts.app')

@section('content')
<section class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-rose-500">Soft Deletes</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">Trashed Posts</h1>
        </div>
        <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Back to Posts</a>
    </div>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold text-slate-600">Title</th>
                    <th class="px-6 py-4 text-left font-semibold text-slate-600">Deleted At</th>
                    <th class="px-6 py-4 text-right font-semibold text-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($posts as $post)
                    <tr>
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $post->title }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            <div>{{ $post->deleted_at?->isoFormat('MMM D, YYYY [at] h:mm A') }}</div>
                            <div class="text-xs text-slate-400">{{ $post->deleted_at?->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex flex-wrap justify-end gap-2">
                                <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                                    @csrf
                                    <x-button type="success" size="sm" buttonType="submit">Restore</x-button>
                                </form>

                                <form action="{{ route('posts.force-delete', $post->id) }}" method="POST" data-confirm-delete data-confirm-message="Delete this post permanently? This action cannot be undone.">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="danger" size="sm" buttonType="submit">Delete Forever</x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-slate-500">No trashed posts found.</td>
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
