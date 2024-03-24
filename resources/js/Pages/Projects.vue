<template>
    <Head>
        <title>{{ props.route }}</title>
    </Head>

    <!-- breadcrumb  -->
    <projectcrumbs></projectcrumbs>
    <!-- end breadcrumb  -->

    <!-- body section  -->
    <div class="py-2 font-boldened">
        <!-- info options  -->
        <projectinfo
            :expSum         = props.expSum
            :projectSum     = props.projectSum
            :projectNo      = props.projects.length
            :completed      = props.completed
            :totalPercent   = props.totalPercent
            :paySum         = props.paySum
            :balance        = props.balance
            :percent        = percent
        ></projectinfo>
        <!--end info options  -->

        <!-- table and form  -->
        <div class="p-2 w-full grid grid-cols-1 md:grid-cols-3 gap-1">
            <!-- projects table  -->
            <projecttable
                :ref      = "tableRefs"
                :projects = props.projects
                @show     = showProject
                @delete   = showDelete
            ></projecttable>
            <!--end projects table  -->
        </div>
        <!-- end table and form  -->
    </div>
    <!-- end body section  -->

    <!-- flash alert  -->
    <alert
        :alertshow  = alerts.alertShow
        :message    = alerts.flashMessage
        :class      = alerts.alertBody
        :type       = alerts.alertType
        :title      = alerts.alertType
        :time       = alerts.alertDuration
    ></alert>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import { computed, reactive, onMounted } from 'vue';

    import alert            from './Components/alerts/toast-simple.vue';

    const props = defineProps({
        name: {
            type: String,
            required: true,
        },
        route: {
            type: String,
            required: true,
        },
        projects: {
            type: Array,
            required: true,
        },
        expSum: {
            type: String,
            required: true,
        },
        paySum: {
            type: String,
            required: true,
        },
        balance: {
            type: String,
            required: true,
        },
        completed: {
            type: String,
            required: true,
        },
        projectSum: {
            type: String,
            required: true,
        },
        totalPercent: {
            type: String,
            required: true,
        },
    })

    const classInfo = reactive({
        info: [],
    })

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

    onMounted(() => setInfo())

    const percent = computed(() => {
        if (props.projectSum == 0) {
            return 0;
        } else {
            return Math.floor(( props.expSum) /  props.projectSum * 100);
        }
    })

    function setInfo() {
        classInfo.info = props.projects;
    }
</script>
