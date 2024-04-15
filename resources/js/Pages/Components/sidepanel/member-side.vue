<template>
    <section :class="[classInfo.infosection, 'col-span-1 font-boldened w-full overflow-y-scroll h-auto max-h-[55.5rem] md:h-fit']"> 
        <section :class="[classInfo.sectionborder, 'md:flex-col grid grid-cols-2 md:grid-cols-1 md:grid-rows-4']">
            <a :class="[classInfo.tagClass]">
                <h5 :class="[classInfo.header]" title="Total amount contributed" v-tooltip="{ content: classInfo.btn1.toUpperCase(), placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Contributions</span>
                    <svg :class="[classInfo.svgClass]" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-blue-700 dark:text-blue-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(member.payments_total).toLocaleString(), placement: 'right', distance: '5'}">
                    ksh {{ numFormat(member.payments_total) }}
                </p>
            </a>

            <a :class="[classInfo.tagClass]">
                <h5 :class="[classInfo.header]" title="Total Welfares In" v-tooltip="{ content: classInfo.btn2.toUpperCase(), placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Welfares In</span>
                    <svg :class="[classInfo.svgClass]" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-orange-700 dark:text-orange-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(member.total_in).toLocaleString(), placement: 'right', distance: '5'}">
                    ksh {{ numFormat(member.total_in) }}
                </p>
            </a>

            <a :class="[classInfo.tagClass]">
                <h5 :class="[classInfo.header]"  title="Total Welfares Owed" v-tooltip="{ content: classInfo.btn3.toUpperCase(), placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Welfares Owing</span>
                    <svg :class="[classInfo.svgClass]" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-yellow-300 dark:text-yellow-300 uppercase" v-tooltip="{ content: 'KSH ' + Number(member.welfare_out).toLocaleString(), placement: 'right', distance: '5'}">
                    ksh {{ numFormat(member.welfare_out) }}
                </p>
            </a>

            <a :class="[classInfo.tagClass]">
                <h5 :class="[classInfo.header]" title="Total Money invested exclusive of welfares owed" v-tooltip="{ content: classInfo.btn4.toUpperCase(), placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Investment</span>
                    <svg :class="[classInfo.svgClass]" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-green-700 dark:text-green-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(member.total_investment).toLocaleString(), placement: 'right', distance: '5'}">
                    ksh {{ numFormat(member.total_investment) }}
                </p>
            </a>

            <a :class="[classInfo.tagClass]">
                <h5 :class="[classInfo.header]" title="Total Percentage invested exclusive of welfares owed" v-tooltip="{ content: classInfo.btn5.toUpperCase(), placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Percentage</span>
                    <svg :class="[classInfo.svgClass]" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-blue-700 dark:text-blue-600 uppercase" v-tooltip="{ content: Number(member.total_shares).toFixed(1)+ '%', placement: 'right', distance: '5'}">
                    {{ Number(member.total_shares).toFixed(1) }}%
                </p>
            </a>

            <a :class="[classInfo.tagClass, 'md:view']">
                <h5 :class="[classInfo.header]" title="Contact Detail" v-tooltip="{ content: classInfo.btn6.toUpperCase(), placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Contact</span>
                    <svg :class="[classInfo.svgClass]" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-indigo-700 dark:text-indigo-600 uppercase textScroll">
                    {{ member.telephone }}
                </p>
            </a>

            <a :class="[classInfo.tagClass]">
                <h5 :class="[classInfo.header]" title="Contact Detail" v-tooltip="{ content: classInfo.btn7.toUpperCase(), placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Days Active</span>
                    <svg :class="[classInfo.svgClass]" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left sm:text-5xl text-4xl text-amber-500 dark:text-amber-500 uppercase">
                    {{ moment(member.created_at).fromNow() }}
                </p>
            </a>
        </section>

        <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-cyan-300/80">
    </section>
</template>

<script setup>
    import { defineProps, reactive } from 'vue'
    import moment from 'moment';

    const props = defineProps({
        member: {
            type: Object,
            required: true,
        }
    });

    function numFormat(num) {
        if (num < 9999) {
            return Number(num).toLocaleString();
        } else {
            if (num > 999999) {
                let x = Number(num / 1000000).toFixed(2);
                let y = x + ' m';
                return y;
            } else {
                let x = Number(num / 1000).toFixed(1);
                let y = x + 'k';
                return y;
            } 
        }
    }

    const classInfo = reactive({ 
        btn1:   'Total amount contributed',
        btn2:   'Total Welfares In',
        btn3:   'Total Welfares Owed',
        btn4:   'Total Money invested exclusive of welfares owed',
        btn5:   'Total Percentage invested exclusive of welfares owed',
        btn6:   'Contact Detail',
        btn7:   'Total Duration as a Member',

        header: 'text-cyan-900 dark:text-cyan-300 mb-1 md:mb-2 sm:text-base md:text-2xl text-left font-normal underline tracking-tight uppercase',
        sectionborder: 'w-full flex-col justify-between m-1 p-1 text-left',
        infosection: 'm-1 text-left mx-auto rounded-xl border-2 shadow-md border-2 border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        svgClass: 'flex-shrink-0 inline w-5 h-5 sm:w-3 sm:h-3 ml-1',
        tagclass: 'block max-w-sm p-0 bg-transparent row-span-1'
    })
</script>