<!-- UserResponseChart.vue -->
<template>
    <div class="chart-container">
        <Chart
            :size="{ width: 700, height: 400 }"
            :data="data"
            :margin="margin"
            :direction="direction"
        >
            <template #layers>
                <Grid strokeDasharray="2,2" />
                <Line
                    v-for="form in forms"
                    :key="form.form_name"
                    :dataKeys="['date', form.form_name]"
                    :name="form.form_name"
                />
            </template>
        </Chart>
    </div>
</template>

<script setup>
import { defineProps, ref } from 'vue';
import { Chart, Grid, Line } from 'vue3-charts';

// Props to accept chart data and the form names
const props = defineProps({
    data: Array, // The chart data (array of objects with date and form response counts)
    forms: Array // The form names (array of objects with form_name)
});

// Set default margin and chart direction
const margin = ref({
    left: 0,
    top: 20,
    right: 20,
    bottom: 40
});

const direction = ref('horizontal');
</script>

<style scoped>
.chart-container {
    margin: 20px;
}
</style>
