<script setup>
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import BookingEngine from '@/components/home/BookingEngine.vue';
import Destinasi from '@/components/home/Destinasi.vue';
import Facilities from '@/components/home/Facilities.vue';
import HeroSlider from '@/components/home/HeroSlider.vue';
import TestimoniSlider from '@/components/home/TestimoniSlider.vue';
import { onMounted } from 'vue';

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
    <div class="flex min-h-screen flex-col bg-[#fcfbf7]">
        <Navbar />
        <HeroSlider />

        <main class="flex-grow">
            <BookingEngine />
            <section class="mx-auto max-w-6xl px-4 py-16 text-center" data-aos="fade-up">
                <h3 class="mb-4 font-serif text-3xl tracking-[0.2em] text-[#5c5d4d] uppercase md:text-4xl">Selamat Datang di Satya Graha</h3>

                <div class="mx-auto mb-8 h-0.5 w-16 bg-[#5c5d4d]"></div>

                <p class="mx-auto max-w-2xl text-base leading-relaxed text-gray-600 italic md:text-lg">
                    "Rasakan pengalaman menginap yang tak terlupakan dengan perpaduan keramahan khas Yogyakarta dan fasilitas modern yang mewah."
                </p>

                <div class="mt-8">
                    <a
                        href="https://wa.me/6281287564433"
                        target="_blank"
                        class="inline-flex items-center gap-3 rounded-full bg-[#2d2e24] px-10 py-4 text-xs font-bold tracking-[0.15em] text-[#d4af37] uppercase transition-all duration-500 hover:bg-[#d4af37] hover:text-white hover:shadow-xl"
                    >
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
