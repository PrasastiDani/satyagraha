<template>
    <section class="bg-white py-16 shadow-inner">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-down">
                <h2 class="font-serif text-3xl md:text-4xl text-black mb-3">Fasilitas Kami</h2>
                <p class="font-serif text-gray-600 text-sm md:text-base font-medium">
                    Kami menawarkan fasilitas hotel modern untuk kenyamanan Anda.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                <div v-for="(facility, index) in facilities" :key="facility.name"
                    class="bg-satya-gold/30 border border-satya-gold/10 rounded-lg p-6 flex flex-col items-center justify-center group hover:bg-satya-dark transition-all duration-500 cursor-default"
                    data-aos="zoom-in-down" :data-aos-delay="index * 100">

                    <div class="mb-3 group-hover:text-satya-gold transition-colors duration-500">
                        <span class="material-symbols-outlined text-4xl text-satya-dark group-hover:text-satya-gold">
                            {{ facility.icon }}
                        </span>
                    </div>

                    <span class="text-satya-dark font-semibold text-base group-hover:text-satya-gold transition-colors duration-500 text-center">
                        {{ facility.name }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const facilities = [
    { name: 'Kolam Renang', icon: 'pool' },
    { name: 'Wifi', icon: 'wifi' },
    { name: 'Breakfast', icon: 'restaurant' },
    { name: 'Resepsionis 24/7', icon: 'notifications_active' },
    { name: 'Area Hijau', icon: 'park' },
    { name: 'Meeting Room', icon: 'groups' },
    { name: 'Ballroom', icon: 'architecture' },
    { name: 'Area Parkir', icon: 'local_parking' },
];
</script>
