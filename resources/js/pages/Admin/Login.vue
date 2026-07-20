<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/admin/login', {
        preserveScroll: true,
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-[#fcfbf7] px-4">
        <div class="w-full max-w-md rounded-[2.5rem] border border-gray-100 bg-white p-10 shadow-2xl">
            <div class="mb-10 text-center">
                <h1 class="mb-2 font-serif text-3xl tracking-widest text-[#5c5d4d] uppercase">Admin Portal</h1>

                <p class="text-xs text-gray-400 italic">Satya Graha Hotel Management</p>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- Username atau email -->
                <div>
                    <label for="login" class="mb-2 block text-[10px] font-black tracking-widest text-gray-400 uppercase"> Username atau Email </label>

                    <input
                        id="login"
                        v-model="form.login"
                        type="text"
                        autocomplete="username"
                        required
                        autofocus
                        class="w-full rounded-2xl border bg-gray-50 px-5 py-4 transition outline-none focus:ring-2 focus:ring-[#d4af37]"
                        :class="form.errors.login ? 'border-red-400' : 'border-gray-100'"
                        placeholder="admin atau admin@satyagraha.com"
                    />

                    <p v-if="form.errors.login" class="mt-2 text-xs text-red-500">
                        {{ form.errors.login }}
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="mb-2 block text-[10px] font-black tracking-widest text-gray-400 uppercase"> Password </label>

                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-2xl border bg-gray-50 px-5 py-4 transition outline-none focus:ring-2 focus:ring-[#d4af37]"
                        :class="form.errors.password ? 'border-red-400' : 'border-gray-100'"
                        placeholder="••••••••"
                    />

                    <p v-if="form.errors.password" class="mt-2 text-xs text-red-500">
                        {{ form.errors.password }}
                    </p>
                </div>

                <!-- Remember me -->
                <label class="flex cursor-pointer items-center gap-3">
                    <input v-model="form.remember" type="checkbox" class="size-4 rounded border-gray-300 text-[#d4af37] focus:ring-[#d4af37]" />

                    <span class="text-xs text-gray-500"> Ingat saya </span>
                </label>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-2xl bg-[#2d2e24] py-5 text-xs font-bold tracking-[0.2em] text-[#d4af37] uppercase transition hover:bg-[#5c5d4d] hover:text-white disabled:cursor-not-allowed disabled:opacity-50"
                >
                    {{ form.processing ? 'Authenticating...' : 'Sign In' }}
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="/" class="text-[10px] tracking-widest text-gray-400 uppercase transition hover:text-[#d4af37]"> ← Back to Website </a>
            </div>
        </div>
    </div>
</template>
