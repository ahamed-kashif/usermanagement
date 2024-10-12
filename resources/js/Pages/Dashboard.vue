<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
defineProps(
    {
            urls: {
                type: Object
            }
        })
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200 table-auto">
                            <thead class="bg-gray-50">
                            <tr>
                                <th v-if="$page.props.auth.user.role === 'admin'" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Form
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Url
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Responses
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="uri in urls" :key="uri.id">
                                <td class="px-6 py-4 whitespace-nowrap" v-if="$page.props.auth.user.role === 'admin'">
                                    <strong>{{ uri.user.email }}</strong>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ uri.form }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code>{{ route('forms.u', uri.url) }}</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <strong>{{ uri.res_count }}</strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
