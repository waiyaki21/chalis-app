<template>
    <div class="p-2 flex-col space-y-2 font-boldened">
        <h3 :class="[classStyle.headerMain]" @click="openView" preserve-scroll>
            <span>
                <span>View Ledgers</span>
                <span class="text-sm text-gray-500 dark:text-gray-500 ml-4">
                    ( Admin )
                </span>
            </span>

            <button class="cursor-pointer text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white bg-transparent dark:bg-transparent dark:hover:bg-cyan-700 border-2 border-gray-300 dark:border-cyan-300 dark:hover:border-cyan-500 rounded-full py-2 px-2 m-2 inline-flex justify-center">
                <svg class="w-4 h-4 text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white" aria-hidden="true" fill="none" viewBox="0 0 10 6" v-if="!info.viewShow">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white" v-else>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </button>
        </h3>

        <div class="flex-col space-y-2" v-if="info.viewShow">
            <section class="w-full m-2 text-left mx-auto rounded-xl border-2 shadow-md border-cyan-500 p-2 overflow-hidden bg-gray-400/10 dark:bg-gray-800/10" v-if="!info.noCycles">
                <p class="text-xl text-gray-500 dark:text-gray-200 my-1 font-sans">
                    <span class="underline font-semibold">Welcome to the ledgers tab</span> from here you can download a full ledger of all the contributions payments, welfare payments , projects and project expenses for each payment cycle.
                </p> 
            </section>

            <section class="w-full m-2 text-left mx-auto rounded-xl border-2 shadow-md border-rose-500 p-2 overflow-hidden bg-gray-rose/10 dark:bg-rose-800/10" v-if="info.noCycles">
                <p class="text-lg text-red-300 dark:text-red-300 my-1 font-sans uppercase text-center">
                    <span class="underline font-semibold">Welcome to the ledgers tab!</span>
                </p>
                <p class="text-2xl text-red-300 dark:text-red-300 my-1 font-boldened uppercase text-center underline  underline-offset-8 decoration-2 decoration-rose-300 dark:decoration-rose-300 tracking-wide">
                    Unfortunately you have not created any payment cycles so as to view any ledgers.
                </p> 
            </section>

            <section class="grid grid-cols-1 md:grid-cols-5 gap-1" v-if="!info.noCycles">
                <div class="m-1 p-2 py-4 rounded-lg bg-gray-50 dark:bg-gray-800 border-2 border-cyan-600 dark:border-cyan-600 h-fit col-span-2">
                    <ol class="relative border-s border-gray-200 dark:border-gray-700 py-2 mx-2">
                        <li class="mb-4 ms-6">
                            <h3 :class="[classStyle.headerClass]">
                                <span class="underline">Complete Ledger</span>
                                <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">Full</span>
                            </h3>
                            <!-- <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Released on January 13th, 2022</time> -->
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                                Get access to all information stored in the system till now in excel form.
                            </p>
                            <a :href="'/download/ledger'" :class="[classStyle.btnSelect]">
                                Download Full Ledger
                                <svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                    <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                </svg> 
                            </a>
                        </li>
                        <li class="mb-4 ms-6">
                            <h3 :class="[classStyle.headerClass]">
                                <span class="underline">Select Ledger Timeframe</span>
                            </h3>
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                                Get access to all information stored in the system till now in excel form.
                            </p>
                            <span class="w-full inline-flex justify-between text-gray-500 uppercase my-0.5 text-base"> 
                                <span>from: <u>{{ info.startName }}</u></span> 
                                <span>to: <u>{{ info.endName }}</u></span>
                            </span>
                            <section class="inline-flex w-full space-x-2 my-2">
                                <div class="w-full flex-col space-y">
                                    <label for="year" value="Select Start" class="w-full text-gray-300 underline uppercase">Start Month</label>
                                    <select id="start" v-model="info.start" name="start" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full">
                                        <option v-for="(month, index) in props.cycleinfo[1]" :value="month.id" class="uppercase my-1" @click="checkStart(month)">{{ index + 1 }}. {{ month.month }} {{ month.year }}</option>
                                    </select>
                                </div>

                                <div class="w-full flex-col space-y">
                                    <label for="end" value="Select End" class="w-full text-gray-300 underline uppercase">End Month</label>
                                    <select id="end" v-model="info.end" name="end" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full">
                                        <option v-for="(month, index) in info.endMonths" :value="month.id" class="uppercase my-1" @click="checkEnd(month)">{{ props.cycleinfo[1].length - index }}. {{ month.month }} {{ month.year }}</option>
                                    </select>
                                </div>
                            </section>
                            <section class="w-full inline-flex my-1">
                                <a :class="[classStyle.btnDanger, 'cursor-not-allowed']" v-if="info.end == ''" @click="getAlert">
                                    Select months
                                    <svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                        <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                    </svg> 
                                </a>
                                <a :class="[classStyle.btnSelect]" v-if="info.start != '' && info.end != ''" @click="downloadMonths(info.start, info.end)">
                                    Download {{ info.countNo }} Months Ledger
                                    <svg class="w-3.5 h-3.5 me-2.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                        <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                    </svg> 
                                </a>
                            </section>
                        </li> 
                    </ol>
                </div>
                <div class="m-1 p-2 py-4 rounded-lg bg-gray-50 dark:bg-gray-800 border-2 border-cyan-600 dark:border-cyan-600 h-fit col-span-3">
                    <ol class="relative border-s border-gray-200 dark:border-gray-700 p-2 mx-2">
                        <li class="mb-4 ms-6">
                            <h3 :class="[classStyle.headerOption]">
                                <span>
                                    <u>Ledgers By Year</u>
                                    <span class="text-sm text-gray-300 dark:text-gray-300">
                                        ( {{ props.cycleinfo[0].length }} Years )
                                    </span>
                                </span>

                                <button class="cursor-pointer text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white bg-transparent dark:bg-transparent dark:hover:bg-cyan-700 border-2 border-gray-300 dark:border-cyan-300 dark:hover:border-cyan-500 rounded-full py-2 px-2 m-2 inline-flex justify-center">
                                    <svg class="w-4 h-4 text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white" aria-hidden="true" fill="none" viewBox="0 0 10 6" v-if="!info.yearShow">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white" v-else>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                    </svg>
                                </button>
                            </h3>
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                                Get access to all ledgers by year as stored in the system till now in excel form.
                            </p>

                            <section class="flex-col w-full p-1 space-y-2 rounded-lg bg-gray-50 dark:bg-cyan-600/20 border-2 border-cyan-600 dark:border-cyan-600 overflow-y-scroll h-auto max-h-60">
                                <a v-for="year in props.cycleinfo[0]" :href="'/download/ledger/year/'+ year.year" :class="[classStyle.btnSelect]">
                                    Download Year: <span class="font-semibold font-sans justify-end underline w-1/2 inline-flex space-x mr-2"> {{ year.year }} Ledger
                                    <svg class="w-3.5 h-3.5 mt-1 ml-2" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                        <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                    </svg></span>
                                </a>
                            </section>
                        </li>
                        <li class="mb-1 ms-6">
                            <h3 :class="[classStyle.headerOption]">
                                <span>
                                    <u>Ledgers By Months</u>
                                    <span class="text-sm text-gray-300 dark:text-gray-300">
                                        (Past {{ props.cycleinfo[1].length }} Months )
                                    </span>
                                </span>

                                <button class="cursor-pointer text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white bg-transparent dark:bg-transparent dark:hover:bg-cyan-700 border-2 border-gray-300 dark:border-cyan-300 dark:hover:border-cyan-500 rounded-full py-2 px-2 m-2 inline-flex justify-center">
                                    <svg class="w-4 h-4 text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white" aria-hidden="true" fill="none" viewBox="0 0 10 6" v-if="!info.monthShow">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-300 hover:text-white dark:text-cyan-300 dark:hover:text-white" v-else>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                    </svg>
                                </button>
                            </h3>
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                                Get access to all ledgers by months as stored in the system till now in excel form.
                            </p>

                            <section class="flex-col w-full p-1 space-y-2 rounded-lg bg-gray-50 dark:bg-cyan-600/20 border-2 border-cyan-600 dark:border-cyan-600 overflow-y-scroll h-fit max-h-[8.5rem]">
                                <a v-for="(month, index) in props.cycleinfo[1]" :href="'/download/ledger/cycle/'+ month.id" :class="[classStyle.btnSelect]">
                                    Download Month: <span class="font-semibold font-sans justify-end underline w-1/2 inline-flex space-x mr-2"> {{index + 1}}. {{ month.month }} {{ month.year }} Ledger
                                    <svg class="w-3.5 h-3.5 mt-1 ml-2" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                        <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                    </svg></span>
                                </a>
                            </section>
                        </li>
                    </ol>
                </div>
            </section>
        </div>
        <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-gray-300/30">
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

    <alertview
        :alertshowview  = alerts.alertShowView
        :message        = alerts.flashMessage
        :class          = alerts.alertBody
        :link           = alerts.linkName
        :url            = alerts.linkUrl
        :url2           = alerts.linkUrl2
        :page           = alerts.ledgerPage
        :state          = alerts.linkState
    ></alertview>
</template>

<script setup>
    import { reactive, onBeforeMount, defineProps } from 'vue'

    const props = defineProps({
        cycleinfo: {
            type: Array,
            required: true,
        }
    })

    const classStyle = reactive({
        btnSelect: 'inline-flex items-center px-4 py-2 text-base font-medium text-gray-900 bg-white border-2 border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring focus:outline-none focus:ring-cyan-200 focus:text-blue-700 dark:bg-cyan-400 dark:text-gray-800 dark:border-gray-900 dark:hover:text-black dark:hover:bg-cyan-700 dark:focus:ring-cyan-700 uppercase w-full justify-between my-2',
        btnDanger: 'inline-flex items-center px-4 py-2 text-base font-medium text-red-900 bg-white border-2 border-red-200 rounded-lg hover:bg-red-100 hover:text-red-700 focus:z-10 focus:ring focus:outline-none focus:ring-red-200 focus:text-blue-700 dark:bg-red-700 dark:text-gray-900 dark:border-gray-900 dark:hover:text-black dark:hover:bg-red-800 dark:focus:ring-red-700 uppercase w-full justify-between my-2 cursor-not-allowed',
        spanClass: 'absolute flex items-center justify-center w-4 h-4 bg-blue-100 rounded-full -start-2.5 ring-4 ring-white dark:ring-gray-900 dark:bg-blue-900',
        svgClass: 'w-3 h-3 text-blue-800 dark:text-blue-300',
        headerClass: 'flex items-center mb-1 text-xl font-normal uppercase text-gray-900 dark:text-white ml-4',
        headerOption: 'inline-flex items-center mb-1 text-xl font-normal uppercase text-gray-900 dark:text-white dark:hover:text-cyan-500 justify-between w-full hover:cursor-pointer',
        headerMain: 'font-normal text-[1.95rem] text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 w-full inline-flex justify-between my-1 hover:text-cyan-500 dark:hover:text-cyan-500 cursor-pointer',
    })

    const info = reactive({
        cycleYears: [],
        cycleMonths: [],
        endMonths: [],
        countNo: '',
        cyclesNo: '',

        noCycles: false,

        lastMonth: {},
        firstMonth: {},

        viewShow: false,
        yearShow: false,
        monthShow: false,

        start: '',
        end: '',
        startName: '',
        endName: '',
    })

    // alerts classes 
    const alerts = reactive({
        // alerts
        alertShow: false,
        alertShowView: false,
        alertDuration: 15000,
        alertType: '',
        flashMessage: '',
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',
        linkName: '',
        linkUrl: '',
        linkUrl2: '',
        linkState: false,
        ledgerPage: false
    })

    onBeforeMount(() => [
        setInfo(),
    ])

    function setInfo() {
        info.cycleYears    = props.cycleinfo[0]
        info.cycleMonths   = props.cycleinfo[1]
        info.endMonths     = props.cycleinfo[1]
        info.firstMonth    = props.cycleinfo[2]
        info.lastMonth     = props.cycleinfo[3]
        info.startName     = props.cycleinfo[4]
        info.endName       = props.cycleinfo[5]
        info.countNo       = props.cycleinfo[6]

        if (props.cycleinfo[6] == 0) {
            info.noCycles = true;
        } else {
            info.noCycles = false;
        }
    }

    function getAlert() {
        if (info.start == '' && info.end == '') {
            let message = "Select Opening and Ending Months!";
            let body = 'danger';
            flashShow(message, body)
        } 
        if (info.start != '' && info.end == '') {
            let message = "Select An Ending Month!";
            let body = 'danger';
            flashShow(message, body)
        }
        if (info.start == '' && info.end != '') {
            let message = "Select An Opening Month!";
            let body = 'danger';
            flashShow(message, body)
        }
    }

    function openView() {
        info.viewShow = !info.viewShow

        if (info.countNo == 0) {
            let message = "No Available Ledgers for download!";
            let body    = 'danger';
            flashShow(message, body)
        } else {
            info.noCycles = false;
            let message = "Welcome! Ledgers Available for download!";
            let body    = 'success';
            flashShow(message, body)
        }
    }

    function checkStart(month) {
        info.startName = month.name;
        axios.get('/api/getNextCyclesInfo/'+ month.id)
            .then(
                ({ data }) => {
                    info.endMonths  = data[0]
                    if (data[0].length == 1) {
                        let message = "Starting Month: "+ month.name +"! Only "+ data[0].length +" month available for the ledger!";
                        let body    = 'info';
                        flashShow(message, body)
                    } else {
                        let message = "Starting Month: "+ month.name +"! "+ data[0].length +" months available for the ledger!";
                        let body    = 'success';
                        flashShow(message, body)
                    }
                    setTimeout(() => {
                        let message = "Select an ending month";
                        let body    = 'info';
                        flashShow(message, body)
                    }, 250);    
                }
            )
    }

    function checkEnd(month) {
        info.endName = month.name;
        axios.get('/api/getCyclesNo/'+ info.start +'/'+ info.end)
            .then(
                ({ data }) => {
                    info.countNo  = data
                    if (data[0] == 1) {
                        let message = "Ending Month: " + month.name + ": ONLY! "+ data +" month available for the ledger!";
                        let body    = 'info';
                        flashShow(message, body)
                    } else {
                        let message = "Ending Month: " + month.name + "! " + data + " months available for the ledger!";
                        let body    = 'success';
                        flashShow(message, body)
                    }
                        
                }
            )
    }

    function flashShow(message, body) {
        alerts.flashMessage = message;
        alerts.alertType = body;

        if (body == 'success') {
            alerts.alertBody = alerts.alertSuccess;
        }
        if (body == 'info') {
            alerts.alertBody = alerts.alertInfo;
        }
        if (body == 'warning') {
            alerts.alertBody = alerts.alertWarning;
        }
        if (body == 'danger') {
            alerts.alertBody = alerts.alertDanger;
        }

        alerts.alertShow = !alerts.alertShow;
    }

    function downloadMonths(start, end) {
        alerts.ledgerPage     = true;
        alerts.flashMessage   = 'Download Monthly Selection Ledger!';
        alerts.linkName       = 'Download ' + info.countNo + ' Months Ledger';
        alerts.alertType      = 'info';
        alerts.linkUrl        = '/download/ledger/'+ start + '/' + end;
        alerts.linkUrl2       = '/download/ledger/'+ start + '/' + end + '/active';
        alerts.linkState      = true;
        flashShowView(alerts.flashMessage, alerts.alertType);
    }

    function downloadLedger() {
        alerts.ledgerPage     = true;
        alerts.flashMessage   = 'Download Full Ledger!';
        alerts.linkName       = 'Download Ledger';
        alerts.alertType      = 'info';
        alerts.linkUrl        = '/download/ledger';
        alerts.linkUrl2       = '/download/ledger/active';
        alerts.linkState      = true;
        flashShowView(alerts.flashMessage, alerts.alertType);
    }
    // end ledgers modal

    function flashShowView(message, body) {
        alerts.flashMessage   = message;
        alerts.alertType = body;
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

        alerts.alertShowView = !alerts.alertShowView;
    }
</script>