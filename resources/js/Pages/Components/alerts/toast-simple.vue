<template> 
    <div id="toast-notification" :class="[classInfo.alertClass, props.class]" v-show="classInfo.show" role="alert" @click="hide" style="z-index: 120 !important;">
        <section class="w-[7%]">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="['w-8 h-8 text-black dark:text-black']">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
            </svg>
        </section>

        <div :class="['pl-4 text-base font-medium uppercase underline font-boldened text-black dark:text-black whitespace-normal']">
            {{ props.message }}
        </div>       
    </div>
</template>
       
<script setup>
    import { defineProps, reactive, watch, computed } from 'vue';

    const props = defineProps({
        message: {
            type: String,
            required: true,
        },
        alertShow: {
            type: Boolean,
            required: true,
        },
        class: {
            type: String,
            required: true,
        },
        time: {
            type: String,
            required: true,
        }
    })

    const classInfo = reactive ({
        show        : false,
        alertClass  : 'fixed inline-flex items-center w-full max-w-md px-2 py-4 space-x-2 text-white divide-x divide-black rounded-md shadow-sm dark:shadow-sm right-5 top-24 dark:divide-black z-120 cursor-pointer',
    })

    const type = computed(() => props.alertShow)

    watch(type, (newValue) => {
        hide()
        see()
    })

    const typetime = computed(() => props.time)

    watch(typetime, (newValue) => {
        hide()
        timed()
    })

    function hide() {
        classInfo.show = false;
    }

    function see() {
        classInfo.show = true;

        setTimeout(() => {
            hide();
        }, 15000);
    }

    function timed() {
        classInfo.show = true;
    }
</script>