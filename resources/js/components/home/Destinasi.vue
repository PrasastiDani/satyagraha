<script setup>
const destinations = [
    {
        name: 'Jalan Malioboro',
        dist: '15 Menit',
        desc: 'Pusat belanja dan ikon budaya legendaris Yogyakarta.',
        image: 'https://images.unsplash.com/photo-1621236304191-37d4039806e3?q=80&w=800'
    },
    {
        name: 'Gembira Loka Zoo',
        dist: '5 Menit',
        desc: 'Kebun binatang edukatif terbesar di Jawa Tengah & DIY.',
        image: 'https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=800'
    },
    {
        name: 'Keraton Yogyakarta',
        dist: '12 Menit',
        desc: 'Istana resmi Kesultanan Ngayogyakarta Hadiningrat.',
        image: 'https://images.unsplash.com/photo-1584810359583-96fc3448beaa?q=80&w=800'
    }
];
</script>

<template>
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="font-serif text-4xl text-[#5c5d4d] uppercase tracking-[0.3em] mb-4">Destinasi Terdekat</h2>
                <div class="w-16 h-0.5 bg-[#d4af37] mx-auto mb-6"></div>
                <p class="text-gray-400 max-w-xl mx-auto text-sm italic tracking-wide">
                    Lokasi strategis kami memudahkan Anda menjangkau berbagai ikon wisata populer.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div v-for="(place, index) in destinations" :key="index"
                     class="group relative h-[500px] rounded-[2.5rem] overflow-hidden shadow-xl transition-all duration-700 hover:shadow-2xl hover:-translate-y-4"
                     data-aos="fade-up" :data-aos-delay="index * 200">

                    <img :src="place.image" :alt="place.name"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent transition-opacity duration-500 group-hover:from-black/90"></div>

                    <div class="absolute inset-0 p-10 flex flex-col justify-end">
                        <div class="flex items-center gap-2 mb-4 bg-black/30 backdrop-blur-sm self-start px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-[#d4af37] text-sm">distance</span>
                            <span class="text-[#d4af37] text-[10px] font-black uppercase tracking-widest">{{ place.dist }} Dari Hotel</span>
                        </div>
                        <h4 class="text-white text-3xl font-serif mb-4 tracking-wide">{{ place.name }}</h4>
                        <p class="text-gray-300 text-sm leading-relaxed opacity-0 translate-y-8 transition-all duration-500 group-hover:opacity-100 group-hover:translate-y-0">
                            {{ place.desc }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-20 text-center">
                <a href="https://maps.google.com" target="_blank"
                   class="inline-flex items-center gap-3 text-[#5c5d4d] font-bold uppercase text-xs tracking-[0.4em] group">
                    <span class="material-symbols-outlined text-xl group-hover:animate-bounce">location_on</span>
                    <span class="border-b-2 border-[#d4af37] pb-1">Buka di Google Maps</span>
                </a>
            </div>
        </div>
    </section>
</template>

<style scoped>
.transition-all {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

@media (max-width: 768px) {
    .grid-cols-1 {
        padding: 0 10px;
    }
}
</style>
