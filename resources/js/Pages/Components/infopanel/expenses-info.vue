<template>
    <!-- header  -->
    <section class="font-normal text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 grid grid-cols-3 md:grid-cols-3 gap-1">
        <section class="flex flex-col col-span-2 w-full">
            <span class="underline text-2xl md:text-4xl">{{ project.name }} Info.</span>
        </section>
        
        <div class="inline-flex rounded-md shadow-sm space-x-1 justify-end col-auto" role="group">
            <!-- edit  -->
            <button type="button"
                class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white focus:z-10 dark:text-cyan-700 dark:hover:text-cyan-600"
                @click="showProject(project)" v-tooltip="{ content: 'Edit Project', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="[classInfo.svgClass]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
            </button>
            <!-- delete  -->
            <button type="button"
                class="inline-flex items-center p-2 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-white focus:z-10 dark:text-red-700 dark:hover:text-red-600"
                @click="showDelete(project)" v-tooltip="{ content: 'Delete Project', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="[classInfo.svgClass]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
            <!-- view  -->
                <!-- <a :href="'/download/project/' + project.id" type="button"
                class="inline-flex items-center p-2 text-base font-medium text-gray-900 bg-transparent border dark:border-gray-300 rounded-md hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 uppercase">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                </svg>
                Excelsheet Download
            </a> -->
        </div>
    </section>
    <!-- end header  -->

    <!-- project status -->
    <section class="font-normal text-xl leading-tight uppercase px-2 py-1 w-full inline-flex justify-between">
        <span class="text-gray-800 dark:text-gray-300">PROJECT STATUS:</span>
        <span class="text-green-800 dark:text-green-500 underline underline-offset-4 text-xl md:text-3xl" v-if="project.total_percent == 100">
            Completed
        </span>
        <span class="text-orange-800 dark:text-orange-500 underline underline-offset-4 text-xl md:text-3xl" v-if="project.total_percent > 100">
            Completed & Surpassed
        </span>
        <span class="text-cyan-800 dark:text-cyan-500 underline underline-offset-4 text-xl md:text-3xl" v-if="project.total_percent > 1 && project.total_percent < 100">
            Ongoing
        </span>
        <span class="text-red-800 dark:text-red-500 underline underline-offset-4 text-xl md:text-3xl" v-if="project.total_percent == 0">
            Not Started
        </span>
    </section>
    <!-- end project status -->

    <!-- info panel  -->
    <section :class="[classInfo.infoSection]"> 
        <section class="w-full m-1 p-1 text-left grid grid-cols-2 md:grid-cols-3 gap-1">
            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]"  v-tooltip="{ content: 'Total no of incomplete / ongoing projects', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Total Expected.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-orange-700 dark:text-orange-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(project.target).toLocaleString()}">
                    ksh {{ numFormat(project.target) }}
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5 :class="[classInfo.infoHeader]"  v-tooltip="{ content: 'Total amount contributed', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Total Expenses.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-green-700 dark:text-green-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(project.total_expenses).toLocaleString()}">
                    ksh {{ numFormat(project.total_expenses) }}
                    <!-- <span class="text-xl text-red-500 dark:text-red-200" v-if="percent = 0">
                        ( 0% )
                    </span>
                    <span class="text-xl text-green-500 dark:text-green-200" v-else>
                        ( {{ percent }} % )
                    </span> -->
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]"  v-tooltip="{ content: 'Total Project Balance', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>T. Balance</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-purple-700 dark:text-purple-600 uppercase" v-tooltip="{ content: 'KSH ' + Number(props.project.target - props.project.total_expenses)}">
                    ksh {{ numFormat(props.project.target - props.project.total_expenses) }}
                    <!-- <span class="text-xl text-red-500 dark:text-red-200">
                        ( {{ balance }} % )
                    </span> -->
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5 :class="[classInfo.infoHeader]"  v-tooltip="{ content: 'Total Expense Percentage contributed', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>% Expenses.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-green-700 dark:text-green-600 uppercase" v-tooltip="{ content: Number(percent).toLocaleString()+'%'}">
                    <span class="text-red-500 dark:text-red-200" v-if="percent = 0">
                        0%
                    </span>
                    <span class="text-green-500 dark:text-green-200" v-else>
                        {{ percent }} %
                    </span>
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]"  v-tooltip="{ content: 'Total Percentage Balance', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>% Balance</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-purple-700 dark:text-purple-600 uppercase" v-tooltip="{ content: balance + '%'}">
                    <span class="text-amber-500 dark:text-amber-500">
                        {{ balance }} %
                    </span>
                </p>
            </a>

            <a class="block max-w-sm p-2 bg-transparent">
                <h5
                    :class="[classInfo.infoHeader]"  v-tooltip="{ content: 'No of Expenses Paid', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                    <span>Expenses No.</span>
                    <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                </h5>
                <p class="font-normal text-left md:text-4xl text-[2.5rem] text-red-700 dark:text-red-600 uppercase">
                    {{ Number(project.expenses.length).toLocaleString() }}
                </p>
            </a>
        </section>
    </section>

    <!-- progress bar  -->
    <progressInfo
        :name1 = '"Paid"'
        :name3 = '"Balance"'
        :percent1 = project.total_percent
        :percent3 = '100 - project.total_percent'
    ></progressInfo>
    <!-- end progress bar  -->

    <!-- update project modal  -->
    <projectsupdate
        :info   = classInfo.modalData
        :show   = classInfo.isOpen
        @reload = resetProjects
        @close  = closeProject
    ></projectsupdate>
    <!-- end update project modal  -->

    <!-- delete project modal  -->
    <projectsdelete
        :info   = classInfo.deleteData
        :show   = classInfo.isDeleteOpen
        :url    = classInfo.deleteURL
        @reload = resetProjects
        @close  = closeDelete
    ></projectsdelete>
    <!-- end delete project modal  -->
</template>

<script setup>
    import { defineProps, defineEmits, reactive, computed } from 'vue'

    const emit = defineEmits(['reload'])

    const props = defineProps({
        project: {
            type: Object,
            required: true,
        }
    });

    const classInfo = reactive({
        // main progress bar 
        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 md:text-2xl sm:text-xl md:text-left sm:text-left font-normal underline tracking-tight uppercase',

        isOpen: false,
        isOpenInfo: false,
        isDebtOpen: false,
        modalData: {},

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',
        deleteURL: '/delete/project/',

        svgClass: 'md:w-8 md:h-8 w-6 h-6'
    })

    function numFormat(num) {
        if (num < 9999) {
            return Number(num).toLocaleString();
        } else {
            if (num > 999999) {
                let x = Number(num / 1000000).toFixed(1);
                let y = x + ' m';
                return y;
            } else {
                let x = Number(num / 1000).toFixed(1);
                let y = x + ' k';
                return y;
            } 
        }
    }

    // computed 
    const percent = computed(() => {
        let percent = Number(props.project.total_expenses / props.project.target * 100).toFixed(1) 

        return percent
    })
    const balance = computed(() => {
        let percent = Number(props.project.total_expenses / props.project.target * 100).toFixed(1) 

        let balance = Number(100 - percent).toFixed(1)

        return balance
    })
    const left = computed(() => {
        let left = Number(props.project.target - props.project.total_expenses).toLocaleString()

        return left
    })

    // modal functions 
    function showProject(project) {
        classInfo.modalData = project;
        classInfo.isOpen    = true;
    }

    function closeProject() {
        classInfo.isOpen    = false;
        classInfo.modalData = {};
    }

    function showDelete(project) {
        classInfo.deleteData   = project;
        classInfo.deleteID     = project.id;
        classInfo.isDeleteOpen = true;
    }

    function closeDelete() {
        classInfo.isDeleteOpen = false;
        classInfo.deleteData   = {};
        classInfo.deleteID     = '';
    }

    // reset
    function resetProjects() {
        emit('reload')
    }
    // end modal functions 
</script>