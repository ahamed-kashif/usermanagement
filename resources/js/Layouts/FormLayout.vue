<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>


    <slot />
</template>
<style>
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}
</style>
