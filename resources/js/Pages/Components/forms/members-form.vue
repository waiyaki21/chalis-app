<template>
    <!-- enter members form  -->
    <section :class="[classInfo.borderClass, 'col-span-2 h-fit']">
        <h3 class="font-boldened  flex-col  w-full flex py-2 px-1">
            <span :class="[classInfo.mainHeader, 'text-3xl']">Add Members</span>
            <span class="text-xs text-gray-500 dark:text-gray-500/40 mb-0.5" v-if="props.count == 0">
                (upload an excel sheet to add more members)
            </span>
            <span class="text-xs text-gray-500 dark:text-gray-500/40 mb-0.5" v-else>
                (upload an excel sheet to add new members)
            </span>
        </h3>
        <!-- members forms tabs  -->
        <div
            class="text-sm font-boldened text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 w-full mb-2 mx-2 p-2">
            <ul class="flex flex-wrap -mb-px">
                <li class="me-2">
                    <a :class="[classInfo.tab1]" @click="tabSwitch()" preserve-scroll>
                        Upload Sheet.
                    </a>
                </li>
                <li class="me-2">
                    <a :class="[classInfo.tab2]" @click="tabSwitch()" preserve-scroll>
                        Enter Members Form.
                    </a>
                </li>
            </ul>
        </div>
        <!-- end members forms tabs  -->

        <!-- upload sheet & form -->
        <div>
            <h3 :class="[classInfo.mainHeader]">
                {{ classInfo.tabheader }}
            </h3>

            <form @submit.prevent="submitSheet" @drop.prevent="onChangeFile" class="p-0" v-if="classInfo.tab1show">
                <h3 :class="[classInfo.infoHeader, 'text-lg p-2 border border-red-500 dark:border-red-500 bg-red-400/10 dark:bg-red-800/90 text-gray-900 dark:text-gray-200 rounded-md']"
                    v-if="props.count > 0">
                    THIS FEATURE SHOULD BE USED TO <span class="text-2xl underline text-blue-600 mx-2">ADD NEW MEMBERS
                        ONLY</span>! ANY EXISTING MEMBERS FOUND IN THE SPREADSHEET WILL BE <span
                        class="text-2xl underline text-blue-600 mx-2">UPDATED</span> TO THE VALUES IN THE SPREADSHEET
                </h3>

                <a href="/download/template/members" type="button"
                    :class="[classInfo.templateActive, 'w-full uppercase text-xl  shadow-md']">
                    Download Members Template
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </a>

                <div class="flex items-center justify-center w-full flex-col">
                    <!-- <InputLabel for="excel" value="Excel sheet upload" class="text-left" /> -->
                    <label for="dropzone-file" :class="[classInfo.label, classInfo.labelClass, ' shadow-md']">
                        <div class="flex flex-col items-center justify-center pt-2 pb-2">
                            <svg class="w-8 h-8 mb-4" aria-hidden="true" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm"><span class="font-normal underline">Click to upload</span></p>
                            <p class="text-xs">XLS, XLXS (MAX. 5MB)</p>
                        </div>
                        <input type="file" id="excel" name="excel" ref="excel"
                            class="overflow-hidden p-1 whitespace-nowrap w-[90%] text-sm" @change="onChangeFile" />
                    </label>
                </div>

                <span
                    :class="['inline-flex text-xs py-2 px-4 border border-cyan-700 dark:border-cyan-700 bg-sky-600 dark:bg-sky-300 text-gray-300 dark:text-gray-800 w-full justify-center my-2 rounded-md space-x-2']"
                    v-if="classInfo.fileSelected != 0">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-6 h-6 text-gray-900 dark:text-gray-900 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <p class="text-sm py-1">
                        {{ classInfo.upload_info }}
                    </p>
                </span>

                <section class="inline-flex w-full justify-between space-x" v-if="classInfo.exist">
                    <p :class="['text-red-400 font-medium rounded-lg text-sm px-2 py-1 text-left mb-[0.5rem] w-full uppercase']"
                        v-if="classInfo.exist && classInfo.members_existing != ''">
                        {{ classInfo.members_existing }} Duplicate Records
                    </p>
                    <p :class="['text-green-400 font-medium text-sm px-2 py-1 text-left mb-[0.5rem] w-full uppercase']"
                        v-if="classInfo.exist && classInfo.members_left != ''">
                        {{ classInfo.members_left }} New Records
                    </p>
                </section>

                <div class="flex items-center justify-start mt-2">
                    <SubmitFile :disabled="classInfo.isLoading" :loading="classInfo.isLoading"
                        :success="classInfo.isSuccess" :failed="classInfo.hasErrors" :editting="classInfo.isEditting"
                        @click.once="handleclick" v-if="!classInfo.exist">
                        Submit & Update Members Sheet
                    </SubmitFile>

                    <SubmitFile :disabled="classInfo.isLoading" :loading="classInfo.isLoading"
                        :success="classInfo.isSuccess" :failed="classInfo.hasErrors" :editting="classInfo.isEditting"
                        @click.once="handleclick" v-else>
                        Submit & Update Members Sheet
                    </SubmitFile>
                </div>
            </form>

            <!-- members form  -->
            <form @submit.prevent="submit" v-if="!classInfo.tab1show" class="flex-col space-y-2">
                <div>
                    <InputLabel for="name" value="Member Name" />

                    <TextInput id="name" type="name" v-model="form.name" :placeholder="form.name" autofocus />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="telephone" value="Member Phonenumber" />

                    <TextInput id="telephone" type="name" v-model="form.telephone" :placeholder="form.telephone"
                        autofocus />

                    <InputError class="mt-2" :message="form.errors.telephone" />
                </div>

                <div>
                    <InputLabel for="amount_before" value="T.Contributions Before" />

                    <TextInput id="amount_before" type="name" v-model="form.amount_before"
                        :placeholder="form.amount_before" autofocus />

                    <InputError class="mt-2" :message="form.errors.amount_before" />
                </div>

                <div>
                    <InputLabel for="welfare_before" value="T.Welfare Before" />

                    <TextInput id="welfare_before" type="name" v-model="form.welfare_before"
                        :placeholder="form.welfare_before" autofocus />

                    <InputError class="mt-2" :message="form.errors.welfare_before" />
                </div>

                <div class="w-full">
                    <InputLabel for="welfareowed_before" value="T.Welfare Owed Before" />

                    <TextInput id="welfareowed_before" type="number" v-model="form.welfareowed_before"
                        :placeholder="form.welfareowed_before" autofocus />

                    <InputError class="mt-2" :message="form.errors.welfareowed_before" />
                </div>

                <div class="w-full">
                    <InputLabel for="active" value="Member Active" />

                    <select id="active" v-model="form.active" name="active"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full">
                        <option :value="1">
                            <span>Active</span>
                        </option>
                        <option :value="0">
                            <span>Inactive</span>
                        </option>
                    </select>
                </div>

                <div class="flex items-center justify-start mt-4 w-full">
                    <SubmitButton :disabled="form.processing" :loading="form.processing" :success="form.wasSuccessful"
                        :failed="form.hasErrors" :editting="form.isDirty">
                        Submit Member
                    </SubmitButton>
                </div>
            </form>

            <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-gray-300/30">

        </div>
        <!-- end upload sheet & form -->
    </section>
    <!-- end enter members form  -->

    <!-- <membersExist
        :formdata = classInfo.excel_file
        @flash = flashShow
        @loadingok = loadingOk
        @loadingerror = loadingError
    ></membersExist> -->

</template>

<script setup>
    import { router, useForm } from '@inertiajs/vue3';
    import { defineProps, defineEmits, reactive, onMounted } from 'vue'

    // // form utilities
    // import utilities    from '../forms/formUtilities/utilities.js';
    // import membersExist from '../forms/formUtilities/membersExist.vue';


    const props = defineProps({
        count : {
            type: String,
            required: true
        }
    })

    const form = useForm({
        name: '',
        telephone: '',
        amount_before: '0',
        welfare_before: '0',
        welfareowed_before: '0',
        active: 1,
    })

    // const formInfo = reactive({
    //     labelClass: ''
    // })

    const classInfo = reactive ({
        info: [],
        countNo: '',

        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        borderClass: 'overflow-hidden font-boldened flex-col space-y-1 justify-between p-2 md:m-2 sm:m-0.5 sm:my-1 rounded-lg bg-cyan-50 dark:bg-gray-800/50 shadow-md sm:rounded-lg border-[3px] border-cyan-300 dark:border-cyan-700',
        mainHeader: 'font-boldened text-2xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1',
        
        // template btns 
        templateInactive: 'text-white bg-gradient-to-r from-rose-500 to-red-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-rose-300 dark:focus:ring-rose-800 font-medium rounded-lg text-sm px-4 py-2.5 text-center me-2 mb-2 inline-flex justify-between cursor-not-allowed',
        templateActive: 'text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-4 py-2.5 text-center me-2 mb-2 inline-flex justify-between',
        label: 'flex flex-col items-center justify-center w-full h-[15rem] border-2 border-dashed rounded-lg cursor-pointer',
        labelClass: '',
        labelDef: 'border-gray-300 bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',
        labelInfo: 'border-cyan-300 bg-cyan-50 dark:hover:bg-cyan-800 dark:bg-cyan-700 hover:bg-cyan-100 dark:border-cyan-600 dark:hover:border-cyan-500 dark:hover:bg-cyan-600',
        labelDanger: 'border-red-300 bg-red-50 dark:hover:bg-red-800 dark:bg-red-700 hover:bg-red-100 dark:border-red-600 dark:hover:border-red-500 dark:hover:bg-red-600',
        labelLoading: 'border-orange-300 bg-orange-50 dark:hover:bg-orange-800 dark:bg-orange-700 hover:bg-orange-100 dark:border-orange-600 dark:hover:border-orange-500 dark:hover:bg-orange-600',
        labelSuccess: 'border-green-300 bg-green-50 dark:hover:bg-green-800 dark:bg-green-700 hover:bg-green-100 dark:border-green-600 dark:hover:border-green-500 dark:hover:bg-green-600',

        clicked: false,

        // exist records 
        exist: false,
        members_existing : '',
        members_left     : '',
        members_count    : '',

        // excel data 
        excel_file: '',
        fileSelected: '',

        // tabs 
        tabActive: 'inline-block p-2 text-blue-600 border-b border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 text-xs cursor-pointer mx-1 uppercase',
        tabInactive: 'inline-block p-2 border-b border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 text-xs cursor-pointer mx-1 uppercase',
        tabActive100: 'inline-block p-2 text-green-600 border-b border-green-600 rounded-t-lg active dark:text-green-500 dark:border-green-500 text-xs cursor-pointer mx-1 uppercase',
        tabInactive100: 'inline-block p-2 dark:text-teal-300 border-b border-transparent rounded-t-lg hover:text-teal-600 hover:border-teal-300 dark:border-teal-300 dark:hover:border-teal-600 dark:hover:text-teal-600 text-xs cursor-pointer mx-1 uppercase',
        tab1: '',
        tab2: '',
        tab1show: false,
        tab2show: false,
        tabheader: '',

        // alerts
        alertShow: false,
        alertType: '',
        flashMessage: '',
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',

        file_size: '',
        file_name: '',
        upload_info: '',

        modalName: '',
        modalLists: [],
        isOpen: false,

        // form upload 
        isLoading: false,
        hasErrors: false,
        isSuccess: false,
        isEditting: false,
    })

    onMounted(() => {
        setInfo()
        tabClass()

        // const formInfo = utilities.loaded();
    })

    const emit = defineEmits(['flash','reload','loading'])

    onMounted(() => {
        
    })

    // function flashShow(message, type, exist) {
    //     classInfo.exist = exist;
    //     // flashMessage 
    //     classInfo.flashMessage = message;
    //     classInfo.alertBody = type;
    //     emit('flash', classInfo.flashMessage, classInfo.alertBody);
    // }

    function setInfo() {
        let link = 'desc';
        let linkTo = 'id/';

        axios.get('/api/getMembers/' + linkTo + link)
        .then(
            ({ data }) => {
                classInfo.countNo = data[1];
            });
    }

    // tabs 
    function tabSwitch() {
        classInfo.tab1show = !classInfo.tab1show;

        tabClass();
    }

    function tabClass() {
        if (props.count > 0) {
            classInfo.tab1show == true;
            classInfo.tabheader = 'Upload spreadsheet';
            if (classInfo.tab1show == true) {
                classInfo.tab1 = classInfo.tabActive100;
                classInfo.tab2 = classInfo.tabInactive100;
                classInfo.tabheader = 'Upload spreadsheet';
            } else {
                classInfo.tab2 = classInfo.tabActive100;
                classInfo.tab1 = classInfo.tabInactive100;
                classInfo.tabheader = 'Add Member form';
            }
        } else {
            classInfo.tab1show == false;
            if (classInfo.tab1show == true) {
                classInfo.tab1 = classInfo.tabActive;
                classInfo.tab2 = classInfo.tabInactive;
                classInfo.tabheader = 'Upload spreadsheet';
            } else {
                classInfo.tab2 = classInfo.tabActive;
                classInfo.tab1 = classInfo.tabInactive;
                classInfo.tabheader = 'Add Member form';
            }
        }
    }

    function clearFields() {
        form.name               = '';
        form.telephone          = '';
        form.amount_before      = '0';
        form.welfare_before     = '0';
        form.welfareowed_before = '0';
        form.active             = 1;
    }

    function submit() {
        let url = '/member/';
        let name = form.name;

        form.post(url, {
            onFinish: () => clearFields(),

            onSuccess: () => [
                classInfo.flashMessage = 'New member: ' + name + ' Added!',
                classInfo.alertType = 'success',
                emit('flash', classInfo.flashMessage, classInfo.alertType),
                emit('reload'),
            ],

            onError: () => [
                classInfo.flashMessage = 'Failed! Try Again',
                classInfo.alertType = 'danger',
                emit('flash', classInfo.flashMessage, classInfo.alertType),
            ]
        });
    }

    // loading state 
    function btnReset() {
        classInfo.isLoading     = false;
        classInfo.isEditting    = false;
        classInfo.isSuccess     = false;
        classInfo.hasErrors     = false;
    }

    function loadingOn() {
        btnReset();
        classInfo.isLoading     = true;
    }

    function loadingEdit() {
        btnReset();
        classInfo.isLoading     = true;
        classInfo.isEditting    = true;
    }

    function loadingOk() {
        btnReset();
        classInfo.isLoading     = false;
        classInfo.hasErrors     = false;
    }

    function loadingError() {
        btnReset();
        classInfo.isLoading     = false;
        classInfo.hasErrors     = true;
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
        loadingEdit();
        classInfo.labelClass     = classInfo.labelLoading;
        classInfo.fileSelected   = event.target.files.length;
        classInfo.excel_file     = event.target.files[0];
        classInfo.file_name      = event.target.files[0].name;
        classInfo.file_size      = Number(event.target.files[0].size/ (1024 * 1024)).toFixed(2);
        classInfo.upload_info    = 'File Name ' + classInfo.file_name + ' ' + classInfo.file_size + ' MBs';

        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }

        let file = event.target.files[0];

        let fileData = file;
        let data    = new FormData();
        data.append('excel', fileData);

        axios.post('/members/excel/exist/', data, config)
            .then(
                ({ data }) => {
                    classInfo.members_existing = data[0];
                    classInfo.members_left     = data[1];
                    classInfo.members_count    = data[0] + data[1];

                    classInfo.oldMembers = data[3];
                    classInfo.newMembers = data[2];

                    if (data[0] > 0) {
                        classInfo.exist = true;
                        if (data[1] > 0) {
                            classInfo.labelClass = classInfo.labelInfo;
                            // flashMessage 
                            classInfo.flashMessage   = classInfo.members_existing + ' existing members and ' + classInfo.members_left +' New Member(s)!';
                            classInfo.alertBody      = 'info';
                            emit('flash', classInfo.flashMessage, classInfo.alertBody);
                            loadingOk();
                        } else {
                            // flashMessage 
                            classInfo.flashMessage = 'NOTE! '+ classInfo.members_existing + ' existing members information will be updated with the current sheet information!';
                            classInfo.alertBody = 'warning';  
                            classInfo.labelClass = classInfo.labelInfo;
                            emit('flash', classInfo.flashMessage, classInfo.alertBody); 
                            loadingOk();
                        }  
                    } else {
                        classInfo.exist = false;
                        classInfo.labelClass = classInfo.labelInfo;
                        // flashMessage 
                        classInfo.flashMessage = classInfo.members_left + ' new members will be added!!';
                        classInfo.alertBody = 'info';
                        emit('flash', classInfo.flashMessage, classInfo.alertBody);
                        loadingOk();
                    }
                })
            .catch(error => {
                loadingError();
                if (error.response.data.errors) {
                    let errors = error.response.data.errors.excel;
                    errors.forEach(error => {
                        // flashMessage 
                        classInfo.flashMessage = error;
                        classInfo.alertBody = 'danger';
                        emit('flash', classInfo.flashMessage, classInfo.alertBody);
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
        classInfo.members_existing   = '';
        classInfo.members_left       = '';
        classInfo.members_count      = '';
        classInfo.exist              = false;
        classInfo.labelClass         = classInfo.labelDef;
    }

    // submit product Sheet
    function submitSheet() {
        loadingOn();
        if (classInfo.fileSelected != 1) {
            // flashMessage 
            classInfo.flashMessage   = 'Upload 1(One) file at a time!';
            classInfo.alertBody      = 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500';
            emit('flash', classInfo.flashMessage, classInfo.alertBody);
            classInfo.labelClass     = classInfo.labelDanger;
            loadingOk();
        } else {
            emit('loading');

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            let file = classInfo.excel_file;

            let fileData = file;
            let data    = new FormData();
            data.append('excel', fileData);
            axios.post('/members/excel/add/', data, config)
                .then(
                    ({ data }) => {
                        classInfo.info         = data[0];
                        classInfo.flashMessage = data[1];
                        classInfo.alertType    = 'success';
                        clearFile();
                        router.reload();
                        emit('flash', classInfo.flashMessage, classInfo.alertType);
                        emit('reload');
                        loadingOk();
                    })
                .catch(function (err) {
                    loadingError();
                    classInfo.labelClass   = classInfo.labelDanger;
                    if (error.response.data.errors) {
                        let errors = error.response.data.errors.excel;
                        errors.forEach(error => {
                            // flashMessage 
                            classInfo.flashMessage = error;
                            classInfo.alertBody = 'danger';
                            emit('flash', classInfo.flashMessage, classInfo.alertBody);
                        });
                    }
                });
        }
    }
</script>