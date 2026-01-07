<template>
    <div class="relative w-full overflow-hidden bg-gray-100">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">

                <div class="swiper-slide relative">
                    <img src="/images/hero/1.png" class="w-full h-auto" alt="Satya Graha Lobby">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <div class="text-center text-satya-gold px-4">
                            <h2 class="font-serif text-5xl md:text-7xl mb-4 opacity-0 animate-fadeIn">
                                Kenyamanan Klasik
                            </h2>
                            <p class="text-lg md:text-xl tracking-[0.3em] uppercase opacity-0 animate-fadeInDelay">
                                Sentuhan Tradisional di Jantung Yogyakarta
                            </p>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide relative">
                    <img src="/images/hero/2.png" class="w-full h-auto" alt="Satya Graha Suite">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <div class="text-center text-satya-gold px-4">
                            <h2 class="font-serif text-5xl md:text-7xl mb-4 opacity-0 animate-fadeIn">
                                Kemewahan Menginap
                            </h2>
                            <p class="text-lg md:text-xl tracking-[0.3em] uppercase opacity-0 animate-fadeInDelay">
                                Kamar dengan Fasilitas Terbaik
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- <div class="swiper-pagination"></div>
            <div class="swiper-button-next !text-satya-gold hidden md:flex"></div>
            <div class="swiper-button-prev !text-satya-gold hidden md:flex"></div> -->
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';

onMounted(() => {
    if (typeof Swiper !== 'undefined') {
        new Swiper(".mySwiper", {
            loop: true,
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    }
});
</script>

<style scoped>
:deep(.swiper-pagination-bullet) {
    background: #ffffff;
    opacity: 0.5;
}

:deep(.swiper-pagination-bullet-active) {
    background-color: #F4F2D9 !important;
    opacity: 1;
    width: 25px;
    border-radius: 4px;
    transition: all 0.3s;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 1.2s ease-out forwards;
}

.animate-fadeInDelay {
    animation: fadeIn 1.2s ease-out forwards 0.6s;
}

:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
    transform: scale(0.7);
    margin: 0 20px;
}
</style>
