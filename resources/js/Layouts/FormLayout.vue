<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <div
        class="flex min-h-screen flex-col items-center bg-gray-300 pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/" class="flex justify-center items-center">
                <img src="/images/rentral-house.jpeg" alt="rental-house" class=" rounded-md w-1/2">
            </Link>
        </div>

        <div
            class="mt-6 form-container overflow-hidden bg-white px-4 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>

</template>
<style>
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}
</style>
