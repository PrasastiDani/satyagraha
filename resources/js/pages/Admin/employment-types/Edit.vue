<script setup>
import EmploymentTypeForm from '@/components/admin/EmploymentTypeForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

defineProps({
    employmentType: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AdminLayout title="Edit Tipe Pekerjaan" description="Perbarui informasi dan status tipe pekerjaan.">
        <EmploymentTypeForm mode="edit" :employment-type="employmentType" />
    </AdminLayout>
</template>
