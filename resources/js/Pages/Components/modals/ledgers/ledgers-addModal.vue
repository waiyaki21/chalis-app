<template>
    <!-- update cycle modal  -->
    <Modal :show=classInfo.isOpen>
        <section class="p-2">
            <div class="w-full inline-flex justify-between mb-1">
                <h2
                    class="font-boldened text-3xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-2 w-full">
                    Upload Yearly Ledger. 
                </h2>

                <button @click="closeModal" :class="[classInfo.modalCloseBtn]">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="font-boldened">
                <!-- upload sheet & form -->
                <h3 :class="[classInfo.mainHeader]">
                    {{ classInfo.tabheader }}
                </h3>
        
                <form @submit.prevent="submitSheet" class="p-0 space-y-2">
                    <div class="flex-col items-center justify-center w-full space-y">    
                        <InputLabel for="year" value="Select Cycle Year" class="w-full"/>
                        
                        <div class="w-full grid grid-cols-4 gap-2">
                            <select id="year" v-model="classInfo.year" name="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 col-span-1 shadow-md">
                                <option :value="moment().year() + 2" @click="check()">{{ moment().year() + 2}}</option>
                                <option :value="moment().year() + 1" @click="check()">{{ moment().year() + 1}}</option>
                                <option :value="moment().year()" selected @click="check()">{{ moment().year() }}</option>
                                <option :value="moment().year() - 1" @click="check()">{{ moment().year() - 1}}</option>
                                <option :value="moment().year() - 2" @click="check()">{{ moment().year() - 2}}</option>
                            </select>

                            <a :href="'/download/template/cycle/' + classInfo.year" type="button" :class="downloadState">
                                Download {{ classInfo.year }} Template
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="flex justify-center w-full flex-col">
                        <InputLabel for="excel" value="Excel sheet upload"/>

                        <label for="dropzone-file" :class="[classInfo.labelClass, 'shadow-md']">
                            <div class="flex flex-col items-center justify-center py-2">
                                <svg class="w-8 h-8 mb-4" aria-hidden="true" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm"><span class="font-normal underline">Click to upload</span></p>
                                <p class="text-xs">XLS, XLXS (MAX. 5MB)</p>
                            </div>
                            <input type="file" id="excel" name="excel" ref="excel" class="overflow-hidden p-1 whitespace-nowrap w-4/5 text-sm text-center" @change="onChangeFile"/>
                        </label>

                        <span :class="['inline-flex text-xs py-2 px-4 border border-cyan-700 dark:border-cyan-700 bg-sky-600 dark:bg-sky-300 text-gray-100 dark:text-gray-900 w-full justify-center my-2 rounded-md space-x-2']" v-if="classInfo.fileSelected != 0">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <p class="text-sm py-1 uppercase font-sans font-normal">
                                {{ classInfo.upload_info }}
                            </p>
                        </span>
                    </div> 

                    <div class="flex items-center justify-start mt-4">
                        <button :class="[submitState]" @click.once="handleclick" :disabled="classInfo.hasErrors" v-if="!classInfo.ledger_exist">
                            Upload {{ classInfo.year }} ledger Excelsheet
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" v-if = "!classInfo.isLoading">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>

                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin" v-else>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </button>
                        <button :class="[submitState]" @click.once="handleclick" :disabled="classInfo.hasErrors" v-else>
                            Ledger Year {{ classInfo.year }} Already Exists
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" v-if = "!classInfo.isLoading">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>

                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin" v-else>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </button>
                    </div>
                </form>

                <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-cyan-300/30 border-cyan-800/20">
                <!-- end upload sheet & form -->
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
    import { router } from '@inertiajs/vue3';
    import moment           from 'moment';

    const emit  = defineEmits(['reload', 'close'])

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

    const classInfo = reactive ({
        // modals 
        isOpen: false,
        modalData: {},

        modalCloseBtn: 'cursor-pointer dark:text-cyan-800 text-cyan-500 transition-transform hover:rotate-180 w-6 h-6 hover:w-8 hover:h-8',

        // form classess 
        mainHeader: 'font-boldened text-gray-800 dark:text-gray-300 leading-tight uppercase underline pb-1 md:text-3xl text-2xl',

        year: moment().year(),
        isLoading: false,
        
        // template btns 
        templateInactive: 'text-white bg-gradient-to-r from-rose-500 to-red-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-rose-300 dark:focus:ring-rose-800 font-normal rounded-lg text-base px-4 py-3 text-center me-2 inline-flex justify-center uppercase col-span-3 shadow-md',
        templateActive: 'text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-normal rounded-lg text-base px-4 py-3 text-center me-2 inline-flex justify-center uppercase col-span-3 shadow-md',
        templateLoading: 'text-white bg-gradient-to-r from-orange-500 to-amber-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-normal rounded-lg text-base px-4 py-3 text-center me-2 inline-flex justify-center uppercase col-span-3 shadow-md',
        templateDanger: 'text-white bg-gradient-to-r from-red-500 to-rose-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-normal rounded-lg text-base px-4 py-3 text-center me-2 inline-flex justify-center uppercase col-span-3 shadow-md',

        labelActive: 'flex flex-col items-center justify-center w-full h-[15rem] border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',
        labelInactive: 'flex flex-col items-center justify-center w-full h-[15rem] border-2 border-red-400 border-dashed rounded-lg bg-red-400/50 dark:bg-red-700/50 dark:border-red-600 dark:hover:border-red-500 dark:hover:bg-red-600/50 text-black',
        labelLoading: 'flex flex-col items-center justify-center w-full h-[15rem] border-2 border-orange-400 border-dashed rounded-lg bg-orange-400/50 dark:bg-orange-700/50 dark:border-orange-600 dark:hover:border-orange-500 dark:hover:bg-orange-600/50 text-black',
        labelDanger: 'flex flex-col items-center justify-center w-full h-[15rem] border-2 border-red-400 border-dashed rounded-lg bg-red-400/50 dark:bg-red-700/50 dark:border-red-600 dark:hover:border-red-500 dark:hover:bg-red-600/50 text-black',

        SubmitActive: 'text-white bg-gradient-to-br from-cyan-600 to-green-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-blue-300 dark:focus:ring-green-800 font-normal rounded-lg text-base px-4 py-2.5 text-center mb-2 uppercase inline-flex justify-between w-full shadow-md',
        SubmitInactive: 'text-white bg-gradient-to-br from-rose-600 to-red-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-normal rounded-lg text-base px-4 py-2.5 text-center mb-2 uppercase inline-flex justify-between w-full shadow-md cursor-pointer',
        SubmitWarning: 'text-white bg-gradient-to-br from-orange-600 to-orange-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-normal rounded-lg text-base px-4 py-2.5 text-center mb-2 uppercase inline-flex justify-between w-full shadow-md cursor-pointer',
        SubmitLoading: 'text-white bg-gradient-to-br from-orange-600 to-orange-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-normal rounded-lg text-base px-4 py-2.5 text-center mb-2 uppercase inline-flex justify-between w-full shadow-md cursor-not-allowed disabled',
        SubmitDanger: 'text-white bg-gradient-to-br from-red-600 to-red-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-normal rounded-lg text-base px-4 py-2.5 text-center mb-2 uppercase inline-flex justify-between w-full shadow-md cursor-not-allowed disabled',

        labelClass: '',

        downloadBtn: '',
        SubmitBtn: '',

        clicked: false,

        // excel data 
        excel_file: '',
        fileSelected: '',

        file_size: '',
        file_name: '',
        upload_info: '',

        // exist records 
        exist            : false,
        ledger_exist     : false,
        members_existing : '',
        members_left     : '',
        members_count    : '',
        newMembers       : [],

        loadingPercent: 0,
        hasErrors: false
    })

    // open modal 
    function showModal(info) {
        classInfo.modalData = info;
        classInfo.isOpen    = props.show;
    }

    // close modal 
    function closeModal() {
        classInfo.modalData = {};
        clearFile();
        emit('close');
        classInfo.isOpen = props.show;
    }

    // computed 
    const downloadState = computed(() => {
        if (!classInfo.ledger_exist) {
            classInfo.downloadBtn       = classInfo.templateActive;
            classInfo.labelClass        = classInfo.labelActive;
            return classInfo.downloadBtn;
        } else {
            classInfo.downloadBtn   = classInfo.templateInactive;
            classInfo.labelClass    = classInfo.labelInactive;
            return classInfo.downloadBtn;
        }
    })

    const submitState = computed(() => {
        if (classInfo.isLoading) {
           classInfo.SubmitBtn = classInfo.SubmitLoading;
            return classInfo.SubmitBtn; 
        } else {
            if (classInfo.hasErrors) {
                classInfo.labelClass    = classInfo.labelDanger;
                classInfo.SubmitBtn     = classInfo.SubmitDanger;
                return classInfo.SubmitBtn;
            } else {
                if (classInfo.ledger_exist) {
                    classInfo.SubmitBtn = classInfo.SubmitLoading;
                    return classInfo.SubmitBtn;
                } else {
                    classInfo.SubmitBtn = classInfo.SubmitActive;
                    return classInfo.SubmitBtn;
                } 
            }
        }
    })

    // check year 
    function check() {
        // loadingOn();
        axios.get('/ledger/excel/exist/'+ classInfo.year)
            .then(
                ({ data }) => {
                    classInfo.ledger_exist   = data[2];
                    alerts.flashMessage      = data[1];
                    if (data[2]) {
                        alerts.alertBody         = 'warning'; 
                    } else {
                        alerts.alertBody         = 'info';
                    }
                    flashShow(alerts.flashMessage, alerts.alertBody);  
                    loadingOk();
                });
    }

    // loading state 
    function loadingOn() {
        classInfo.isLoading     = true;
        classInfo.hasErrors     = false;
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
        classInfo.isLoading     = false;
        classInfo.hasErrors     = true;
        classInfo.downloadBtn   = classInfo.templateDanger;
        classInfo.labelClass    = classInfo.labelDanger;
        classInfo.SubmitBtn     = classInfo.SubmitDanger;
        setTimeout(() => {
            clearFile()
            loadingOk()
        }, 20000);
    }
    // end loading state 

    // upload sheet 
    function handleclick() {
        if (!classInfo.clicked) {
            classInfo.clicked = true;
        }
    }

    // on file change 
    function onChangeFile(event) {
        loadingOn();
        classInfo.fileSelected   = event.target.files.length;
        classInfo.excel_file     = event.target.files[0];
        classInfo.upload_info    = event.target.files[0].name;
        // console.log('Uploaded sheet', classInfo.excel_file, classInfo.fileSelected);

        classInfo.file_size      = Number(event.target.files[0].size/ (1024 * 1024)).toFixed(2);
        classInfo.upload_info    = 'File Name ' + event.target.files[0].name + ' ' + classInfo.file_size + ' MBs';

        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }

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
                    classInfo.exist = true;

                    if (data[1] > 0) {
                        // flashMessage 
                        alerts.flashMessage   = classInfo.members_existing + ' existing members and ' + classInfo.members_left +' New Member(s)!';
                        alerts.alertBody      = 'info';
                        flashShow(alerts.flashMessage, alerts.alertBody);
                    } else {
                        // flashMessage 
                        alerts.flashMessage = 'NOTE! '+ classInfo.members_existing + ' existing members information will be updated with the current sheet information!';
                        alerts.alertBody = 'danger';  
                        flashShow(alerts.flashMessage, alerts.alertBody); 
                    }                                
                } else {
                    classInfo.exist = false;
                    // flashMessage 
                    alerts.flashMessage = classInfo.members_left + ' new members will be added!!';
                    alerts.alertBody = 'info';
                    flashShow(alerts.flashMessage, alerts.alertBody);
                }
                loadingOk();
            })
        .catch(error => {
            loadingError();
            if (error.response.data.errors) {
                let errors = error.response.data.errors.excel;
                errors.forEach(error => {
                    // flashMessage 
                    alerts.flashMessage = error;
                    alerts.alertBody    = 'danger';
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
        classInfo.exist          = false;
        classInfo.year           = moment().year()
    }

    // submit product Sheet
    function submitSheet() {
        loadingOn();
        if (classInfo.fileSelected != 1) {
            // flashMessage 
            alerts.flashMessage   = 'Upload 1(One) file at a time!';
            alerts.alertBody      = 'info';
            flashShow(alerts.flashMessage, alerts.alertBody);
            classInfo.isLoading = false;
        } else {
            flashLoading('Loading! Please Wait');

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            let file     = classInfo.excel_file;
            let fileData = file;
            let data     = new FormData();
            data.append('excel', fileData);

            axios
            .post('/import/cycles/excel/'+classInfo.year, data, { 
                onUploadProgress: (progressEvent) => {
                    const { loaded, total }     = progressEvent;
                    classInfo.loadingPercent    = Math.floor((loaded * 100) / total);
                    flashLoading('Loading! Please Wait');
                },
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(
                ({ data }) => {
                    clearFile();
                    let url = '/cycles';
                    router.get(url);
                    // ledgersView(classInfo.year)
                    loadingOk();
                    // flashMessage 
                    alerts.flashMessage = data[0];
                    alerts.alertBody = 'success';
                    flashShow(alerts.flashMessage, alerts.alertBody);
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
    }

    function finished() {
        setTimeout(() => {
            closeModal();
        }, 3000);
    }

    // ledgers view 
    function ledgersView(year) {
        alerts.linkUrl      = '/cycles';
        emit('close');
        alerts.flashMessage   = 'View '+ year +' Uploaded Cycles!';
        alerts.linkName       = 'View '+ year +' Cycles';
        alerts.alertType      = 'success';
        alerts.linkState      = true;
        flashShowView(alerts.flashMessage, alerts.alertType);
    }

    // flash 
    function flashShow(message, body) {
        alerts.flashMessage     = message;
        alerts.alertType        = body;
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

    function flashLoading(info) {
        alerts.flashMessage   = info;
        alerts.alertBody      = alerts.alertWarning;
        alerts.alertType      = 'warning';
        alerts.alertDuration  = 60000;
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