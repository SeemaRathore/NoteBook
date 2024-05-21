<template>
    <AuthenticatedLayout>
        <Box>
            <form class="max-w-sm mx-auto" @submit.prevent="update" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="mb-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                    <input v-model="form.title" type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    <div v-if="form.errors.title" class="input-error">
                        {{ form.errors.title }}
                    </div>
                </div>
                <div class="mb-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea v-model="form.description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>
                    <div v-if="form.errors.description" class="input-error">
                        {{ form.errors.description }}
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="cover_photo">Cover Image</label>
                    <img v-if="form.cover_photo" :src="form.cover_photo ? '/storage/' + form.cover_photo : '/demo.png'" alt="Cover Image Preview" class="mt-2 border border-gray-300 dark:border-gray-600 rounded-lg" style="max-width: 100%;">
                    <input @change="handleFileUpload" name="cover_photo" id="cover_photo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="cover_photo_help" type="file">
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </Box>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {useForm} from '@inertiajs/vue3';
import Box from "@/Pages/Notes/Components/Box.vue";

const props = defineProps({
    notes: Object,
});

const form = useForm({
    title: props.notes.title,
    description: props.notes.description,
    cover_photo: props.notes.cover_photo,
});

const handleFileUpload = (event) => {
    form.cover_photo = event.target.files[0];
    console.log(form);
};

//const update = () => form.put(route('notes.update', { note: props.notes.id }));



const updateRoute = route('notes.update', { note: props.notes.id });
const INDEX_ROUTE_URL = '/notes';
const update = async () => {
    try {
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); // Add CSRF token
        formData.append('title', form.title);
        formData.append('description', form.description);
        formData.append('cover_photo', form.cover_photo);

        await axios.post(updateRoute, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        window.location.href = INDEX_ROUTE_URL;
    } catch (error) {
        console.error(error);

    }
};
</script>

