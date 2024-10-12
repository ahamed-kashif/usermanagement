<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3'
const props = defineProps({
    title: String
})
</script>
<template>
    <Head :title="props?.title ?? 'Application Form'" />

    <slot />
</template>
<style>
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}
</style>
