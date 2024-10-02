<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Responses
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <!-- Iterate over paginated responses -->
                        <div v-for="response in responses.data" :key="response.id" class="response-card">
                            <div class="response-header">
                                <h1>SSN: {{ response.ssn }}</h1>
                                <a :href="downloadUrl(response.id)" class="download-btn">Download all files as ZIP</a>
                            </div>

                            <!-- Formatted response data -->
                            <div class="response-body">
                                <h3>Response Details</h3>
                                <table>
                                    <tr v-for="(value, key) in formattedResponse(response.response)" :key="key">
                                        <td>{{ formatKey(key) }}</td>
                                        <td>{{ value }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination component -->
                        <Pagination
                            v-if="responses.data.length > 0"
                            :links="responses.links"
                        />
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Props passed from controller
const props = defineProps({
    responses: Object
});

// Method to handle downloading all files
const downloadUrl = (responseId) => {
    return route('response.download', responseId);
};

// Format response data for display
const formattedResponse = (response) => {
    // If response is a string (because it's stored as JSON), parse it
    if (typeof response === 'string') {
        return JSON.parse(response);
    }
    return response;
};

// Format keys to be more readable
const formatKey = (key) => {
    return key
        .replace(/_/g, ' ') // Replace underscores with spaces
        .replace(/\b\w/g, char => char.toUpperCase()); // Capitalize first letters
};
</script>

<style scoped>
.response-card {
    border: 1px solid #ccc;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 8px;
}

.response-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.download-btn {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 5px;
    text-decoration: none;
}

.response-body {
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table td {
    padding: 8px;
    border: 1px solid #ddd;
}

table td:first-child {
    font-weight: bold;
}
</style>
