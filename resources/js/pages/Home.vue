<script setup>
import { onMounted } from 'vue';
import Navbar from '@/components/Navbar.vue';
import HeroSlider from '@/components/home/HeroSlider.vue';
import Facilities from '@/components/home/Facilities.vue';
import Destinasi from '@/components/home/Destinasi.vue';
import TestimoniSlider from '@/components/home/TestimoniSlider.vue';
import Footer from '@/components/Footer.vue';


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
    <div class="min-h-screen bg-[#fcfbf7] flex flex-col">
        <Navbar />
        <HeroSlider />

        <main class="flex-grow">
            <section class="max-w-6xl mx-auto py-16 px-4 text-center" data-aos="fade-up">
                <h3 class="font-serif text-3xl md:text-4xl text-[#5c5d4d] mb-4 uppercase tracking-[0.2em]">
                    Selamat Datang di Satya Graha
                </h3>

                <div class="w-16 h-0.5 bg-[#5c5d4d] mx-auto mb-8"></div>

                <p class="text-gray-600 max-w-2xl mx-auto leading-relaxed text-base md:text-lg italic">
                    "Rasakan pengalaman menginap yang tak terlupakan dengan perpaduan keramahan khas Yogyakarta dan
                    fasilitas modern yang mewah."
                </p>

                <div class="mt-8">
                    <a href="https://wa.me/6281287564433" target="_blank"
                        class="inline-flex items-center gap-3 px-10 py-4 bg-[#2d2e24] text-[#d4af37] rounded-full font-bold uppercase tracking-[0.15em] text-xs transition-all duration-500 hover:bg-[#d4af37] hover:text-white hover:shadow-xl">
                        <span class="material-symbols-outlined text-xl">calendar_month</span>
                        Reservasi Sekarang
                    </a>
                </div>
            </section>

            <Facilities />
            <Destinasi />
            <TestimoniSlider />
        </main>

        <Footer />
    </div>
</template>
