<script setup>
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header class="font-boldened my-4">
            <p class="mt-1 text-lg text-rose-600 dark:text-rose-300 w-full inline-flex justify-between">
                <span class="text-[5rem] font-bold mr-2 w-[10%] flex justify-center">*</span>
                <span class="mt-4 text-2xl font-sans w-[90%]">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</span>
            </p>
        
            <hr class="w-[90%] my-2 mx-auto border-t-4 border-rose-800 dark:border-rose-300/30 shadow-lg shadow-rose-400">

            <button type="button" class="text-white bg-gradient-to-r from-rose-600 to-red-500 hover:bg-gradient-to-l focus:ring-1 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-xl px-4 py-2.5 text-center mb-2 uppercase inline-flex justify-center w-full shadow-md my-2" @click="confirmUserDeletion">
                Delete Account
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-4 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </button>

        </header>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="px-4 py-8 font-boldened">
                <h2 class="text-xl uppercase underline mb-2 font-normal text-gray-900 dark:text-white">
                    Are you sure you want to delete your account?
                </h2>

                <p class="mt-1 text-base flex-col space-y-2 text-gray-600 dark:text-white font-sans my-4">
                    Once your account is deleted, all of its resources and data will be permanently deleted. <br> Please
                    enter your password to confirm you would like to permanently delete your account.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only text-white uppercase hover:underline text-lg"/>

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2 uppercase text-lg" />
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-1 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-base px-5 py-2.5 text-center me-2 mb-2 uppercase w-full" @click="closeModal"> Cancel </button>

                    <DangerButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
