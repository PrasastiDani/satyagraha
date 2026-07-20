<script setup>
import { Link, router } from '@inertiajs/vue3';

const logout = () => {
    router.post('/admin/logout');
};

const stats = [
    { label: 'Total Kamar', value: '24', icon: 'bed' },
    { label: 'Pesan Baru', value: '12', icon: 'mail' },
    { label: 'Fasilitas', value: '8', icon: 'pool' },
];
</script>

<template>
    <div class="flex min-h-screen bg-gray-50">
        <aside class="bg-satya-dark flex w-64 flex-col p-6 text-white">
            <div class="mb-10 text-center">
                <h2 class="text-satya-gold font-serif text-xl tracking-widest uppercase">Satya Graha</h2>
                <p class="mt-1 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Admin Panel</p>
            </div>

            <nav class="flex-grow space-y-2">
                <Link
                    :href="'/admin/dashboard'"
                    :class="{ 'text-satya-gold bg-white/10': $page.component === 'Admin/Dashboard' }"
                    class="flex items-center gap-3 rounded-xl p-3 transition"
                >
                    <span class="material-symbols-outlined text-sm">dashboard</span>
                    <span class="text-xs font-bold tracking-widest uppercase">Dashboard</span>
                </Link>
            </nav>

            <button @click="logout" class="mt-auto flex items-center gap-3 rounded-xl p-3 text-red-400 transition hover:bg-red-500/10">
                <span class="material-symbols-outlined text-sm">logout</span>
                <span class="text-xs font-bold tracking-widest uppercase">Logout</span>
            </button>
        </aside>

        <main class="flex-grow p-10">
            <header class="mb-10 flex items-center justify-between">
                <div>
                    <h1 class="text-satya-dark font-serif text-2xl tracking-widest uppercase">Dashboard Overview</h1>
                    <p class="text-sm text-gray-400 italic">Selamat datang kembali, Admin.</p>
                </div>
                <div class="flex items-center gap-4">
                    <Link
                        href="/"
                        class="text-satya-gold border-satya-gold hover:bg-satya-gold rounded-full border px-4 py-2 text-[10px] font-bold tracking-widest uppercase transition hover:text-white"
                    >
                        Lihat Website
                    </Link>
                </div>
            </header>

            <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div
                    v-for="stat in stats"
                    :key="stat.label"
                    class="flex items-center gap-5 rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm"
                >
                    <div class="bg-satya-gold/10 flex h-12 w-12 items-center justify-center rounded-2xl">
                        <span class="material-symbols-outlined text-satya-gold">{{ stat.icon }}</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">{{ stat.label }}</p>
                        <p class="text-satya-dark text-2xl font-bold">{{ stat.value }}</p>
                    </div>
                </div>
            </div>

            <div
                class="flex min-h-[400px] flex-col items-center justify-center rounded-[2rem] border border-gray-100 bg-white p-10 text-center shadow-sm"
            >
                <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-50">
                    <span class="material-symbols-outlined text-4xl text-gray-300">edit_note</span>
                </div>
                <h3 class="text-satya-dark mb-2 font-serif text-xl">Mulai Kelola Konten</h3>
                <p class="max-w-sm text-sm text-gray-400 italic">Pilih menu di samping untuk menambah, mengubah, atau menghapus data hotel.</p>
            </div>
        </main>
    </div>
</template>
