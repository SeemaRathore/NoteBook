<template>
    <AuthenticatedLayout>
        <template #header>
        <div class="flex justify-between items-center">
            <Link :href="route('notes.index')" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Notes List</Link>
            <Link :href="route('notes.create')" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">+ Add Note</Link>
        </div>
        </template>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <FilterForm :tags="tags" @tag-selected="fetchNotesByTag" @filter="handleFilter"></FilterForm>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Tags</th>
                    <th scope="col" class="px-6 py-3">Cover Photo</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
                </thead>
                <tbody  v-if="notes && notes.data">


                <tr v-for="note in filterItems" :key="note.id" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input :id="'checkbox-table-' + note.id" :checked="hasTags(note)" type="checkbox"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label :for="'checkbox-table-' + note.id" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ note.title }}
                    </th>
                    <td class="px-6 py-4">
                        {{ note.description }}
                    </td>
                    <td class="px-6 py-4">
                        {{ note.tags }}
                    </td>
                    <td class="px-6 py-4">
                        <img :src="note.cover_photo ? '/storage/' + note.cover_photo : '/demo.png'" alt="Cover Photo" class="h-10 w-10 object-cover rounded-full" />
                    </td>

                    <td class="px-6 py-4">
                    <Link :href="route('notes.edit', { note: note.id })"  class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Edit</Link>
                        <Link :href="route('notes.destroy', { note: note.id })"  method="delete" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Delete</Link>
                        <Link :href="route('notes.show', { note: note.id })"  class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Preview</Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-if="notes.data.length" class="w-full flex justify-center mt-4 mb-4">
            <Pagination :links="notes.links" />
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link} from "@inertiajs/vue3";
import Pagination from '@/Components/Pagination.vue'
import FilterForm from '@/Pages/Notes/Components/FilterForm.vue'

import { usePage } from '@inertiajs/vue3';
import {computed, ref} from "vue";

const { props } = usePage();


defineProps({
    notes: Object,
    tags:Object
})

const hasTags = (note) => {
    return note.tags !== null && note.tags.trim() !== '';
};

const searchFilter = ref('');

const handleFilter = (search) => {
    searchFilter.value = search;
};

const filterItems = computed(() => {
    if (searchFilter.value !== '') {
        return props.notes.data.filter(item => item.tags.includes(searchFilter.value));
    }
    return props.notes.data;
});


</script>

