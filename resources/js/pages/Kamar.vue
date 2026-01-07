<script setup>
import { onMounted } from 'vue';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import TipeKamar from '@/components/kamar/TipeKamar.vue';

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
    <div class="min-h-screen bg-satya-gold/10 flex flex-col">
        <Navbar />

        <section class="relative h-[40vh] flex items-center justify-center bg-satya-dark">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1200"
                     class="w-full h-full object-cover opacity-40" alt="Hotel Room Header">
            </div>
            <div class="relative z-10 text-center" data-aos="fade-down">
                <h1 class="font-serif text-4xl md:text-5xl text-satya-gold uppercase tracking-widest mb-4">
                    Pilihan Kamar
                </h1>
                <div class="w-24 h-1 bg-satya-gold mx-auto"></div>
            </div>
        </section>

        <main class="flex-grow py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <TipeKamar />
            </div>
        </main>

        <Footer />
    </div>
</template>

<style scoped>
</style>
