<template>
    <section :class="[classInfo.infosection, 'col-span-1 font-boldened h-fit max-h-[760px] overflow-y-scroll w-full']"> 
        <section :class="[classInfo.sectionborder, 'md:flex-col grid grid-cols-2 md:grid-cols-1 md:grid-rows-5']">
            <a class="block max-w-sm p-0 bg-transparent row-span-1 view overflow-hidden text-ellipsis">
                <h5 :class="[classInfo.header]"  v-tooltip="{ content: 'Cycle Payment Date', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Date</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="pr-2 font-normal text-left sm:text-5xl text-4xl text-blue-700 dark:text-blue-600 uppercase textScroll">
                    {{ moment(cycle.created_at).format("ddd, Do/MM/YY") }}
                </p>
                <p class="font-normal text-left text-sm text-gray-300 dark:text-gray-300 uppercase">
                    {{ moment(cycle.created_at).fromNow() }}
                </p>
            </a>

            <a class="block max-w-sm p-0 bg-transparent row-span-1">
                <h5 :class="[classInfo.header]"  v-tooltip="{ content: 'Total amount expected during this cycle', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T.Paid</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-amber-500 dark:text-amber-500 uppercase" v-tooltip="{ content: 'KSH ' + Number(cycle.payments_total).toLocaleString()}">
                    ksh {{ numFormat(cycle.payments_total) }}
                </p>
            </a>

            <a class="block max-w-sm p-0 bg-transparent row-span-1">
                <h5
                    :class="[classInfo.header]"  v-tooltip="{ content: 'Total amount contributed in this cycle', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T.Welfares In</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-purple-700 dark:text-purple-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(cycle.welfaresin_total).toLocaleString()}">
                    ksh {{ numFormat(cycle.welfaresin_total) }}
                </p>
            </a>

            <a class="block max-w-sm p-0 bg-transparent row-span-1">
                <h5
                    :class="[classInfo.header]"  v-tooltip="{ content: 'Total amount contributed in this cycle', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T.Welfares Owed</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-red-700 dark:text-red-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(cycle.welfaresowed_total).toLocaleString()}">
                    ksh {{ numFormat(cycle.welfaresowed_total) }}
                </p>
            </a>

            <a class="block max-w-sm p-0 bg-transparent row-span-1">
                <h5 :class="[classInfo.header]"  v-tooltip="{ content: 'Total amount expected during this cycle', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Members</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-gray-700 dark:text-gray-300 uppercase">
                    {{ numFormat(cycle.members_no) }} Paid
                </p>
            </a>

            <!-- <a class="block max-w-sm p-0 bg-transparent row-span-1">
                <h5
                    :class="[classInfo.header]"  v-tooltip="{ content: 'Total amount contributed in this cycle', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Total Money In</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-emerald-700 dark:text-emerald-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(cycle.payments_total + cycle.welfaresin_total).toLocaleString()}">
                    ksh {{ numFormat(cycle.payments_total + cycle.welfaresin_total) }}
                </p>
            </a> -->

            <a class="block max-w-sm p-0 bg-transparent row-span-1">
                <h5
                    :class="[classInfo.header]"  v-tooltip="{ content: 'Total No. of Payments in this cycle', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Payments No.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-purple-500 dark:text-purple-500 uppercase" v-tooltip="{ content: Number(cycle.payments_count).toLocaleString() + ' Payments'}">
                    {{ numFormat(cycle.payments_count) }} Payments
                </p>
            </a>

            <a class="block max-w-sm p-0 bg-transparent row-span-1">
                <h5
                    :class="[classInfo.header]"  v-tooltip="{ content:' Total No. of Welfare Payments in this cycle', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Welfare No.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-rose-700 dark:text-rose-600 uppercase" v-tooltip="{ content: Number(cycle.welfares_count).toLocaleString() + ' Welfares'}">
                    {{ numFormat(cycle.welfares_count) }} Welfares
                </p>
            </a>

            <a class="block max-w-sm p-0 bg-transparent row-span-1">
                <h5
                    :class="[classInfo.header]"  v-tooltip="{ content:' Total No. of Projects in this cycle', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Projects No.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-amber-700 dark:text-amber-600 uppercase" v-tooltip="{ content: Number(cycle.projects_count).toLocaleString() + ' Projects'}">
                    {{ numFormat(cycle.projects_count) }} Projects
                </p>
            </a>

            <a class="block max-w-sm p-0 bg-transparent row-span-1">
                <h5
                    :class="[classInfo.header]"  v-tooltip="{ content:' Total Amount of Project Expenses in this cycle', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Expenses.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-teal-700 dark:text-teal-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(cycle.expenses_total).toLocaleString()}">
                    KSH {{ numFormat(cycle.expenses_total) }}
                </p>
            </a>
        </section>

        <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-cyan-300/80">
    </section>
</template>

<script setup>
    import { defineProps, reactive } from 'vue'
    //moment 
    import moment from 'moment';
    const props = defineProps({
        cycle: {
            type: Object,
            required: true,
        }
    });

    function numFormat(num) {
        if (num < 99999) {
            return Number(num).toLocaleString();
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

    const classInfo = reactive({ 
        header: 'text-cyan-900 dark:text-cyan-300 mb-1 md:mb-2 sm:text-base md:text-2xl text-left font-normal underline tracking-tight uppercase',
        sectionborder: 'w-full flex-col justify-between m-1 p-1 text-left',
        infosection: 'm-1 text-left mx-auto rounded-xl border-2 shadow-md border-2 border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
    })
</script>