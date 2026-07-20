<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';

const props = defineProps({
    vacancies: {
        type: Object,
        required: true,
    },

    filters: {
        type: Object,
        default: () => ({}),
    },

    departments: {
        type: Array,
        default: () => [],
    },

    employmentTypes: {
        type: Array,
        default: () => [],
    },

    statuses: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();

const filterForm = reactive({
    search: props.filters.search ?? '',
    status: props.filters.status ?? '',
    department_id: props.filters.department_id ?? '',
    employment_type_id: props.filters.employment_type_id ?? '',
});

const successMessage = computed(() => page.props.flash?.success ?? null);

const errorMessage = computed(() => page.props.flash?.error ?? null);

const applyFilters = () => {
    router.get(
        '/admin/job-vacancies',
        {
            search: filterForm.search || undefined,
            status: filterForm.status || undefined,
            department_id: filterForm.department_id || undefined,
            employment_type_id: filterForm.employment_type_id || undefined,
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
    filterForm.department_id = '';
    filterForm.employment_type_id = '';

    router.get(
        '/admin/job-vacancies',
        {},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
};

const deleteVacancy = (vacancy) => {
    const confirmed = window.confirm(`Arsipkan lowongan "${vacancy.title}"?`);

    if (!confirmed) {
        return;
    }

    router.delete(`/admin/job-vacancies/${vacancy.id}`, {
        preserveScroll: true,
    });
};

const statusClass = (status) => {
    return (
        {
            draft: 'bg-gray-100 text-gray-600',
            published: 'bg-green-50 text-green-700',
            closed: 'bg-red-50 text-red-700',
            archived: 'bg-amber-50 text-amber-700',
        }[status] ?? 'bg-gray-100 text-gray-600'
    );
};
</script>

<template>
    <AdminLayout title="Lowongan Kerja" description="Kelola informasi dan jadwal publikasi lowongan pekerjaan.">
        <template #header-action>
            <Link
                href="/admin/job-vacancies/create"
                class="bg-satya-dark text-satya-gold inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-5 text-[10px] font-black tracking-[0.14em] uppercase transition hover:opacity-90"
            >
                <span class="material-symbols-outlined text-lg"> add </span>

                Tambah Lowongan
            </Link>
        </template>

        <div
            v-if="successMessage"
            class="mb-5 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700"
        >
            <span class="material-symbols-outlined"> check_circle </span>

            {{ successMessage }}
        </div>

        <div v-if="errorMessage" class="mb-5 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
            <span class="material-symbols-outlined"> error </span>

            {{ errorMessage }}
        </div>

        <form class="mb-6 rounded-[1.75rem] border border-gray-100 bg-white p-5 shadow-sm" @submit.prevent="applyFilters">
            <div class="grid gap-4 lg:grid-cols-4">
                <div class="relative lg:col-span-2">
                    <span class="material-symbols-outlined absolute top-2 left-4 text-xl text-gray-400"> search </span>

                    <input
                        v-model="filterForm.search"
                        type="search"
                        placeholder="Cari judul, ringkasan, atau lokasi..."
                        class="focus:border-satya-gold focus:ring-satya-gold/20 h-12 w-full rounded-2xl border border-gray-200 bg-gray-50 pr-4 pl-12 text-sm transition outline-none focus:ring-2"
                    />
                </div>

                <select
                    v-model="filterForm.status"
                    class="focus:border-satya-gold h-12 rounded-2xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-600 outline-none"
                >
                    <option value="">Semua Status</option>

                    <option v-for="status in statuses" :key="status.value" :value="status.value">
                        {{ status.label }}
                    </option>
                </select>

                <select
                    v-model="filterForm.department_id"
                    class="focus:border-satya-gold h-12 rounded-2xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-600 outline-none"
                >
                    <option value="">Semua Departemen</option>

                    <option v-for="department in departments" :key="department.id" :value="department.id">
                        {{ department.name }}
                    </option>
                </select>

                <select
                    v-model="filterForm.employment_type_id"
                    class="focus:border-satya-gold h-12 rounded-2xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-600 outline-none lg:col-span-2"
                >
                    <option value="">Semua Tipe Pekerjaan</option>

                    <option v-for="employmentType in employmentTypes" :key="employmentType.id" :value="employmentType.id">
                        {{ employmentType.name }}
                    </option>
                </select>

                <button type="submit" class="bg-satya-dark text-satya-gold h-12 rounded-2xl px-5 text-[10px] font-bold tracking-widest uppercase">
                    Terapkan
                </button>

                <button
                    type="button"
                    class="h-12 rounded-2xl border border-gray-200 bg-white px-5 text-[10px] font-bold tracking-widest text-gray-500 uppercase transition hover:bg-gray-50"
                    @click="resetFilters"
                >
                    Reset
                </button>
            </div>
        </form>

        <div class="overflow-hidden rounded-[1.75rem] border border-gray-100 bg-white shadow-sm">
            <div class="hidden overflow-x-auto lg:block">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/70">
                            <th class="px-6 py-4 text-left text-[9px] font-black tracking-widest text-gray-400 uppercase">Lowongan</th>

                            <th class="px-6 py-4 text-left text-[9px] font-black tracking-widest text-gray-400 uppercase">Kategori</th>

                            <th class="px-6 py-4 text-left text-[9px] font-black tracking-widest text-gray-400 uppercase">Status</th>

                            <th class="px-6 py-4 text-left text-[9px] font-black tracking-widest text-gray-400 uppercase">Deadline</th>

                            <th class="px-6 py-4 text-right text-[9px] font-black tracking-widest text-gray-400 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="vacancy in vacancies.data" :key="vacancy.id" class="transition hover:bg-gray-50/60">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="flex size-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-gray-100">
                                        <img
                                            v-if="vacancy.thumbnail_url"
                                            :src="vacancy.thumbnail_url"
                                            :alt="vacancy.title"
                                            class="h-full w-full object-cover"
                                        />

                                        <span v-else class="material-symbols-outlined text-gray-300"> work </span>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-800">
                                            {{ vacancy.title }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-400">
                                            {{ vacancy.location || 'Lokasi belum diatur' }}
                                        </p>

                                        <p class="mt-1 text-[10px] text-gray-300">
                                            {{ vacancy.slug }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <p class="text-sm font-semibold text-gray-700">
                                    {{ vacancy.department.name }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ vacancy.employment_type.name }}
                                </p>
                            </td>

                            <td class="px-6 py-5">
                                <span
                                    class="inline-flex rounded-full px-3 py-1.5 text-[9px] font-black tracking-widest uppercase"
                                    :class="statusClass(vacancy.status)"
                                >
                                    {{ vacancy.status_label }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-xs text-gray-500">
                                {{ vacancy.application_deadline || 'Tanpa batas waktu' }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="`/admin/job-vacancies/${vacancy.id}/edit`"
                                        title="Edit"
                                        class="hover:border-satya-gold hover:text-satya-gold inline-flex size-10 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition"
                                    >
                                        <span class="material-symbols-outlined text-lg"> edit </span>
                                    </Link>

                                    <button
                                        type="button"
                                        title="Arsipkan"
                                        class="inline-flex size-10 items-center justify-center rounded-xl border border-red-100 text-red-400 transition hover:bg-red-50 hover:text-red-600"
                                        @click="deleteVacancy(vacancy)"
                                    >
                                        <span class="material-symbols-outlined text-lg"> archive </span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="vacancies.data.length === 0">
                            <td colspan="5" class="px-6 py-20 text-center">
                                <span class="material-symbols-outlined text-5xl text-gray-200"> work_off </span>

                                <p class="mt-3 text-sm font-bold text-gray-500">Belum ada lowongan kerja</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile -->
            <div class="divide-y divide-gray-100 lg:hidden">
                <article v-for="vacancy in vacancies.data" :key="vacancy.id" class="p-5">
                    <div class="flex gap-4">
                        <div class="flex size-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-gray-100">
                            <img v-if="vacancy.thumbnail_url" :src="vacancy.thumbnail_url" :alt="vacancy.title" class="h-full w-full object-cover" />

                            <span v-else class="material-symbols-outlined text-gray-300"> work </span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <span
                                class="inline-flex rounded-full px-2.5 py-1 text-[8px] font-black tracking-widest uppercase"
                                :class="statusClass(vacancy.status)"
                            >
                                {{ vacancy.status_label }}
                            </span>

                            <h3 class="mt-2 font-bold text-gray-800">
                                {{ vacancy.title }}
                            </h3>

                            <p class="mt-1 text-xs text-gray-400">
                                {{ vacancy.department.name }}
                                ·
                                {{ vacancy.employment_type.name }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
                        <p class="text-xs text-gray-400">
                            {{ vacancy.location || 'Lokasi belum diatur' }}
                        </p>

                        <div class="flex gap-2">
                            <Link
                                :href="`/admin/job-vacancies/${vacancy.id}/edit`"
                                class="inline-flex size-9 items-center justify-center rounded-xl border border-gray-200 text-gray-500"
                            >
                                <span class="material-symbols-outlined text-lg"> edit </span>
                            </Link>

                            <button
                                type="button"
                                class="inline-flex size-9 items-center justify-center rounded-xl border border-red-100 text-red-400"
                                @click="deleteVacancy(vacancy)"
                            >
                                <span class="material-symbols-outlined text-lg"> archive </span>
                            </button>
                        </div>
                    </div>
                </article>

                <div v-if="vacancies.data.length === 0" class="px-6 py-16 text-center">
                    <span class="material-symbols-outlined text-5xl text-gray-200"> work_off </span>

                    <p class="mt-3 text-sm font-bold text-gray-500">Belum ada lowongan kerja</p>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="vacancies.links.length > 3" class="flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 px-5 py-4">
                <p class="text-xs text-gray-400">Menampilkan {{ vacancies.from ?? 0 }}–{{ vacancies.to ?? 0 }} dari {{ vacancies.total }} data</p>

                <div class="flex flex-wrap gap-1.5">
                    <template v-for="link in vacancies.links" :key="link.label">
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
