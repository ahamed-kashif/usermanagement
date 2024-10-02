<template>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            <span v-if="hasPrevLink()">
                <button
                    @click="goToPage(prevLink())"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                >
                    Previous
                </button>
            </span>
            <span v-if="hasNextLink()">
                <button
                    @click="goToPage(nextLink())"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                >
                    Next
                </button>
            </span>
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ firstItem() }}</span> to <span class="font-medium">{{ lastItem() }}</span> of <span class="font-medium">{{ totalItems() }}</span> results
                </p>
            </div>
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    <button
                        v-for="(link, index) in links"
                        :key="index"
                        @click="goToPage(link.url)"
                        :class="[
                            'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                            link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                            link.url == null ? 'cursor-not-allowed' : ''
                        ]"
                        :disabled="link.url == null"
                        v-html="link.label"
                    />
                </span>
            </div>
        </div>
    </nav>
</template>

<script>
import { router } from '@inertiajs/vue3'

export default {
    props: {
        links: Array, // Links passed from Laravel pagination
    },
    methods: {
        goToPage(link) {
            if (link) {
                router.visit(link)
            }
        },
        hasPrevLink() {
            return this.links.find((link) => link.label === 'Previous &laquo;');
        },
        hasNextLink() {
            return this.links.find((link) => link.label === 'Next &raquo;');
        },
        prevLink() {
            return this.hasPrevLink().url;
        },
        nextLink() {
            return this.hasNextLink().url;
        },
        firstItem() {
            return this.links[1]?.label || 1;
        },
        lastItem() {
            return this.links[this.links.length - 2]?.label || 1;
        },
        totalItems() {
            return this.links.total || 0;
        }
    }
};
</script>
