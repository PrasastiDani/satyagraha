<script setup>
import { Link, router } from '@inertiajs/vue3';

const logout = () => {
    router.post(route('logout'));
};

// Data statistik dummy untuk tampilan awal
const stats = [
    { label: 'Total Kamar', value: '24', icon: 'bed' },
    { label: 'Pesan Baru', value: '12', icon: 'mail' },
    { label: 'Fasilitas', value: '8', icon: 'pool' },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <aside class="w-64 bg-satya-dark text-white p-6 flex flex-col">
            <div class="mb-10 text-center">
                <h2 class="font-serif text-satya-gold text-xl tracking-widest uppercase">Satya Graha</h2>
                <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest font-bold">Admin Panel</p>
            </div>

            <nav class="flex-grow space-y-2">
                <Link :href="'/admin/dashboard'"
                    :class="{ 'bg-white/10 text-satya-gold': $page.component === 'Admin/Dashboard' }"
                    class="flex items-center gap-3 p-3 rounded-xl transition">
                    <span class="material-symbols-outlined text-sm">dashboard</span>
                    <span class="text-xs font-bold uppercase tracking-widest">Dashboard</span>
                </Link>
            </nav>

            <button @click="logout"
                class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-500/10 rounded-xl transition mt-auto">
                <span class="material-symbols-outlined text-sm">logout</span>
                <span class="text-xs font-bold uppercase tracking-widest">Logout</span>
            </button>
        </aside>

        <main class="flex-grow p-10">
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-2xl font-serif text-satya-dark uppercase tracking-widest">Dashboard Overview</h1>
                    <p class="text-gray-400 text-sm italic">Selamat datang kembali, Admin.</p>
                </div>
                <div class="flex items-center gap-4">
                    <Link href="/"
                        class="text-[10px] font-bold uppercase tracking-widest text-satya-gold border border-satya-gold px-4 py-2 rounded-full hover:bg-satya-gold hover:text-white transition">
                        Lihat Website
                    </Link>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div v-for="stat in stats" :key="stat.label"
                    class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5">
                    <div class="w-12 h-12 bg-satya-gold/10 rounded-2xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-satya-gold">{{ stat.icon }}</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ stat.label }}</p>
                        <p class="text-2xl font-bold text-satya-dark">{{ stat.value }}</p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-10 min-h-[400px] flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-4xl text-gray-300">edit_note</span>
                </div>
                <h3 class="text-satya-dark font-serif text-xl mb-2">Mulai Kelola Konten</h3>
                <p class="text-gray-400 text-sm max-w-sm italic">Pilih menu di samping untuk menambah, mengubah, atau
                    menghapus data hotel.</p>
            </div>
        </main>
    </div>
</template>
