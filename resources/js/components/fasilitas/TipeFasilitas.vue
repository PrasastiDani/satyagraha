<script setup>
const facilities = [
    {
        name: 'Kolam Renang Outdoor',
        image: 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?q=80&w=1000&auto=format&fit=crop',
        description: 'Nikmati kesegaran air di kolam renang kami yang luas, dikelilingi taman tropis yang asri. Cocok untuk bersantai bersama keluarga atau sekadar berolahraga ringan.',
        icons: ['Suasana Asri', 'Kedalaman Beragam', 'Handuk Bersih'],
        aos: 'fade-right'
    },
    {
        name: 'Restoran & Cafe',
        image: 'https://images.unsplash.com/photo-1552566626-52f8b828add9?q=80&w=1000&auto=format&fit=crop',
        description: 'Manjakan lidah Anda dengan pilihan hidangan khas nusantara dan internasional. Kami menyajikan sarapan prasmanan yang lezat setiap pagi dengan bumbu autentik.',
        icons: ['Sarapan Buffet', 'Open 24/7', 'Layanan Kamar'],
        aos: 'fade-left'
    },
    {
        name: 'Pojok Baca & Lounge',
        image: 'https://images.unsplash.com/photo-1521017432531-fbd92d768814?q=80&w=1000&auto=format&fit=crop',
        description: 'Ruang tenang bagi Anda yang ingin bersantai sambil membaca koleksi buku kami atau sekadar menikmati kopi sore dalam suasana yang hangat.',
        icons: ['Wifi Gratis', 'Area Tenang', 'Koleksi Buku'],
        aos: 'fade-right'
    },
    {
        name: 'Parkir Luas & Aman',
        image: 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?q=80&w=1000&auto=format&fit=crop',
        description: 'Tidak perlu khawatir dengan kendaraan Anda. Kami menyediakan area parkir yang sangat luas yang mampu menampung bus pariwisata maupun kendaraan pribadi dengan keamanan 24 jam.',
        icons: ['Akses Bus', 'Keamanan 24 Jam', 'Gratis'],
        aos: 'fade-left'
    }
];
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div v-for="(item, index) in facilities" :key="index"
            class="flex flex-col md:flex-row items-center gap-12 mb-32 last:mb-0"
            :class="{ 'md:flex-row-reverse': index % 2 !== 0 }">

            <div class="w-full md:w-1/2" :data-aos="item.aos">
                <div class="relative group">
                    <div
                        class="absolute -inset-4 border border-satya-gold/20 translate-x-8 translate-y-8 rounded-2xl -z-10 group-hover:translate-x-4 group-hover:translate-y-4 transition-all duration-500">
                    </div>
                    <img :src="item.image" :alt="item.name"
                        class="rounded-2xl shadow-2xl w-full h-[400px] object-cover object-center" />
                </div>
            </div>

            <div class="w-full md:w-1/2 space-y-6" :data-aos="index % 2 === 0 ? 'fade-left' : 'fade-right'">
                <h2 class="font-serif text-3xl md:text-4xl text-satya-dark capitalize">{{ item.name }}</h2>
                <div class="w-16 h-1 bg-satya-accent"></div>
                <p class="text-gray-600 leading-relaxed text-lg">
                    {{ item.description }}
                </p>

                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div v-for="icon in item.icons" :key="icon" class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-satya-accent">done_all</span>
                        <span class="text-sm font-bold text-satya-dark uppercase tracking-tight">
                            {{ icon }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
