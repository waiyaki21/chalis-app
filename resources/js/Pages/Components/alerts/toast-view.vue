<template> 
    <div id="view-notification" :class="[classInfo.alertClass, props.class, 'flex-col space-y overflow-hidden block z-[120]']" v-show="classInfo.show" role="alert" @click="hide">

        <section class="w-full flex-col space-y px-1 pt-1">
            <div class="w-full inline-flex justify-start mb-1">
                <section class="w-[7%]">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="[classInfo.svgClass]" v-if="!classInfo.fileLink">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                </svg>
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="[classInfo.svgClass]" v-else>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                </section>
                <div :class="[classInfo.textClass]">
                    {{ props.message }}
                </div>   
            </div>
        </section>

        <section class="w-full grid grid-cols-1 md:grid-cols-5 md:gap-2 bg-gray-600/30 p-2" style="border-left: 0px;margin-left: 0px;">
            <div class="col-span-4">
                <button @click="goTo(props.url)" :class="[classInfo.btnLink]" v-if="!classInfo.fileLink" :title="props.link">
                    {{ props.link }}
                </button>
                <a :href="props.url" :class="[classInfo.btnLink]" :title="props.link" v-else>
                    {{ props.link }}
                </a>
            </div>
            <div class="col-span-1">
                <a @click="hide" :class="[classInfo.btnClose]" title="Close Modal">
                    Close
                </a> 
            </div>
        </section>

        <section class="mx-auto w-full">
            <div class="relative">
                <div class="flex rounded-full text-sm w-full">
                    <div :style="'width:100%; min-width: 10px;'" class="alerts-loading bg-gradient-to-r from-gray-300/50 via-gray-700/50 to-gray-600/50 border-[2px] border-gray-300 dark:border-gray-700 h-2 rounded-lg">
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style>
    .alerts-loading {
        display: block;
        animation: grow 25s forwards;
        width: 0%;
    }
</style>

<script setup>
    import { defineProps, reactive, watch, computed } from 'vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        message: {
            type: String,
            required: true,
        },
        alertshowview: {
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
        }
    })

    // alerts classes 
    const alerts = reactive({
        alertBody: '',
        alertDuration: 20000,
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',
    })

    const classInfo = reactive ({
        time        : '',
        show        : false,
        alertClass  : 'fixed inline-flex items-center w-full max-w-md text-white divide-x divide-black rounded-md shadow-sm dark:shadow-sm right-5 bottom-[5rem] dark:divide-black z-120 cursor-pointer',
        textClass   : 'pl-2 text-[1.45rem] font-medium uppercase underline font-boldened text-black dark:text-black',
        fileLink    : false, 

        svgClass    : 'w-8 h-8 text-black dark:text-black mt-1 animate__animated animate__bounceInLeft',

        btnLink     : 'text-black dark:text-black bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-800 font-medium rounded-lg px-5 py-2.5 text-center uppercase inline-flex w-full mb-2 justify-center font-medium text-base font-boldened border-2 border-gray-800 dark:border-gray-800',
        btnClose    : 'focus:outline-none text-black dark:text-black bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 uppercase w-full inline-flex justify-center font-medium text-base font-boldened border-2 border-gray-800 dark:border-gray-800'
    })

    const type = computed(() => props.alertshowview);

    watch(type, (newValue) => {
        see();
    })

    function hide() {
        classInfo.show = false;
    }

    function see() {
        classInfo.show = true;

        if (props.state) {
            classInfo.fileLink = true;
        } else {
            classInfo.fileLink = false;
        }

        setTimeout(() => {
            hide();
        }, alerts.alertDuration);
    }

    function goTo(url) {
        router.visit(url, { method: 'get' , preserveScroll: true })
    }
</script>