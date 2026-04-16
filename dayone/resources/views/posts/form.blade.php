@csrf

<div class="space-y-6">
<div>
    <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Title</label>
    <input
        type="text"
        name="title"
        id="title"
        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:ring-4 focus:ring-sky-100"
        value="{{ old('title', $post->title ?? '') }}"
    >
    @error('title')
        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Description</label>
    <textarea
        name="description"
        id="description"
        rows="5"
        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:ring-4 focus:ring-sky-100"
    >{{ old('description', $post->description ?? '') }}</textarea>
    @error('description')
        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="image" class="mb-2 block text-sm font-medium text-slate-700">Image</label>
    <input
        type="file"
        name="image"
        id="image"
        class="w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition file:mr-4 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white"
    >
    @error('image')
        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
    @enderror

    @if (!empty($post?->image))
        <p class="mt-2 text-sm text-slate-500">Current image: {{ $post->image }}</p>
    @endif
</div>

<div class="flex items-center gap-3">
    <x-button type="primary" buttonType="submit">Save Post</x-button>
    <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Cancel</a>
</div>
</div>
