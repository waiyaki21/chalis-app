<template>
<!-- info section  -->
    <section class="font-normal text-[2.5rem] text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 w-full inline-flex justify-between">
        <span class="underline">All Payment Cycles.</span>
    </section>

    <section :class="[info.infoSection, 'mb-2']"> 
        <section :class="[info.sectionborder, 'grid grid-cols-2 md:grid-cols-4 gap-1']">
            <a class="block max-w-sm p-2 bg-transparent">
                <h5 :class="[info.infoHeader]" v-tooltip="{ content: info.btn1.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Cycles No.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-5xl text-2xl text-blue-700 dark:text-blue-600 uppercase">
                    {{ Number(count).toLocaleString() }} cycles
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]" v-tooltip="{ content: info.btn2.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Total Contributed</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-5xl text-2xl text-green-700 dark:text-green-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(paysum).toLocaleString()}">
                    KSH {{ numFormat(paysum) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]" v-tooltip="{ content: info.btn3.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Active Members</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-5xl text-2xl text-orange-700 dark:text-orange-600 uppercase">
                    {{ Number(members).toLocaleString() }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]" v-tooltip="{ content: info.btn4.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Avg Contribution</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-5xl text-2xl text-purple-700 dark:text-purple-700 uppercase">
                    KSH {{ numFormat(avg) }}
                </p>
            </a>
        </section>
    </section>

    <section :class="[info.infoSection, 'mt-2']" v-if="cycle != null">
        <h3 class="font-normal text-2xl md:text-5xl text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 w-full inline-flex justify-start">
            <small class="text-lg mt-4 hidden md:block">Current:</small>
            <span class="border-b-2 border-cyan-800 dark:border-cyan-800 text-cyan-800 dark:text-cyan-300 mx-4">{{ cycle.name }}.</span>
        </h3>
        <section class="w-full m-1 p-1 text-left grid grid-cols-2 md:grid-cols-4 gap-1">
            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]" v-tooltip="{ content: info.btn5.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Contributors</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-5xl text-2xl text-amber-500 dark:text-amber-500 uppercase">
                    {{ Number(cycle.members_no).toFixed(0) }} Members
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]" v-tooltip="{ content: info.btn6.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Contributed</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-5xl text-2xl text-purple-700 dark:text-purple-500 uppercase" v-tooltip="{ content: 'KSH ' + Number(cycle.payments_total).toLocaleString()}">
                    KSH {{ numFormat(cycle.payments_total) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]" v-tooltip="{ content: info.btn7.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Welfares In</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-5xl text-2xl text-red-700 dark:text-red-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(cycle.welfaresin_total).toLocaleString()}">
                    KSH {{ numFormat(cycle.welfaresin_total) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]" v-tooltip="{ content: info.btn8.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Investment</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-5xl text-2xl text-green-700 dark:text-green-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(cycle.total_amount).toLocaleString()}">
                    KSH {{ numFormat(cycle.total_amount) }}
                </p>
            </a>
        </section>
    </section>
    <!-- end info section  -->

    <!-- progress bar  -->
    <progressInfo
        v-if="cycle != null"
        :name1 = '"Payments"'
        :name3 = '"Welfares"'
        :percent1 = cycle.percent
        :percent3 = '100 - cycle.percent'
    ></progressInfo>
    <!-- end progress bar  -->
</template>

<script setup>
    import { defineProps, reactive } from 'vue'

    defineProps({
        infosection: {
            type: String,
            required: true,
        },
        infoheader: {
            type: String,
            required: true,
        },
        sectionborder: {
            type: String,
            required: true,
        },
        count: {
            type: String,
            required: true,
        },
        cycle: {
            type: Object,
            required: true,
        },
        paysum: {
            type: String,
            required: true,
        },
        avg: {
            type: String,
            required: true,
        },
        members: {
            type: String,
            required: true,
        }
    });

    const info = reactive({
        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-900 dark:text-cyan-300 mb-2 md:text-2xl sm:text-xl md:text-left sm:text-left font-normal underline tracking-tight uppercase',
        sectionBorder: 'w-full inline-flex justify-between m-1 p-1 text-left border-b-2 border-cyan-500',

        btn4: "Average amount Contributed per cycle",
        btn3: "Total no of active members",
        btn2: "Total amount contributed in all cycles",
        btn1: "Total no of payment cycles",
        btn5: "No of members who have contributed in this cycle",
        btn6: "This is the amount contributed in this cycle",
        btn7: "Total Welfare Payments",
        btn8: "This is the current cycle"
    })

    function numFormat(num) {
        if (num < 9999) {
            return Number(num).toFixed(0);
        } else {
            if (num > 999999) {
                let x = Number(num / 1000000).toFixed(2);
                let y = x + ' m';
                return y;
            } else {
                let x = Number(num / 1000).toFixed(1);
                let y = x + ' k';
                return y;
            } 
        }
    }
</script>