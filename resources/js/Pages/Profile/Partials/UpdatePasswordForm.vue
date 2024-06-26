<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header class="font-boldened">
            <h2 class="text-2xl font-medium text-gray-900 dark:text-gray-300 uppercase underline">Update Password</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6 font-boldened">
            <div>
                <InputLabel for="current_password" value="Current Password" class="text-gray-500 uppercase hover:underline text-lg"/>

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                />

                <InputError :message="form.errors.current_password" class="mt-2 uppercase text-lg" />
            </div>

            <div>
                <InputLabel for="password" value="New Password" class="text-gray-500 uppercase hover:underline text-lg"/>

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="mt-2 uppercase text-lg" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirm Password" class="text-gray-500 uppercase hover:underline text-lg"/>

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2 uppercase text-lg" />
            </div>

            <div class="flex items-center gap-4">
                <SubmitButton :disabled="form.processing" :loading="form.processing" :success="form.wasSuccessful"
                    :failed="form.hasErrors" :editting="form.isDirty">
                    Update Password.
                </SubmitButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-white">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
