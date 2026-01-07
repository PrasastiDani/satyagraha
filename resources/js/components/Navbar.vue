<template>
    <nav class="bg-satya-gold/30 backdrop-blur-md sticky top-0 z-50 border-b border-satya-dark/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <Link href="/" class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                    <img class="h-12 w-auto" src="/images/logo.svg" alt="Satya Graha Logo">

                    <div class="flex flex-col">
                        <span class="font-serif text-xl font-bold text-satya-dark tracking-wide leading-none">
                            SATYA GRAHA HOTEL
                        </span>
                        <span class="text-[0.65rem] text-satya-accent tracking-[0.2em] uppercase font-semibold">
                            Yogyakarta
                        </span>
                    </div>
                </Link>

                <div class="hidden md:flex space-x-8">
                    <Link href="/" :class="[
                        'text-satya-dark hover:text-black font-serif font-medium transition duration-300 relative group',
                        { 'text-black': isActive('home') }
                    ]">
                        Beranda
                        <span :class="[
                            'absolute -bottom-1 left-0 h-0.5 bg-satya-dark transition-all',
                            isActive('home') ? 'w-full' : 'w-0 group-hover:w-full'
                        ]"></span>
                    </Link>

                    <Link href="/kamar" :class="[
                        'text-satya-dark hover:text-black font-serif font-medium transition duration-300 relative group',
                        { 'text-black': isActive('kamar') }
                    ]">
                        Kamar
                        <span :class="[
                            'absolute -bottom-1 left-0 h-0.5 bg-satya-dark transition-all',
                            isActive('kamar') ? 'w-full' : 'w-0 group-hover:w-full'
                        ]"></span>
                    </Link>

                    <Link href="/meetingballroom" :class="[
                        'text-satya-dark hover:text-black font-serif font-medium transition duration-300 relative group',
                        { 'text-black': isActive('meetingballroom') }
                    ]">
                        Meeting & Ballroom
                        <span :class="[
                            'absolute -bottom-1 left-0 h-0.5 bg-satya-dark transition-all',
                            isActive('meetingballroom') ? 'w-full' : 'w-0 group-hover:w-full'
                        ]"></span>
                    </Link>

                    <Link href="/fasilitas" :class="[
                        'text-satya-dark hover:text-black font-serif font-medium transition duration-300 relative group',
                        { 'text-black': isActive('fasilitas') }
                    ]">
                        Fasilitas
                        <span :class="[
                            'absolute -bottom-1 left-0 h-0.5 bg-satya-dark transition-all',
                            isActive('fasilitas') ? 'w-full' : 'w-0 group-hover:w-full'
                        ]"></span>
                    </Link>

                    <Link href="/galeri" :class="[
                        'text-satya-dark hover:text-black font-serif font-medium transition duration-300 relative group',
                        { 'text-black': isActive('galeri') }
                    ]">
                        Galeri
                        <span :class="[
                            'absolute -bottom-1 left-0 h-0.5 bg-satya-dark transition-all',
                            isActive('galeri') ? 'w-full' : 'w-0 group-hover:w-full'
                        ]"></span>
                    </Link>

                    <Link href="/kontak" :class="[
                        'text-satya-dark hover:text-black font-serif font-medium transition duration-300 relative group',
                        { 'text-black': isActive('kontak') }
                    ]">
                        Kontak
                        <span :class="[
                            'absolute -bottom-1 left-0 h-0.5 bg-satya-dark transition-all',
                            isActive('kontak') ? 'w-full' : 'w-0 group-hover:w-full'
                        ]"></span>
                    </Link>
                </div>

                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-satya-dark focus:outline-none p-2">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Menu -->
            <div v-show="mobileMenuOpen" class="md:hidden pb-4 space-y-2">
                <Link href="/" :class="[
                    'block px-3 py-2 rounded-md text-satya-dark hover:bg-satya-gold/20 font-serif font-medium transition',
                    { 'bg-satya-gold/30': isActive('home') }
                ]" @click="mobileMenuOpen = false">
                    Beranda
                </Link>
                <Link href="/kamar" :class="[
                    'block px-3 py-2 rounded-md text-satya-dark hover:bg-satya-gold/20 font-serif font-medium transition',
                    { 'bg-satya-gold/30': isActive('kamar') }
                ]" @click="mobileMenuOpen = false">
                    Kamar
                </Link>
                <Link href="/meetingballroom" :class="[
                    'block px-3 py-2 rounded-md text-satya-dark hover:bg-satya-gold/20 font-serif font-medium transition',
                    { 'bg-satya-gold/30': isActive('meetingballroom') }
                ]" @click="mobileMenuOpen = false">
                    Meeting Ballroom
                </Link>
                <Link href="/fasilitas" :class="[
                    'block px-3 py-2 rounded-md text-satya-dark hover:bg-satya-gold/20 font-serif font-medium transition',
                    { 'bg-satya-gold/30': isActive('fasilitas') }
                ]" @click="mobileMenuOpen = false">
                    Fasilitas
                </Link>
                <Link href="/galeri" :class="[
                    'block px-3 py-2 rounded-md text-satya-dark hover:bg-satya-gold/20 font-serif font-medium transition',
                    { 'bg-satya-gold/30': isActive('galeri') }
                ]" @click="mobileMenuOpen = false">
                    Galeri
                </Link>
                <Link href="/kontak" :class="[
                    'block px-3 py-2 rounded-md text-satya-dark hover:bg-satya-gold/20 font-serif font-medium transition',
                    { 'bg-satya-gold/30': isActive('kontak') }
                ]" @click="mobileMenuOpen = false">
                    Kontak
                </Link>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const mobileMenuOpen = ref(false);
const page = usePage();

const isActive = (routeName) => {
    return computed(() => {
        const currentRoute = page.url;

        if (routeName === 'home') {
            return currentRoute === '/';
        }

        return currentRoute.startsWith(`/${routeName}`);
    }).value;
};
</script>
