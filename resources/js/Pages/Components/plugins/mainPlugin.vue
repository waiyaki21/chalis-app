<template>
    <div class="fixed group z-10 top-[45%] right-[20px] flex flex-col space-y-4" @mouseleave="closeDial">
        <!-- dial btn  -->
        <button type="button" :class="[pluginClass.mainClass]" @click="showDial" v-tooltip="{ content: pluginClass.btn0.toUpperCase(), placement: 'left', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
            <svg class="w-5 h-5 transition-transform group-hover:rotate-90" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
            </svg>
            <span class="sr-only">Open actions menu</span>
        </button>

        <!-- color btn -->
        <button id="theme-toggle" type="button" :class="!pluginClass.isLight ? pluginClass.lightClass : pluginClass.darkClass" @click="getColor" v-tooltip="{ content: pluginClass.themeMsg.toUpperCase(), placement: 'left', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
            <svg id="theme-toggle-dark-icon" :class="pluginClass.isDark ? pluginClass.colorActive : pluginClass.colorInactive" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            <svg id="theme-toggle-light-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="pluginClass.isLight ? pluginClass.colorActive : pluginClass.colorInactive">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>
        </button>

        <div :class="[pluginClass.dialClass, 'animate__animated animate__slideInRight']" v-show="pluginClass.dialShow">
            <!-- Members  -->
            <button type="button" :class="[pluginClass.btnDropClass]" @click="addMembers" v-tooltip="{ content: pluginClass.btn1.toUpperCase(), placement: 'left', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <span :class="[pluginClass.spanClass1]">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="[pluginClass.svgClass]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </span>
            </button>
            <!-- contributions  -->
            <button type="button" :class="[pluginClass.btnDropClass]" @click="addCycles" v-tooltip="{ content: pluginClass.btn2.toUpperCase(), placement: 'left', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <span :class="[pluginClass.spanClass1]">
                    <svg :class="[pluginClass.svgClass]" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </span>
                <span class="sr-only">Add contributions</span>
            </button>
            <!-- upload ledger  -->
            <button type="button" :class="[pluginClass.btnDropClass, 'shadow-md']" @click="addLedger" v-tooltip="{ content: pluginClass.btn3.toUpperCase(), placement: 'left', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <span :class="[pluginClass.spanClass1]">
                    <svg :class="[pluginClass.svgClass]" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                </span>
                <span class="sr-only">Upload ledger</span>
            </button>
            <!-- download  ledger -->
            <a type="button" :class="[pluginClass.btnDropClass]" @click="downloadLedger" v-tooltip="{ content: pluginClass.btn4.toUpperCase() , placement: 'left', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <span :class="[pluginClass.spanClass1]">
                    <svg :class="[pluginClass.svgClass]" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </span>
                <span class="sr-only">Download Ledger</span>
            </a>
        </div>
    </div>

    <!-- add member modal  -->
    <membersadd
        :show       = formClass.isOpen
        @close      = closeMembers
        @loading    = flashLoading
    ></membersadd>
    <!-- end add member modal  -->

    <!-- add cycle modal  -->
    <cyclesaddModal
        :show       = formClass.isPaysOpen
        @close      = closeCycle
        @loading    = flashLoading
    ></cyclesaddModal>
    <!-- end add cycle modal  -->

    <!-- add ledger modal  -->
    <ledgersaddModal
        :show       = formClass.isLedgersOpen
        @close      = closeLedger
        @loading    = flashLoading
    ></ledgersaddModal>
    <!-- end add ledger modal  -->

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
    ></alertview>
</template>

<script setup>
    import { defineProps, reactive ,onBeforeMount }  from 'vue'
    import { vTooltip } from 'floating-vue'

    // props 
    const props = defineProps({
        user: {
            type: Object,
            required: true,
        },
        done: {
            type: Boolean,
            required: true,
        },
    });
    // end props 

    // data 
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
        linkState: false,
    })

    const pluginClass = reactive({
        btn0: 'Shortcuts',
        btn1: 'Add Members',
        btn2: 'Add contributions',
        btn3: 'Upload ledger',
        btn4: 'Download Ledger',

        mainClass: 'flex justify-center items-center w-12 h-12 bg-gray-50 dark:bg-gray-800 dark:hover:bg-cyan-800 border-[3px] border-cyan-800 dark:border-cyan-600 dark:hover:border-gray-900 text-cyan-900 hover:text-gray-900 dark:text-cyan-300 dark:hover:text-gray-900 rounded-2xl shadow-md hover:rounded-full',
        dialClass: 'flex hidden flex-col items-center my-4 space-y-2',
        dialClassActive: 'flex flex-col items-center my-4 space-y-2',
        dialShow: true,

        spanClass1: 'h-6 w-6',
        btnDropClass: 'flex justify-center items-center w-12 h-12 bg-gray-50 dark:bg-gray-800 border-[3px] border-cyan-800 dark:border-cyan-600 text-cyan-300 hover:text-cyan-500 rounded-xl shadow-md hover:rounded-2xl',
        svgClass: 'flex-shrink-0 w-6 h-6 text-cyan-500 transition duration-75 dark:text-cyan-300 group-hover:text-cyan-900 dark:group-hover:text-cyan-300',
        tooltipClass: 'inline-block absolute invisible z-10 py-2 px-3 w-auto text-sm uppercase font-semibold text-cyan-300 hover:text-cyan-500 bg-cyan-800 dark:bg-cyan-800 rounded-lg shadow-md opacity-0 transition-opacity duration-300 tooltip border-2 border-cyan-300 dark:border-cyan-300 whitespace-nowrap',
        modalCloseBtn: 'cursor-pointer dark:text-cyan-800 text-cyan-500 transition-transform hover:rotate-180 w-6 h-6 hover:w-10 hover:h-10',

        isLight: false,
        isDark: false,

        colorActive: 'w-6 h-6 m-1',
        colorInactive: 'hidden w-6 h-6 m-1',

        lightClass: 'text-cyan-100 bg-cyan-800 hover:bg-cyan-700 rounded-full text-sm p-2 border-2 border-cyan-100 shadow-md',
        darkClass: 'dark:text-cyan-800 dark:hover:text-gray-900 dark:bg-cyan-100 dark:hover:bg-cyan-300 rounded-full text-sm p-2 border-2 dark:border-cyan-900 shadow-md',
        themeMsg: 'Select Theme',
        theme: ''
    })

    const formClass = reactive({
        // members form info 
        isOpen      : false,

        // cycle form info 
        isPaysOpen      : false,

        // ledgers info
        isLedgersOpen   : false,
    })
    // end data 

    onBeforeMount(() => {
        getInfo()
        showDial()
    })

    function getInfo() {
        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            pluginClass.isLight = true;
            pluginClass.theme = 'light';
        } else {
            pluginClass.isDark = true;
            pluginClass.theme = 'dark';
        }

        if (pluginClass.theme == '') {
            getDark();
        }
    }

    function getDark() {
        pluginClass.isLight = false;
        pluginClass.isDark  = true;

        // if set via local storage previously
        if (!localStorage.getItem('color-theme')) {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                pluginClass.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                pluginClass.theme = 'dark';
            }
        }
    }

    function getColor() {
        pluginClass.isLight = !pluginClass.isLight;
        pluginClass.isDark  = !pluginClass.isDark;

        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                pluginClass.theme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                pluginClass.theme = 'light';
            }
        // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                pluginClass.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                pluginClass.theme = 'dark';
            }
        }
    }

    // dial settings 
    function showDial() {
        pluginClass.dialShow = !pluginClass.dialShow;
        if (pluginClass.dialShow == true) {
            pluginClass.dialClass = pluginClass.dialClassActive;
        } else {
            pluginClass.dialClass = pluginClass.dialClass;
        }
    }

    function closeDial() {
        pluginClass.dialShow = false;
    }
    // end dial settings 

    // month cycle modal 
    function addCycles() {
        showDial();
        formClass.isPaysOpen = !formClass.isPaysOpen;
    }

    function closeCycle() {
        formClass.isPaysOpen = false;
    }
    // end month cycle modal 

    // members modal 
    function addMembers() {
        showDial();
        formClass.isOpen = !formClass.isOpen;
    }

    function closeMembers() {
        formClass.isOpen      = false;
    }
    // end members modal 

    // ledgers modal 
    function addLedger() {
        formClass.isLedgersOpen = !formClass.isLedgersOpen;
    }

    function closeLedger() {
        formClass.isLedgersOpen = false;
    }

    function downloadLedger() {
        closeDial();
        alerts.flashMessage   = 'Download Full Ledger!';
        alerts.linkName       = 'Download Ledger';
        alerts.alertType      = 'info';
        alerts.linkUrl        = '/download/ledger';
        alerts.linkState      = true;
        flashShowView(alerts.flashMessage, alerts.alertType);
    }
    // end ledgers modal

    // flash message 
    function flashShow(message, body) {
        alerts.flashMessage   = message;
        alerts.alertType      = body;
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

    function flashLoading() {
        alerts.flashMessage   = 'Loading! Please Wait';
        alerts.alertBody      = alerts.alertWarning;
        alerts.alertType      = 'warning';
        alerts.alertDuration  = 900000;
    }

    function flashShowView(message, body) {
        alerts.flashMessage   = message;
        alerts.alertType      = body;
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
    // end flash message 
</script>