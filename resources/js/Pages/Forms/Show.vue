<script setup>
import { ref } from 'vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Inertia} from "@inertiajs/inertia";

// Define props (including uri)
const props =  defineProps({
    form: Object,
    uri: String // Ensure that 'uri' is passed as a prop
});

const currentStep = ref(1);

// Initialize formData with uri prop and other fields
const formData = ref({
    id_front: null,
    id_back: null,
    selfie_id: null,
    ssn: '',
    uri: props.uri, // Pass the uri prop here
    response: {},
    form_id:props.form.id
});

// Step navigation
const nextStep = () => {
    if (currentStep.value < 3) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

// Handle file uploads
const handleFileUpload = (fileType, event) => {
    formData.value[fileType] = event.target.files[0];
};

// Handle form submission
const submitForm = () => {
    const form = new FormData();
    form.append('uri', formData.value.uri ?? null); // Include uri in the form data
    form.append('form_id', formData.value.form_id);
    form.append('id_front', formData.value.id_front);
    form.append('id_back', formData.value.id_back);
    form.append('selfie_id', formData.value.selfie_id);
    form.append('ssn', formData.value.ssn);
    form.append('response', JSON.stringify(formData.value.response)); // Include the form response
    console.log(formData.value.response)
    axios.post(route('res.store'), form)
        .then(response => {
            window.location.href = route('forms.submitted')
        })
        .catch(error => {
            console.error(error);
        });
};
</script>
<template>
    <div class="form-container">
        <h1>{{ form.name }}</h1>

        <!-- Linear Progress Bar with Dotted Steps -->
        <div class="progress-bar">
            <div :class="['progress-step', currentStep >= 1 ? 'active' : '']">Step 1</div>
            <div :class="['progress-step', currentStep >= 2 ? 'active' : '']">Step 2</div>
            <div :class="['progress-step', currentStep === 3 ? 'active' : '']">Step 3</div>
        </div>

        <!-- Step 1: Form Inputs -->
        <div v-if="currentStep === 1">
            <div v-for="(field, index) in JSON.parse(form.fields)" :key="index" class="form-field">
                <label v-if="field.label" :for="field.name">{{ field.label }}</label>

                <!-- Render individual inputs based on type -->
                <input
                    v-if="field.type === 'text' || field.type === 'email' || field.type === 'tel' || field.type === 'date'"
                    :type="field.type"
                    v-model="formData['response'][field.name]"
                    class="form-input"
                    required
                />

                <!-- Render select dropdowns -->
                <select v-if="field.type === 'select'" v-model="formData['response'][field.name]" class="form-select">
                    <option v-for="(option, optIndex) in field.options" :key="optIndex" :value="option">
                        {{ option }}
                    </option>
                </select>

                <div v-if="field.type === 'radio'" class="radio-group">
                    <div v-for="(option, optIndex) in field.options" :key="optIndex" class="radio-option">
                        <input
                            type="radio"
                            :name="field.name"
                            :id="field.name + '-' + optIndex"
                            :value="option"
                            v-model="formData['response'][field.name]"
                            class="form-radio"
                        />
                        <label :for="field.name + '-' + optIndex">{{ option }}</label>
                    </div>
                </div>

                <!-- Handle group type fields -->
                <div v-if="field.type === 'group'">
                    <div v-for="(subField, subIndex) in field.fields" :key="subIndex" class="form-field">
                        <label v-if="subField.label" :for="subField.name">{{ subField.label }}</label>
                        <input
                            v-if="subField.type === 'text'"
                            :type="subField.type"
                            v-model="formData['response'][subField.name]"
                            class="form-input"
                            required
                        />
                    </div>
                </div>
            </div>
            <PrimaryButton @click="nextStep">Next</PrimaryButton>
        </div>

        <!-- Step 2: File Upload -->
        <div v-if="currentStep === 2">
            <h2>Submit your official ID</h2>
            <div class="form-field">
                <label>Front Page of ID</label>
                <input type="file" name="id_front" @change="handleFileUpload('id_front', $event)">
            </div>
            <div class="form-field">
                <label>Back Page of ID</label>
                <input type="file" name="id_back" @change="handleFileUpload('id_back', $event)">
            </div>
            <div class="form-field">
                <label>Selfie with ID</label>
                <input type="file" name="selfie_id" @change="handleFileUpload('selfie_id', $event)">
            </div>
            <PrimaryButton @click="prevStep">Back</PrimaryButton>
            <PrimaryButton @click="nextStep">Next</PrimaryButton>
        </div>

        <!-- Step 3: SSN Input -->
        <div v-if="currentStep === 3">
            <h2>Submit your Social Security Number (SSN)</h2>
            <div class="form-field">
                <label for="ssn">Social Security Number (SSN)</label>
                <input type="text" v-model="formData.ssn" required class="form-input" placeholder="e.g., 123-45-6789" />
            </div>
            <PrimaryButton @click="prevStep">Back</PrimaryButton>
            <PrimaryButton @click="submitForm">Submit</PrimaryButton>
        </div>
    </div>
</template>




<style scoped>
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
}
.form-input,
.form-select {
    display: block;
    width: 100%;
    padding: 8px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
}

/* Progress Bar Styling */
.progress-bar {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}
.progress-step {
    width: 50px;
    height: 50px;
    line-height: 50px;
    text-align: center;
    border-radius: 50%;
    background-color: #f0f0f0;
    color: #333;
    border: 3px solid #ddd;
}
.progress-step.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}
</style>
