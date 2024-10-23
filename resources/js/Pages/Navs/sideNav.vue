<template>
    <!-- Sidenav -->
    <aside id="sidebar-button"
        :class="['fixed top-[60px] mt-2 left-1 z-40 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-transparent dark:bg-transparent', info.sideWidth]"
        aria-label="Sidebar" v-show="info.closeNavBar">
        <div class="h-[90vh] py-2 pl-2 w-full overflow-y-scroll relative font-boldened space-y-2 flex-col hidescroll">
            <ul :class="props.done ? info.classList : info.settingsList">
                <li class="relative"
                    v-tooltip="{ content: 'Return Back', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}"
                    v-if="info.reloadBtn && props.done">
                    <Link :class="props.done ? info.linkClass : info.settingsClass" @click="getRoute(info.reloadLink)"
                        as="button">
                    <span :class="props.done ? info.spanClass1 : info.settingsClass1">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            :class="[info.svgSize]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                        </svg>
                    </span>
                    <span :class="props.done ? info.spanClass2 : info.settingsClass2" v-if="info.spanShow">Return
                        Back</span>
                    </Link>
                </li>
                <li class="relative"
                    v-tooltip="{ content: 'Reload View', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}"
                    v-if="!info.reloadBtn && props.done">
                    <Link :class="props.done ? info.linkClass : info.settingsClass" @click="getRoute(info.reloadLink)"
                        as="button">
                    <span :class="props.done ? info.spanClass1 : info.settingsClass1">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </span>
                    <span :class="props.done ? info.spanClass2 : info.settingsClass2" v-if="info.spanShow">Reload</span>
                    </Link>
                </li>
                <li class="relative" v-for="link in links"
                    v-tooltip="{ content: title(link.header), placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <a :class="props.done ? info.linkClass : info.settingsClass" @click="getRoute(link.link)">
                        <span :class="props.done ? info.spanClass1 : info.settingsClass1">
                            <div :class="[info.svgSize]" v-html="link.icon" @click="getRoute(link.link)"></div>
                        </span>
                        <span :class="props.done ? info.spanClass2 : info.settingsClass2" v-if="info.spanShow"
                            @click="getRoute(link.link)">
                            {{link.header}}
                        </span>
                        <div :class="info.badgeClass"
                            v-if="link.badge && link.header == 'Members' && info.membersNo > 0">
                            <span>{{ info.membersNo }}</span>
                        </div>
                        <div :class="info.badgeClass" v-if="link.badge && link.header == 'Cycles' && info.cyclesNo > 0">
                            <span>{{ info.cyclesNo }}</span>
                        </div>
                        <div :class="info.badgeClass" v-if="link.badge && link.header == 'Projects' && info.projectsNo > 0">
                            <span>{{ info.projectsNo }}</span>
                        </div>
                    </a>
                </li>
            </ul>
            <ul :class="props.done ? info.classList : info.settingsList">
                <!-- <li class="relative">
                    <button :class="props.done ? info.linkClass : info.settingsClass" 
                        data-drawer-target="sidebar-button" data-drawer-toggle="sidebar-button" aria-controls="sidebar-button">
                        <span :class="props.done ? info.spanClass1 : info.settingsClass1">
                            <svg :class="[info.svgSize]" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-5.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                                </svg>
                        </span>
                        <span :class="props.done ? info.spanClass2 : info.settingsClass2"
                            v-if="info.spanShow">Close</span>
                    </button>
                </li> -->
                <li class="relative"
                    v-tooltip="{ content: 'Log Out', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <Link :class="[info.linkClass]" :href="route('logout')" method="post" as="button">
                    <span :class="props.done ? info.spanClass1 : info.settingsClass1">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            :class="[info.svgSize]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M22 10.5h-5m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                    </span>
                    <span :class="props.done ? info.spanClass2 : info.settingsClass2" v-if="info.spanShow">Logout</span>
                    </Link>
                </li>
                <li class="relative"
                    v-tooltip="{ content: 'Database Backup', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <a :class="props.done ? info.linkClass : info.settingsClass" @click="toggle()" href="/DBbackup">
                        <span :class="props.done ? info.spanClass1 : info.settingsClass1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" :class="[info.svgSize]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                        </span>
                        <span :class="props.done ? info.spanClass2 : info.settingsClass2" v-if="info.spanShow">
                            DB Backup
                        </span>
                    </a>
                </li>
                <li class="relative"
                    v-tooltip="{ content: 'Expand Sidebar', placement: 'right', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <a :class="props.done ? info.linkClass : info.settingsClass" @click="toggle()">
                        <span :class="props.done ? info.spanClass1 : info.settingsClass1">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                :class="[info.svgSize]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                            </svg>
                        </span>
                        <span :class="props.done ? info.spanClass2 : info.settingsClass2" v-if="info.spanShow">
                            Expand
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <!-- End Sidenav-->
</template>

<script setup>
    import { router } from '@inertiajs/vue3';
    import { onMounted, onUnmounted, reactive, defineProps, ref, defineEmits } from 'vue';

    const props = defineProps({
        show: {
            type: Boolean,
            required: true
        },
        done: {
            type: Boolean,
            required: true
        },
        link: {
            type: String,
            required: true
        },
    })

    const emit = defineEmits(['size','full','flash'])

    const info = reactive ({
        // windowWidthTest: ''
        windowWidth     : '',
        sideBarClass    : '',

        // classes 
        reloadBtn       : false,
        reloadLink      : '',
        reloadState     : false,

        classList: 'space-y-2 font-normal relative bg-gray-50 dark:bg-gray-800 border-2 border-cyan-800 w-full dark:border-cyan-600 rounded-md shadow-md py-1',
        settingsList: 'space-y-2 font-normal relative bg-gray-50 dark:bg-gray-800 border-[2px] border-rose-800 w-full dark:border-rose-600 rounded-md shadow shadow-rose-500/40 py-1',

        tooltipClass: 'inline-block absolute invisible z-10 py-2 px-3 w-auto text-sm uppercase font-semibold text-cyan-300 hover:text-cyan-500 bg-cyan-800 dark:bg-cyan-800 rounded-lg shadow-md opacity-0 transition-opacity duration-300 tooltip border-2 border-cyan-300 dark:border-cyan-300 whitespace-nowrap',

        linkClass: 'mt-1 flex h-10 cursor-pointer items-center truncate w-full p-2 text-[2rem] text-gray-900 outline-none transition duration-300 ease-linear hover:text-cyan-600 hover:outline-none focus:bg-transparent focus:outline-none active:bg-transparent active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:focus:text-emerald-800 dark:hover:text-cyan-600 text-xl hover:underline uppercase',
        settingsClass: 'mt-1 flex h-10 cursor-not-allowed items-center truncate w-full p-2 text-[2rem] text-red-600 outline-none transition duration-300 ease-linear hover:text-red-600 hover:outline-none focus:bg-transparent focus:outline-none active:bg-transparent active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-red-300 dark:focus:text-red-800 dark:hover:text-red-600 text-xl hover:underline uppercase',

        spanClass1      : 'mr-1 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-gray-900 dark:[&>svg]:text-gray-300 dark:hover:[&>svg]:text-cyan-600',

        spanClass2      : 'group-[&[data-te-sidenav-slim-collapsed=' + 'true' + ']]:data-[te-sidenav-slim=' + 'false' + ']:hidden',

        svgSize: 'h-5 w-5',

        settingsClass1      : 'mr-1 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-red-800 dark:[&>svg]:text-red-300 dark:hover:[&>svg]:text-red-600',

        settingsClass2      : 'group-[&[data-te-sidenav-slim-collapsed=' + 'true' + ']]:data-[te-sidenav-slim=' + 'false' + ']:hidden',

        spanClassDrop: 'absolute right-0 ml-auto mr-[0.5rem] transition-transform duration-300 ease-linear motion-reduce:transition-none [&>svg]:text-gray-600 dark:[&>svg]:text-gray-300',

        linkDrop: 'h-5 items-center cursor-pointer truncate w-full py-4 pl-[3.4rem] pr-6 text-[0.85rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-transparent my-1 hover:text-inherit hover:outline-none focus:bg-transparent focus:text-inherit focus:outline-none active:bg-transparent active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:text-emerald-600 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10 inline-flex justify-between w-full',

        spanClass3: 'ml-2 inline-block whitespace-nowrap rounded-[0.27rem] bg-emerald-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.85em] font-normal leading-none text-emerald-700',

        badgeClass: 'absolute inline-flex items-center justify-center w-6 h-6 text-xs font-normal text-black bg-cyan-100 border-2 border-cyan-500 rounded-full -top-2 -end-2 dark:border-cyan-900 right-1 px-1',

        ordersList       : [],

        isVisible       : true,

        link1: '/dashboard',
        link2: '/members',
        link3: '/cycles',
        link4: '/ledgers',
        link5: '/projects',
        link6: '/settings',
        link7: '/profile',

        svg1: '<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-gray-800 dark:[&>svg]:text-gray-300 dark:hover:[&>svg]:text-cyan-600  transition duration-75 h-5 w-5"><path stroke- linecap="round" stroke - linejoin="round" d = "M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>',
        svg2: '<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-gray-800 dark:[&>svg]:text-gray-300 dark:hover:[&>svg]:text-cyan-600  transition duration-75 h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" /></svg>',
        svg3: '<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-gray-800 dark:[&>svg]:text-gray-300 dark:hover:[&>svg]:text-cyan-600  transition duration-75 h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        svg4: '<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-gray-800 dark:[&>svg]:text-gray-300 dark:hover:[&>svg]:text-cyan-600  transition duration-75 h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12"/></svg>',
        svg5: '<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-gray-800 dark:[&>svg]:text-gray-300 dark:hover:[&>svg]:text-cyan-600  transition duration-75 h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>',
        svg6: '<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-gray-800 dark:[&>svg]:text-gray-300 dark:hover:[&>svg]:text-cyan-600  transition duration-75 h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>',
        svg7: '<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-gray-800 dark:[&>svg]:text-gray-300 dark:hover:[&>svg]:text-cyan-600  transition duration-75 h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>',

        // links: [],

        setting: {},
        version: '',

        navLinkActive: 'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group uppercase underline',
        navLinkInactive: 'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group uppercase underline cursor-not-allowed',
        navLink: 'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group uppercase underline',

        spanShow: false,
        close: false,
        sideWidth: '',

        closeNavBar: true,

        // badges 
        membersNo: 0,
        cyclesNo: 0,
        projectsNo: 0
    })

    const links =  [
        { 
            id: 1, 
            header: 'Dashboard',  
            info:   'Dashboard',   
            link:   info.link1 , 
            icon:   info.svg1,
            badge:  false,
        },
        { 
            id: 2, 
            header: 'Members',    
            info:   'View All Members',     
            link:   info.link2, 
            icon:   info.svg2,
            badge:  true,
            count:  info.membersNo
        },
        { 
            id: 3, 
            header: 'Cycles',      
            info:   'View All Cycles',      
            link:   info.link3, 
            icon:   info.svg3,
            badge:  true,
            count:  info.cyclesNo
        },
        { 
            id: 4, 
            header: 'Ledgers',     
            info:   'View All Ledgers',     
            link:   info.link4 , 
            icon:   info.svg4,
            badge:  false,
        },
        { 
            id: 5, 
            header: 'Projects',    
            info:   'View All Projects',    
            link:   info.link5, 
            icon:   info.svg5,
            badge:  true,
            count:  info.projectsNo
        },
        { 
            id: 6, 
            header: 'Settings',    
            info:   'View All Settings',    
            link:   info.link6 , 
            icon:   info.svg6,
            badge:  false,
        },
        { 
            id: 7, 
            header: 'Profile',     
            info:   'View User Profile',     
            link:   info.link7 , 
            icon:   info.svg7,
            badge:  false,
        }
    ]

    onMounted(() => {
        window.addEventListener('resize', () => { getWindowWidth() })

        getWindowWidth()

        getBackLink()

        axios.get('/api/urlPrev')
            .then(({ data }) => {
                    info.membersNo   = data[2];
                    info.cyclesNo    = data[3];
                    info.projectsNo  = data[4];
                });
    })

    onUnmounted(() => {
        window.removeEventListener('resize', () => { getWindowWidth() })
    })

    function toggle() {
        info.spanShow = !info.spanShow;
        spanVisible();
    }

    function title(a) {
        if (props.done) {
            return a.toUpperCase();
        } else {
            let x = 'View Disabled ,Complete All Settings';
            return x;
        }
    }

    function closeNav() {
        info.closeNavBar = !info.closeNavBar

        if (info.closeNavBar) {
            info.sideWidth = 'w-[0px]';
            emit('size', 'sm:ml-2')
            emit('full', info.closeNavBar);
        } else {
            info.spanShow = false;
            info.sideWidth = 'w-fit';
            emit('size', 'sm:ml-4')
            emit('full', info.closeNavBar);
        }
    }

    function getBackLink() {
        let link = info.reloadLink
        // console.log(route().current());
			
        if (link == 'empty' || route().current() == 'Dashboard') {
            info.reloadBtn     = false;
            info.reloadLink    = '/dashboard';
        } else {
            info.reloadBtn     = true;
            info.reloadLink    = link;
        }
    }

    function getUrl() {
        axios.get('/api/urlPrev')
            .then(({ data }) => {
                    info.reloadState = data[0];
                    info.reloadLink  = data[1];
                    info.membersNo   = data[2];
                    info.cyclesNo    = data[3];
                    info.projectsNo  = data[4];
                    getBackLink();    
                });
    }

    function spanVisible() {
        if (info.spanShow) {
            info.sideWidth = 'w-64';
            emit('size', 'sm:ml-64')
        } else {
            info.sideWidth = 'w-fit';
            emit('size', 'sm:ml-14')
        }
    }
    
    function getWindowWidth() {
        info.windowWidth = ref(window.innerWidth)
        
        const x = info.windowWidth;
        
        switch (true) {
            case (x < 640):
                // console.log('small mobile');
                info.spanShow = false;
                info.close = true;
                spanVisible();
                break;
            case (x < 1024):
                // console.log('medium laptop');
                info.spanShow = false;
                info.close = false;
                spanVisible();
                break;
            case (x > 2400):
                // console.log('large screen');
                info.spanShow = true;
                info.close = false;
                spanVisible();
                break;
        }

        getBackLink()
    }

    function getRoute(url) {
        if (info.spanShow == true) {
            toggle();
        }

        if (props.done) {
            router.visit(url, { 
                preserveScroll: true 
            });
        } else {
            let flashMessage = 'Other Views Disabled ,Complete All Settings!';
            let alertBody    = 'danger';
            emit('flash', flashMessage, alertBody);
        }

        getUrl();
    }

    function controlVis() {
        info.isVisible = !info.isVisible;
    }
</script>