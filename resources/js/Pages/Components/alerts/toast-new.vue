<template>
    <notifications 
        group='toast'
        position="top right" 
        width="400px"
        :classes="[props.class, 'animate__animated animate__slideInDown']"
        :type="props.type"
        @click="props.close">
        <!-- <slot /> -->
        <template slot="body" slot-scope="props" #body="props">
            <div :class="['flex flex-col items-center w-full max-w-md p-2 space-y-2 text-white divide-x divide-black rounded-md shadow-sm dark:shadow-sm top-24 dark:divide-black z-120 cursor-pointer my-1 my-notification', props.class]">
                <section class="inline-flex w-full">
                    <section class="w-[7%]">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="['w-6 h-6 my-2 text-black dark:text-black animate__animated animate__swing animate__delay-1s animate__infinite']">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                        </svg>
                    </section>

                    <div :class="['pl-4 text-base font-normal uppercase underline font-boldened text-black dark:text-black whitespace-normal notification-title']" v-html="props.item.text"/> 
                </section>
                <hr class="w-[90%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-[2.5px] dark:border-gray-300/30 md:block sm:hidden">
                <div :class="['w-full px-2 justify-between font-normal uppercase font-boldened text-gray-800 dark:text-gray-800 whitespace-normal notification-content sm:inline-flex hidden']">
                    <span class="underline">{{ $page.component }}</span>
                    <span class="inline-flex"><svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {{ moment().format("ddd, Do/MM/YY HH:MM:SS A") }}</span>
                </div>
            </div>
        </template>
    </notifications>

    <notifications 
        group='loading'
        position="top right" 
        width="400px"
        :classes="[props.class, 'animate__animated animate__slideInDown']"
        :type="props.type"
        @click="props.close">
        <!-- <slot /> -->
        <template slot="body" slot-scope="props" #body="props">
            <div :class="['flex flex-col items-center w-full max-w-md p-2 space-y-2 text-white divide-x divide-black rounded-md shadow-sm dark:shadow-sm top-24 dark:divide-black z-120 cursor-pointer my-1 my-notification', props.class]">
                <section class="inline-flex w-full">
                    <section class="w-[7%]">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="['w-6 h-6 my-2 text-black dark:text-black animate__animated animate__swing animate__delay-1s animate__infinite']">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                        </svg>
                    </section>

                    <div :class="['pl-4 text-base font-normal uppercase underline font-boldened text-black dark:text-black whitespace-normal notification-title']" v-html="props.item.text"/> 
                </section>
                <hr class="w-[90%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-[2.5px] dark:border-gray-300/30 md:block sm:hidden">
                <div :class="['w-full px-2 justify-between font-normal uppercase font-boldened text-gray-800 dark:text-gray-800 whitespace-normal notification-content sm:inline-flex hidden']">
                    <span class="underline">{{ $page.component }}</span>
                    <span class="inline-flex"><svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {{ moment().format("ddd, Do/MM/YY HH:MM:SS A") }}</span>
                </div>
            </div>
        </template>
    </notifications>
</template>

<script setup>
    import { defineProps, watch, computed } from 'vue';
    import { useNotification } from "@kyvg/vue3-notification";
    import moment from 'moment';

    const { notify } = useNotification()

    const props = defineProps({
        message: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
        alertshow: {
            type: Boolean,
            required: true,
        },
        class: {
            type: String,
            required: true,
        },
        link: {
            type: String,
            required: true,
        },
        url: {
            type: String,
            required: true,
        },
        url2: {
            type: String,
            required: true,
        },
        state: {
            type: Object,
            required: true,
        },
        page: {
            type: Boolean,
            required: true,
        },
        time: {
            type: String,
            required: true,
        }
    })

    const type = computed(() => props.alertshow);

    const id = Date.now()

    watch(type, (newValue) => {
        show();
    })

    const loading = computed(() => props.time);

    watch(loading, (newValue) => {
        showLoading();
    })

    function show() {
        notify(
            {
                id,
                title:      props.title,
                text:       props.message,
                duration:   10000,
                type:       props.type,
                max:        5,
                reverse:    true,
                group:      'toast',
                ignoreDuplicates: true,
                closeOnClick: true,
                // clean: true
            }
        );
    }

    function close(id) {
        notify.close(id)
    }

    function showLoading() {
        notify(
            {
                id,
                title:      props.title,
                text:       props.message,
                duration:   60000,
                type:       props.type,
                max:        1,
                reverse:    true,
                group:      'loading',
                ignoreDuplicates: true,
                closeOnClick: true,
                clean: true
            }
        );
    }
</script>

<style scoped>
    .my-notification {
        background: #44a4fc;
        border-bottom: 4px solid #187fe7;
    }
        /* // types (green, amber, red) */
    .my-notification.success {
        background: rgb(14 159 110 / var(--tw-bg-opacity));
        border-bottom-color: rgb(6 95 70 / var(--tw-border-opacity));
    }

    .my-notification.warning {
        background: rgb(255 90 31 / var(--tw-bg-opacity));
        border-bottom-color: rgb(138 44 13 / var(--tw-border-opacity));
    }

    .my-notification.info {
        background-color: rgb(63 131 248 / var(--tw-bg-opacity));
        border-bottom-color: rgb(30 66 159 / var(--tw-border-opacity));
    }

    .my-notification.danger {
        background-color: rgb(240 82 82 / var(--tw-bg-opacity));
        border-bottom-color:rgb(155 28 28 / var(--tw-border-opacity));
    }

    .notification-title {
        font-size: 1.2rem;
        font-weight: 300;
    }

    .notification-content {
        font-size: 0.7rem;
    }

    .vue-notification-group {
        display: block;
        position: fixed;
        z-index: 5000;
        top: 4rem !important;
        right: 2rem !important;
    }
</style>