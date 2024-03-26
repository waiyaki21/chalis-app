<template>
    <!-- header  -->
    <section
        class="font-normal text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 grid grid-cols-3 md:grid-cols-3 gap-1">
        <section class="flex flex-col col-span-2 w-full">
            <span class="underline text-3xl md:text-4xl">{{ props.cycle.name }}.</span>
            <span class="text-gray-500 md:text-base sm:text-sm">
                {{ moment(props.cycle.created_at).format("ddd, Do-MM-YY") }}
            </span>
        </section>

        <div class="inline-flex rounded-md shadow-sm space-x-1 justify-end col-auto" role="group">
            <!-- edit  -->
            <button type="button"
                class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-cyan-700 dark:hover:text-cyan-600"
                v-tooltip="{ content: classInfo.btn1.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}"
                @click="showCycle(props.cycle)">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    :class="[classInfo.svgClass]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
            </button>
            <!-- delete  -->
            <button type="button"
                class="inline-flex items-center p-2 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-red-700 dark:hover:text-red-600"
                v-tooltip="{ content: classInfo.btn2.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}"
                @click="showCycleDelete(props.cycle)">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    :class="[classInfo.svgClass]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>

            <ledgerDrop @click='classInfo.selected = true' @all=downloadAllSheet @down="downloadSheet"
                @active="downloadActiveSheet" :cycle="props.cycle"
                v-tooltip="{ content: classInfo.btn3.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn' }">
            </ledgerDrop>
        </div>
    </section>
    <!-- end header  -->

    <!-- cycle status -->
    <section class="font-normal text-xl leading-tight uppercase px-2 py-1 w-full inline-flex justify-between">
        <span class="text-gray-800 dark:text-gray-300">CYCLE STATUS:</span>
        <span class="text-green-800 dark:text-green-500 underline underline-offset-4 text-3xl" v-if="percent == 100">
            Completed
        </span>
        <span class="text-orange-800 dark:text-orange-500 underline underline-offset-4 text-3xl" v-if="percent > 100">
            Completed & Surpassed
        </span>
        <span class="text-cyan-800 dark:text-cyan-500 underline underline-offset-4 text-3xl" v-if="percent < 100">
            Ongoing
        </span>
        <span class="text-red-800 dark:text-red-500 underline underline-offset-4 text-3xl" v-if="percent == 0">
            Not Started
        </span>
    </section>
    <!-- end cycle status -->

    <!-- progress bar  -->
    <progressInfo :name1='"Payments"' :name2='"Welfares"' :name3='"Welfares Owed"' :percent1=paidPercent
        :percent2=welfInPercent :percent3=welfOwedPercent></progressInfo>
    <!-- end progress bar  -->
</template>

<script setup>
    import { reactive, defineProps , computed, defineEmits, onMounted} from 'vue';
    
    //moment 
    import moment from 'moment';

    const props = defineProps({
        cycle: {
            type: Object,
            required: true,
        },
        border: {
            type: Array,
            required: true,
        },
        class: {
            type: Array,
            required: true,
        },
        percent: {
            type: String,
            required: true,
        },
    })

    const emit = defineEmits(['editCycle', 'deleteCycle', 'view'])

    const classInfo = reactive ({
        progressMainWelf: 'alerts flex h-6 items-center justify-center rounded-r-full bg-gradient-to-r from-gray-300 via-teal-500 to-emerald-800 text-base leading-none',
        svgClass: 'md:w-8 md:h-8 w-6 h-6',

        btn1: 'Update Payment Cycle',
        btn2: 'Delete Payment Cycle',
        btn3: 'Download Payment Cycle Excelsheet',

        title1: '',
        title2: '',
        title3: '',

        flashMessage: '',
        alertType: '',

        selected: false
    })

    onMounted(() => {
        set()
    })

    const paidPercent = computed(() => {
        if (props.cycle.total == 0) {
            return 0;
        } else {
            return Number(props.cycle.payments_total / props.cycle.total * 100).toFixed(2)
        }
    })

    const welfInPercent = computed(() => {
        if (props.cycle.total == 0) {
            return 0;
        } else {
            return Number(props.cycle.welfaresin_total / props.cycle.total * 100).toFixed(2)
        }
    })

    const welfOwedPercent = computed(() => {
        if (props.cycle.total == 0) {
            return 0;
        } else {
            return Number(props.cycle.welfaresowed_total / props.cycle.total * 100).toFixed(2)
        }
    })

    function set() {
        classInfo.title1 = 'Total Payment : '+ Number(paidPercent).toFixed(1) +'%',
        classInfo.title2 = 'Total Welfare : '+ Number(welfInPercent).toFixed(1) +'%',
        classInfo.title3 = 'Total Welfare Owed : '+ Number(welfOwedPercent).toFixed(1) +'%'
    }

    function downloadSheet(cycle) {
        classInfo.flashMessage = 'Download ' + cycle.name +' With Paid Members Only Excelsheet!';
        classInfo.alertType      = 'info';
        classInfo.linkName = cycle.name + ' Download Excelsheet';
        classInfo.linkUrl = '/download/current/' + cycle.id;

        emit('view', classInfo.flashMessage, classInfo.alertType, classInfo.linkName, classInfo.linkUrl, cycle);
    }

    function downloadActiveSheet(cycle) {
        classInfo.flashMessage = 'Download ' + cycle.name +' With Active Members Only Excelsheet!';
        classInfo.alertType      = 'info';
        classInfo.linkName = cycle.name + ' Download Active Excelsheet';
        classInfo.linkUrl = '/download/current/active/' + cycle.id;

        emit('view', classInfo.flashMessage, classInfo.alertType, classInfo.linkName, classInfo.linkUrl, cycle);
    }

    function downloadAllSheet(cycle) {
        classInfo.flashMessage   = 'Download '+ cycle.name +' With All Members Full Excelsheet!';
        classInfo.alertType      = 'info';
        classInfo.linkName = cycle.name + ' Download All Excelsheet';
        classInfo.linkUrl = '/download/current/all/' + cycle.id;

        emit('view', classInfo.flashMessage, classInfo.alertType, classInfo.linkName, classInfo.linkUrl, cycle);
    }

    function showCycle(cycle) {
        emit('editCycle', cycle);
    }

    function showCycleDelete(cycle) {
        emit('deleteCycle', cycle);
    }
</script>