<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import Pagination from "@/Components/Pagination.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    data: {
        type: Object,
        required: true,
        default: () => ({
            data: [],
            links: []
        }),
    },
    searchRoute: {
        type: String,
        required: true,
    }
});

const search = ref('');

watch(search, (newSearch) => {
    // Perform a manual visit to the backend when the search changes
    router.get(searchRoute, { search: newSearch }, { preserveState: true, replace: true });
});
</script>

<template>
    <div>
        <!-- Search Input -->
        <TextInput v-model="search" class="mb-3.5" placeholder="Search..." />

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th v-for="(column, index) in columns" :key="index" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ column.label }}
                    </th>
                </tr>
                </thead>
                <tbody v-if="data.data.length > 0" class="bg-white divide-y divide-gray-200">
                <tr v-for="row in data.data" :key="row.id">
                    <td v-for="(column, index) in columns" :key="index" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ row[column.field] }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <Pagination :links="data.links" />
    </div>
</template>
