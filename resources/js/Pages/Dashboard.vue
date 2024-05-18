<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <Link :href="route('notes.index')" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Notes List</Link>
            </div>
        </template>
        <div>Welcome</div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head ,Link} from '@inertiajs/vue3';
</script>
