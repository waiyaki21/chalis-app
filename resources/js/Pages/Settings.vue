<template>

    <Head>
        <title>{{ props.route }}</title>
    </Head>

    <!-- breadcrumb  -->
    <settingscrumbs></settingscrumbs>
    <!-- end breadcrumb  -->

    <!-- Contribution documents  -->
    <div class="py-2 font-boldened">
        <div class="w-full m-2 text-left mx-auto p-2 overflow-hidden">
            <h2
                class="font-normal font-boldened text-[3.5rem] text-cyan-800 dark:text-cyan-300 leading-tight uppercase underline mb-2">
                ADMIN SETTINGS.
            </h2>

            <!--documents tabs  -->
            <div class="mb-4 px-2">
                <ul class="flex flex-wrap -mb-px text-base font-medium text-center">
                    <li class="me-2" role="presentation">
                        <button :class="[classInfo.tab1]" id="setup-tab" data-tabs-target="#setup" type="button"
                            role="tab" aria-controls="setup" aria-selected="false" @click="tabSwitch">
                            System Settings
                            <span :class="[classInfo.tab2svg]">
                                1
                            </span>
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button :class="[classInfo.tab2]" v-if="props.updated" @click="tabSwitch2">
                            Members
                            <span :class="[classInfo.tab2svg]">
                                {{ members.length }}
                            </span>
                        </button>
                        <button :class="[classInfo.tabDanger, 'cursor-not-allowed opacity-25']" @click="finishSettings"
                            v-else>
                            Members
                            <span :class="[classInfo.tab2svg]">
                                {{ members.length }}
                            </span>
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button :class="[classInfo.tabDanger, 'cursor-not-allowed opacity-25']" @click="finishMembers"
                            v-if="members.length == 0">
                            Contribution Cycles
                            <span :class="[classInfo.tab3svg]">
                                {{ cycles.length }}
                            </span>
                        </button>
                        <button :class="[classInfo.tab3]" v-else @click="tabSwitch3">
                            Contribution Cycles
                            <span :class="[classInfo.tab3svg]">
                                {{ cycles.length }}
                            </span>
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button :class="[classInfo.tabReset]" @click="resetDB">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 mx-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            Full Resest
                        </button>
                    </li>
                    <li role="presentation">
                        <a :class="[classInfo.tabInfo, 'cursor-not-allowed opacity-25']" @click="finishCycle"
                            v-if="cycles.length == 0">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 mx-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dashboard
                        </a>
                        <a @click="getRoute()" :class="[classInfo.tabSuccess]" v-else>
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 mx-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Finish
                        </a>
                    </li>
                </ul>
            </div>

            <!-- tabs body  -->
            <div class="">
                <settingTabs :settings=settings :show="classInfo.tab1show" :updated=props.updated @reload=reloadNav
                    @changed=settingsChanged v-if="classInfo.tab1show"></settingTabs>

                <setmembersTabs :route=props.route @changed=membersChanged v-if="classInfo.tab2show"></setmembersTabs>

                <setcycleTabs :route=props.route :current=current :cycles=cycles :nextname=nextname :date=date
                    :settings=settings :show="classInfo.tab3show" @changed=cyclesChanged v-if="classInfo.tab3show">
                </setcycleTabs>
            </div>
        </div>
        <!-- end documents panel -->
    </div>
    <!--end Contribution documents  -->

    <!-- flash alert  -->
    <alert :alertshow=classInfo.alertShow :message=classInfo.flashMessage :class=classInfo.alertBody
        :type=classInfo.alertType :title=classInfo.alertType :time=classInfo.alertDuration></alert>

    <alertview :alertshowview=classInfo.alertShowView :message=classInfo.flashMessage :class=classInfo.alertBody
        :link=classInfo.linkName :url=classInfo.linkUrl :state=classInfo.linkState :type=classInfo.alertType
        :title=classInfo.alertType></alertview>
</template>

<script setup>
    import { defineProps, reactive, onMounted } from "vue";
    import { router } from '@inertiajs/vue3';
    
    const props = defineProps({
        name: {
            type: String,
            required: true,
        },
        route: {
            type: String,
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
        members: {
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
        settings: {
            type: Object,
            required: true,
        },
        projects: {
            type: Object,
            required: true,
        },
        updated: {
            type: Boolean,
            required: true,
        },
    })

    const classInfo = reactive ({
        isOpen: false,
        modalData: {},

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',

        info: [],

        // tabs 
        tabActive: 'inline-flex p-4 border-b-[3px] rounded-t-lg uppercase text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500',
        tabInactive: 'inline-flex p-4 border-b-[3px] rounded-t-lg uppercase hover:text-gray-600 border-gray-200 hover:border-gray-300 dark:hover:text-teal-300 dark:text-gray-300 cursor-pointer',
        tabDanger: 'inline-flex p-4 border-b-[3px] rounded-t-lg uppercase hover:text-red-600 border-red-400 hover:border-red-600 dark:hover:text-red-300 dark:text-red-600 cursor-not-allowed',
        tabReset: 'inline-flex p-4 border-[3px] rounded-lg uppercase hover:text-red-600 border-red-500 hover:border-red-600 dark:hover:text-red-500 dark:text-red-600 cursor-pointer',
        tabInfo: 'inline-flex p-4 border-[3px] rounded-lg uppercase hover:text-cyan-600 border-cyan-400 hover:border-cyan-600 dark:hover:text-cyan-300 dark:text-cyan-600 cursor-not-allowed',
        tabSuccess: 'inline-flex p-4 border-[3px] rounded-lg uppercase hover:text-green-600 border-green-400 hover:border-green-600 dark:hover:text-green-300 dark:text-green-600 cursor-pointer',

        tab1: '',
        tab2: '',
        tab3: '',
        tab4: '',
        tab1show: true,
        tab2show: true,
        tab3show: true,
        tab4show: false,

        tab2svg: '',
        tab3svg: '',

        svgActive: 'bg-blue-100 text-gray-800 text-base font-normal mx-2 px-2.5 py-0.5 rounded-full dark:bg-cyan-900 dark:text-gray-300 border-2 border-cyan-900 dark:border-cyan-500',
        svgInactive: 'bg-red-100 text-gray-800 text-base font-normal mx-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-gray-300 border-2 border-red-900 dark:border-red-500',

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

    onMounted(() => {
        setInfo()
        tabSwitch()
    })

    function setInfo() {
        classInfo.info = props.cycles;
    }

    function tabSwitch() {
        resetTabClass();
        classInfo.tab1show = true;
        classInfo.tab2show = false;
        classInfo.tab3show = false;
        classInfo.tab4Show = false;
        classInfo.tab1     = classInfo.tabActive;
    }

    function tabSwitch2() {
        // console.log('2');
        // resetTabClass();
        classInfo.tab1show = false;
        classInfo.tab2show = true;
        classInfo.tab3show = false;
        classInfo.tab4Show = false;

        classInfo.tab2    = classInfo.tabActive;
    }

    function tabSwitch3() {
        resetTabClass();
        classInfo.tab1show = false;
        classInfo.tab2show = false;
        classInfo.tab3show = true;
        classInfo.tab4Show = false;
        classInfo.tab3    = classInfo.tabActive;
    }

    function tabSwitch4() {
        resetTabClass();
        classInfo.tab1show = false;
        classInfo.tab2show = false;
        classInfo.tab3show = false;
        classInfo.tab4Show = true;
        classInfo.tab4     = classInfo.tabActive;
    }

    function resetTabClass() {
        classInfo.tab1 = classInfo.tabInactive;
        classInfo.tab2 = classInfo.tabInactive;
        classInfo.tab3 = classInfo.tabInactive;
        classInfo.tab4 = classInfo.tabInactive;
        classInfo.tab2svg = classInfo.svgActive;
        classInfo.tab3svg = classInfo.svgActive;
    }

    function finishSettings() {
        classInfo.flashMessage   = 'Enter new System Settings To Proceeed!';
        classInfo.alertType      = 'danger';
        classInfo.alertBody      = classInfo.alertDanger;
        classInfo.alertShow      = !classInfo.alertShow;
    }

    function finishMembers() {
        classInfo.flashMessage   = 'Enter new Members To Proceeed!';
        classInfo.alertType      = 'warning';
        classInfo.alertBody      = classInfo.alertDanger;
        classInfo.alertShow      = !classInfo.alertShow;
    }

    function finishCycle() {
        classInfo.flashMessage   = 'Create a new Payment Cycle To Proceeed!';
        classInfo.alertType      = 'info';
        classInfo.alertBody      = classInfo.alertInfo;
        classInfo.alertShow      = !classInfo.alertShow;
    }

    function reloadNav() {
        // emit('reload');
    }

    function settingsChanged() {
        if (props.settings.created_at != props.settings.updated_at) {
            // console.log('settings main check success');
            // if (classInfo.tab1show) {
            //     classInfo.tab1 = classInfo.tabActive;
            // } else {
            //     classInfo.tab1 = classInfo.tabSuccess
            // }
            tabSwitch2()
        } else {
            // if (classInfo.tab1show) {
            //     classInfo.tab1 = classInfo.tabActive;
            // } else {
            //     classInfo.tab1 = classInfo.tabInactive
            // }
            tabSwitch()
        }
    }

    function membersChanged(count) {
        // this.membersCount = members.length;
        // router.get('/settings');
        
        if (count != 0) {
            // console.log('members main check success');
            if (classInfo.tab2show) {
                classInfo.tab2 = classInfo.tabActive;
                classInfo.tab2svg = classInfo.svgActive;
            } else {
                classInfo.tab2 = classInfo.tabSuccess
                classInfo.tab2svg = classInfo.svgActive;
            }
        } else {
            if (classInfo.tab2show) {
                classInfo.tab2 = classInfo.tabActive;
                classInfo.tab2svg = classInfo.svgActive;
            } else {
                classInfo.tab2 = classInfo.tabDanger;
                classInfo.tab2svg = classInfo.svgInactive;
            }
        }
    }

    function cyclesChanged(count) {
        // this.membersCount = members.length;
        if (count != 0) {
            // console.log('cycles main check success');
            if (classInfo.tab3show) {
                classInfo.tab3 = classInfo.tabActive;
                classInfo.tab3svg = classInfo.svgActive;
            } else {
                classInfo.tab3 = classInfo.tabSuccess;
                classInfo.tab3svg = classInfo.svgActive;
            }
        } else {
            if (classInfo.tab3show) {
                classInfo.tab3 = classInfo.tabActive;
                classInfo.tab3svg = classInfo.svgActive;
            } else {
                classInfo.tab3 = classInfo.tabInactive;
                classInfo.tab3svg = classInfo.svgInactive;
            }
        }
    }

    function getRoute() {
        let url = '/dashboard';

        router.get(url);
    }

    function resetDB() {
        classInfo.flashMessage = 'All information will be deleted!, Are you sure you want to delete everything?';
        classInfo.alertType = 'warning',
        classInfo.linkName  = 'Reset Database';
        classInfo.linkUrl   = '/resetDB';
        classInfo.alertBody = classInfo.alertWarning;
        classInfo.linkState = true;
        classInfo.alertShowView = !classInfo.alertShowView;
    }
</script>