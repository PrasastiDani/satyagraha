<template>
    <section class="py-16 bg-white text-satya-dark overflow-hidden border-t border-satya-gold/20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-10" data-aos="fade-up">
                <h2 class="font-serif text-2xl md:text-3xl text-satya-dark mb-3 uppercase tracking-widest">Apa Kata
                    Mereka</h2>
                <div class="w-16 h-1 bg-satya-accent mx-auto mb-5"></div>
                <p class="text-gray-600 max-w-xl mx-auto italic text-sm md:text-base">
                    Kepuasan Anda adalah kebahagiaan kami. Berikut adalah pengalaman tulus dari para tamu setia Satya
                    Graha.
                </p>
            </div>

            <div class="swiper testimoniSwiper pb-10" data-aos="zoom-in">
                <div class="swiper-wrapper">
                    <div v-for="(review, index) in testimonials" :key="index" class="swiper-slide h-auto p-2">
                        <div
                            class="bg-satya-gold/60 border border-satya-gold/30 p-6 rounded-xl h-full flex flex-col items-center text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">

                            <div
                                class="w-16 h-16 rounded-full mb-3 border-2 border-satya-accent bg-white flex items-center justify-center shadow-sm">
                                <span class="text-xl font-bold text-satya-dark uppercase tracking-tighter">
                                    {{ getInitials(review.name) }}
                                </span>
                            </div>

                            <div class="flex gap-1 mb-3 text-orange-400">
                                <span v-for="star in 5" :key="star"
                                    class="material-symbols-outlined text-xs filled-star">
                                    star
                                </span>
                            </div>

                            <p class="text-gray-700 text-sm leading-relaxed mb-4 italic flex-grow">
                                "{{ review.comment }}"
                            </p>

                            <div class="mt-auto">
                                <h4 class="font-bold text-satya-dark text-sm uppercase tracking-wider">{{ review.name }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted } from 'vue';

const getInitials = (name) => {
    const names = name.split(' ');
    if (names.length >= 2) return (names[0][0] + names[1][0]).toUpperCase();
    return names[0][0].toUpperCase();
};

const testimonials = [
    {
        name: "asya scarf",
        rating: 5,
        comment: "Lokasi strategis, parkiran luas, ada kolam renang, pojok baca, harga ekonomis, pelayanan ramah, ruang rapat luas, AC dingin, air panas ada",
    },
    {
        name: "Muna Wisnu",
        rating: 5,
        comment: "Pelayanan yang sangat memuaskan. Suami saya ketinggalan barangnya, langsung direspon pihak hotel. Dan lgsng bersedia mengirimkan ke alamat kami. Pokoknya jooss",
    },
    {
        name: "Kiki Aptisa",
        rating: 5,
        comment: "Kamar Bersih nyaman, kamar mandi bersih, puas banget menginap disini Kolam renang pun ada",
    },
    {
        name: "asasi e store",
        rating: 5,
        comment: "Pas banget buat kamu yang memerlukan penginapan di tengah kota Jogja dengan harga yang terjangkau Tidak jauh dr Malioboro, alun2 xt square, Gembiraloka",
    }
];

onMounted(() => {
    if (typeof Swiper !== 'undefined') {
        new Swiper(".testimoniSwiper", {
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            slidesPerView: 1,
            spaceBetween: 16,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    }
});
</script>

<style scoped>
.testimoniSwiper {
    padding-bottom: 50px !important;
}

.filled-star {
    font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 20;
}

:deep(.swiper-pagination-bullet) {
    background: #5E604F;
    opacity: 0.2;
}

:deep(.swiper-pagination-bullet-active) {
    background: #8C8E75 !important;
    opacity: 1;
    width: 16px;
    border-radius: 10px;
    transition: all 0.3s;
}
</style>
