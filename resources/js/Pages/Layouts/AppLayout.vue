<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

        <nav class="fixed top-0 z-50 w-full bg-white border-b-2 border-cyan-200 dark:bg-gray-800 dark:border-cyan-700 shadow-md">
            <div class="px-3 py-2 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <button data-drawer-target="sidebar-button" data-drawer-toggle="sidebar-button" aria-controls="sidebar-button" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 sm:hidden rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                            </svg>
                        </button>
                        <a :href="route('Dashboard')" :active="route().current('Dashboard')" class="flex ml-2 md:mr-24 cursor-pointer font-boldened dark:text-cyan-500 hover:text-cyan-600 dark:hover:text-cyan-600">
                            <span class="self-center text-xl font-medium md:text-2xl whitespace-nowrap uppercase border-b-2 border-cyan-300 hover:border-cyan-600">
                                {{ $page.props.setting.shortname }}
                                <span class="self-center text-base opacity-50 font-medium sm:text-lg whitespace-nowrap  uppercase">v1.0</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center ml-3 font-boldened">
                            <div class="inline-flex">
                                <button type="button" class="px-5 py-1 bg-gray-800 text-gray-300 hover:text-cyan-400 sm:flex hidden text-lg hover:underline uppercase font-medium" @click="switchDrop()">
                                    <span class="sr-only">Open user menu</span>
                                    {{ $page.props.auth.user.name }}.
                                </button>
                                <button type="button" class="px-5 py-1 flex bg-gray-800 text-gray-300 hover:text-cyan-400 sm:hidden text-lg uppercase font-medium" @click="switchDrop()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white hover:text-cyan-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                            <div :class="[classInfo.dropdownActive]" v-if="classInfo.dropdown" style="position: absolute;  top: 44px;right: 15px;" @mouseleave="closeDrop">
                                <div class="px-4 py-3" role="none">
                                    <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    {{ $page.props.auth.user.name }}.
                                    </p>
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ $page.props.auth.user.email }}.
                                    </p>
                                </div>
                                <ul class="py-1" role="none">
                                    <li>
                                        <Link :href="route('Dashboard')" :active="route().current('Dashboard')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white uppercase cursor-pointer" role="menuitem">Dashboard</Link>
                                    </li>
                                    <li>
                                        <Link href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white uppercase cursor-pointer" role="menuitem">Settings</Link>
                                    </li>
                                    <li>
                                        <Link href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white uppercase cursor-pointer" role="menuitem">Profile</Link>
                                    </li>
                                    <li>
                                        <Link :href="route('logout')" method="post" as="button" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white uppercase cursor-pointer" role="menuitem">Sign out</Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <section class="inline-flex justify-normal w-full bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <!-- Sidenav -->
            <sidenav
                :user   = $page.props.auth.user
                :done   = $page.props.done
                :show   = classInfo.showBtn
                :link   = props.urlPrev
                @size   = widthCheck
                @full   = fullCheck
                @flash  = flashShow
            ></sidenav>
            <!--End Sidenav -->

            <div :class="['flex min-h-screen bg-transparent dark:bg-transparent w-full', classInfo.bodyWidth]">
                <div class="p-4 mt-8 w-full">
                    <!-- Page Heading -->
                    <header class="text-gray-300" v-if="$slots.header">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <slot name="header" />
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main>
                        <!-- plugins -->
                        <mainplugin
                            :user               = $page.props.auth.user
                            :done               = $page.props.done
                            ref                 = "pluginRef"
                        ></mainplugin>
                        <!-- end plugins -->
                        <slot />
                    </main>
                </div>
            </div>
        </section>
    </div>

    <!-- update payment modal  -->
    <!-- <autoSetup
        :show   = !$page.props.done
        :name   = classInfo.modalName
        @close  = closeModal
    ></autoSetup> -->
    <!-- end update payment modal  -->

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
    import  sidenav     from "../Navs/sideNav.vue";
    import  mainplugin  from "../Components/plugins/mainPlugin.vue";
    import { reactive, defineProps } from "vue";

    const props = defineProps({
        urlPrev: {
            type: String,
            required: true
        },
    })

    const classInfo = reactive ({
        setup: false,

        setting: {},
        version: '',
        componentKey: false,

        bodyWidth: 'sm:ml-14',
        showBtn: true,
        
        sidebarBtn: '',

        dropdown: false,
        dropdownClass: '',
        dropdownActive: 'z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 uppercase font-boldened block',
        dropdownInactive: 'z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 uppercase font-boldened',

        complete: '',
    })

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

    // function setup() {
    //     classInfo.complete = props.done;
    //     if (!props.done) {
    //         showModal()
    //     }
    // }

    // function showModal() {
    //     classInfo.modalName  = 'Automatic Upload';
    //     classInfo.isOpen     = true;
    // }

    // function closeModal() {
    //     classInfo.isOpen             = false;
    //     classInfo.modalName          = '';
    // }

    function widthCheck(a) {
        classInfo.bodyWidth = a;
    }

    function fullCheck(a) {
        classInfo.showBtn  = a;
        if (classInfo.showBtn) {
            classInfo.sidebarBtn = 'inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600';
        } else {
            classInfo.sidebarBtn = 'inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 sm:hidden rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600';
        }
    }

    function toggle() {
        classInfo.showBtn = !classInfo.showBtn
    }

    function switchDrop() {
        classInfo.dropdown = !classInfo.dropdown
        if (classInfo.dropdown) {
            classInfo.dropdownClass = classInfo.dropdownInactive
        } else {
            classInfo.dropdownClass = classInfo.dropdownActive
        }
    }

    function closeDrop() {
        classInfo.dropdown = false
        if (classInfo.dropdown) {
            classInfo.dropdownClass = classInfo.dropdownInactive
        } else {
            classInfo.dropdownClass = classInfo.dropdownActive
        }
    }

    function flashShow(message, body) {
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

        alerts.alertShow      = !alerts.alertShow;
    }
</script>