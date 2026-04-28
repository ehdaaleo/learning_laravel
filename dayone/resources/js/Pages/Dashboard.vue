<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
                <Link
                    :href="route('posts.create')"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700"
                >
                    New Post
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-sm font-medium uppercase tracking-wide text-indigo-600">
                                Posts
                            </p>
                            <h3 class="mt-2 text-2xl font-semibold text-gray-900">Manage blog posts</h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Create, edit, upload images, and review comments.
                            </p>
                            <div class="mt-6 flex gap-3">
                                <Link
                                    :href="route('posts.index')"
                                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-black"
                                >
                                    Open Posts
                                </Link>
                                <Link
                                    :href="route('posts.create')"
                                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                                >
                                    Create
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="page.props.auth.user?.is_admin"
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <p class="text-sm font-medium uppercase tracking-wide text-rose-600">
                                Admin
                            </p>
                            <h3 class="mt-2 text-2xl font-semibold text-gray-900">Trash management</h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Restore or permanently delete soft-deleted posts.
                            </p>
                            <div class="mt-6">
                                <Link
                                    :href="route('posts.trashed')"
                                    class="rounded-md bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700"
                                >
                                    Open Trash
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg md:col-span-2">
                        <div class="p-6 text-gray-900">
                            Signed in as <span class="font-semibold">{{ page.props.auth.user?.name }}</span>
                            <span class="text-gray-500">({{ page.props.auth.user?.email }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
