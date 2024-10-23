<template>
    <div class="p-2 flex-col space-y-2" id="cycles" role="tabpanel" aria-labelledby="cycles-tab">
        <section class="grid grid-cols-1 md:grid-cols-4">
            <!-- forms  -->
            <cycleform
                @flash      = flashReload
                @loading    = flashLoading
                :cycles     = props.cycles
                :nextname   = props.nextname
                :date       = props.date
                :settings   = props.settings
                :current    = props.current
            ></cycleform>
        </section>
    </div>

    <!-- flash alert  -->
    <alert :alertShow=classInfo.alertShow :message=classInfo.flashMessage :class=classInfo.alertInfo :time=classInfo.alertDuration></alert>
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
        headerMain: 'font-normal text-[1.95rem] text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 w-full inline-flex justify-between my-1 hover:text-cyan-500 dark:hover:text-cyan-500 cursor-pointer',

        // alerts
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

    function flashReload(message, body) {
        classInfo.flashMessage = message;
        classInfo.alertType = body;

        if (body == 'success') {
            classInfo.alertBody = classInfo.alertSuccess;
        }
        if (body == 'info') {
            classInfo.alertBody = classInfo.alertInfo;
        }
        if (body == 'warning') {
            classInfo.alertBody = classInfo.alertWarning;
        }
        if (body == 'danger') {
            classInfo.alertBody = classInfo.alertDanger;
        }

        classInfo.alertShow = !classInfo.alertShow;
    }

    function flashLoading(message, body, duration) {
        classInfo.flashMessage   = message;
        classInfo.alertType = body;
        classInfo.alertBody      = classInfo.alertWarning;

        classInfo.alertDuration  = duration;
    }
</script>