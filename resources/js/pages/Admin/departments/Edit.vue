<script setup>
import DepartmentForm from '@/components/admin/DepartmentForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

defineProps({
    department: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AdminLayout title="Edit Departemen" description="Perbarui informasi dan status departemen.">
        <DepartmentForm mode="edit" :department="department" />
    </AdminLayout>
</template>
