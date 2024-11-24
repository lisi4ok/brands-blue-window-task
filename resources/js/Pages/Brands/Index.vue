<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import BlueButton from '@/Components/BlueButton.vue';
import GreenButton from '@/Components/GreenButton.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    brands?: Array;
}>();

const deleteBrand = (id) => {
    let form = useForm({});
    form.delete(route('brands.destroy', { id: id }), {
        preserveScroll: true,
        onFinish: () => form.reset(),
        onSuccess: () => form.reset(),
    });
};

const editBrand = (id) => {
    window.location.href = route('brands.edit', { id: id });
};
const createBrand = () => {
    window.location.href = route('brands.create');
};
</script>

<template>
    <Head title="Brands" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 mt-2">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Brands</h2>
                </div>
                <div class="col-span-9 mt-2 text-right">
                    <GreenButton class="ms-3" @click="createBrand">
                        Create
                    </GreenButton>
                </div>
            </div>
        </template>


        <div class="py-12">
            <div class="w-full sm:px-6 lg:px-8 space-y-6">
                <div class="mx-auto">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        v-if="brands.data.length"
                    >
                        <caption class="py-6 bg-white text-gray-900 uppercase text-lg sm:rounded-none md:rounded-t-lg shadow-md dark:text-gray-400 dark:bg-gray-800">
                            <h2>Brands List</h2>
                        </caption>
                        <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 shadow-md">
                        <tr>
                            <th scope="col" class="px-4 py-4">
                                Name
                            </th>
                            <th scope="col" class="px-4 py-4">
                                Image
                            </th>
                            <th scope="col" class="px-4 py-4">
                                Rating
                            </th>
                            <th scope="col" class="px-4 py-4">
                                GeoLocation
                            </th>
                            <th scope="col" class="px-4 py-4">
                                Created At
                            </th>
                            <th scope="col" class="px-4 py-4">
                                Updated At
                            </th>
                            <th scope="col" colspan="2" class="sm:px-20 px-18 xl:px-24 py-4">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 dark:text-gray-400">
                        <tr v-for="brand in brands.data"
                            class="ff odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <th scope="row"
                                class="px-2 py-4 font-medium text-gray-900 xl:whitespace-nowrap dark:text-white"
                            >
                                {{ brand.name }}
                            </th>
                            <td class="px-2 py-4">
                                <template v-if="brand.image">
                                    <img :src="brand.image_url" :alt="brand.name" class="bg-gray-900" />
                                </template>
                            </td>
                            <td class="px-2 py-4">
                              <div><div class="stars"><div :style="{ width: brand.rating_percentage + '%' }"></div></div></div>
                            </td>
                            <td class="px-2 py-4">
                                {{ brand.geolocation }}
                            </td>
                            <td class="px-2 py-4">
                                {{ brand.created_at }}
                            </td>
                            <td class="px-2 py-4">
                                {{ brand.updated_at }}
                            </td>
                            <td colspan="2" class="xl:px-4 px-2 py-4">
                                <BlueButton class="ms-3" @click="editBrand(brand.id)">
                                    Edit
                                </BlueButton>
                                <DangerButton class="ms-3" @click="deleteBrand(brand.id)">
                                    Delete
                                </DangerButton>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot class="uppercase text-lg bg-white text-gray-900 shadow-md dark:bg-gray-800 dark:text-white">
                        <tr>
                            <th scope="colgroup" colspan="8" class="px-3 xl:px-6 py-3 sm:rounded-none md:rounded-b-lg">
                                <Pagination :collection="brands.meta" />
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.stars,
.starsbg {
  width: 85px;
  height: 16px;
  background: url(/static/rating.png) 0 bottom repeat-x;
  margin: 15px auto;
  overflow: hidden;
  position: relative;
}

.stars div,
.starsbg div.starsfg {
  position: absolute;
  height: 100%;
  background: url(/static/rating.png) 0 0 repeat-x;
}
</style>
