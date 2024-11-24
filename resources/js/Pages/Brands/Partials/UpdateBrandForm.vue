<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps<{
    brand?: Object;
}>();

const form = useForm({
    _method: 'PUT',
    name: props.brand.name,
    rating: props.brand.rating,
    geolocation: props.brand.geolocation,
    image: null,
});

const imagePreview = ref(null);
const imageInput = ref(null);

const submit = (id) => {

    if (imageInput.value) {
        form.image = imageInput.value.files[0];
    }

    form.post(route('brands.update', { id: id }), {
        preserveScroll: true,
        onFinish: () => form.reset('name', 'image', 'rating', 'geolocation'),
        onSuccess: () => clearImageFileInput(),
    });
};

const selectNewImage = () => {
    imageInput.value.click();
};

const updateImagePreview = () => {
    const image = imageInput.value.files[0];

    if (!image) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        imagePreview.value = e.target.result;
    };

    reader.readAsDataURL(image);
};

const deleteImage = (id) => {
    router.delete(route('image.destroy', { id: Number(id), model: 'brand' }), {
        preserveScroll: true,
        onSuccess: () => {
            imagePreview.value = null;
            clearImageFileInput();
        },
    });
};

const clearImageFileInput = () => {
    if (imageInput.value?.value) {
        imageInput.value.value = null;
    }
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Brand #{{ brand.id }}</h2>
            <p class="mt-1 text-sm text-gray-600">
                Update brand.
            </p>
        </header>

        <form
            @submit.prevent="submit(brand.id)"
            class="mt-6 space-y-6"
            enctype="multipart/form-data"
        >
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="rating" value="Rating" />

                <TextInput
                    id="rating"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.rating"
                    autofocus
                    autocomplete="rating"
                />

                <InputError class="mt-2" :message="form.errors.rating"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <input
                    id="image"
                    ref="imageInput"
                    type="file"
                    class="hidden"
                    @change="updateImagePreview"
                >

                <InputLabel for="image" value="Image" />

                <div v-show="! imagePreview" class="mt-2 rounded-lg">
                    <img
                        :src="brand.image_url" :alt="brand.name"
                        class="rounded-lg h-[100px] object-cover"
                        :class="brand.image_url !== brand.default_image_url  ? 'w-[100px]' : 'w-[100px]'"
                    />
                </div>

                <div v-show="imagePreview" class="mt-2 rounded-lg">
                    <span
                        class="block rounded-lg w-[100px] h-[100px] bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + imagePreview + '\');'"
                    />
                </div>

                <SecondaryButton class="mt-2 me-2" type="button" @click.prevent="selectNewImage">
                    Select A New Image
                </SecondaryButton>

                <div>
                    <SecondaryButton
                        v-if="true"
                        type="button"
                        class="mt-2"
                        @click.prevent="deleteImage(brand.id)"
                    >
                        Remove Image
                    </SecondaryButton>
                </div>

                <InputError :message="form.errors.image" class="mt-2" />
            </div>


            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>

    </section>
</template>
