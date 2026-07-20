<script setup>
import JobVacancyForm from '@/components/admin/JobVacancyForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

defineProps({
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
</script>

<template>
    <AdminLayout title="Tambah Lowongan Kerja" description="Buat dan publikasikan lowongan pekerjaan baru.">
        <JobVacancyForm mode="create" :departments="departments" :employment-types="employmentTypes" :statuses="statuses" />
    </AdminLayout>
</template>
