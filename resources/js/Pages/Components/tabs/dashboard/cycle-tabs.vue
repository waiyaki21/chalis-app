<template>
    <div class="p-2 flex-col space-y-2" id="cycles" role="tabpanel" aria-labelledby="cycles-tab">
        <h3 :class="[classInfo.headerMain]" @click="classInfo.viewShow = !classInfo.viewShow" preserve-scroll>
            <span>
                <span>View Payment Cycles</span>
                <span class="text-xs text-gray-500 dark:text-gray-500 ml-4">
                    ( {{ props.cycles.length }} Cycles)
                </span>
            </span>

            <button class="cursor-pointer text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white bg-transparent dark:bg-transparent dark:hover:bg-cyan-700 border-2 border-gray-300 dark:border-cyan-300 dark:hover:border-cyan-500 rounded-full py-2 px-2 m-2 inline-flex justify-center">
                <svg class="w-4 h-4 text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white" aria-hidden="true" fill="none" viewBox="0 0 10 6" v-if="!classInfo.viewShow">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white" v-else>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </button>
        </h3>

        <section class="grid grid-cols-1 md:grid-cols-4" v-if="classInfo.viewShow">
            <!-- forms  -->
            <cycleform
                :cycles     = props.cycles
                :nextname   = props.nextname
                :date       = props.date
                :settings   = props.settings
                :current    = props.current
            ></cycleform>
        </section>

        <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-gray-300/30">
    </div>
</template>

<script setup>
    import { defineProps, reactive } from 'vue';

    const props = defineProps({
        settings: {
            type: Object,
            required: true,
        },
        current: {
            type: Object,
            required: true,
        },
        cycles: {
            type: Array,
            required: true,
        },
        nextname: {
            type: String,
            required: true,
        },
        date: {
            type: String,
            required: true,
        }
    })

    const classInfo = reactive ({
        viewShow: false,
        headerMain: 'font-normal text-[1.95rem] text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 w-full inline-flex justify-between my-1 hover:text-cyan-500 dark:hover:text-cyan-500 cursor-pointer',
    })
</script>