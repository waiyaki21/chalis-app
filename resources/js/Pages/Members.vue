<script setup>
    import { defineProps, reactive } from 'vue'

    const props = defineProps({
        name: {
            type: String,
            required: true,
        },
        route: {
            type: String,
            required: true,
        },
        members: {
            type: Array,
            required: true,
        },
        active: {
            type: String,
            required: true,
        },
        inactive: {
            type: String,
            required: true,
        },
        paySum: {
            type: String,
            required: true,
        },
        welfSum: {
            type: String,
            required: true,
        },
        user: {
            type: Object,
            required: true,
        },
        paySum: {
            type: String,
            required: true,
        },
        welfSum: {
            type: String,
            required: true,
        },
        grandtotal: {
            type: String,
            required: true,
        },
        amntbefore: {
            type: String,
            required: true,
        },
        welfareIn: {
            type: String,
            required: true,
        },
        welfareOwed: {
            type: String,
            required: true,
        },
    });

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
</script>

<template>
    <Head>
        <title>{{ props.route }}</title>
    </Head>

    <!-- breadcrumb  -->
    <memberscrumbs></memberscrumbs>
    <!-- end breadcrumb  -->

    <div class="py-2 font-boldened">
        <!-- info panel  -->
        <membersinfo
            :members = members.length
            :active  = active
            :inactive = inactive
            :paySum  = paySum
            :welfSum = welfSum
            :amntbefore = amntbefore
            :grandtotal  = grandtotal
            :welfareIn   = welfareIn
            :welfareOwed = welfareOwed
        ></membersinfo>

        <hr class="w-[90%] text-gray-800 dark:text-gray-300/30 my-6 mx-auto border-t-4 dark:border-gray-300/30 shadow-lg shadow-cyan-400">

        <membersPageTabs
            :route          = props.route
            :members        = members
        ></membersPageTabs>
    </div>
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
