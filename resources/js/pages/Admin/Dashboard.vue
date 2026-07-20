<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';

const stats = [
    {
        label: 'Total Kamar',
        value: '24',
        icon: 'bed',
    },
    {
        label: 'Pesan Baru',
        value: '12',
        icon: 'mail',
    },
    {
        label: 'Fasilitas',
        value: '8',
        icon: 'pool',
    },
];
</script>

<template>
    <AdminLayout title="Dashboard Overview" description="Selamat datang kembali, Admin.">
        <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-3">
            <div v-for="stat in stats" :key="stat.label" class="flex items-center gap-5 rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm">
                <div class="bg-satya-gold/10 flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl">
                    <span class="material-symbols-outlined text-satya-gold">
                        {{ stat.icon }}
                    </span>
                </div>

                <div>
                    <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                        {{ stat.label }}
                    </p>

                    <p class="text-satya-dark text-2xl font-bold">
                        {{ stat.value }}
                    </p>
                </div>
            </div>
        </div>

        <div
            class="flex min-h-[400px] flex-col items-center justify-center rounded-[2rem] border border-gray-100 bg-white p-10 text-center shadow-sm"
        >
            <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-50">
                <span class="material-symbols-outlined text-4xl text-gray-300"> edit_note </span>
            </div>

            <h3 class="text-satya-dark mb-2 font-serif text-xl">Mulai Kelola Konten</h3>

            <p class="max-w-sm text-sm text-gray-400 italic">Pilih menu di samping untuk menambah, mengubah, atau menghapus data hotel.</p>
        </div>
    </AdminLayout>
</template>
