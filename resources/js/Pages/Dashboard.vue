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
                        <ul>
                            <li v-for="uri in urls" :key="uri.id">
                                <strong v-if="$page.props.auth.user.role === 'admin'">{{uri.user.email}} <span> : </span></strong>
                                <span>{{uri.url}}</span>
                                <span>  </span>
                                <strong>({{uri.res_count}})</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
