<script setup>
const meetings = [
    {
        name: 'Satya Graha Ballroom',
        capacity: '500 Pax',
        image: 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=800',
        description: 'Ruang aula megah untuk pernikahan, seminar skala besar, dan acara korporat.'
    },
    {
        name: 'Mendut Meeting Room',
        capacity: '50 Pax',
        image: 'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?q=80&w=800',
        description: 'Ruang rapat formal dengan fasilitas multimedia lengkap untuk kebutuhan bisnis Anda.'
    }
];
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div
            v-for="(hall, index) in meetings"
            :key="hall.name"
            class="bg-white rounded-3xl overflow-hidden shadow-xl border border-satya-gold/20 group"
            data-aos="fade-up"
            :data-aos-delay="index * 200"
        >
            <div class="relative overflow-hidden h-72">
                <img
                    :src="hall.image"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    :alt="hall.name"
                />
            </div>
            <div class="p-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-serif text-2xl text-satya-dark">{{ hall.name }}</h3>
                    <span class="text-xs font-bold bg-satya-dark text-satya-gold px-4 py-1.5 rounded-full uppercase tracking-wider">
                        {{ hall.capacity }}
                    </span>
                </div>
                <p class="text-gray-600 mb-8 italic text-sm leading-relaxed">
                    {{ hall.description }}
                </p>
                <button class="w-full py-3 border-2 border-satya-dark text-satya-dark hover:bg-satya-dark hover:text-satya-gold transition-all duration-300 font-bold uppercase text-xs tracking-[0.2em]">
                    Hubungi Marketing
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
button {
    backface-visibility: hidden;
}
</style>
