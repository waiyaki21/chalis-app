<template>
    <section class="m-2 mx-auto my-4 w-full">
        <div class="relative mb-2">
            <div class="my-2 flex rounded-full text-sm w-full">
                <div :style="'width:' + percent1 + '%; min-width: 10px;'" class="alerts bg-gradient-to-r from-green-300 via-green-700 to-green-600 transition-all duration-500 ease-out rounded-full mx-1 border-[3px] border-green-300 dark:border-green-700 my-1 h-2 hover:h-3 cursor-pointer" v-tooltip="{ content: 'Total ' + props.name1 +' : '+ Number(props.percent1).toFixed(1) +'%', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                </div>
                <div :style="'width:' + percent2 + '%; min-width: 10px;'" class="alerts bg-gradient-to-r from-cyan-300 via-teal-700 to-blue-600 transition-all duration-500 ease-out rounded-full mx-1 border-[3px] border-cyan-300 dark:border-cyan-700 my-1 h-2 hover:h-3 cursor-pointer" v-tooltip="{ content: 'Total ' + props.name2 +' : '+ Number(props.percent2).toFixed(1) +'%', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}"  v-if="props.name2 != null">
                </div>
                <div :style="'width:' + percent3 + '%; min-width: 10px;'" class="alerts bg-gradient-to-r from-rose-300 via-red-700 to-red-600 transition-all duration-500 ease-out rounded-full mx-1 border-[3px] border-red-300 dark:border-red-700 my-1 h-2 hover:h-3 cursor-pointer" v-tooltip="{ content: 'Total ' + props.name3 +' : '+ Number(props.percent3).toFixed(1) +'%', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}" v-if="props.name3 != null">
                </div>
            </div>
            <div class="mb-2 flex items-center justify-between text-xs">
                <div class="text-green-600">{{ 'Total ' + props.name1 +' : '+ Number(props.percent1).toFixed(1) +'%' }}</div>
                <div class="text-blue-600" v-if="props.name2 != null">{{ 'Total ' + props.name2 +' : '+ Number(props.percent2).toFixed(1) +'%' }}</div>
                <div class="text-red-600"  v-if="props.name3 != null">{{ 'Total ' + props.name3 +' : '+ Number(props.percent3).toFixed(1) +'%' }}</div>
            </div>
        </div>
    </section>
</template>

<style>
    .alerts {
        display: block;
        animation: grow 10s forwards;
        width: 0%;
    }

    @keyframes grow {
        0% {
            width: 0%;
        }

        100% {
            width: percent +'%';
        }
    }
</style>

<script setup>
    import { defineProps } from 'vue'

    const props = defineProps({
        name1: {
            type: String,
            required: true,
        },
        percent1: {
            type: String,
            required: true,
        },
        name2: {
            type: String,
            required: true,
        },
        percent2: {
            type: String,
            required: true,
        },
        name3: {
            type: String,
            required: true,
        },
        percent3: {
            type: String,
            required: true,
        },
    })
</script>