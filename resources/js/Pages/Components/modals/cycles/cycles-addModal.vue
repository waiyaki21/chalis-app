<template>
    <!-- update cycle modal  -->
    <Modal :show=classInfo.isOpen>
        <section class="p-2">
            <div class="w-full inline-flex justify-between mb-2 p-2">
                <h2 class="font-boldened text-2xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 w-full">
                    Add New Contribution Cycle
                </h2>

                <button @click="closeModal" :class="[classInfo.modalCloseBtn]">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-2 py-1 font-boldened">
                <!-- update cycle form  -->
                <form @submit.prevent="submitSheet" class="p-0 space-y-4" enctype="multipart/form-data">
                    <div class="flex-col items-center justify-center w-full space-y-2"> 

                        <div class="inline-flex items-center justify-center w-full space-x-2"> 
                            <section class="w-1/2">
                                <InputLabel for="month" value="Select Cycle Month" class="w-full"/>
                                
                                <div class="inline-flex items-center justify-center w-full space-x-2">
                                    <select id="month" v-model="classInfo.month" name="month" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full" @click="check()" required>
                                        <option :value="month.toUpperCase()" v-for="month in months">{{ month.toUpperCase() }}</option>
                                    </select>
                                </div>
                            </section>
                            <section class="w-1/2">
                                <InputLabel for="year" value="Select Cycle year" class="w-full"/>

                                <select id="year" v-model="classInfo.year" name="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full" @click="classInfo.yearTrue = true" required>
                                    <option :value="moment().year()" selected>{{ moment().year() }}</option>
                                    <option :value="moment().year() + 1">{{ moment().year() + 1 }}</option>
                                    <option :value="moment().year() + 2">{{ moment().year() + 2 }}</option>
                                    <option :value="moment().year() - 1">{{ moment().year() - 1 }}</option>
                                </select>
                            </section>
                        </div>

                        <div class="inline-flex items-center justify-center w-full space-x-2">
                            <a :href="'/download/template/cycle/' + classInfo.month +'/'+ classInfo.year" type="button" :class="[downloadState]" v-if="classInfo.monthTrue && classInfo.yearTrue">
                                Download {{ classInfo.month }} {{ classInfo.year }} Template
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </a>
                            <a @click="downladFalse" type="button" :class="[downloadState]"  v-if="!classInfo.monthTrue && classInfo.yearTrue">
                                Download {{ classInfo.month }} {{ classInfo.year }} Template
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="flex justify-center w-full flex-col">
                        <InputLabel for="excel" value="Excel sheet upload"/>
                        
                        <label for="dropzone-file" :class="[classInfo.label, classInfo.labelClass]">
                            <div class="flex flex-col items-center justify-center py-2">
                                <svg class="w-8 h-8 mb-4" aria-hidden="true" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm"><span class="font-normal underline">Click to upload</span> or drag and drop</p>
                                <p class="text-xs">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input type="file" id="excel" name="excel" ref="excel" class="overflow-hidden p-1 whitespace-nowrap w-4/5 text-sm text-center" @change="onChangeFile" required/>
                        </label>

                        <span :class="['inline-flex text-xs py-2 px-4 border border-cyan-700 dark:border-cyan-700 bg-sky-600 dark:bg-sky-300 text-gray-300 dark:text-gray-800 w-full justify-center my-2 rounded-md space-x-2']" v-if="classInfo.fileSelected != 0">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-900 dark:text-gray-900 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <p class="text-sm py-1">
                                {{ classInfo.upload_info }}
                            </p>
                        </span>
                    </div> 

                    <div class="flex items-center justify-start mt-4">
                        <button :class="[submitState]" @click.once="handleclick" v-if="!classInfo.cycle_exist">
                            Upload {{ classInfo.month }} {{ classInfo.year }} cycle Excelsheet
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" v-if = "!classInfo.isLoading">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>

                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin" v-else>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </button>
                        <button :class="[submitState]" @click="submitFalse" v-else>
                            Cycle {{ classInfo.month }} {{ classInfo.year }} Already Exists
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" v-if = "!classInfo.isLoading">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>

                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin" v-else>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </button>
                    </div>
                </form>
                <!-- end update cycle form  -->

                <!-- <progressForm 
                    v-if="classInfo.loadingPercent != 0" 
                    :percent = classInfo.loadingPercent
                ></progressForm>

                <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-gray-300/30" v-else> -->
                <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-gray-300/30"> 
            </div>
        </section>
    </Modal>
    <!-- end update cycle modal  -->

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
    import { defineProps, reactive, computed, watch, defineEmits, onMounted, onUnmounted } from 'vue'

    import moment           from 'moment';

    const emit = defineEmits(['reload', 'close'])

    const props = defineProps({
        info: {
            type: Object,
            required: true,
        },
        show : {
            type: Boolean,
            required:true
        }
    });

    const type = computed(() => props.show);

    watch(type, (newValue) => {
        classInfo.isOpen = props.show;
        showModal(props.info);
    })

    const closeOnEscape = (e) => {
        if (e.key === 'Escape' && props.show) {
            closeModal();
        }
    };

    onMounted(() => document.addEventListener('keydown', closeOnEscape));
    onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

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

    const classInfo = reactive({
        // modals 
        isOpen: false,
        modalData: {},

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',

        newCycle   : {},

        year: moment().year(),
        month: '',

        monthTrue: false,
        yearTrue: true,

        modalCloseBtn: 'cursor-pointer dark:text-cyan-800 text-cyan-500 transition-transform hover:rotate-180 w-6 h-6 hover:w-8 hover:h-8',

        // template btns 
        downloadBtn: '',
        templateInactive: 'text-white bg-gradient-to-r from-rose-600 to-red-600 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-rose-300 dark:focus:ring-rose-800 font-medium rounded-lg text-base px-4 py-3 text-center inline-flex justify-center uppercase cursor-not-allowed w-full',
        templateActive: 'text-white bg-gradient-to-r from-cyan-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-base px-4 py-3 text-center inline-flex justify-center uppercase cursor-pointer w-full',
        templateDanger: 'text-white bg-gradient-to-r from-red-600 to-rose-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-base px-4 py-3 text-center inline-flex justify-center uppercase cursor-pointer w-full',
        
        labelActive: 'flex flex-col items-center justify-center w-full h-[10rem] border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',
        labelInactive: 'flex flex-col items-center justify-center w-full h-[10rem] border-2 border-red-400 border-dashed rounded-lg bg-red-400 dark:bg-red-700 dark:border-red-600 dark:hover:border-red-500 dark:hover:bg-red-600 text-black cursor-not-allowed',

        SubmitActive: 'text-white bg-gradient-to-br from-cyan-600 to-green-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-blue-300 dark:focus:ring-green-800 font-medium rounded-lg text-base px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between w-full',
        SubmitInactive: 'text-white bg-gradient-to-br from-rose-600 to-red-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-base px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between w-full cursor-not-allowed disabled',
        
        SubmitBtn: '',

        label: 'flex flex-col items-center justify-center w-full h-[15rem] border-2 border-dashed rounded-lg cursor-pointer',
        labelClass: '',
        labelDef: 'border-gray-300 bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',
        labelInfo: 'border-cyan-300 bg-cyan-50 dark:hover:bg-cyan-800 dark:bg-cyan-700 hover:bg-cyan-100 dark:border-cyan-600 dark:hover:border-cyan-500 dark:hover:bg-cyan-600',
        labelDanger: 'border-red-300 bg-red-50 dark:hover:bg-red-800 dark:bg-red-700 hover:bg-red-100 dark:border-red-600 dark:hover:border-red-500 dark:hover:bg-red-600',
        labelLoading: 'border-orange-300 bg-orange-50 dark:hover:bg-orange-800 dark:bg-orange-700 hover:bg-orange-100 dark:border-orange-600 dark:hover:border-orange-500 dark:hover:bg-orange-600',
        labelSuccess: 'border-green-300 bg-green-50 dark:hover:bg-green-800 dark:bg-green-700 hover:bg-green-100 dark:border-green-600 dark:hover:border-green-500 dark:hover:bg-green-600',

        // loading state 
        templateLoading: 'text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-medium rounded-lg text-base px-4 py-3 text-center inline-flex justify-center uppercase cursor-pointer w-full',
        SubmitLoading: 'text-white bg-gradient-to-br from-orange-600 to-orange-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-medium rounded-lg text-base px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between w-full cursor-not-allowed disabled',
        labelLoading: 'text-xs text-orange-900 dark:text-orange-900',
        uploadLoading: 'flex flex-col items-center justify-center w-full h-[10rem] border-2 border-orange-400 border-dashed rounded-lg bg-orange-400 dark:bg-orange-700 dark:border-orange-600 dark:hover:border-orange-500 dark:hover:bg-orange-600 text-black cursor-not-allowed',

        // danger state
        SubmitDanger: 'text-white bg-gradient-to-br from-red-600 to-red-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-base px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between w-full cursor-not-allowed disabled',

        clicked: false,

        isLoading: false,
        loadingPercent: 0,

        // excel data 
        excel_file: '',
        fileSelected: '',

        // file data 
        file_name : '',
        file_size : '',
        upload_info : '',

        // exist records 
        exist            : false,
        cycle_exist      : false,
        members_existing : '',
        members_left     : '',
        members_count    : '',

        hasErrors: false
    })

    // computed 
    const downloadState = computed(() => {
        if (classInfo.month != '' && classInfo.year != '') {
            classInfo.downloadBtn       = classInfo.templateActive;
            classInfo.labelClass        = classInfo.labelActive;
            // check();
            return classInfo.downloadBtn;
        } else {
            classInfo.downloadBtn   = classInfo.templateInactive;
            classInfo.labelClass    = classInfo.labelInactive;
            // reset
            classInfo.month          = '';
            classInfo.monthTrue      = false;
            return classInfo.downloadBtn;
        }
    })

    const submitState = computed(() => {
        if (classInfo.isLoading) {
           classInfo.SubmitBtn = classInfo.SubmitLoading;
            return classInfo.SubmitBtn; 
        } else {
            if (classInfo.cycle_exist) {
                classInfo.SubmitBtn = classInfo.SubmitInactive;
                return classInfo.SubmitBtn;
            } else {
                classInfo.SubmitBtn = classInfo.SubmitActive;
                return classInfo.SubmitBtn;
            }    
        }
    })

    const months = computed(() => {
        const end = moment().startOf('year')
        const start = moment().endOf('year')
        // console.log(end, start);
        let results = []
        let current = start
        while (end.format('MMMM YYYY') !== start.format('MMMM YYYY')) {
            results.push(current.format('MMMM'))
            current = current.subtract(1, 'month')
        }
        // need to add current one last time because the loop will have ended when it is equal to the end date, and will not have added it
        results.push(current.format('MMMM'))

        let list = results.reverse();

        return list;
    })
    // end computed 

    // loading state 
    function loadingOn() {
        classInfo.isLoading     = true;
        classInfo.SubmitBtn     = classInfo.SubmitWarning;
        classInfo.downloadBtn   = classInfo.templateLoading;
        classInfo.labelClass    = classInfo.labelLoading;
        classInfo.loadingPercent = 0;
        // flashLoading();
    }

    function loadingOk() {
        classInfo.isLoading     = false;
        classInfo.hasErrors     = false;
        classInfo.downloadBtn   = classInfo.templateLoading;
        classInfo.labelClass    = classInfo.labelInfo;
        classInfo.SubmitBtn     = classInfo.SubmitActive;
        setTimeout(() => {
            classInfo.loadingPercent = 0;
        }, 10000);
    }

    function loadingError() {
        classInfo.isLoading = false;
        classInfo.hasErrors = true;
        classInfo.downloadBtn   = classInfo.templateDanger;
        classInfo.labelClass    = classInfo.labelDanger;
        classInfo.SubmitBtn     = classInfo.SubmitDanger;
        setTimeout(() => {
            clearFile()
            loadingOk()
        }, 20000);
    }
    // end loading state 

    // open modal 
    function showModal(info) {
        classInfo.modalData = info;
        classInfo.isOpen    = props.show;
        if (classInfo.month != '' && classInfo.year != '') {
            classInfo.downloadBtn = classInfo.templateActive;
        } else {
            classInfo.downloadBtn = classInfo.templateInactive
        }
    }

    // close modal 
    function closeModal() {
        classInfo.modalData = {};
        clearFile();
        emit('close');
        classInfo.isOpen = props.show;
    }

    // false download 
    function downladFalse() {
        alerts.flashMessage   = 'Fill in The Month & Try Again!';
        alerts.alertType      = 'danger';
        flashShow(alerts.flashMessage, alerts.alertType);
    }

    // false submit 
    function submitFalse() {
        alerts.flashMessage   = month + ' '+ year +' already exists select a new month & Try Again!';
        alerts.alertType      = 'danger';
        flashShow(alerts.flashMessage, alerts.alertType);
    }

    // upload sheet 
    function handleclick() {
        if (!classInfo.clicked) {
            classInfo.clicked = true;
        }
    }

    function check() {
        if (classInfo.month != '') {
            loadingOn();
            axios.get('/cycle/exist/' + classInfo.month + '/'+ classInfo.year)
                .then(
                    ({ data }) => {
                        if (data[0] > 0) {
                            classInfo.cycle_exist    = true;
                            // reset
                            classInfo.month          = '';
                            classInfo.monthTrue      = false;
                            // flashMessage 
                            alerts.flashMessage   = data[1];
                            alerts.alertBody      = 'danger';
                            flashShow(alerts.flashMessage, alerts.alertBody);
                            loadingOk();
                        } else {
                            classInfo.cycle_exist    = false;

                            classInfo.monthTrue = true;
                            // flashMessage 
                            alerts.flashMessage   = data[1];
                            alerts.alertBody      = 'success';
                            flashShow(alerts.flashMessage, alerts.alertBody);
                            loadingOk();
                        }
                    });
        } else {
            // reset
            classInfo.month          = '';
            classInfo.monthTrue      = false;
        }
    }

    // on file change 
    function onChangeFile(event) {
        loadingOn();
        classInfo.fileSelected   = event.target.files.length;
        classInfo.excel_file     = event.target.files[0];
        classInfo.upload_info    = event.target.files[0].name;

        classInfo.file_size      = Number(event.target.files[0].size/ (1024 * 1024)).toFixed(2);
        classInfo.upload_info    = 'File Name ' + event.target.files[0].name + ' ' + classInfo.file_size + ' MBs';

        let file = event.target.files[0];

        let fileData = file;
        let data     = new FormData();
        data.append('excel', fileData);
        
        axios
        .post('/members/excel/exist/', data, { 
            onUploadProgress: (progressEvent) => {
                const { loaded, total }     = progressEvent;
                classInfo.loadingPercent    = Math.floor((loaded * 100) / total);
            },
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(
            ({ data }) => {
                classInfo.members_existing = data[0];
                classInfo.members_left     = data[1];
                classInfo.members_count    = data[0] + data[1];
                if (data[0] > 0) {
                    if (data[1] > 0) {
                        // flashMessage 
                        alerts.flashMessage   = classInfo.members_existing + ' existing members and ' + classInfo.members_left +' New Member(s)!';
                        alerts.alertBody      = 'info';
                        flashShow(alerts.flashMessage, alerts.alertBody);
                        loadingOk();
                    } else {
                        // flashMessage 
                        alerts.flashMessage = 'NOTE! '+ classInfo.members_existing + ' existing members information will be updated with the current sheet information!';
                        alerts.alertBody = 'warning';  
                        flashShow(alerts.flashMessage, alerts.alertBody);
                        loadingOk();
                    }  
                    classInfo.exist = true;
                } else {
                    classInfo.exist = false;
                    // flashMessage 
                    alerts.flashMessage = classInfo.members_left + ' new members will be added!!';
                    alerts.alertBody = 'info';
                    flashShow(alerts.flashMessage, alerts.alertBody);
                    loadingOk();
                }
            })
        .catch(error => {
            loadingError();
            if (error.response.data.errors) {
                let errors = error.response.data.errors.excel;
                errors.forEach(error => {
                    // flashMessage 
                    alerts.flashMessage = error;
                    alerts.alertBody = 'danger';
                    flashShow(alerts.flashMessage, alerts.alertBody);
                });
            }
        });
    }

    function clearFile() {
        classInfo.fileSelected   = '';
        classInfo.excel_file     = '';
        classInfo.file_name      = '';
        classInfo.file_size      = '';
        classInfo.upload_info    = '';
        classInfo.month          = '';
        classInfo.year           = '';
        classInfo.labelClass     = classInfo.labelDef;
        classInfo.cycle_exist    = false;
    }

    // submit product Sheet
    function submitSheet() {
        loadingOn();
        if (classInfo.month != '' && classInfo.year != '') {
            if (classInfo.fileSelected != 1) {
                // flashMessage 
                alerts.flashMessage   = 'Upload 1(One) file at a time!';
                alerts.alertBody      = 'info';
                flashShow(alerts.flashMessage, alerts.alertBody);
                loadingOk();
                classInfo.labelClass     = classInfo.labelDanger;
            } else {
                flashLoading();

                let name = classInfo.month +' '+ classInfo.year;

                let file = classInfo.excel_file;

                let fileData = file;
                let data     = new FormData();
                data.append('excel', fileData);
                // post excel_file  
                axios
                .post('/import/cycles/modal/'+ classInfo.month + '/' + classInfo.year, data, { 
                    onUploadProgress: (progressEvent) => {
                        const { loaded, total }     = progressEvent;
                        classInfo.loadingPercent    = Math.floor((loaded * 100) / total);
                    },
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(
                    ({ data }) => {
                        alerts.flashMessage   = 'New Cycle: ' + name + ' Added!';
                        alerts.linkName       = 'View Cycle: ' + name;
                        alerts.alertType      = 'success';
                        alerts.linkUrl        = '/cycle/' + data[2];
                        loadingOk();
                        closeModal();
                        flashShowView(alerts.flashMessage, alerts.alertType);
                    }
                )
                .catch(error => {
                    loadingError();
                    if (error.response.data.errors) {
                        let errors = error.response.data.errors.excel;
                        errors.forEach(error => {
                            // flashMessage 
                            alerts.flashMessage = error;
                            alerts.alertBody = 'danger';
                            flashShow(alerts.flashMessage, alerts.alertBody);
                        });
                    }
                });
            }
        } else {
            if (classInfo.month == '') {
                // flashMessage 
                alerts.flashMessage   = 'Fill in The Month & Try Again!';
                alerts.alertBody      = 'info';
                flashShow(alerts.flashMessage, alerts.alertBody);
            }
            if (classInfo.year == '') {
                // flashMessage 
                alerts.flashMessage   = 'Fill in The Year & Try Again!';
                alerts.alertBody      = 'info';
                flashShow(alerts.flashMessage, alerts.alertBody);
            }
            if (classInfo.month == '' && classInfo.year == '') {
                // flashMessage 
                alerts.flashMessage   = 'Fill in The Both Month & Year & Try Again!';
                alerts.alertBody      = 'info';
                flashShow(alerts.flashMessage, alerts.alertBody);
            }
            loadingOk();
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

    function flashLoading() {
        alerts.flashMessage   = 'Loading! Please Wait';
        alerts.alertBody      = alerts.alertWarning;
        alerts.alertType      = 'warning';
        alerts.alertDuration  = 900000;
        alerts.alertShow      = !alerts.alertShow;
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
</script>