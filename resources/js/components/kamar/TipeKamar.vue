<script setup>
const rooms = [
    {
        name: 'Deluxe Lt. 1',
        image: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=800',
        features: ['1 Bed', 'Free Wifi', 'Shower'],
        description: 'Kamar nyaman dengan fasilitas lengkap untuk perjalanan bisnis atau liburan singkat Anda.'
    },
    {
        name: 'Deluxe Lt. 2',
        image: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=800',
        features: ['Large Bed', 'Free Wifi', 'City View'],
        description: 'Nikmati kenyamanan ekstra dengan ruang yang lebih luas dan pemandangan kota Yogyakarta.'
    },
    {
        name: 'Superior',
        image: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=800',
        features: ['King Bed', 'Bathtub', 'Living Area'],
        description: 'Kemewahan terbaik kami dengan ruang tamu terpisah dan fasilitas premium yang memanjakan.'
    },
    {
        name: 'Family Room',
        image: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=800',
        features: ['1 Bed', 'Air Conditioning', 'TV'],
        description: 'Kamar ideal untuk keluarga dengan ruang yang cukup dan fasilitas yang ramah anak.'
    }
];
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div v-for="(room, index) in rooms" :key="index"
             class="bg-white rounded-2xl overflow-hidden shadow-lg border border-satya-gold/20 group"
             data-aos="fade-up" :data-aos-delay="index * 150">

            <div class="relative h-64 overflow-hidden">
                <img :src="room.image" :alt="room.name"
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            </div>

            <div class="p-8">
                <h3 class="font-serif text-2xl text-satya-dark mb-3 capitalize">{{ room.name }}</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                    {{ room.description }}
                </p>

                <div class="flex flex-wrap gap-3 mb-8">
                    <span v-for="feat in room.features" :key="feat"
                          class="flex items-center text-[10px] uppercase tracking-wider bg-satya-gold/30 px-3 py-1 rounded text-satya-dark font-bold">
                        <span class="material-symbols-outlined text-xs mr-1">check_circle</span>
                        {{ feat }}
                    </span>
                </div>

                <button class="w-full py-3 bg-satya-dark text-satya-gold rounded-lg font-bold uppercase tracking-widest transition-all hover:bg-satya-accent">
                    Informasi Lebih Lanjut
                </button>
            </div>
        </div>
    </div>
</template>
