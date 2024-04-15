<template>
    <!-- header  -->
    <section class="font-normal text-[4.5rem] text-cyan-900 dark:text-gray-300 leading-tight uppercase py-1 w-full inline-flex justify-between">
        <span class="underline uppercase">Welcome Admin!</span>
    </section>
    <section class="font-normal text-[2.5rem] text-cyan-900 dark:text-gray-300 leading-tight uppercase py-1 w-full inline-flex justify-between">
        <span class="underline">Dashboard Page.</span>
    </section>

    <!-- info panel  -->
    <section :class="[info.infoSection]"> 
        <section class="w-full m-1 p-1 text-left grid grid-cols-2 md:grid-cols-4 gap-1">
            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]"  title="Total no of incomplete / ongoing projects">
                    <span>Grand Total</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-orange-700 dark:text-orange-600 uppercase">
                    ksh {{ numFormat(finance.money_left) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5 :class="[info.infoHeader]"  title="Total amount contributed">
                    <span>T. Money In.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-green-700 dark:text-green-600 uppercase" :title="'ksh ' + Number(finance.money_left).toLocaleString()">
                    ksh {{ numFormat(finance.money_left) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]"  title="Total welfare amount">
                    <span>T. Money Out</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-purple-700 dark:text-purple-600 uppercase" :title="'ksh ' + Number(finance.money_out).toLocaleString()">
                    ksh {{ numFormat(finance.money_out) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]"  title="Average Completion of Projects as a Percentage">
                    <span>Members</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-red-700 dark:text-red-600 uppercase">
                    {{ numFormat(finance.members_no) }}
                </p>
            </a>
        </section>

        <section class="w-full m-1 p-1 text-left grid grid-cols-2 md:grid-cols-4 gap-1">
            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]"  title="This is the amount contributed by members monthly">
                    <span>P. Cycles</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-amber-400 dark:text-amber-400 uppercase">
                    {{ numFormat(finance.cycles_no) }} Cycles.
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]"  title="This is the no of projects">
                    <span>Projects</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-blue-700 dark:text-blue-600 uppercase">
                    {{ numFormat(finance.projects_no) }} Projects.
                </p>
            </a>
    
            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]"  title="This is the total welfarecontributed by members">
                    <span>T.Welfare In</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-cyan-700 dark:text-cyan-600 uppercase" :title="'ksh ' + Number(finance.welfare_in).toLocaleString()">
                    ksh {{ numFormat(finance.welfare_in) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[info.infoHeader]"  title="Total Amount of welfare Owed">
                    <span>T. Welfare Owed</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-purple-700 dark:text-purple-600 uppercase" :title="'ksh ' + Number(finance.welfare_out).toLocaleString()">
                    ksh {{ numFormat(finance.welfare_out) }}
                </p>
            </a>
        </section>
    </section>

    <!-- progress bar  -->
    <section class="mx-auto my-4">
        <div class="relative mb-2">
            <div class="my-2 flex rounded-full text-sm w-full">
                <div :style="'width:' + finance.percent + '%; min-width: 10px;'" class="alerts bg-gradient-to-r from-green-300 via-green-700 to-green-600 transition-all duration-500 ease-out rounded-full mx-1 border-[3px] border-green-300 dark:border-green-700 my-1 h-2 hover:h-3 cursor-pointer" title="View Money In" @click="info.progressShow = !info.progressShow">
                </div>
                <div :style="'width:' + percent.left + '%; min-width: 10px;'" class="alerts bg-gradient-to-r from-rose-100 via-red-600 to-rose-700 transition-all duration-500 ease-out rounded-full mx-1 border-[3px] border-red-300 dark:border-rose-700 my-1 h-2 hover:h-3 cursor-pointer" title="View Money Out" @click="info.progressShow = !info.progressShow">
                </div>
            </div>
            <div class="mb-2 flex items-center justify-between text-sm">
                <div class="text-green-600 underline uppercase cursor-pointer" @click="info.progressShow = !info.progressShow">Money In: {{ finance.percent }}%</div>
                <div class="text-red-600 underline uppercase cursor-pointer" @click="info.progressShow = !info.progressShow">Money Out: {{ percent.left }}%</div>
            </div>
        </div>
    </section>
    <!-- end progress bar  -->

    <!-- in progress bar  -->
    <progressInfo
        v-if        = "info.progressShow"
        :name1      = '"Contributions"'
        :name2      = '"Welfares In"'
        :percent1   = info.payPercent
        :percent2   = info.welPercent
    ></progressInfo>
    <!-- end in progress bar  -->

    <!-- out progress bar  -->
    <progressInfo
        v-else
        :name1      = '"Welfares Owed"'
        :name2      = '"Project Expenses"'
        :percent1   = info.owePercent
        :percent2   = info.expPercent
    ></progressInfo>
    <!-- end out progress bar  -->
</template>

<script setup>
    import { defineProps, reactive, onMounted } from 'vue'

    const props = defineProps({
        finance: {
            type: Object,
            required: true,
        },
    });

    const percent = reactive({ 
        left: ''
    });

    const info = reactive({
        // main progress bar 
        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-900 dark:text-cyan-300 mb-2 md:text-2xl sm:text-xl md:text-left sm:text-left font-normal underline tracking-tight uppercase',

        infoSection100: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-emerald-500 p-1 overflow-hidden bg-emerald-400/10 dark:bg-emerald-400/10',
        infoHeader100: 'text-emerald-300 mb-2 md:text-2xl sm:text-xl md:text-left sm:text-left font-normal underline tracking-tight uppercase',

        infoSectionZero: 'w-full mx-2 mb-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-rose-500 overflow-hidden bg-rose-400/10 dark:bg-rose-400/10',
        infoHeaderZero: 'text-red-300 mb-2 md:text-2xl sm:text-xl md:text-left sm:text-left font-normal underline tracking-tight uppercase',

        payPercent: '',
        welPercent: '',
        owePercent: '',
        expPercent: '',

        progressShow: true
    })

    onMounted(() => progressMain())

    function progressMain() {
        if (props.finance.percent == 0) {
            info.payPercent = '0'
            info.welPercent = '0'
            info.owePercent = '0'
            info.expPercent = '0'
        } else {
            let a = Number(props.finance.total_pays / props.finance.money_left * 100).toFixed(2);
            info.payPercent = a;
            let b = Number(props.finance.welfare_in / props.finance.money_left * 100).toFixed(2);
            info.welPercent = b;
            let c = Number(props.finance.welfare_out / props.finance.money_out * 100).toFixed(2);
            info.owePercent = c;
            let d = Number(props.finance.total_expenses / props.finance.money_out * 100).toFixed(2);
            info.expPercent = d;
        }
        percent.left = Number(100 - props.finance.percent).toLocaleString()
    }

    function numFormat(num) {
        if (num < 49999) {
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
</script>