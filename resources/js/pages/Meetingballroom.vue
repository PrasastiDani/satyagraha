<script setup>
import { onMounted } from 'vue';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import TipeMeetingballroom from '@/components/meetingballroom/TipeMeetingballroom.vue';

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

        <section class="relative h-[45vh] flex items-center justify-center bg-satya-dark overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img
                    src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=1200"
                    class="w-full h-full object-cover opacity-50 scale-110 animate-slow-zoom"
                    alt="Meeting & Ballroom Header"
                >
            </div>

            <div class="relative z-10 text-center px-4" data-aos="zoom-in" data-aos-duration="1200">
                <h1 class="font-serif text-4xl md:text-5xl text-satya-gold uppercase tracking-[0.3em] mb-4 drop-shadow-lg">
                    Meeting & Ballroom
                </h1>
                <div class="w-24 h-1 bg-satya-gold mx-auto"></div>
            </div>
        </section>

        <main class="max-w-7xl mx-auto py-20 px-4 flex-grow">
            <TipeMeetingballroom />
        </main>

        <Footer />
    </div>
</template>

<style scoped>
.animate-slow-zoom {
    animation: slowZoom 20s infinite alternate linear;
}

@keyframes slowZoom {
    from { transform: scale(1); }
    to { transform: scale(1.15); }
}
</style>
