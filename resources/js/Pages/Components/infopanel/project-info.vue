<template>
    <!-- header   -->
    <section class="font-normal text-[2.5rem] text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 w-full inline-flex justify-between">
        <span class="underline">All Projects.</span>
    </section>

    <!-- info panel  -->
    <section :class="[classInfo.infoSection]"> 
        <section class="w-full m-1 p-1 text-left grid grid-cols-2 md:grid-cols-4 gap-1">
            <a class="block max-w-sm p-2 bg-transparent">
                <h5 :class="[classInfo.infoHeader]" v-tooltip="{ content: classInfo.btn1.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Project No.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left text-4xl text-blue-700 dark:text-blue-600 uppercase">
                    {{ Number(projectNo).toLocaleString() }} Projects
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]" v-tooltip="{ content: classInfo.btn2.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Completed</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left text-4xl text-green-700 dark:text-green-600 uppercase">
                    {{ Number(completed).toLocaleString() }} Projects
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]" v-tooltip="{ content: classInfo.btn3.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Ongoing</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left text-4xl text-orange-700 dark:text-orange-600 uppercase">
                    {{ Number(projectNo - completed).toLocaleString() }} Projects
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]" v-tooltip="{ content: classInfo.btn4.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>% Paid</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left text-4xl text-red-700 dark:text-red-600 uppercase">
                    {{ Number(totalPercent).toLocaleString() }} %
                </p>
            </a>
        </section>
        <section class="w-full m-1 p-1 text-left grid grid-cols-2 md:grid-cols-4 gap-1">

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]" v-tooltip="{ content: classInfo.btn5.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Contributions</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left text-4xl text-green-700 dark:text-green-600 uppercase" v-tooltip="{ content: 'ksh ' + Number(paySum).toLocaleString()}">
                    ksh {{ numFormat(paySum) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]" v-tooltip="{ content: classInfo.btn6.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Targets</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left text-4xl text-purple-700 dark:text-purple-500 uppercase" v-tooltip="{ content: 'ksh ' + Number(projectSum).toLocaleString()}">
                    ksh {{ numFormat(projectSum) }}
                </p>
            </a>
    
            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]" v-tooltip="{ content: classInfo.btn7.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Expenses</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left text-4xl text-amber-500 dark:text-amber-500 uppercase" v-tooltip="{ content: 'ksh ' + Number(expSum).toLocaleString()}">
                    ksh {{ numFormat(expSum) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]" v-tooltip="{ content: classInfo.btn8.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Balances</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left text-4xl text-red-700 dark:text-red-600 uppercase" v-tooltip="{ content: 'ksh ' + Number(balance).toLocaleString()}">
                    ksh {{ numFormat(balance) }}
                </p>
            </a>
        </section>
    </section>

    <!-- progress bar  -->
    <progressInfo
        :name1 = '"Payments"'
        :name3 = '"Balances"'
        :percent1 = totalPercent
        :percent3 = '100 - totalPercent'
    ></progressInfo>
    <!-- end progress bar  -->
</template>

<script setup>
    import { defineProps, reactive, onMounted } from 'vue'

    const props = defineProps({
        expSum: {
            type: String,
            required: true
        },
        projectSum: {
            type: String,
            required: true
        },
        projectNo: {
            type: String,
            required: true
        },
        completed: {
            type: String,
            required: true
        },
        totalPercent: {
            type: String,
            required: true
        },
        paySum: {
            type: String,
            required: true
        },
        balance: {
            type: String,
            required: true
        },
        percent: {
            type: String,
            required: true
        },
    })

    const classInfo = reactive ({
        // main progress bar 
        progressMainBorder: 'border border-cyan-500 p-1 overflow-hidden',
        progressMainClass: 'alerts flex h-6 items-center justify-center rounded-full bg-gradient-to-r from-gray-200 via-cyan-400 to-blue-500 text-base leading-none',
        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 md:text-2xl sm:text-xl text-left font-normal underline tracking-tight uppercase',

        progressMainBorder100: 'border border-emerald-500 p-1 overflow-hidden',
        progressMainClass100: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-grey-300 via-emerald-400 to-green-600 text-base leading-none',
        infoSection100: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-emerald-500 p-1 overflow-hidden bg-emerald-400/10 dark:bg-emerald-400/10',
        infoHeader100: 'text-emerald-300 mb-2 md:text-2xl sm:text-xl text-left font-normal underline tracking-tight uppercase',

        progressMainBorderZero: 'border border-red-500 p-1 overflow-hidden',
        progressMainClassZero: 'alerts flex h-6 items-center justify-center rounded-full bg-gradient-to-r from-orange-300 via-rose-400 to-red-500 text-base leading-none',
        infoSectionZero: 'w-full mx-2 mb-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-rose-500 overflow-hidden bg-rose-400/10 dark:bg-rose-400/10',
        infoHeaderZero: 'text-red-300 mb-2 md:text-2xl sm:text-xl text-left font-normal underline tracking-tight uppercase',

        btn1: "Total no of projects",
        btn2: "Total no of completed projects" ,
        btn3: "Total no of incomplete / ongoing projects",
        btn4: "Completion of Projects as a Percentage",
        btn5: "This is the amount total contributed by members monthly",
        btn6: "This is the amount needed by uncompleted projects",
        btn7: "This is the amount already used by projects",
        btn8: "Amount needed to complete the projects"
    })

    onMounted(() => {
        progressMain()
    })

    function progressMain() {
        let percentMain = Math.floor((props.expSum) / props.projectSum * 100);
        switch (true) {
            case (percentMain = 100):
                classInfo.progressMainClass = classInfo.progressMainClass100;
                classInfo.progressMainBorder = classInfo.progressMainBorder100;
                classInfo.infoHeader = classInfo.infoHeader100;
                classInfo.infoSection = classInfo.infoSection100;
                break;
            case (percentMain > 50):
                classInfo.progressMainClass = classInfo.progressMainClass;
                classInfo.progressMainBorder = classInfo.progressMainBorder;
                classInfo.infoHeader = classInfo.infoHeader;
                classInfo.infoSection = classInfo.infoSection;
                break;
            case (percentMain < 50):
                classInfo.progressMainClass = classInfo.progressMainClassZero;
                classInfo.progressMainBorder = classInfo.progressMainBorderZero;
                classInfo.infoHeader = classInfo.infoHeaderZero;
                classInfo.infoSection = classInfo.infoSectionZero;
                break;
        }
    }

    function numFormat(num) {
        if (num < 9999) {
            return num;
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