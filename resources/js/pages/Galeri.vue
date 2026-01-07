<script setup>
import { onMounted } from 'vue';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import GambarGaleri from '@/components/galeri/GambarGaleri.vue';

onMounted(() => {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-back',
        });
    }
});
</script>

<template>
    <div class="min-h-screen bg-white flex flex-col">
        <Navbar />

        <section class="relative h-[45vh] flex items-center justify-center bg-satya-dark overflow-hidden">
            <div class="absolute inset-0 opacity-50 scale-110">
                <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?q=80&w=1200" class="w-full h-full object-cover" alt="Galeri Header">
            </div>
            <div class="relative z-10 text-center px-4" data-aos="zoom-in">
                <h1 class="font-serif text-4xl md:text-5xl text-satya-gold uppercase tracking-[0.3em] mb-4">Galeri Foto</h1>
                <div class="w-24 h-1 bg-satya-gold mx-auto mb-6"></div>
                <p class="text-white/80 max-w-xl mx-auto italic text-sm md:text-base">
                    Jelajahi keindahan dan kemewahan Satya Graha melalui koleksi foto pilihan kami.
                </p>
            </div>
        </section>

        <main class="flex-grow py-20">
            <GambarGaleri />
        </main>

        <Footer />
    </div>
</template>
