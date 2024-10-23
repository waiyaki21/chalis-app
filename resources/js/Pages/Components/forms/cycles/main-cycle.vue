<template>
    <div class="font-boldened">
        <ActionButton :class="'col-span-2 w-full mt-1 py-1.5'"
            :buttonClass="classInfo.month ? 'other' : 'danger'"
            @handleClick="classInfo.month ? downloadTemplate(): downladFalse()"
            :tooltipText="`Download ${classInfo.month} ${classInfo.year} Monthly Template`"
            :buttonText="`Download ${classInfo.month} ${classInfo.year} Template.`">
            <download-icon class="w-4 h-4 md:w-5 md:h-5"></download-icon>
        </ActionButton>
        
        <hr-line :color="classInfo.month ? 'border-purple-500 dark:border-purple-500' : 'border-rose-500 dark:border-rose-500'"></hr-line>

        <!-- update cycle form  -->
        <form @submit.prevent="submitLedgerForm" class="p-0 space-y-2" enctype="multipart/form-data">
            <div class="flex-col items-center justify-center w-full space-y-1"> 
                <div class="items-center justify-center w-full grid grid-cols-2 gap-2"> 
                    <section class="col-span-1">
                        <InputLabel for="year" value="Select Cycle year" class="w-full"/>

                        <select id="year" v-model="classInfo.year" name="year"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-md w-full" @click="classInfo.yearTrue = true" required>
                            <option :value="moment().year() + 2">{{ moment().year() + 2}}</option>
                            <option :value="moment().year() + 1">{{ moment().year() + 1}}</option>
                            <option :value="moment().year()" selected>{{ moment().year() }}
                            </option>
                            <option :value="moment().year() - 1">{{ moment().year() - 1}}</option>
                            <option :value="moment().year() - 2">{{ moment().year() - 2}}</option>
                        </select>
                    </section>
                    <section class="col-span-1">
                        <InputLabel for="month" value="Select Cycle Month" class="w-full"/>

                        <select id="month" v-model="classInfo.month" name="month"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-md w-full" @change="check()" required>
                            <option :value="month.toUpperCase()" v-for="month in months">
                                {{ month.toUpperCase() }}
                            </option>
                        </select>
                    </section>
                </div>
            </div>

            <hr-line :color="'border-yellow-300 dark:border-yellow-300'"></hr-line>
            
            <div class="flex justify-center w-full flex-col">
                <!-- <InputLabel for="excel" value="Excel sheet upload"/> -->

                <label for="dropzone-file" :class="[classInfo.label, labelState, 'shadow-md']">
                    <div class="flex flex-col items-center justify-center py-2 dark:text-white text-black">
                        <cloud-icon class="w-8 h-8 mb-2"></cloud-icon>
                        <p class="mb-1 text-2xs"><span class="font-normal underline">Click to upload</span></p>
                        <p class="text-2xs">XLS, XLXS (MAX. 5MB)</p>
                    </div>
                    <input type="file" id="excel" name="excel" ref="excel"
                        class="my-2 overflow-hidden whitespace-nowrap w-[90%] text-2xs dark:text-white text-black border border-cyan-700 dark:border-cyan-700 rounded-xl"
                        @change="onChangeFile" required/>
                </label>

                <section class="inline-flex justify-start gap-1 my-1" v-if="isFilled">
                    <span :class="[classInfo.infoBadge, 'inline-flex justify-center gap-2 w-full']" v-tooltip="$tooltip('File Info', 'top')">
                        {{ classInfo.upload_info }}
                        <download-icon
                        class="my-auto w-4 h-4 text-teal-800 dark:text-teal-500 ml-1"></download-icon>
                    </span>
                </section>

                <section class="grid grid-cols-4 gap-1 my-1" v-if="isFilled">

                    <span :class="[classInfo.failBadge, 'col-span-1']" v-tooltip="$tooltip('Existing Members in the spreadsheet', 'top')">
                        {{ classInfo.members_existing }} Members
                    </span>

                    <span :class="[classInfo.infoBadge, 'col-span-1']" v-tooltip="$tooltip('New Members in the spreadsheet', 'top')" v-if="classInfo.members_left > 0">
                        {{ classInfo.members_left }} New
                    </span>

                    <span :class="[classInfo.purpleBadge, 'col-span-1']" v-tooltip="$tooltip('Total Contributions in the spreadsheet', 'top')">
                        KSH {{ Number(classInfo.totalPay).toLocaleString() }}
                    </span>

                    <span :class="[classInfo.successBadge, 'col-span-1']" v-tooltip="$tooltip('Total Welfares In Amnt in the spreadsheet', 'top')">
                        KSH {{ Number(classInfo.totalIn).toLocaleString() }}
                    </span>

                    <span :class="[classInfo.warnBadge, 'col-span-1']" v-tooltip="$tooltip('Total Welfare Owed in the spreadsheet', 'top')">
                        KSH {{ Number(classInfo.totalOwe).toLocaleString() }}
                    </span>
                </section>
            </div> 

            <div class="flex items-center justify-start mt-4">
                <button :class="[isFilled ? submitState : [submitState, 'cursor-not-allowed']]" @click.once="isFilled ? handleclick : errorCheck">
                    Upload {{ classInfo.month }} {{ classInfo.year }} Cycle Spreadsheet
                    <submit-icon class="w-6 h-6" v-if="!classInfo.isLoading"></submit-icon>
                    <loading-icon class="w-6 h-6 animate-spin" v-else></loading-icon>
                </button>
            </div>
        </form>
        <!-- end update cycle form  -->

        <hr-line :color="isFilled ? 'border-cyan-500 dark:border-cyan-300' : 'border-rose-500 dark:border-rose-500'"></hr-line>
    </div>
</template>

<script setup>
    import { defineProps, reactive, computed, defineEmits, onMounted, onUnmounted } from 'vue'

    import moment                    from 'moment';
    import { useForm }       from '@inertiajs/vue3';

    const emit = defineEmits(['reload', 'close', 'view', 'flash', 'timed', 'hide', 'loading', 'allhide']);

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

    const form = useForm({
        name: '',
        month: '',
        year: '',
    })

    onMounted(() => {
        clearAll();
    })

    onUnmounted(() => {
        clearAll();
    })

    const alerts = reactive({
        // alerts
        alertShow: false,
        alertShowView: false,
        alertDuration: 15000,
        alertType: '',
        flashMessage: '',
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        linkName: '',
        linkUrl: '',
        linkState: false,
    })

    const classInfo = reactive({
        newCycle   : {},

        year: moment().year(),
        month: '',

        monthTrue: false,
        yearTrue: true,
        filled: false,
        
        // label classes 
        labelActive: 'flex flex-col items-center justify-center w-full h-[10rem] border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',
        labelInactive: 'flex flex-col items-center justify-center w-full h-[10rem] border-2 border-red-400 border-dashed rounded-lg bg-red-400 dark:bg-red-700 dark:border-red-600 dark:hover:border-red-500 dark:hover:bg-red-600 text-black cursor-not-allowed',

        SubmitActive: 'text-white bg-gradient-to-br from-cyan-600 to-green-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-blue-300 dark:focus:ring-green-800 font-normal rounded-lg text-md py-2 px-2.5 text-center mb-1 uppercase inline-flex justify-between w-full shadow-md',
        SubmitInactive: 'text-white bg-gradient-to-br from-rose-600 to-red-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-normal rounded-lg text-md py-2 px-2.5 text-center mb-1 uppercase inline-flex justify-between w-full shadow-md cursor-not-allowed disabled',
        
        SubmitBtn: '',

        label: 'flex flex-col items-center justify-center w-full h-fit border-2 border-dashed rounded-lg cursor-pointer',
        labelClass: '',
        labelDef: 'border-gray-300 bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',
        labelInfo: 'border-cyan-300 bg-cyan-50 dark:hover:bg-cyan-800 dark:bg-cyan-700 hover:bg-cyan-100 dark:border-cyan-600 dark:hover:border-cyan-500 dark:hover:bg-cyan-600',
        labelDanger: 'border-red-300 bg-red-50 dark:hover:bg-red-800 dark:bg-red-700 hover:bg-red-100 dark:border-red-600 dark:hover:border-red-500 dark:hover:bg-red-600',
        labelLoading: 'border-orange-300 bg-orange-50 dark:hover:bg-orange-800 dark:bg-orange-700 hover:bg-orange-100 dark:border-orange-600 dark:hover:border-orange-500 dark:hover:bg-orange-600',
        labelSuccess: 'border-green-300 bg-green-50 dark:hover:bg-green-800 dark:bg-green-700 hover:bg-green-100 dark:border-green-600 dark:hover:border-green-500 dark:hover:bg-green-600',

        // loading state 
        templateLoading: 'text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-normal rounded-lg text-sm px-4 py-3 text-center inline-flex justify-center uppercase cursor-pointer w-full',
        SubmitLoading: 'text-white bg-gradient-to-br from-orange-600 to-orange-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-normal rounded-lg text-md py-2 px-2.5 text-center mb-1 uppercase inline-flex justify-between w-full shadow-md cursor-not-allowed disabled',
        labelLoading: 'text-2xs text-orange-900 dark:text-orange-900',
        uploadLoading: 'flex flex-col items-center justify-center w-full h-[10rem] border-2 border-orange-400 border-dashed rounded-lg bg-orange-400 dark:bg-orange-700 dark:border-orange-600 dark:hover:border-orange-500 dark:hover:bg-orange-600 text-black cursor-not-allowed',

        // danger state
        SubmitDanger: 'text-white bg-gradient-to-br from-red-600 to-red-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-normal rounded-lg text-md py-2 px-2.5 text-center mb-1 uppercase inline-flex justify-between w-full shadow-md cursor-not-allowed disabled',

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
        oldMembers       : [],
        newMembers       : [],
        allMembers       : [],
        monthsCount      : '',
        monthsInfo       : [],
        monthsExpIn      : [],
        monthsExpOwed    : [],
        expInCount       : '',
        expOweCount      : '',
        totalPay         : '',
        totalIn          : '',
        totalOwe         : '',
        confirmText      : '',

        hasErrors: false,

        successBadge : 'text-black dark:text-black md:text-sm text-2xs border dark:border-green-900 border-black bg-green-400 rounded-md shadow-md py-1 px-2 my-auto w-full justify-center inline-flex',
        purpleBadge : 'text-black dark:text-black md:text-sm text-2xs border dark:border-purple-900 border-black bg-purple-400 rounded-md shadow-md py-1 px-2 my-auto w-full justify-center inline-flex',
        infoBadge : 'text-black dark:text-black md:text-sm text-2xs border dark:border-cyan-900 border-black bg-cyan-400 rounded-md shadow-md py-1 px-2 my-auto w-full justify-center inline-flex',
        failBadge : 'text-black dark:text-black md:text-sm text-2xs border dark:border-red-900 border-black bg-rose-400 rounded-md shadow-md py-1 px-2 my-auto w-full justify-center inline-flex',
        warnBadge : 'text-black dark:text-black md:text-sm text-2xs border dark:border-yellow-900 border-black bg-yellow-300 rounded-md shadow-md py-1 px-2 my-auto w-full justify-center inline-flex',
    })

    // computed 
    const submitState = computed(() => {
        if (classInfo.isLoading) {
           classInfo.SubmitBtn = classInfo.SubmitLoading;
            return classInfo.SubmitBtn; 
        } else {
            if (!classInfo.filled) {
                classInfo.SubmitBtn = classInfo.SubmitInactive;
                return classInfo.SubmitBtn;
            } else {
                classInfo.SubmitBtn = classInfo.SubmitActive;
                return classInfo.SubmitBtn;
            }    
        }
    })

    const labelState = computed(() => {
        if (classInfo.isLoading) {
           classInfo.labelClass = classInfo.labelLoading;
            return classInfo.labelClass; 
        } else {
            if (!classInfo.filled) {
                classInfo.labelClass = classInfo.labelDanger;
                return classInfo.labelClass;
            } else {
                classInfo.labelClass = classInfo.labelInfo;
                return classInfo.labelClass;
            }    
        }
    })

    const months = computed(() => {
        // Get the current month using moment
        const currentMonthIndex = moment().month(); // Month is 0-indexed in moment (0 = January)
        
        // Array to hold the list of months starting from the current one
        const monthsArray = [];

        // Loop through 12 months starting from the current month
        for (let i = 0; i < 12; i++) {
            // Use moment's month manipulation to get the correct month name
            monthsArray.push(moment().month(currentMonthIndex + i).format('MMMM'));
        }

        return monthsArray;
    });

    // Computed property to check if month and year are filled
    const isFilled = computed(() => {
        // Check if month and year and file are not empty
        if (classInfo.month && classInfo.year && classInfo.fileSelected) {
            classInfo.filled = true;
            return classInfo.filled;
        } else {
            classInfo.filled = false;
            return classInfo.filled;
        }  
    })
    // end computed 

    // loading state 
    function loadingOn() {
        classInfo.isLoading     = true;
        classInfo.SubmitBtn     = classInfo.SubmitWarning;
        classInfo.labelClass    = classInfo.labelLoading;
        classInfo.loadingPercent = 0;
        // flashTimed('Loading, Please Wait...', 'loading', 30000);
    }

    function loadingOk() {
        classInfo.isLoading     = false;
        classInfo.hasErrors     = false;
        classInfo.labelClass    = classInfo.labelInfo;
        classInfo.SubmitBtn     = classInfo.SubmitActive;
        setTimeout(() => {
            classInfo.loadingPercent = 0;
        }, 10000);
    }

    function loadingError() {
        classInfo.isLoading = false;
        classInfo.hasErrors = true;
        classInfo.labelClass    = classInfo.labelDanger;
        classInfo.SubmitBtn     = classInfo.SubmitDanger;
        setTimeout(() => {
            clearAll()
            loadingOk()
        }, 20000);
    }
    // end loading state 

    function downloadTemplate() {
        let url     = '/download/template/cycle/' + classInfo.month +'/'+ classInfo.year;
        let header  = classInfo.month +' '+ classInfo.year +' Template!';
        let button  = `Download Template`;
        let body    = 'download';
        let message = 'Download ' + classInfo.month +' '+ classInfo.year +' Template! With all Members';

        flashShowView(message, body, header, url, button, 15000, false);
    }

    // false download 
    function downladFalse() {
        alerts.flashMessage   = 'Fill in The Month & Try Again!';
        alerts.alertType      = 'danger';
        flashShow(alerts.flashMessage, alerts.alertType);
    }

    // false submit 
    function errorCheck() {
        if (classInfo.cycle_exist) {
            alerts.flashMessage   = classInfo.month + ' '+ classInfo.year +' already exists and will be updated!';
            alerts.alertType      = 'warning';
            flashShow(alerts.flashMessage, alerts.alertType);
        }

        if (!classInfo.month) {
            alerts.flashMessage   = 'Enter a month!';
            alerts.alertType      = 'warning';
            flashShow(alerts.flashMessage, alerts.alertType);
        }

        if (!classInfo.year) {
            alerts.flashMessage   = 'Select a year!';
            alerts.alertType      = 'warning';
            flashShow(alerts.flashMessage, alerts.alertType);
        }

        if (!classInfo.fileSelected) {
            alerts.flashMessage   = 'Upload a spreadsheet!';
            alerts.alertType      = 'warning';
            flashShow(alerts.flashMessage, alerts.alertType);
        }
    }

    // upload sheet 
    function handleclick() {
        if (!classInfo.clicked) {
            classInfo.clicked = true;
        }
    }

    function check() {
        if (classInfo.month) {
            loadingOn();
            axios.get('/cycle/exist/' + classInfo.month + '/'+ classInfo.year)
                .then(
                    ({ data }) => {
                        if (data[0] > 0) {
                            classInfo.cycle_exist    = true;
                            // reset
                            // classInfo.month          = '';
                            classInfo.monthTrue      = true;
                            // flashMessage 
                            alerts.flashMessage   = data[1];
                            alerts.alertType      = 'danger';
                            flashShow(alerts.flashMessage, alerts.alertType);
                            loadingOk();
                        } else {
                            classInfo.cycle_exist    = false;

                            classInfo.monthTrue = true;
                            // flashMessage 
                            alerts.flashMessage   = data[1];
                            alerts.alertType      = 'success';
                            flashShow(alerts.flashMessage, alerts.alertType);
                            loadingOk();
                        }
                    });
        } else {
            // reset
            classInfo.month          = '';
            classInfo.monthTrue      = false;
        }
    }

    // utility 
    function pluralCheck(count, name) {
        if (count == 1) {
            let text = `${name}`;
            return text;
        } else {
            let text = `${name}s`;
            return text;
        }
    }

    // on file change 
    function onChangeFile(event) {
        if (classInfo.year && classInfo.month) {
            clearFile();
            flashTimed(`Checking Ledger: Months, Payments, Existing & New Member(s)!`, 'loading', 40000);
            loadingOn();
            classInfo.fileSelected   = event.target.files.length;
            classInfo.excel_file     = event.target.files[0];
            classInfo.upload_info    = event.target.files[0].name;
    
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
    
            axios.post(`/payments/check/excel/${classInfo.month}/${classInfo.year}`, data, config)
                .then(({ data }) => {
                    flashHide();
                    classInfo.members_existing  = data.existing_count;
                    classInfo.members_left      = data.new_count;
                    classInfo.members_count     = data.existing_count + data.new_count;
                    classInfo.oldMembers        = data.existing_members;
                    classInfo.newMembers        = data.new_members;
                    classInfo.allMembers        = data.all_members;
                    classInfo.exist             = data.exist;
    
                    classInfo.monthsInfo        = data.monthly_contributions;
                    classInfo.monthsCount       = data.months_count;
                    classInfo.expInCount        = data.monthsexpin_no;
                    classInfo.expOweCount       = data.monthsexpowe_no;
                    classInfo.totalPay          = data.total_pay;
                    classInfo.totalIn           = data.total_in;
                    classInfo.totalOwe          = data.total_owe;
    
                    // Array to hold messages
                    let messages = [];
                    
                    // Helper function to generate message info
                    const createMessage = (info, type, delay = 500, duration = 15000) => ({
                        info,
                        type,
                        delay,
                        duration
                    });
    
                    // Simplified messages array creation
                    messages.push(
                        createMessage(
                            data.existing_count > 0
                            ? `${classInfo.members_existing} existing ${pluralCheck(data.existing_count, 'member')}, in ${classInfo.year} info will be updated!`
                            : `No (0) existing members in the spreadsheet!`,
                            'members', 1000, 15000
                        ),
                        createMessage(
                            data.new_count > 0
                            ? `${classInfo.members_left} new ${pluralCheck(data.new_count, 'member')}, in ${classInfo.year} info will be submitted!`
                            : `No (0) new members in the spreadsheet!`,
                            'newMembers', 2000, 16000
                        ),
                        createMessage(
                            data.months_count > 0
                            ? `Contributions - KSH ${Number(classInfo.totalPay).toLocaleString()} : ${classInfo.monthsCount} ${pluralCheck(data.months_count, 'contribution')} in the ${classInfo.month} ${classInfo.year}!`
                            : `Contributions - No (0) monthly contributions in the spreadsheet!`,
                            'info', 3000, 17000
                        ),
                        createMessage(
                            data.monthsexpin_no > 0
                            ? `Welfare In - KSH ${Number(classInfo.totalIn).toLocaleString()} : ${classInfo.expInCount} ${pluralCheck(data.expInCount, 'welfare')} in the ${classInfo.month} ${classInfo.year}!`
                            : `Welfare In - No (0) welfare payments in the spreadsheet!`,
                            'info', 4000, 18000
                        ),
                        createMessage(
                            data.monthsexpowe_no > 0
                            ? `Welfare Owed - KSH ${Number(classInfo.totalOwe).toLocaleString()} : ${classInfo.expOweCount} ${pluralCheck(data.expOweCount, 'owed welfare')} in the ${classInfo.month} ${classInfo.year}!`
                            : `Welfare Owed - No (0) owed welfare payments in the spreadsheet!`,
                            'info', 5000, 19000
                        ),
                        createMessage(`Spreadsheet Analysis Complete`, 'success', 5500, 20000)
                    );
    
                    loadingOk();
    
                    // Loop through messages and display them
                    flashMessages(messages);
                })
                .catch(error => {
                    loadingError();
                    if (error.response.data.errors) {
                        let errors = error.response.data.errors.excel;
                        errors.forEach(error => {
                            flashShow(error, 'danger');
                        });
                    }
                });
        } else {
            if (!classInfo.month) {
                flashShow('Fill in the month', 'danger');
            }
            if (!classInfo.year) {
                flashShow('Fill in the year', 'danger');
            }
        }
    }

    // submit product Sheet
    async function submitLedgerForm() {
        await flashAllHide();
        await flashShow(`Submitting New Members & Updating Existing Members!`, `info`) 

        classInfo.confirmText = `All existing members will be updated and new Members will added, ready?`;
        await submitSheetAsync();

        await flashShow(`Submitting New Payment Cycles & Updating Existing Payment Cycles!`, `info`) 
        classInfo.confirmText = `All existing payment cycles will be updated and new payment cycles will added, ready?`;
        await submitLedgerAsync();

        await getAllCycles(classInfo.cycleID, classInfo.cycleName);
    }

    // Main function: submit members
    const submitSheetAsync = async () => {
        if (confirm(classInfo.confirmText)) {
            // Timed flash message
            flashTimed('Ledger Members processing, please wait...', 'loading', 9999999);

            // Filter out the needed members
            const allMembers = classInfo.allMembers;

            // Loop through each member and await the Axios request
            for (let [index, member] of allMembers.entries()) {
                const remainingMembers  = allMembers.length - index - 1;
                let memberData          = `${member.name}`;

                try {
                    if (member.exists) {
                        form.name               = member.name;
                        form.telephone          = member.telephone;
                        form.amount_before      = member.amount_before;
                        form.welfare_before     = member.welfare_before;
                        form.welfareowed_before = member.welfareowed_before;
                        form.active             = member.active;
    
                        // Await the Axios PUT request
                        await axios.put('/update/member/modal/' + member.id, form);

                        // Show a success flash message after the update
                        flashTimed(`${memberData} Updated. (${remainingMembers} members left)`, 'info', 1500);
                    } else {
                        form.name               = member.name;
                        form.telephone          = member.telephone;
                        form.amount_before      = member.amount_before;
                        form.welfare_before     = member.welfare_before;
                        form.welfareowed_before = member.welfareowed_before;
                        form.active             = member.active;
    
                        // Await the Axios GET request
                        await axios.post('/member', form);

                        // Show a success flash message after the update
                        flashTimed(`${memberData} Added. (${remainingMembers} members left)`, 'success', 1500);
                    }
                } catch (error) {
                    // Show an error flash message if the update fails
                    flashTimed(`${memberData} failed. (${remainingMembers} members left)`, 'danger', 60000);
                }

                // After all members are updated, show a final flash message
                if (remainingMembers === 0) {
                    flashHide();
                    const time = 9 * 90 * 90;
                    setTimeout(() => {
                        flashShow(`Upload Success.`, 'success', time);
                    }, 1000);
                    await refresh(); // Wait for the refresh method to complete
                    // await getAllMembers(); // get all members 
                }
            }
        } else {
            flashAllHide();
            flashShow('Upload Cancelled', 'danger');
        }
    };

    // submit cycle spreadsheet 
    const submitLedgerAsync = async () => {
        if (confirm(classInfo.confirmText)) {
            flashHide();
            // Loop through each month in the contributions
            for (const [month, contributions] of Object.entries(classInfo.monthsInfo)) {
                // start flash 
                let newMessage = '';
                newMessage = `${month} ${classInfo.year} Processing, Please Wait....`
                flashTimed(newMessage, 'loading', 40000);
                
                try {
                    // Send the POST request for each cycle
                    const { data } = await axios.post(`/import/ledger/cycles/modal/${month}/${classInfo.year}`)

                    classInfo.cycleID     = data.id;
                    classInfo.cycleName   = data.name;

                    // post the contributions in the cycle 
                    await postContributionsAsync(classInfo.cycleID, classInfo.cycleName, contributions)

                    // Array to hold messages
                    let messages = [];
                    
                    // Helper function to generate message info
                    const createMessage = (info, type, delay = 500, duration = 15000) => ({
                        info,
                        type,
                        delay,
                        duration
                    });

                    // Simplified messages array creation
                    messages.push(
                        createMessage(
                            `${data.message} Upload Success`,
                            data.type, 
                            1000 + 500, 
                            40000
                        )
                    );

                    // end flash 
                    flashMessages(messages);
                } catch (error) {
                    loadingError();
                    
                    // Log the main error message
                    console.error('Error Message:', error.response.data.message);

                    // Check if there are validation errors
                    if (error.response.data.errors) {
                        // Iterate through the errors and log each one
                        for (const [key, errorMessages] of Object.entries(error.response.data.errors)) {
                            errorMessages.forEach(errorMessage => {
                                console.error(`Error for ${key}: ${errorMessage}`);
                                flashShow(errorMessage, 'danger'); // Display error messages in the UI
                            });
                        }
                    }
                }
            }
        } else {
            flashHide();
            flashShow('Ledger Upload Cancelled', 'danger');
        }
    };

    // Function to post contributions for a given cycle
    const postContributionsAsync = async (id, name, contributions) => {
        try {
            // Notification for starting the process
            flashTimed(`${name} info processing, please wait...`, 'loading', 20000);

            // Iterate over contributions and post them sequentially
            for (const { name, member_id, cycle_id, amount, expin_amount, expowe_amount } of contributions) {
                const contributionData = {
                    name,
                    member_id,
                    cycle_id,
                    amount,
                    expin_amount,
                    expowe_amount,
                };
                // console.log(contributionData);
                

                // Send POST request for each contribution
                const { data } = await axios.post(`/import/ledger/monthly/${id}`, contributionData);
                flashTimed(data.message, data.type, 1500);
            }

        } catch (error) {
            // Handle errors after the entire loop
            loadingError();
            if (error.response?.data?.errors) {
                error.response.data.errors.excel.forEach(err => flashTimed(err, 'danger', 30000));
            } else {
                flashTimed(`${name} Failed.`, 'danger', 60000);
            }
        }
    };

    // clear info 
    // clear form fields only 
    function clearFields() {
        form.name               = '';
        form.month              = '';
        form.year               = '';
    }

    // clear file uploads only 
    function clearFile() {
        classInfo.fileSelected   = '';
        classInfo.excel_file     = '';
        classInfo.file_name      = '';
        classInfo.file_size      = '';
        classInfo.upload_info    = '';
        classInfo.members_existing   = '';
        classInfo.members_left       = '';
        classInfo.members_count      = '';
        classInfo.oldMembers         = [];
        classInfo.newMembers         = [];
        classInfo.exist              = false;
        // classInfo.labelClass         = classInfo.labelInfo;
        classInfo.monthsInfo        = [];
        classInfo.monthsCount       = '';
        classInfo.expInCount        = '';
        classInfo.expOweCount       = '';
        classInfo.totalPay          = '';
        classInfo.totalIn           = '';
        classInfo.totalOwe          = '';
    }

    // clear all info 
    function clearAll() {
        clearFields();
        clearFile();
        classInfo.year           = moment().year();
        classInfo.month          = '';
        classInfo.isLoading = false;
    }

    function refresh() {
        emit('reload');
    }

    function getAllCycles(id, name) {
        flashAllHide();
        let url     = '/cycle/'+id;
        let header  = 'View Payment Cycles';
        let button  = 'View '+ name;
        let body    = 'success';
        let message = 'View ' + name + ' Cycle!';

        flashShowView(message, body, header, url, button, 15000, true);
        emit('close');
    }

    // flash messages 
    function flashMessages(messages) {
        messages.forEach(message => {
            setTimeout(() => {
                flashTimed(message.info, message.type, message.duration);
            }, message.delay);
        });
    }

    function flashShow(message, body) {
        emit('flash', message, body)
    }

    function flashHide() {
        emit('hide')
    }

    function flashAllHide() {
        emit('allhide')
    }

    function flashTimed(message, body, duration) {
        emit('timed', message, body, duration)
    }

    function flashShowView(message, body, header, url, button, duration, linkState) {
        emit('view', message, body, header, url, button, duration, linkState);
    }
</script>