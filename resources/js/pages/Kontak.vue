<script setup>
import { onMounted } from 'vue';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import DaftarKontak from '@/components/kontak/DaftarKontak.vue';

onMounted(() => {
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 1000, once: true });
    }
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        <Navbar />

        <section class="relative h-[30vh] flex items-center justify-center bg-satya-dark overflow-hidden">
            <div class="absolute inset-0 opacity-30">
                <img src="https://images.unsplash.com/photo-1516733725897-1aa73b87c8e8?q=80&w=1200"
                    class="w-full h-full object-cover" alt="Hero">
            </div>
            <div class="relative z-10 text-center" data-aos="zoom-in">
                <h1 class="font-serif text-3xl md:text-5xl text-white uppercase tracking-[0.4em]">Hubungi Kami</h1>
            </div>
        </section>

        <main class="max-w-7xl mx-auto py-24 px-4 flex-grow">
            <DaftarKontak />
        </main>

        <Footer />
    </div>
</template>

<style scoped>
h1 {
    letter-spacing: 0.3em;
}
</style>
