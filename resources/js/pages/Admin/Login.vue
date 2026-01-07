<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    // Jika tidak menggunakan Ziggy, ganti route('login') menjadi '/admin/login'
    form.post('/admin/login', {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-[#fcfbf7] px-4">
        <div class="max-w-md w-full bg-white p-10 rounded-[2.5rem] shadow-2xl border border-gray-100">
            <div class="text-center mb-10">
                <h1 class="font-serif text-3xl text-[#5c5d4d] uppercase tracking-widest mb-2">Admin Portal</h1>
                <p class="text-gray-400 text-xs italic">Satya Graha Hotel Management</p>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Email Address</label>
                    <input v-model="form.email" type="email" required
                        class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#d4af37] outline-none transition"
                        placeholder="admin@satyagraha.com">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Password</label>
                    <input v-model="form.password" type="password" required
                        class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#d4af37] outline-none transition"
                        placeholder="••••••••">
                </div>

                <button :disabled="form.processing"
                    class="w-full py-5 bg-[#2d2e24] text-[#d4af37] rounded-2xl font-bold uppercase tracking-[0.2em] text-xs transition hover:bg-[#5c5d4d] hover:text-white disabled:opacity-50">
                    {{ form.processing ? 'Authenticating...' : 'Sign In' }}
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="/" class="text-[10px] text-gray-400 hover:text-[#d4af37] uppercase tracking-widest transition">
                    ← Back to Website
                </a>
            </div>
        </div>
    </div>
</template>
