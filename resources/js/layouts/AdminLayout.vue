<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

defineProps({
    title: {
        type: String,
        default: 'Admin Panel',
    },
    description: {
        type: String,
        default: null,
    },
});

const page = usePage();

const mobileSidebarOpen = ref(false);
const sidebarCollapsed = ref(false);

const menus = [
    {
        label: 'Dashboard',
        href: '/admin/dashboard',
        icon: 'dashboard',
        exact: true,
    },

    // Contoh menu berikutnya:
    // {
    //     label: 'Kamar',
    //     href: '/admin/rooms',
    //     icon: 'bed',
    // },
    // {
    //     label: 'Fasilitas',
    //     href: '/admin/facilities',
    //     icon: 'pool',
    // },
    // {
    //     label: 'Pesan',
    //     href: '/admin/messages',
    //     icon: 'mail',
    // },
];

const currentUrl = computed(() => {
    return page.url.split('?')[0];
});

const authUser = computed(() => {
    return page.props.auth?.user ?? null;
});

const userName = computed(() => {
    return authUser.value?.name ?? 'Administrator';
});

const userRole = computed(() => {
    return authUser.value?.role?.name ?? 'Admin';
});

const userInitials = computed(() => {
    return userName.value
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((name) => name.charAt(0))
        .join('')
        .toUpperCase();
});

const isActive = (menu) => {
    if (menu.exact) {
        return currentUrl.value === menu.href;
    }

    return currentUrl.value === menu.href || currentUrl.value.startsWith(`${menu.href}/`);
};

const toggleMobileSidebar = () => {
    mobileSidebarOpen.value = !mobileSidebarOpen.value;
};

const closeMobileSidebar = () => {
    mobileSidebarOpen.value = false;
};

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

const logout = () => {
    closeMobileSidebar();

    router.post(
        '/admin/logout',
        {},
        {
            preserveScroll: true,
        },
    );
};

/*
 * Tutup drawer mobile otomatis ketika berpindah halaman.
 */
watch(currentUrl, () => {
    closeMobileSidebar();
});
</script>

<template>
    <div class="min-h-screen bg-[#f7f7f4] text-gray-800">
        <!-- Mobile overlay -->
        <Transition
            enter-active-class="transition-opacity duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <button
                v-if="mobileSidebarOpen"
                type="button"
                aria-label="Tutup menu"
                class="fixed inset-0 z-40 bg-black/50 backdrop-blur-[2px] lg:hidden"
                @click="closeMobileSidebar"
            />
        </Transition>

        <!-- Sidebar -->
        <aside
            class="bg-satya-dark fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-white/10 text-white shadow-2xl transition-all duration-300"
            :class="[mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0', sidebarCollapsed ? 'lg:w-24' : 'lg:w-72']"
        >
            <!-- Sidebar header -->
            <div
                class="flex h-24 shrink-0 items-center border-b border-white/10 px-5"
                :class="sidebarCollapsed ? 'lg:justify-center' : 'justify-between'"
            >
                <Link href="/admin/dashboard" class="flex min-w-0 items-center gap-3" @click="closeMobileSidebar">
                    <div
                        class="bg-satya-gold text-satya-dark flex size-11 shrink-0 items-center justify-center rounded-2xl shadow-lg shadow-black/20"
                    >
                        <span class="material-symbols-outlined text-2xl"> apartment </span>
                    </div>

                    <div v-show="!sidebarCollapsed" class="min-w-0 lg:block">
                        <h2 class="text-satya-gold truncate font-serif text-lg tracking-[0.16em] uppercase">Satya Graha</h2>

                        <p class="mt-1 text-[9px] font-bold tracking-[0.24em] text-gray-400 uppercase">Hotel Management</p>
                    </div>
                </Link>

                <!-- Close mobile -->
                <button
                    type="button"
                    aria-label="Tutup sidebar"
                    class="flex size-9 items-center justify-center rounded-xl text-gray-400 transition hover:bg-white/10 hover:text-white lg:hidden"
                    @click="closeMobileSidebar"
                >
                    <span class="material-symbols-outlined"> close </span>
                </button>
            </div>

            <!-- Navigation -->
            <div class="flex min-h-0 flex-1 flex-col px-4 py-6">
                <div v-show="!sidebarCollapsed" class="mb-3 px-3">
                    <p class="text-[9px] font-black tracking-[0.22em] text-gray-500 uppercase">Main Menu</p>
                </div>

                <nav class="flex-1 space-y-2 overflow-y-auto">
                    <Link
                        v-for="menu in menus"
                        :key="menu.href"
                        :href="menu.href"
                        :title="sidebarCollapsed ? menu.label : undefined"
                        class="group relative flex min-h-12 items-center rounded-2xl transition-all duration-200"
                        :class="[
                            sidebarCollapsed ? 'lg:justify-center lg:px-0' : 'gap-3 px-3',

                            isActive(menu)
                                ? 'text-satya-gold bg-white/10 shadow-inner shadow-white/5'
                                : 'text-gray-400 hover:bg-white/5 hover:text-white',
                        ]"
                        @click="closeMobileSidebar"
                    >
                        <span v-if="isActive(menu)" class="bg-satya-gold absolute inset-y-3 left-0 w-1 rounded-r-full" />

                        <div
                            class="flex size-9 shrink-0 items-center justify-center rounded-xl transition"
                            :class="isActive(menu) ? 'bg-satya-gold/15 text-satya-gold' : 'bg-white/5 group-hover:bg-white/10'"
                        >
                            <span class="material-symbols-outlined text-[20px]">
                                {{ menu.icon }}
                            </span>
                        </div>

                        <span v-show="!sidebarCollapsed" class="truncate text-[11px] font-bold tracking-[0.13em] uppercase">
                            {{ menu.label }}
                        </span>
                    </Link>
                </nav>

                <!-- Website link -->
                <div class="mt-5 border-t border-white/10 pt-5">
                    <Link
                        href="/"
                        title="Lihat Website"
                        class="group flex min-h-12 items-center rounded-2xl text-gray-400 transition hover:bg-white/5 hover:text-white"
                        :class="sidebarCollapsed ? 'lg:justify-center' : 'gap-3 px-3'"
                    >
                        <div class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-white/5 transition group-hover:bg-white/10">
                            <span class="material-symbols-outlined text-[20px]"> language </span>
                        </div>

                        <span v-show="!sidebarCollapsed" class="text-[11px] font-bold tracking-[0.13em] uppercase"> Lihat Website </span>
                    </Link>
                </div>
            </div>

            <!-- Sidebar footer -->
            <div class="border-t border-white/10 p-4">
                <div class="rounded-2xl bg-white/[0.06] p-3" :class="sidebarCollapsed ? 'lg:p-2' : ''">
                    <div class="flex items-center" :class="sidebarCollapsed ? 'lg:justify-center' : 'gap-3'">
                        <div class="bg-satya-gold text-satya-dark flex size-10 shrink-0 items-center justify-center rounded-xl text-xs font-black">
                            {{ userInitials }}
                        </div>

                        <div v-show="!sidebarCollapsed" class="min-w-0 flex-1">
                            <p class="truncate text-xs font-bold text-white">
                                {{ userName }}
                            </p>

                            <p class="mt-0.5 truncate text-[10px] text-gray-400">
                                {{ userRole }}
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        title="Logout"
                        class="mt-3 flex w-full items-center rounded-xl text-red-400 transition hover:bg-red-500/10 hover:text-red-300"
                        :class="sidebarCollapsed ? 'justify-center p-2' : 'gap-3 px-3 py-2.5'"
                        @click="logout"
                    >
                        <span class="material-symbols-outlined text-[19px]"> logout </span>

                        <span v-show="!sidebarCollapsed" class="text-[10px] font-bold tracking-[0.15em] uppercase"> Logout </span>
                    </button>
                </div>
            </div>

            <!-- Desktop collapse button -->
            <button
                type="button"
                :aria-label="sidebarCollapsed ? 'Perbesar sidebar' : 'Perkecil sidebar'"
                class="bg-satya-dark hover:text-satya-gold absolute top-28 -right-3 hidden size-7 items-center justify-center rounded-full border border-white/10 text-gray-400 shadow-lg transition lg:flex"
                @click="toggleSidebar"
            >
                <span class="material-symbols-outlined text-base">
                    {{ sidebarCollapsed ? 'keyboard_arrow_right' : 'keyboard_arrow_left' }}
                </span>
            </button>
        </aside>

        <!-- Page wrapper -->
        <div class="min-h-screen transition-[padding] duration-300" :class="sidebarCollapsed ? 'lg:pl-24' : 'lg:pl-72'">
            <!-- Mobile topbar -->
            <header
                class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-gray-200/80 bg-white/90 px-4 backdrop-blur-xl lg:hidden"
            >
                <button
                    type="button"
                    aria-label="Buka menu"
                    class="flex size-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 shadow-sm transition hover:bg-gray-50"
                    @click="toggleMobileSidebar"
                >
                    <span class="material-symbols-outlined"> menu </span>
                </button>

                <div class="text-center">
                    <p class="text-satya-dark font-serif text-sm tracking-[0.14em] uppercase">Satya Graha</p>

                    <p class="text-[8px] font-bold tracking-[0.18em] text-gray-400 uppercase">Admin Panel</p>
                </div>

                <div class="bg-satya-dark text-satya-gold flex size-10 items-center justify-center rounded-xl text-xs font-bold">
                    {{ userInitials }}
                </div>
            </header>

            <!-- Main content -->
            <main class="px-4 py-6 sm:px-6 lg:px-10 lg:py-9">
                <div class="mx-auto w-full max-w-[1600px]">
                    <!-- Page header -->
                    <header class="mb-7 rounded-[1.75rem] border border-gray-200/70 bg-white px-5 py-5 shadow-sm sm:px-7 sm:py-6">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <div class="mb-2 flex items-center gap-2">
                                    <span class="bg-satya-gold block h-1.5 w-8 rounded-full" />

                                    <span class="text-[9px] font-black tracking-[0.2em] text-gray-400 uppercase"> Administration </span>
                                </div>

                                <h1 class="text-satya-dark font-serif text-xl tracking-[0.08em] uppercase sm:text-2xl">
                                    {{ title }}
                                </h1>

                                <p v-if="description" class="mt-2 max-w-2xl text-xs leading-relaxed text-gray-400 sm:text-sm">
                                    {{ description }}
                                </p>
                            </div>

                            <div class="flex shrink-0 items-center gap-3">
                                <slot name="header-action">
                                    <Link
                                        href="/"
                                        class="border-satya-gold text-satya-gold hover:bg-satya-gold inline-flex min-h-10 items-center justify-center gap-2 rounded-xl border px-4 text-[9px] font-black tracking-[0.14em] uppercase transition hover:text-white"
                                    >
                                        <span class="material-symbols-outlined text-base"> open_in_new </span>

                                        <span class="hidden sm:inline"> Lihat Website </span>
                                    </Link>
                                </slot>
                            </div>
                        </div>
                    </header>

                    <!-- Page content -->
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
