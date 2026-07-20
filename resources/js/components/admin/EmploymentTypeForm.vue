<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    mode: {
        type: String,
        default: 'create',
        validator: (value) => ['create', 'edit'].includes(value),
    },

    employmentType: {
        type: Object,
        default: null,
    },
});

const isEdit = computed(() => props.mode === 'edit');

const form = useForm({
    name: props.employmentType?.name ?? '',
    description: props.employmentType?.description ?? '',
    is_active: props.employmentType?.is_active ?? true,
});

const submit = () => {
    if (isEdit.value) {
        form.put(`/admin/employment-types/${props.employmentType.id}`, {
            preserveScroll: true,
        });

        return;
    }

    form.post('/admin/employment-types', {
        preserveScroll: true,
    });
};
</script>

<template>
    <form class="space-y-6" @submit.prevent="submit">
        <div class="rounded-[1.75rem] border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-7">
                <h2 class="text-satya-dark font-serif text-xl">Informasi Tipe Pekerjaan</h2>

                <p class="mt-1 text-sm text-gray-400">Atur tipe pekerjaan yang dapat dipilih ketika membuat lowongan.</p>
            </div>

            <div class="space-y-5">
                <!-- Name -->
                <div>
                    <label for="name" class="mb-2 block text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase">
                        Nama Tipe Pekerjaan
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        maxlength="100"
                        required
                        autofocus
                        placeholder="Contoh: Penuh Waktu"
                        class="focus:ring-satya-gold/30 w-full rounded-2xl border bg-gray-50 px-5 py-4 text-sm transition outline-none focus:ring-2"
                        :class="form.errors.name ? 'border-red-400' : 'focus:border-satya-gold border-gray-200'"
                    />

                    <p v-if="form.errors.name" class="mt-2 text-xs text-red-500">
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- Description -->
                <div>
                    <div class="mb-2 flex items-center justify-between gap-4">
                        <label for="description" class="text-[10px] font-black tracking-[0.14em] text-gray-500 uppercase"> Deskripsi </label>

                        <span class="text-[10px] text-gray-400"> {{ form.description?.length ?? 0 }}/2000 </span>
                    </div>

                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="5"
                        maxlength="2000"
                        placeholder="Jelaskan tipe pekerjaan ini..."
                        class="focus:ring-satya-gold/30 w-full resize-y rounded-2xl border bg-gray-50 px-5 py-4 text-sm leading-relaxed transition outline-none focus:ring-2"
                        :class="form.errors.description ? 'border-red-400' : 'focus:border-satya-gold border-gray-200'"
                    />

                    <p v-if="form.errors.description" class="mt-2 text-xs text-red-500">
                        {{ form.errors.description }}
                    </p>
                </div>

                <!-- Status -->
                <div class="flex items-center justify-between gap-4 rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-700">Status Tipe Pekerjaan</p>

                        <p class="mt-1 text-xs leading-5 text-gray-400">Tipe aktif dapat dipilih saat membuat lowongan kerja.</p>
                    </div>

                    <button
                        type="button"
                        role="switch"
                        :aria-checked="form.is_active"
                        class="focus:ring-satya-gold/20 relative inline-flex h-6 w-11 shrink-0 rounded-full transition-colors duration-200 focus:ring-4 focus:outline-none"
                        :class="form.is_active ? 'bg-satya-gold' : 'bg-gray-300'"
                        @click="form.is_active = !form.is_active"
                    >
                        <span
                            class="absolute top-0.5 left-0.5 size-5 rounded-full bg-white shadow-sm transition-transform duration-200"
                            :class="form.is_active ? 'translate-x-3' : 'translate-x-0'"
                        />
                    </button>
                </div>

                <p v-if="form.errors.is_active" class="text-xs text-red-500">
                    {{ form.errors.is_active }}
                </p>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <Link
                href="/admin/employment-types"
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

                {{ form.processing ? 'Menyimpan...' : isEdit ? 'Simpan Perubahan' : 'Tambah Tipe' }}
            </button>
        </div>
    </form>
</template>
