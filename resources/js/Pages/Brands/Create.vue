<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateBrandForm from '@/Pages/Brands/Partials/CreateBrandForm.vue';

defineProps<{
    defaultImagePath: string;
    countries: Object;
}>();
</script>

<template>
    <Head title="Create Brand" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Brand</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <CreateBrandForm :defaultImagePath="defaultImagePath" :countries="countries" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
