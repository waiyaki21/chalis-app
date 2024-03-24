<script setup>
    import Checkbox from '@/Components/Checkbox.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';

    import GuestLayout from "../Layouts/GuestLayout.vue";
    import { onMounted, reactive } from 'vue';

    defineProps({
        canResetPassword: {
            type: Boolean,
        },
        status: {
            type: String,
        },
        users: {
            type: String,
            required: true,
        },
        data: Array
    });

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = () => {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };

    defineOptions({
        layout: (h, page) => h(GuestLayout, { data: page.props.data }, {
            default: () => page
        }),
    });

    onMounted(() => linkCheck())

    // alerts classes 
    const alerts = reactive({
        alertShow: false,
        alertType: '',
        alertDuration: 15000,
        flashMessage: '',
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',
    })

    function linkCheck() {
        alerts.flashMessage = 'This is an offline app be careful with your password as it cant be reset online but can be reset through profile settings or by contacting the developer!';
        alerts.alertType = 'warning';
        flashShow(alerts.flashMessage, alerts.alertType);
    }

    function flashShow(message, body) {
        alerts.flashMessage   = message;
        if(body == 'warning') {
            alerts.alertBody = alerts.alertWarning;
        }
        alerts.alertShow      = !alerts.alertShow;
    }
</script>

<template>
    <!-- <GuestLayout> -->
        <Head title="Log in" />


        <div v-if="status" class="mb-4 font-medium text-base text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email"  class="uppercase text-base"/>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password"  class="uppercase text-base"/>

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-base text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <!-- <Link
                    v-if="canResetPassword" @click="linkCheck"
                    :href="route('password.request')"
                    class="underline text-base text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link> -->

                <a @click="linkCheck"
                    class="underline text-base text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </a>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>

        <div class="flex items-center justify-end mt-4">
            <Link
                :href="'/register'"
                class="underline text-base text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Register An Account
            </Link>
        </div>

        <!-- flash alert  -->
        <alert
            :alertshow  = alerts.alertShow
            :message    = alerts.flashMessage
            :class      = alerts.alertBody
            :type       = alerts.alertType
            :title      = alerts.alertType
            :time       = alerts.alertDuration
        ></alert>
    <!-- </GuestLayout> -->
</template>
