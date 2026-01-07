<script setup>
import { onMounted } from 'vue';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import TipeFasilitas from '@/components/fasilitas/TipeFasilitas.vue';

onMounted(() => {
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 1000, once: true });
    }
});
</script>

<template>
    <div class="min-h-screen bg-white flex flex-col">
        <Navbar />

        <section class="relative h-[45vh] flex items-center justify-center bg-satya-dark overflow-hidden">
            <div class="absolute inset-0 opacity-50 scale-110">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1200"
                    class="w-full h-full object-cover" alt="Fasilitas Header">
            </div>
            <div class="relative z-10 text-center px-4" data-aos="zoom-in">
                <h1 class="font-serif text-4xl md:text-5xl text-satya-gold uppercase tracking-[0.3em] mb-4">
                    Layanan & Fasilitas
                </h1>
                <div class="w-24 h-1 bg-satya-gold mx-auto mb-6"></div>
                <p class="text-white/80 max-w-xl mx-auto italic text-sm md:text-base">
                    Kami menghadirkan kenyamanan modern dengan sentuhan keramahan khas Yogyakarta untuk pengalaman
                    menginap yang tak terlupakan.
                </p>
            </div>
        </section>

        <main class="flex-grow py-24">
            <TipeFasilitas />
        </main>

        <section class="py-20 bg-satya-gold/10 border-t border-satya-gold/20">
            <div class="max-w-4xl mx-auto text-center px-4" data-aos="fade-up">
                <h2 class="font-serif text-3xl text-satya-dark mb-6">Ingin Mengetahui Lebih Lanjut?</h2>
                <p class="text-gray-600 mb-10">Tim kami siap membantu menjawab pertanyaan Anda mengenai fasilitas atau
                    pemesanan khusus.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <button
                        class="px-8 py-3 bg-satya-dark text-satya-gold rounded-full font-bold uppercase text-xs tracking-[0.2em] hover:bg-satya-accent transition-all">
                        Hubungi Kami
                    </button>
                    <router-link to="/kamar"
                        class="px-8 py-3 border border-satya-dark text-satya-dark rounded-full font-bold uppercase text-xs tracking-[0.2em] hover:bg-satya-dark hover:text-white transition-all">
                        Lihat Kamar
                    </router-link>
                </div>
            </div>
        </section>

        <Footer />
    </div>
</template>

<style scoped>
html {
    scroll-behavior: smooth;
}
</style>
