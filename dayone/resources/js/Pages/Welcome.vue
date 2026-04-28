<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen bg-gray-100">
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col justify-center px-6 py-16">
            <div class="overflow-hidden rounded-2xl bg-white shadow-xl">
                <div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
                    <div class="bg-gray-900 p-10 text-white sm:p-12">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-indigo-300">Laravel Blog Lab</p>
                        <h1 class="mt-4 text-4xl font-bold tracking-tight">Posts, images, comments, policies, gates, and GitHub login.</h1>
                        <p class="mt-4 max-w-xl text-sm leading-7 text-gray-300">
                            
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <Link
                                :href="route('posts.index')"
                                class="rounded-md bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-gray-100"
                            >
                                Open Posts
                            </Link>

                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="rounded-md border border-white/20 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                            >
                                Dashboard
                            </Link>

                            <template v-else>
                                <Link
                                    v-if="canLogin"
                                    :href="route('login')"
                                    class="rounded-md border border-white/20 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                                >
                                    Log in
                                </Link>

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="rounded-md border border-white/20 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                                >
                                    Register
                                </Link>

                                <Link
                                    :href="route('github.redirect')"
                                    class="rounded-md border border-indigo-400 bg-indigo-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-400"
                                >
                                    GitHub Login
                                </Link>
                            </template>
                        </div>
                    </div>

                    <div class="p-8 sm:p-10">
                        <div class="space-y-6">
                            

    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
