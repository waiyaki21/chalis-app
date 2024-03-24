<template>
    <Head>
        <title>{{ props.route }}</title>
    </Head>

    <!-- breadcrumb  -->
    <cyclescrumbs></cyclescrumbs>
    <!-- end breadcrumb  -->

    <!-- body section  -->
    <div class="py-2 font-boldened">
        <!-- info section  -->
        <cyclesinfo
            :infosection    = classInfo.infoSection
            :infoheader     = classInfo.infoHeader
            :sectionborder  = classInfo.sectionBorder
            :cycle          = props.cycle
            :count          = props.cycles.length
            :paysum         = props.paySum
            :avg            = props.avg
            :members        = props.members
        ></cyclesinfo>
        <!-- end info section  -->

        <!-- table and forms  -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-1">
            <!-- cycles table  -->
            <cyclestable
                :cycles         = classInfo.info
                :cycleinfo      = info
                @flash   = flashShow
                @view    = flashShowView
                @reload  = setInfo
            ></cyclestable>
            <!-- cycles table  -->

            <!-- cycles form  -->
            <section class="col-span-2 bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg rounded-md font-boldened border-2 border-cyan-300 dark:border-cyan-700 h-fit">
                <div class="p-2 w-full">
                    <h3 class="font-boldened text-2xl md:text-4xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 px-2">
                        Add New cycles.
                    </h3>
                    <!-- cycles form  -->
                    <infocycle
                        :settings = props.settings
                        @reload   = setInfo
                    ></infocycle>
                </div>
            </section>
            <!-- cycles form  -->
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

    <alertview
        :alertshowview  = alerts.alertShowView
        :message        = alerts.flashMessage
        :class          = alerts.alertBody
        :link           = alerts.linkName
        :url            = alerts.linkUrl
        :state          = alerts.linkState
        :type           = alerts.alertType
    ></alertview>
</template>

<script setup>
    import { defineProps, reactive, onMounted } from 'vue'

    const props = defineProps({
        name: {
            type: String,
            required: true,
        },
        route: {
            type: String,
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
        },
        paySum: {
            type: String,
            required: true,
        },
        members: {
            type: String,
            required: true,
        },
        avg: {
            type: String,
            required: true,
        },
        cycle: {
            type: Object,
            required: true,
        },
        settings: {
            type: Object,
            required: true,
        },
        info: {
            type: Array,
            required: true
        }
    });

    // alerts classes 
    const alerts = reactive({
        // alerts
        alertShow: false,
        alertShowView: false,
        alertDuration: 15000,
        alertType: '',
        flashMessage: '',
        alertBody: 'border-b-[5px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[5px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[5px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[5px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[5px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',
        linkName: '',
        linkUrl: '',
        linkState: false,
    })

    // classes 
    const classInfo = reactive({
        isOpen: false,
        modalData: {},

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',

        info: [],

        myDate: new Date().toISOString().slice(0, 10),

        // main progress bar 
        progressMainBorder: 'border border-cyan-500 p-1 overflow-hidden',
        progressMainClass: 'alerts flex h-6 items-center justify-center rounded-full bg-gradient-to-r from-gray-200 via-cyan-400 to-blue-500 text-base leading-none',
        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 sm:text-base text-xl text-left font-normal underline tracking-tight uppercase',
        sectionBorder: 'w-full inline-flex justify-between m-1 p-1 text-left border-b-2 border-cyan-500',
    })

    onMounted(() => [
        setInfo(),
        progressMain()
    ])

    function setInfo() {
        classInfo.info = props.cycles;
    }

    function progressMain() {
        classInfo.progressMainClass  = classInfo.progressMainClass;
        classInfo.progressMainBorder = classInfo.progressMainBorder;
        classInfo.infoHeader         = classInfo.infoHeader;
        classInfo.infoSection        = classInfo.infoSection;
        classInfo.sectionBorder      = classInfo.sectionBorder;
    }

    function flashShow(message, body) {
        alerts.flashMessage   = message;

        if (body == 'success') {
            alerts.alertBody = alerts.alertSuccess; 
        } 
        if(body == 'info') {
            alerts.alertBody = alerts.alertInfo;
        } 
        if(body == 'warning') {
            alerts.alertBody = alerts.alertWarning;
        } 
        if(body == 'danger') {
            alerts.alertBody = alerts.alertDanger; 
        }

        alerts.alertShow      = !alerts.alertShow;
    }

    function flashShowView(message, body, cycle) {
        alerts.flashMessage   = message;
        alerts.alertType      = body;

        alerts.linkName       = cycle.name +' Download Excelsheet';
        alerts.linkUrl        = '/download/current/' + cycle.id
        alerts.linkState      = true;

        if (body == 'success') {
            alerts.alertBody = alerts.alertSuccess; 
        } 
        if(body == 'info') {
            alerts.alertBody = alerts.alertInfo;
        } 
        if(body == 'warning') {
            alerts.alertBody = alerts.alertWarning;
        } 
        if(body == 'danger') {
            alerts.alertBody = alerts.alertDanger; 
        }

        alerts.alertShowView  = !alerts.alertShowView;
    }
</script>