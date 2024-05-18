<template>
    <div class="pb-4 bg-white dark:bg-gray-900">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" v-model="searchQuery" @input="filterTags">
            <ul v-if="filteredTags.length > 0">
                <li v-for="tag in filteredTags" :key="tag" @click="selectTag(tag)">{{ tag }}</li>
            </ul>
        </div>
    </div>

</template>

<script>
export default {
    props: ['tags'],
    data() {
        return {
            searchQuery: '',
            filteredTags: []
        };
    },
    methods: {
        filterTags() {
            const query = this.searchQuery.toLowerCase();
            if (query.trim() === '') {
                this.filteredTags = [];
            } else {
                this.filteredTags = this.tags.filter(tag => tag.toLowerCase().includes(query));
            }
            this.$emit('filter', query); // Emit event with search query
        },
        selectTag(tag) {
            this.$emit('tag-selected', tag); // Emit event with selected tag
            this.searchQuery = tag; // Set search query to selected tag
            this.filteredTags = []; // Clear filtered suggestions
            this.$emit('filter', tag); // Emit event with selected tag as query
        }
    }

}

const filter = () => {
    // Emit a custom event to notify parent component
    emit('filter');
};
</script>
