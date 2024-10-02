<script setup>
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
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
    },
    hasAction: {
        type: Boolean,
        default: false, // Controls if the action column should be displayed
    },
    editRoute: {
        type: Function,
        default: (id) => `#`, // A default route for editing, but configurable
    },
    deleteRoute: {
        type: Function,
        default: (id) => `#`, // A default route for deleting, but configurable
    },
    deleteMethod: {
        type: String,
        default: 'DELETE', // Allows you to change the HTTP method if necessary
    },
});

const search = ref('');

watch(search, (newSearch) => {
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

                    <!-- Action Column Header -->
                    <th v-if="hasAction" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody v-if="data.data.length > 0" class="bg-white divide-y divide-gray-200">
                <tr v-for="row in data.data" :key="row.id">
                    <!-- Render Data Columns -->
                    <td v-for="(column, index) in columns" :key="index" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ row[column.field] }}
                    </td>

                    <!-- Action Column with Edit and Delete Buttons -->
                    <td v-if="hasAction" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <!-- Edit Button (using dynamic route from props) -->
                        <Link :href="editRoute(row.id)" class="text-blue-500 hover:underline">Edit</Link>

                        <!-- Delete Button (using dynamic route and method from props) -->
                        <form :action="deleteRoute(row.id)" method="POST" class="inline-block">
                            <input type="hidden" name="_method" :value="deleteMethod" />
                            <button type="submit" class="text-red-500 hover:underline ml-4" @click.prevent="deleteUser(row.id)">Delete</button>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <Pagination :links="data.links" />
    </div>
</template>

<script>
export default {
    methods: {
        deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                this.$inertia.delete(this.deleteRoute(userId));
            }
        }
    }
}
</script>
