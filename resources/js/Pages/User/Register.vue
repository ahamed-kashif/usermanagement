<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

// Accept a prop to handle the user data (for updating)
const props = defineProps({
    user: {
        type: Object,
        default: null, // If there's no user, the form will be for creating
    },
});

// Initialize the form, either for creating or updating
const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    password: '',
    password_confirmation: '',
});
const goBack = () => {
    window.history.back();
};
// Handle form submission
const submit = () => {
    if (props.user) {
        // Update the user
        form.put(route('users.update', props.user.id), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    } else {
        // Create a new user
        form.post(route('users.store'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    }
};
</script>

<template>
    <Head :title="props.user ? 'Update User' : 'Register'"/>
    <GuestLayout>


        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <!-- Only show the password fields when creating a user or if the user wants to update their password -->
            <div class="mt-4">
                <InputLabel for="password" value="Password"/>

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    :required="!props.user"
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password"/>
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    :required="!props.user"
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    type="button"
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    @click="goBack"
                >
                    Go Back
                </PrimaryButton>
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ props.user ? 'Update User' : 'Register' }}
                </PrimaryButton>

            </div>
        </form>
    </GuestLayout>
</template>
