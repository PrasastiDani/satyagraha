<script setup>
import { ref, onMounted } from 'vue';

const galleryImages = ref([
    { src: 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=600', alt: 'Lobi Hotel yang Elegan', category: 'Interior' },
    { src: 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=600', alt: 'Kamar Deluxe yang Nyaman', category: 'Kamar' },
    { src: 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?q=80&w=600', alt: 'Kolam Renang Outdoor', category: 'Fasilitas' },
    { src: 'https://images.unsplash.com/photo-1552566626-52f8b828add9?q=80&w=600', alt: 'Restoran yang Menawan', category: 'Fasilitas' },
    { src: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=600', alt: 'Eksterior Hotel Modern', category: 'Eksterior' },
    { src: 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=800', alt: 'Ruang Meeting & Ballroom', category: 'Meeting' },
    { src: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=600', alt: 'Detail Kamar Hotel', category: 'Kamar' },
    { src: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=600', alt: 'Lounge Santai', category: 'Interior' },
    { src: 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=600', alt: 'Pemandangan Kota dari Kamar', category: 'Kamar' },
]);

const categories = ['Semua', 'Kamar', 'Fasilitas', 'Meeting', 'Interior', 'Eksterior'];
const activeCategory = ref('Semua');
const filteredImages = ref([]);

const filterImages = (category) => {
    activeCategory.value = category;
    if (category === 'Semua') {
        filteredImages.value = galleryImages.value;
    } else {
        filteredImages.value = galleryImages.value.filter(img => img.category === category);
    }
};

// Lightbox Logic
const showLightbox = ref(false);
const currentImageIndex = ref(0);

const openLightbox = (index) => {
    currentImageIndex.value = index;
    showLightbox.value = true;
    document.body.style.overflow = 'hidden';
};

const closeLightbox = () => {
    showLightbox.value = false;
    document.body.style.overflow = '';
};

const navigateLightbox = (direction) => {
    let newIndex = currentImageIndex.value + direction;
    if (newIndex < 0) {
        newIndex = filteredImages.value.length - 1;
    } else if (newIndex >= filteredImages.value.length) {
        newIndex = 0;
    }
    currentImageIndex.value = newIndex;
};

onMounted(() => {
    filterImages('Semua');
});
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up">
            <button v-for="cat in categories" :key="cat"
                @click="filterImages(cat)"
                :class="['px-6 py-2 rounded-full text-sm font-bold uppercase transition',
                         activeCategory === cat ? 'bg-satya-dark text-satya-gold' : 'bg-satya-gold/20 text-satya-dark hover:bg-satya-gold/40']">
                {{ cat === 'Meeting' ? 'Meeting & Ballroom' : cat }}
            </button>
        </div>

        <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
            <div v-for="(image, index) in filteredImages" :key="index"
                 class="mb-4 break-inside-avoid"
                 data-aos="zoom-in" :data-aos-delay="index * 50">
                <div class="relative overflow-hidden rounded-lg shadow-lg group cursor-pointer" @click="openLightbox(index)">
                    <img :src="image.src" :alt="image.alt" loading="lazy"
                         class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-satya-dark/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                    </div>
                </div>
            </div>
        </div>

        <teleport to="body">
            <transition name="fade">
                <div v-if="showLightbox"
                     class="fixed inset-0 bg-black/90 z-[9999] flex items-center justify-center p-4"
                     @click.self="closeLightbox">

                    <button @click="closeLightbox" class="absolute top-6 right-6 text-white text-4xl hover:text-satya-gold transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <button @click="navigateLightbox(-1)" class="absolute left-6 text-white text-5xl hover:text-satya-gold transition-colors z-10">
                        <span class="material-symbols-outlined">arrow_back_ios</span>
                    </button>

                    <img :src="filteredImages[currentImageIndex].src"
                         :alt="filteredImages[currentImageIndex].alt"
                         class="max-w-[90vw] max-h-[90vh] object-contain rounded-lg shadow-2xl animate-fade-in" />

                    <button @click="navigateLightbox(1)" class="absolute right-6 text-white text-5xl hover:text-satya-gold transition-colors z-10">
                        <span class="material-symbols-outlined">arrow_forward_ios</span>
                    </button>
                </div>
            </transition>
        </teleport>
    </div>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>
