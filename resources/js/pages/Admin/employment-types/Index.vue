<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';

const props = defineProps({
    employmentTypes: {
        type: Object,
        required: true,
    },

    filters: {
        type: Object,
        default: () => ({
            search: '',
            status: '',
        }),
    },
});

const page = usePage();

const filterForm = reactive({
    search: props.filters.search ?? '',
    status: props.filters.status ?? '',
});

const successMessage = computed(() => page.props.flash?.success ?? null);

const errorMessage = computed(() => page.props.flash?.error ?? null);

const applyFilters = () => {
    router.get(
        '/admin/employment-types',
        {
            search: filterForm.search || undefined,
            status: filterForm.status || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
};

const resetFilters = () => {
    filterForm.search = '';
    filterForm.status = '';

    router.get(
        '/admin/employment-types',
        {},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
};

const deleteEmploymentType = (employmentType) => {
    const confirmed = window.confirm(`Hapus tipe pekerjaan "${employmentType.name}"?`);

    if (!confirmed) {
        return;
    }

    router.delete(`/admin/employment-types/${employmentType.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <AdminLayout title="Tipe Pekerjaan" description="Kelola tipe pekerjaan yang tersedia untuk lowongan kerja.">
        <template #header-action>
            <Link
                href="/admin/employment-types/create"
                class="bg-satya-dark text-satya-gold inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-5 text-[10px] font-black tracking-[0.14em] uppercase transition hover:opacity-90"
            >
                <span class="material-symbols-outlined text-lg"> add </span>

                Tambah Tipe
            </Link>
        </template>

        <!-- Flash message -->
        <div
            v-if="successMessage"
            class="mb-5 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700"
        >
            <span class="material-symbols-outlined text-xl"> check_circle </span>

            {{ successMessage }}
        </div>

        <div v-if="errorMessage" class="mb-5 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
            <span class="material-symbols-outlined text-xl"> error </span>

            {{ errorMessage }}
        </div>

        <!-- Filters -->
        <form class="mb-6 rounded-[1.75rem] border border-gray-100 bg-white p-5 shadow-sm" @submit.prevent="applyFilters">
            <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_220px_auto]">
                <div class="relative">
                    <span class="material-symbols-outlined absolute top-2 left-4 text-xl text-gray-400"> search </span>

                    <input
                        v-model="filterForm.search"
                        type="search"
                        placeholder="Cari tipe pekerjaan..."
                        class="focus:border-satya-gold focus:ring-satya-gold/20 h-12 w-full rounded-2xl border border-gray-200 bg-gray-50 pr-4 pl-12 text-sm transition outline-none focus:ring-2"
                    />
                </div>

                <select
                    v-model="filterForm.status"
                    class="focus:border-satya-gold focus:ring-satya-gold/20 h-12 rounded-2xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-600 transition outline-none focus:ring-2"
                >
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>

                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="bg-satya-dark text-satya-gold inline-flex h-12 flex-1 items-center justify-center rounded-2xl px-5 text-[10px] font-bold tracking-widest uppercase"
                    >
                        Terapkan
                    </button>

                    <button
                        type="button"
                        title="Reset filter"
                        class="inline-flex size-12 shrink-0 items-center justify-center rounded-2xl border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50"
                        @click="resetFilters"
                    >
                        <span class="material-symbols-outlined"> refresh </span>
                    </button>
                </div>
            </div>
        </form>

        <div class="overflow-hidden rounded-[1.75rem] border border-gray-100 bg-white shadow-sm">
            <!-- Desktop -->
            <div class="hidden overflow-x-auto md:block">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/70">
                            <th class="px-6 py-4 text-left text-[9px] font-black tracking-[0.16em] text-gray-400 uppercase">Tipe Pekerjaan</th>

                            <th class="px-6 py-4 text-left text-[9px] font-black tracking-[0.16em] text-gray-400 uppercase">Status</th>

                            <th class="px-6 py-4 text-center text-[9px] font-black tracking-[0.16em] text-gray-400 uppercase">Lowongan</th>

                            <th class="px-6 py-4 text-left text-[9px] font-black tracking-[0.16em] text-gray-400 uppercase">Dibuat</th>

                            <th class="px-6 py-4 text-right text-[9px] font-black tracking-[0.16em] text-gray-400 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="employmentType in employmentTypes.data" :key="employmentType.id" class="transition hover:bg-gray-50/60">
                            <td class="px-6 py-5">
                                <p class="text-sm font-bold text-gray-800">
                                    {{ employmentType.name }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ employmentType.slug }}
                                </p>

                                <p v-if="employmentType.description" class="mt-2 line-clamp-2 max-w-md text-xs leading-relaxed text-gray-500">
                                    {{ employmentType.description }}
                                </p>
                            </td>

                            <td class="px-6 py-5">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-[9px] font-black tracking-widest uppercase"
                                    :class="employmentType.is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500'"
                                >
                                    <span class="size-1.5 rounded-full" :class="employmentType.is_active ? 'bg-green-500' : 'bg-gray-400'" />

                                    {{ employmentType.is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-gray-700">
                                    {{ employmentType.job_vacancies_count }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-xs text-gray-500">
                                {{ employmentType.created_at }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="`/admin/employment-types/${employmentType.id}/edit`"
                                        title="Edit"
                                        class="hover:border-satya-gold hover:text-satya-gold inline-flex size-10 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition"
                                    >
                                        <span class="material-symbols-outlined text-lg"> edit </span>
                                    </Link>

                                    <button
                                        type="button"
                                        title="Hapus"
                                        :disabled="employmentType.job_vacancies_count > 0"
                                        class="inline-flex size-10 items-center justify-center rounded-xl border border-red-100 text-red-400 transition hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40"
                                        @click="deleteEmploymentType(employmentType)"
                                    >
                                        <span class="material-symbols-outlined text-lg"> delete </span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="employmentTypes.data.length === 0">
                            <td colspan="5" class="px-6 py-20 text-center">
                                <span class="material-symbols-outlined text-5xl text-gray-200"> work_history </span>

                                <p class="mt-3 text-sm font-bold text-gray-500">Belum ada tipe pekerjaan</p>

                                <p class="mt-1 text-xs text-gray-400">Tambahkan tipe pekerjaan seperti penuh waktu, paruh waktu, atau magang.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile -->
            <div class="divide-y divide-gray-100 md:hidden">
                <article v-for="employmentType in employmentTypes.data" :key="employmentType.id" class="p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="font-bold text-gray-800">
                                {{ employmentType.name }}
                            </h3>

                            <p class="mt-1 text-xs text-gray-400">
                                {{ employmentType.slug }}
                            </p>
                        </div>

                        <span
                            class="shrink-0 rounded-full px-2.5 py-1 text-[8px] font-black tracking-widest uppercase"
                            :class="employmentType.is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500'"
                        >
                            {{ employmentType.is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <p v-if="employmentType.description" class="mt-4 line-clamp-3 text-xs leading-relaxed text-gray-500">
                        {{ employmentType.description }}
                    </p>

                    <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
                        <p class="text-xs text-gray-400">{{ employmentType.job_vacancies_count }} lowongan</p>

                        <div class="flex gap-2">
                            <Link
                                :href="`/admin/employment-types/${employmentType.id}/edit`"
                                class="inline-flex size-9 items-center justify-center rounded-xl border border-gray-200 text-gray-500"
                            >
                                <span class="material-symbols-outlined text-lg"> edit </span>
                            </Link>

                            <button
                                type="button"
                                :disabled="employmentType.job_vacancies_count > 0"
                                class="inline-flex size-9 items-center justify-center rounded-xl border border-red-100 text-red-400 disabled:opacity-40"
                                @click="deleteEmploymentType(employmentType)"
                            >
                                <span class="material-symbols-outlined text-lg"> delete </span>
                            </button>
                        </div>
                    </div>
                </article>

                <div v-if="employmentTypes.data.length === 0" class="px-6 py-16 text-center">
                    <span class="material-symbols-outlined text-5xl text-gray-200"> work_history </span>

                    <p class="mt-3 text-sm font-bold text-gray-500">Belum ada tipe pekerjaan</p>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="employmentTypes.links.length > 3" class="flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 px-5 py-4">
                <p class="text-xs text-gray-400">
                    Menampilkan {{ employmentTypes.from ?? 0 }}–{{ employmentTypes.to ?? 0 }} dari {{ employmentTypes.total }} data
                </p>

                <div class="flex flex-wrap gap-1.5">
                    <template v-for="link in employmentTypes.links" :key="link.label">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            preserve-scroll
                            class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-xl border px-3 text-xs transition"
                            :class="
                                link.active
                                    ? 'border-satya-dark bg-satya-dark text-satya-gold'
                                    : 'border-gray-200 bg-white text-gray-500 hover:bg-gray-50'
                            "
                        >
                            <span v-html="link.label" />
                        </Link>

                        <span
                            v-else
                            class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-xl border border-gray-100 px-3 text-xs text-gray-300"
                            v-html="link.label"
                        />
                    </template>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
