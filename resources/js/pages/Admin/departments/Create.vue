<script setup>
import DepartmentForm from '@/components/admin/DepartmentForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
</script>

<template>
    <AdminLayout title="Tambah Departemen" description="Tambahkan departemen baru untuk kebutuhan lowongan kerja.">
        <DepartmentForm mode="create" />
    </AdminLayout>
</template>
