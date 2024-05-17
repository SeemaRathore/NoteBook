<template>
    <AuthenticatedLayout>
        <template #header>
        <div class="flex justify-between items-center">
            <Link :href="route('notes.index')" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Notes List</Link>
            <Link :href="route('notes.create')" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">+ Add Note</Link>
        </div>
        </template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Title</th>
                <th scope="col" class="px-6 py-3">Description</th>
                <th scope="col" class="px-6 py-3">Cover Photo</th>
                <th scope="col" class="px-6 py-3">Tags</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
            </thead>
            <tbody  v-if="notes && notes.length">
            <!-- Loop through notes and render each note as a table row -->
            <tr v-for="note in notes" :key="note.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ note.title }}</td>
                <td class="px-6 py-4">{{ note.description }}</td>
                <td class="px-6 py-4">{{ note.tags }}</td>
                <td class="px-6 py-4">
                    <!-- Assuming note.cover_photo contains the image URL -->

                    <img :src="'/storage/' + note.cover_photo" alt="Cover Photo" class="h-10 w-10 object-cover rounded-full" />

                </td>
                <td class="px-6 py-4">
                    <Link :href="route('notes.edit', { note: note.id })" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</Link>
                    <Link :href="route('notes.destroy', { note: note.id })" method="delete" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</Link>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link} from "@inertiajs/vue3";

defineProps({
    notes: Array,
})


</script>
