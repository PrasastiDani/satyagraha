<script setup>
import EmploymentTypeForm from '@/components/admin/EmploymentTypeForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
</script>

<template>
    <AdminLayout title="Tambah Tipe Pekerjaan" description="Tambahkan tipe pekerjaan baru untuk lowongan kerja.">
        <EmploymentTypeForm mode="create" />
    </AdminLayout>
</template>
