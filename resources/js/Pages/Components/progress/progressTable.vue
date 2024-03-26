<template>
    <section class="w-full flex" v-if="percent == 100">
        <div class="relative w-full">
            <div :class="[classInfo.rowClass]">
                <div :class="[classInfo.progressClass100]" :style="'width:' + percent + '%; min-width:5px'">
                    <span class="flex justify-center text-black font-boldened"></span>
                </div>
            </div>
        </div>
        <span :class="[classInfo.progressInfo100]" v-tooltip="{ content: classInfo.message }">
            {{ percent }}%
        </span>
    </section>
    <section class="w-full flex" v-if="percent >= 50 && percent < 100">
        <div class="relative w-full">
            <div :class="[classInfo.rowClass]">
                <div :class="[classInfo.progressClass]" :style="'width:' + percent + '%; min-width:5px'">
                    <span class="flex justify-center text-black font-boldened"></span>
                </div>
                <div :class="[classInfo.progressClassDiff]"
                    :style="'width:' + Number(100 - percent).toLocaleString() + '%;'">
                    <span class="flex justify-center text-black font-boldened"></span>
                </div>
            </div>
        </div>
        <span :class="[classInfo.progressInfo]" v-tooltip="{ content: classInfo.message }">
            {{ percent }}%
        </span>
    </section>
    <section class="w-full flex" v-if="percent > 30 && percent < 50">
        <div class="relative w-full">
            <div :class="[classInfo.rowClass]">
                <div :class="[classInfo.progressClassLow]" :style="'width:' + percent + '%; min-width:5px'">
                    <span class="flex justify-center text-black font-boldened"></span>
                </div>
                <div :class="[classInfo.progressClassDiff]"
                    :style="'width:' + Number(100 - percent).toLocaleString() + '%;'">
                    <span class="flex justify-center text-black font-boldened"></span>
                </div>
            </div>
        </div>
        <span :class="[classInfo.progressInfoLow]" v-tooltip="{ content: classInfo.message }">
            {{ percent }}%
        </span>
    </section>
    <section class="w-full flex" v-if="percent < 30">
        <div class="relative w-full">
            <div :class="[classInfo.rowClass]">
                <div :class="[classInfo.progressClassZero]" :style="'width:' + percent + '%; min-width:5px'">
                    <span class="flex justify-center text-black font-boldened"></span>
                </div>
                <div :class="[classInfo.progressClassDiff]"
                    :style="'width:' + Number(100 - percent).toLocaleString() + '%;'" v-if="percent > 0">
                    <span class="flex justify-center text-black font-boldened"></span>
                </div>
            </div>
        </div>
        <span :class="[classInfo.progressInfoZero]" v-tooltip="{ content: classInfo.message }">
            {{ percent }}%
        </span>
    </section>
</template>

<script setup>
    import { defineProps, onMounted, reactive } from 'vue'

    const props = defineProps({
        percent: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        }
    })

    const classInfo = reactive ({
        rowClass:  'rounded-full overflow-hidden w-full inline-flex justify-start space-x-2',
        // table progress bar
        progressClass100: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-emerald-400 via-teal-500 to-green-600 text-base leading-none',
        progressClass: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 via-cyan-500 to-blue-600 text-base leading-none',
        progressClassLow: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 text-base leading-none',
        progressClassZero: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-red-400 via-rose-500 to-red-600 text-base leading-none',
        progressClassDiff: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-yellow-300 via-amber-400 to-red-500 text-base leading-none',
        // table progress bar info
        progressInfo100: 'mx-2 text-sm font-normal text-green-500',
        progressInfo: 'mx-2 text-sm font-normal text-blue-500',
        progressInfoLow: 'mx-2 text-sm font-normal text-orange-500',
        progressInfoZero: 'mx-2 text-sm font-normal text-rose-500',

        message: ''
    })

    onMounted(() => {
        setMessage()
    })

    function setMessage() {
        classInfo.message = props.name + ': ' + props.percent + '% / ' + Number(100 - props.percent).toLocaleString() + '%'
    }
</script>