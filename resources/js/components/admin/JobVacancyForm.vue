<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, ref } from 'vue';

const props = defineProps({
    mode: {
        type: String,
        default: 'create',
        validator: (value) => ['create', 'edit'].includes(value),
    },

    vacancy: {
        type: Object,
        default: null,
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

const isEdit = computed(() => props.mode === 'edit');

const form = useForm({
    department_id: props.vacancy?.department_id ?? '',
    employment_type_id: props.vacancy?.employment_type_id ?? '',

    title: props.vacancy?.title ?? '',
    summary: props.vacancy?.summary ?? '',
    description: props.vacancy?.description ?? '',
    responsibilities: props.vacancy?.responsibilities ?? '',
    requirements: props.vacancy?.requirements ?? '',
    location: props.vacancy?.location ?? '',

    status: props.vacancy?.status ?? 'draft',
    published_at: props.vacancy?.published_at ?? '',
    application_deadline: props.vacancy?.application_deadline ?? '',

    thumbnail: null,
    remove_thumbnail: false,
});

const thumbnailInput = ref(null);
const thumbnailPreview = ref(props.vacancy?.thumbnail_url ?? null);

let temporaryObjectUrl = null;

const handleThumbnail = (event) => {
    const file = event.target.files?.[0] ?? null;

    form.thumbnail = file;
    form.remove_thumbnail = false;

    if (temporaryObjectUrl) {
        URL.revokeObjectURL(temporaryObjectUrl);
        temporaryObjectUrl = null;
    }

    if (file) {
        temporaryObjectUrl = URL.createObjectURL(file);
        thumbnailPreview.value = temporaryObjectUrl;
    }
};

const removeThumbnail = () => {
    form.thumbnail = null;
    form.remove_thumbnail = true;
    thumbnailPreview.value = null;

    if (thumbnailInput.value) {
        thumbnailInput.value.value = '';
    }

    if (temporaryObjectUrl) {
        URL.revokeObjectURL(temporaryObjectUrl);
        temporaryObjectUrl = null;
    }
};

const submit = () => {
    if (isEdit.value) {
        /*
         * Upload file pada update menggunakan method spoofing.
         */
        form.transform((data) => ({
            ...data,
            _method: 'put',
        })).post(`/admin/job-vacancies/${props.vacancy.id}`, {
            forceFormData: true,
            preserveScroll: true,
        });

        return;
    }

    form.post('/admin/job-vacancies', {
        forceFormData: true,
        preserveScroll: true,
    });
};

onBeforeUnmount(() => {
    if (temporaryObjectUrl) {
        URL.revokeObjectURL(temporaryObjectUrl);
    }
});
</script>

<template>
    <form class="space-y-6" @submit.prevent="submit">
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <!-- Main fields -->
            <div class="space-y-6">
                <section class="rounded-[1.75rem] border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-7">
                        <h2 class="text-satya-dark font-serif text-xl">Informasi Lowongan</h2>

                        <p class="mt-1 text-sm text-gray-400">Masukkan informasi utama lowongan pekerjaan.</p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="title" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                                Judul Lowongan
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="title"
                                v-model="form.title"
                                type="text"
                                maxlength="160"
                                required
                                autofocus
                                placeholder="Contoh: Staf Front Office"
                                class="focus:ring-satya-gold/20 w-full rounded-2xl border bg-gray-50 px-5 py-4 text-sm transition outline-none focus:ring-2"
                                :class="form.errors.title ? 'border-red-400' : 'focus:border-satya-gold border-gray-200'"
                            />

                            <p v-if="form.errors.title" class="mt-2 text-xs text-red-500">
                                {{ form.errors.title }}
                            </p>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="department_id" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                                    Departemen
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="department_id"
                                    v-model="form.department_id"
                                    required
                                    class="focus:ring-satya-gold/20 w-full rounded-2xl border bg-gray-50 px-5 py-4 text-sm transition outline-none focus:ring-2"
                                    :class="form.errors.department_id ? 'border-red-400' : 'focus:border-satya-gold border-gray-200'"
                                >
                                    <option value="" disabled>Pilih departemen</option>

                                    <option v-for="department in departments" :key="department.id" :value="department.id">
                                        {{ department.name }}
                                    </option>
                                </select>

                                <p v-if="form.errors.department_id" class="mt-2 text-xs text-red-500">
                                    {{ form.errors.department_id }}
                                </p>
                            </div>

                            <div>
                                <label for="employment_type_id" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                                    Tipe Pekerjaan
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="employment_type_id"
                                    v-model="form.employment_type_id"
                                    required
                                    class="focus:ring-satya-gold/20 w-full rounded-2xl border bg-gray-50 px-5 py-4 text-sm transition outline-none focus:ring-2"
                                    :class="form.errors.employment_type_id ? 'border-red-400' : 'focus:border-satya-gold border-gray-200'"
                                >
                                    <option value="" disabled>Pilih tipe pekerjaan</option>

                                    <option v-for="employmentType in employmentTypes" :key="employmentType.id" :value="employmentType.id">
                                        {{ employmentType.name }}
                                    </option>
                                </select>

                                <p v-if="form.errors.employment_type_id" class="mt-2 text-xs text-red-500">
                                    {{ form.errors.employment_type_id }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="location" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                                Lokasi Penempatan
                            </label>

                            <input
                                id="location"
                                v-model="form.location"
                                type="text"
                                maxlength="150"
                                placeholder="Contoh: Yogyakarta"
                                class="focus:border-satya-gold focus:ring-satya-gold/20 w-full rounded-2xl border bg-gray-50 px-5 py-4 text-sm transition outline-none focus:ring-2"
                                :class="form.errors.location ? 'border-red-400' : 'border-gray-200'"
                            />

                            <p v-if="form.errors.location" class="mt-2 text-xs text-red-500">
                                {{ form.errors.location }}
                            </p>
                        </div>

                        <div>
                            <div class="mb-2 flex justify-between gap-4">
                                <label for="summary" class="text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase"> Ringkasan </label>

                                <span class="text-[10px] text-gray-400"> {{ form.summary.length }}/500 </span>
                            </div>

                            <textarea
                                id="summary"
                                v-model="form.summary"
                                rows="3"
                                maxlength="500"
                                placeholder="Ringkasan singkat yang tampil pada kartu lowongan..."
                                class="focus:border-satya-gold focus:ring-satya-gold/20 w-full resize-y rounded-2xl border bg-gray-50 px-5 py-4 text-sm leading-relaxed transition outline-none focus:ring-2"
                                :class="form.errors.summary ? 'border-red-400' : 'border-gray-200'"
                            />

                            <p v-if="form.errors.summary" class="mt-2 text-xs text-red-500">
                                {{ form.errors.summary }}
                            </p>
                        </div>
                    </div>
                </section>

                <section class="rounded-[1.75rem] border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-7">
                        <h2 class="text-satya-dark font-serif text-xl">Detail Pekerjaan</h2>

                        <p class="mt-1 text-sm text-gray-400">Jelaskan deskripsi, tanggung jawab, dan persyaratan.</p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="description" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                                Deskripsi
                                <span class="text-red-500">*</span>
                            </label>

                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="7"
                                required
                                placeholder="Jelaskan posisi dan gambaran umum pekerjaan..."
                                class="focus:ring-satya-gold/20 w-full resize-y rounded-2xl border bg-gray-50 px-5 py-4 text-sm leading-relaxed transition outline-none focus:ring-2"
                                :class="form.errors.description ? 'border-red-400' : 'focus:border-satya-gold border-gray-200'"
                            />

                            <p v-if="form.errors.description" class="mt-2 text-xs text-red-500">
                                {{ form.errors.description }}
                            </p>
                        </div>

                        <div>
                            <label for="responsibilities" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                                Tanggung Jawab
                            </label>

                            <textarea
                                id="responsibilities"
                                v-model="form.responsibilities"
                                rows="6"
                                placeholder="Tuliskan satu tanggung jawab per baris..."
                                class="focus:border-satya-gold focus:ring-satya-gold/20 w-full resize-y rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-sm leading-relaxed transition outline-none focus:ring-2"
                            />

                            <p v-if="form.errors.responsibilities" class="mt-2 text-xs text-red-500">
                                {{ form.errors.responsibilities }}
                            </p>
                        </div>

                        <div>
                            <label for="requirements" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                                Persyaratan
                            </label>

                            <textarea
                                id="requirements"
                                v-model="form.requirements"
                                rows="6"
                                placeholder="Tuliskan satu persyaratan per baris..."
                                class="focus:border-satya-gold focus:ring-satya-gold/20 w-full resize-y rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-sm leading-relaxed transition outline-none focus:ring-2"
                            />

                            <p v-if="form.errors.requirements" class="mt-2 text-xs text-red-500">
                                {{ form.errors.requirements }}
                            </p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Sidebar form -->
            <div class="space-y-6">
                <section class="rounded-[1.75rem] border border-gray-100 bg-white p-5 shadow-sm">
                    <h2 class="text-satya-dark font-serif text-lg">Publikasi</h2>

                    <div class="mt-5 space-y-5">
                        <div>
                            <label for="status" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase"> Status </label>

                            <select
                                id="status"
                                v-model="form.status"
                                class="focus:border-satya-gold focus:ring-satya-gold/20 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-sm transition outline-none focus:ring-2"
                            >
                                <option v-for="status in statuses" :key="status.value" :value="status.value">
                                    {{ status.label }}
                                </option>
                            </select>

                            <p v-if="form.errors.status" class="mt-2 text-xs text-red-500">
                                {{ form.errors.status }}
                            </p>
                        </div>

                        <div>
                            <label for="published_at" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                                Waktu Publikasi
                            </label>

                            <input
                                id="published_at"
                                v-model="form.published_at"
                                type="datetime-local"
                                class="focus:border-satya-gold focus:ring-satya-gold/20 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-sm transition outline-none focus:ring-2"
                            />

                            <p class="mt-2 text-[11px] leading-relaxed text-gray-400">
                                Jika dikosongkan saat status dipublikasikan, sistem memakai waktu sekarang.
                            </p>

                            <p v-if="form.errors.published_at" class="mt-2 text-xs text-red-500">
                                {{ form.errors.published_at }}
                            </p>
                        </div>

                        <div>
                            <label for="application_deadline" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                                Batas Pendaftaran
                            </label>

                            <input
                                id="application_deadline"
                                v-model="form.application_deadline"
                                type="datetime-local"
                                class="focus:border-satya-gold focus:ring-satya-gold/20 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-sm transition outline-none focus:ring-2"
                            />

                            <p v-if="form.errors.application_deadline" class="mt-2 text-xs text-red-500">
                                {{ form.errors.application_deadline }}
                            </p>
                        </div>
                    </div>
                </section>

                <section class="rounded-[1.75rem] border border-gray-100 bg-white p-5 shadow-sm">
                    <h2 class="text-satya-dark font-serif text-lg">Thumbnail</h2>

                    <div class="mt-5">
                        <div v-if="thumbnailPreview" class="relative overflow-hidden rounded-2xl border border-gray-200">
                            <img :src="thumbnailPreview" alt="Preview thumbnail" class="aspect-[16/10] w-full object-cover" />

                            <button
                                type="button"
                                title="Hapus thumbnail"
                                class="absolute top-3 right-3 inline-flex size-9 items-center justify-center rounded-xl bg-white/90 text-red-500 shadow-lg backdrop-blur transition hover:bg-white"
                                @click="removeThumbnail"
                            >
                                <span class="material-symbols-outlined text-lg"> delete </span>
                            </button>
                        </div>

                        <label
                            v-else
                            for="thumbnail"
                            class="hover:border-satya-gold hover:bg-satya-gold/5 flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 px-5 py-10 text-center transition"
                        >
                            <span class="material-symbols-outlined text-4xl text-gray-300"> add_photo_alternate </span>

                            <span class="mt-3 text-sm font-semibold text-gray-600"> Pilih thumbnail </span>

                            <span class="mt-1 text-xs text-gray-400"> JPG, PNG, atau WebP. Maksimal 4 MB. </span>
                        </label>

                        <input
                            id="thumbnail"
                            ref="thumbnailInput"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="sr-only"
                            @change="handleThumbnail"
                        />

                        <label
                            v-if="thumbnailPreview"
                            for="thumbnail"
                            class="mt-3 inline-flex min-h-10 w-full cursor-pointer items-center justify-center gap-2 rounded-xl border border-gray-200 text-[10px] font-bold tracking-widest text-gray-500 uppercase transition hover:bg-gray-50"
                        >
                            <span class="material-symbols-outlined text-base"> upload </span>

                            Ganti Thumbnail
                        </label>

                        <p v-if="form.errors.thumbnail" class="mt-2 text-xs text-red-500">
                            {{ form.errors.thumbnail }}
                        </p>
                    </div>
                </section>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <Link
                href="/admin/job-vacancies"
                class="inline-flex min-h-12 items-center justify-center rounded-2xl border border-gray-200 bg-white px-6 text-xs font-bold tracking-widest text-gray-500 uppercase transition hover:bg-gray-50"
            >
                Batal
            </Link>

            <button
                type="submit"
                :disabled="form.processing"
                class="bg-satya-dark text-satya-gold inline-flex min-h-12 items-center justify-center gap-2 rounded-2xl px-7 text-xs font-bold tracking-widest uppercase transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <span class="material-symbols-outlined text-lg">
                    {{ isEdit ? 'save' : 'add' }}
                </span>

                {{ form.processing ? 'Menyimpan...' : isEdit ? 'Simpan Perubahan' : 'Tambah Lowongan' }}
            </button>
        </div>
    </form>
</template>
