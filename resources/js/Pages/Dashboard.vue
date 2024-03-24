<script setup>
    import { defineProps } from 'vue';

    const props = defineProps({
        name: {
            type: String,
            required: true,
        },
        route: {
            type: String,
            required: true,
        },
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
        },
        finance: {
            type: Object,
            required: true,
        },
        info: {
            type: Array,
            required: true
        }
    })
</script>

<template>
    <Head>
        <title>{{ props.route }}</title>
    </Head>

    <!-- breadcrumb  -->
    <dashboardcrumbs></dashboardcrumbs>
    <!-- end breadcrumb  -->

    <!-- Contribution documents  -->
    <div class="py-2 font-boldened">
        <!-- info panel  -->
        <dashboardinfo
            :finance        = finance
        ></dashboardinfo>
        <!-- end info panel  -->

        <ledgerTabs
            :cycleinfo      = info
        ></ledgerTabs>

        <membersTabs
            :route          = props.route
        ></membersTabs>

        <cycleTabs
            :current    = current
            :cycles     = cycles
            :nextname   = nextname
            :date       = date
            :settings   = settings
        ></cycleTabs>
    </div>
    <!--end Contribution documents  -->
</template>
