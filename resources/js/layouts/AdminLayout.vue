<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, reactive, ref, watch } from 'vue';

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

    {
        key: 'karier',
        label: 'Karier',
        icon: 'business_center',
        children: [
            {
                label: 'Departemen',
                href: '/admin/departments',
                icon: 'account_tree',
            },
            {
                label: 'Tipe Pekerjaan',
                href: '/admin/employment-types',
                icon: 'schedule',
            },
            {
                label: 'Lowongan Kerja',
                href: '/admin/job-vacancies',
                icon: 'work_outline',
            },
        ],
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

const openMenus = reactive({
    karier: false,
});

const currentUrl = computed(() => {
    return page.url.split('?')[0];
});

const isLinkActive = (menu) => {
    if (!menu.href) {
        return false;
    }

    if (menu.exact) {
        return currentUrl.value === menu.href;
    }

    return currentUrl.value === menu.href || currentUrl.value.startsWith(`${menu.href}/`);
};

const isGroupActive = (menu) => {
    return menu.children?.some((child) => isLinkActive(child)) ?? false;
};

const syncOpenMenu = () => {
    menus.forEach((menu) => {
        if (menu.children && isGroupActive(menu)) {
            openMenus[menu.key] = true;
        }
    });
};

const toggleMenu = (menu) => {
    /*
     * Jika sidebar sedang kecil, klik menu akan memperbesar
     * sidebar terlebih dahulu sekaligus membuka dropdown.
     */
    if (sidebarCollapsed.value) {
        sidebarCollapsed.value = false;
        openMenus[menu.key] = true;

        return;
    }

    openMenus[menu.key] = !openMenus[menu.key];
};

syncOpenMenu();

watch(currentUrl, () => {
    syncOpenMenu();
    closeMobileSidebar();
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

                <nav class="flex-1 space-y-2 overflow-x-hidden overflow-y-auto">
                    <template v-for="menu in menus" :key="menu.key ?? menu.href">
                        <!-- Menu biasa -->
                        <Link
                            v-if="!menu.children"
                            :href="menu.href"
                            :title="sidebarCollapsed ? menu.label : undefined"
                            class="group relative flex min-h-12 items-center rounded-2xl transition-all duration-200"
                            :class="[
                                sidebarCollapsed ? 'lg:justify-center lg:px-0' : 'gap-3 px-3',

                                isLinkActive(menu)
                                    ? 'text-satya-gold bg-white/10 shadow-inner shadow-white/5'
                                    : 'text-gray-400 hover:bg-white/5 hover:text-white',
                            ]"
                            @click="closeMobileSidebar"
                        >
                            <span v-if="isLinkActive(menu)" class="bg-satya-gold absolute inset-y-3 left-0 w-1 rounded-r-full" />

                            <div
                                class="flex size-9 shrink-0 items-center justify-center rounded-xl transition"
                                :class="isLinkActive(menu) ? 'bg-satya-gold/15 text-satya-gold' : 'bg-white/5 group-hover:bg-white/10'"
                            >
                                <span class="material-symbols-outlined text-[20px]">
                                    {{ menu.icon }}
                                </span>
                            </div>

                            <span class="truncate text-[11px] font-bold tracking-[0.13em] uppercase" :class="{ 'lg:hidden': sidebarCollapsed }">
                                {{ menu.label }}
                            </span>
                        </Link>

                        <!-- Menu dropdown -->
                        <div v-else>
                            <button
                                type="button"
                                :title="sidebarCollapsed ? menu.label : undefined"
                                class="group relative flex min-h-12 w-full items-center rounded-2xl transition-all duration-200"
                                :class="[
                                    sidebarCollapsed ? 'lg:justify-center lg:px-0' : 'gap-3 px-3',

                                    isGroupActive(menu) ? 'text-satya-gold bg-white/10' : 'text-gray-400 hover:bg-white/5 hover:text-white',
                                ]"
                                @click="toggleMenu(menu)"
                            >
                                <span v-if="isGroupActive(menu)" class="bg-satya-gold absolute inset-y-3 left-0 w-1 rounded-r-full" />

                                <div
                                    class="flex size-9 shrink-0 items-center justify-center rounded-xl transition"
                                    :class="isGroupActive(menu) ? 'bg-satya-gold/15 text-satya-gold' : 'bg-white/5 group-hover:bg-white/10'"
                                >
                                    <span class="material-symbols-outlined text-[20px]">
                                        {{ menu.icon }}
                                    </span>
                                </div>

                                <span
                                    class="min-w-0 flex-1 truncate text-left text-[11px] font-bold tracking-[0.13em] uppercase"
                                    :class="{ 'lg:hidden': sidebarCollapsed }"
                                >
                                    {{ menu.label }}
                                </span>

                                <span
                                    class="material-symbols-outlined text-lg transition-transform duration-200"
                                    :class="[
                                        openMenus[menu.key] ? 'rotate-180' : 'rotate-0',

                                        {
                                            'lg:hidden': sidebarCollapsed,
                                        },
                                    ]"
                                >
                                    keyboard_arrow_down
                                </span>
                            </button>

                            <!-- Isi dropdown -->
                            <Transition
                                enter-active-class="transition-all duration-200 ease-out"
                                enter-from-class="-translate-y-1 opacity-0"
                                enter-to-class="translate-y-0 opacity-100"
                                leave-active-class="transition-all duration-150 ease-in"
                                leave-from-class="translate-y-0 opacity-100"
                                leave-to-class="-translate-y-1 opacity-0"
                            >
                                <div
                                    v-show="openMenus[menu.key] && !sidebarCollapsed"
                                    class="relative mt-2 ml-6 space-y-1 border-l border-white/10 pl-4"
                                >
                                    <Link
                                        v-for="child in menu.children"
                                        :key="child.href"
                                        :href="child.href"
                                        class="group flex min-h-11 items-center gap-3 rounded-xl px-3 transition"
                                        :class="
                                            isLinkActive(child)
                                                ? 'bg-satya-gold/10 text-satya-gold'
                                                : 'text-gray-400 hover:bg-white/5 hover:text-white'
                                        "
                                        @click="closeMobileSidebar"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">
                                            {{ child.icon }}
                                        </span>

                                        <span class="truncate text-[10px] font-bold tracking-[0.11em] uppercase">
                                            {{ child.label }}
                                        </span>

                                        <span v-if="isLinkActive(child)" class="bg-satya-gold ml-auto size-1.5 rounded-full" />
                                    </Link>
                                </div>
                            </Transition>
                        </div>
                    </template>
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
