<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITIBlog</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-gradient-to-br from-sky-200 via-white to-emerald-100"></div>

    <nav class="border-b border-white/60 bg-white/80 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="/" class="text-xl font-black tracking-tight text-slate-900">ITIBlog</a>
            <div class="flex items-center gap-2 text-sm font-medium">
                <a href="/" class="rounded-full px-4 py-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Home</a>
                <a href="{{ route('posts.index') }}" class="rounded-full px-4 py-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Posts</a>
                <a href="{{ route('posts.create') }}" class="rounded-full px-4 py-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Create</a>
                <a href="{{ route('posts.trashed') }}" class="rounded-full px-4 py-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Trash</a>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <dialog id="delete-confirmation-dialog" class="w-full max-w-md rounded-3xl border-0 p-0 shadow-2xl backdrop:bg-slate-900/50">
        <div class="space-y-5 bg-white p-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-rose-500">Warning</p>
                <h2 class="mt-2 text-2xl font-bold text-slate-900">Confirm deletion</h2>
                <p id="delete-confirmation-message" class="mt-3 text-sm leading-6 text-slate-600">
                    Are you sure you want to continue?
                </p>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="cancel-delete-button" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                    No
                </button>
                <button type="button" id="confirm-delete-button" class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">
                    Yes, delete
                </button>
            </div>
        </div>
    </dialog>

    <script>
        (() => {
            const dialog = document.getElementById('delete-confirmation-dialog');
            const message = document.getElementById('delete-confirmation-message');
            const confirmButton = document.getElementById('confirm-delete-button');
            const cancelButton = document.getElementById('cancel-delete-button');
            let currentForm = null;

            document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    currentForm = form;
                    message.textContent = form.dataset.confirmMessage || 'Are you sure you want to continue?';

                    if (typeof dialog.showModal === 'function') {
                        dialog.showModal();
                    } else if (window.confirm(message.textContent)) {
                        form.submit();
                    }
                });
            });

            confirmButton?.addEventListener('click', () => {
                if (currentForm) {
                    currentForm.submit();
                }
            });

            cancelButton?.addEventListener('click', () => {
                dialog.close();
                currentForm = null;
            });

            dialog?.addEventListener('close', () => {
                currentForm = null;
            });
        })();
    </script>
</body>
</html>
