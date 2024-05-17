<template xmlns="http://www.w3.org/1999/html">

    <AuthenticatedLayout>
        <form class="max-w-sm mx-auto" @submit.prevent="update">
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                <input v-model="form.title" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                <div v-if="form.errors.title" class="input-error">
                    {{ form.errors.title }}
                </div>
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea v-model="form.description" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>
                <div v-if="form.errors.description" class="input-error">
                    {{ form.errors.description }}
                </div>
            </div>
            <div class="mb-5" v-if="form.cover_photo">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cover Image</label>
                <img :src="'/storage/' + form.cover_photo" alt="Cover Image" class="block w-full rounded-lg">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Cover Image</label>
                <input @change="handleFileUpload" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    notes: Object,

})


const form = useForm({
    title: props.notes.title,
    description: props.notes.description,
    cover_photo: props.notes.cover_photo,
})
const update = () => form.put(
    route('notes.update', { note: props.notes.id }),
)
const handleFileUpload = (event) => {
    // Set the selected file to the form data
    form.cover_photo = event.target.files[0];
}
</script>
