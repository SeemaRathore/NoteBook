<template>

    <AuthenticatedLayout>

        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" :src="notes.cover_photo ? '/storage/' + notes.cover_photo : '/demo.png'" alt="" />
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Title :  {{ notes.title }}</h5>
                </a>

                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Description :  {{ notes.description }}</p>
                <h2>Tags :  {{ notes.tags }}</h2>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
const props = defineProps({
    notes: Object,

})
</script>
