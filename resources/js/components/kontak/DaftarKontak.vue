<script setup>
const phoneContacts = [
    {
        title: '.',
        name: 'Official Marketing',
        whatsapp: '6281287564433',
        icon: 'hub'
    },
    {
        title: 'LAYANAN 24 JAM',
        name: 'Front Office',
        whatsapp: '6285117840147',
        icon: 'table_restaurant'
    },
    {
        title: '.',
        name: 'Guest Relation',
        whatsapp: '6285117670147',
        icon: 'support_agent'
    }
];

const emailContacts = [
    {
        title: 'Email Marketing',
        email: 'satyagrahaofficialmarketing@gmail.com',
        icon: 'mail_lock',
        desc: 'Untuk proposal, kerjasama, dan reservasi grup.'
    },
    {
        title: 'Email Administrasi',
        email: 'backofficesatyagraha@gmail.com',
        icon: 'mark_as_unread',
        desc: 'Untuk korespondensi resmi dan dokumen kantor.'
    }
];
</script>

<template>
    <div class="space-y-24">
        <section>
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-serif text-3xl text-satya-dark uppercase tracking-widest mb-4">Layanan Telepon & WhatsApp</h2>
                <div class="w-20 h-0.5 bg-satya-gold mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div v-for="(card, index) in phoneContacts" :key="index"
                    class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-gray-100 p-10 flex flex-col items-center text-center transition-all duration-500 hover:shadow-2xl hover:-translate-y-2"
                    data-aos="fade-up" :data-aos-delay="index * 150">

                    <div class="mb-8 h-20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl text-satya-gold/30 font-light">
                            {{ card.icon }}
                        </span>
                    </div>

                    <div class="flex-grow space-y-2 mb-8">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold min-h-[1rem]">
                            {{ card.title }}
                        </p>
                        <h3 class="text-2xl font-bold text-gray-700 tracking-tight">
                            {{ card.name }}
                        </h3>
                    </div>

                    <a :href="`https://wa.me/${card.whatsapp}`" target="_blank"
                        class="w-full py-4 bg-[#25D366] text-white rounded-xl text-xs font-black uppercase tracking-[0.2em] shadow-lg shadow-green-200 hover:bg-green-600 transition-all flex items-center justify-center gap-2">
                        WhatsApp Chat
                    </a>
                </div>
            </div>
        </section>

        <section>
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-serif text-3xl text-satya-dark uppercase tracking-widest mb-4">Korespondensi Email</h2>
                <div class="w-20 h-0.5 bg-satya-gold mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto">
                <div v-for="(item, index) in emailContacts" :key="index"
                    class="bg-satya-dark rounded-[2rem] p-12 flex flex-col items-center text-center border-b-8 border-satya-gold shadow-2xl transition-all duration-500 hover:scale-[1.02]"
                    data-aos="zoom-in" :data-aos-delay="index * 200">

                    <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-satya-gold text-4xl font-light">{{ item.icon }}</span>
                    </div>

                    <h3 class="font-serif text-satya-gold text-2xl mb-4 tracking-wide">{{ item.title }}</h3>
                    <p class="text-gray-400 text-sm mb-8 italic max-w-xs leading-relaxed">{{ item.desc }}</p>

                    <a :href="`mailto:${item.email}`"
                        class="text-white font-medium hover:text-satya-gold transition-colors break-all text-sm border-b border-white/20 pb-2 tracking-wider">
                        {{ item.email }}
                    </a>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.material-symbols-outlined {
    transition: transform 0.3s ease;
}

/* Parent selector hack for hover effect on icon */
div:hover .material-symbols-outlined {
    transform: scale(1.1);
}
</style>
