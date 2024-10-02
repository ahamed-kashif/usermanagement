<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import DataTable from "@/Components/DataTable.vue";

const columns = ref([
    { label: 'ID', field: 'id' },
    { label: 'Name', field: 'name' },
    { label: 'Email', field: 'email' },
    { label: 'No. Responses', field: 'responses_count' }
]);

defineProps({
    users: {
        type: Object,
        default: () => ({
            data: [],
            links: []
        })
    }
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Users</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Use the reusable TableWithPagination component -->
                        <div class="flex justify-end">
                            <a :href="route('users.create')" class="no-underline w-1/6 px-2 py-4 bg-blend-luminosity bg-amber-200 text-center mb-4 hover:bg-amber-500 hover:shadow hover:text-amber-50 hover:shadow-amber-300">
                                <span class="font-bold ">Add New User</span>
                            </a>
                        </div>
                        <DataTable
                            :columns="columns"
                            :data="users"
                            searchRoute="/users"
                            :hasAction="true"
                            :editRoute="(id) => route('users.edit', id)"
                            :deleteRoute="(id) => route('users.delete', id)"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
