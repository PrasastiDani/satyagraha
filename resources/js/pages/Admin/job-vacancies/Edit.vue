<script setup>
import JobVacancyForm from '@/components/admin/JobVacancyForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

defineProps({
    vacancy: {
        type: Object,
        required: true,
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
</script>

<template>
    <AdminLayout title="Edit Lowongan Kerja" description="Perbarui informasi dan pengaturan publikasi lowongan.">
        <JobVacancyForm mode="edit" :vacancy="vacancy" :departments="departments" :employment-types="employmentTypes" :statuses="statuses" />
    </AdminLayout>
</template>
