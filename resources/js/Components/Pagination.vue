<template>
    <div class="flex gap-1">
        <Link
            v-for="(note, index) in notes"
            :key="index" class="py-2 px-4 rounded-md"
            :href="note.url"
            :class="{'bg-indigo-500 dark:bg-indigo-800 text-gray-300': note.active}"
            v-html="note.label"
        />
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
defineProps({notes: Array})
</script>
