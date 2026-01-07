<template>
    <footer class="bg-satya-dark text-satya-gold pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-12">

                <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="col-span-1">
                        <div class="flex items-center gap-3 mb-6">
                            <img class="h-14 w-auto" src="/images/logo.svg" alt="Satya Graha Logo">
                            <div class="flex flex-col">
                                <span class="font-serif text-xl font-bold tracking-wide leading-none uppercase">
                                    Satya Graha
                                </span>
                                <span class="text-[0.6rem] tracking-[0.2em] uppercase font-semibold opacity-80">
                                    Yogyakarta
                                </span>
                            </div>
                        </div>
                        <p class="text-sm leading-relaxed opacity-80 font-serif">
                            Menghadirkan harmoni antara tradisi Yogyakarta dan kenyamanan modern untuk pengalaman
                            menginap yang tak terlupakan.
                        </p>

                        <div class="flex gap-4 mt-6">
                            <a href="https://www.instagram.com/satyagrahahotel/" target="_blank"
                                class="w-8 h-8 border border-satya-gold/30 rounded-full flex items-center justify-center hover:bg-satya-gold hover:text-satya-dark transition text-xs">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/share/1AVEoF7V75/"
                                class="w-8 h-8 border border-satya-gold/30 rounded-full flex items-center justify-center hover:bg-satya-gold hover:text-satya-dark transition text-xs">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.tiktok.com/@satyagraha_hotel" target="_blank"
                                class="w-8 h-8 border border-satya-gold/30 rounded-full flex items-center justify-center hover:bg-satya-gold hover:text-satya-dark transition text-xs">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-span-1">
                        <h4
                            class="font-serif text-lg font-bold mb-6 border-b border-satya-gold/20 pb-2 inline-block uppercase tracking-wider">
                            Kontak Kami
                        </h4>
                        <ul class="space-y-4 text-sm opacity-90">
                            <li class="flex items-start gap-3">
                                <span class="font-bold min-w-[60px]">Alamat:</span>
                                <span>Jl. Veteran No.147, Pandeyan, Kec. Umbulharjo, Kota Yogyakarta</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="font-bold min-w-[60px]">Telepon:</span>
                                <span>+62 812-8756-4433</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="font-bold min-w-[60px]">Email:</span>
                                <span class="break-all">backofficesatyagraha@gmail.com</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="lg:col-span-5 h-[250px] lg:h-full min-h-[250px]">
                    <div
                        class="w-full h-full rounded-lg overflow-hidden border border-satya-gold/20 shadow-lg grayscale-[20%] hover:grayscale-0 transition-all duration-500">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.756716951851!2d110.38522497358092!3d-7.815556877605423!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a576ef5edfaab%3A0x37b1340cfdfeacc1!2sSatya%20Graha%20Hotel!5e0!3m2!1sid!2sid!4v1767324236770!5m2!1sid!2sid"
                            class="w-full h-full border-0" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>

            <div
                class="border-t border-satya-gold/10 pt-8 text-center text-[10px] md:text-xs opacity-60 tracking-[0.2em] uppercase">
                <p>&copy; {{ new Date().getFullYear() }} Satya Graha Hotel Yogyakarta. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<style scoped>
footer {
    -webkit-font-smoothing: antialiased;
}
</style>
