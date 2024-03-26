<template>
    <!-- enter settings info  -->
    <section :class="[classInfo.borderClass]" v-if="props.cycles.length != 0">
        <h3 class="font-boldened  flex-col  w-full flex py-2 px-1">
            <span :class="[classInfo.mainHeader]">Recent Cycle</span>
        </h3>
        <section class="relative grid grid-cols-2 md:grid-cols-1 gap-1 m-1 overflow-y-scroll sm:h-[350px] md:h-[540px]"
            v-if="props.current != null">
            <a class="mb-6 border-s-2 border-gray-200 dark:border-gray-700 ms-2 pl-2">
                <h3 class="text-xl underline font-normal text-gray-900 dark:text-white uppercase">Cycle Name</h3>
                <p class="md:text-2xl text-3xl font-medium uppercase underline text-cyan-500 dark:text-cyan-400">
                    {{ props.current.name }}
                </p>
                <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                    {{ moment(props.current.created_at).format("ddd, Do/MM/YY") }} : {{
                    moment(props.current.created_at).fromNow() }}
                </time>
            </a>
            <a class="mb-6 border-s-2 border-gray-200 dark:border-gray-700 ms-2 pl-2">

                <h3 class="text-xl underline font-normal text-gray-900 dark:text-white uppercase">Members</h3>
                <p class="md:text-2xl text-3xl font-medium uppercase underline text-cyan-500 dark:text-cyan-400">
                    {{ props.current.members_no }} ACTIVE
                </p>
            </a>
            <a class="mb-6 border-s-2 border-gray-200 dark:border-gray-700 ms-2 pl-2">

                <h3 class="text-xl underline font-normal text-gray-900 dark:text-white uppercase">T. Contributed.</h3>
                <p class="md:text-2xl text-3xl font-medium uppercase underline text-cyan-500 dark:text-cyan-400">
                    <small class="text-xl">KSH</small> {{ Number(props.current.payments_total).toLocaleString() }}.
                </p>
            </a>
            <a class="mb-6 border-s-2 border-gray-200 dark:border-gray-700 ms-2 pl-2">
                <h3 class="text-xl underline font-normal text-gray-900 dark:text-white uppercase">T. Welfare In.</h3>
                <p class="md:text-2xl text-3xl font-medium uppercase underline text-cyan-500 dark:text-cyan-400">
                    <small class="text-xl">KSH</small> {{ Number(props.current.welfaresin_total).toLocaleString() }}.
                </p>
            </a>
            <a class="mb-6 border-s-2 border-gray-200 dark:border-gray-700 ms-2 pl-2">
                <h3 class="text-xl underline font-normal text-gray-900 dark:text-white uppercase">T. Welfare Owed.</h3>
                <p class="md:text-2xl text-3xl font-medium uppercase underline text-cyan-500 dark:text-cyan-400">
                    <small class="text-xl">KSH</small> {{ Number(props.current.welfaresowed_total).toLocaleString() }}.
                </p>
            </a>
            <a class="mb-6 border-s-2 border-gray-200 dark:border-gray-700 ms-2 pl-2">
                <h3 class="text-xl underline font-normal text-gray-900 dark:text-white uppercase">T. Projects.</h3>
                <p class="md:text-2xl text-3xl font-medium uppercase underline text-cyan-500 dark:text-cyan-400">
                    {{ Number(props.current.projects.length).toLocaleString() }} Projects.
                </p>
            </a>
            <a class="mb-6 border-s-2 border-gray-200 dark:border-gray-700 ms-2 pl-2">
                <h3 class="text-xl underline font-normal text-gray-900 dark:text-white uppercase">T. Expenses.</h3>
                <p class="md:text-2xl text-3xl font-medium uppercase underline text-cyan-500 dark:text-cyan-400">
                    <small class="text-xl">KSH</small> {{ Number(props.current.expenses_total).toLocaleString() }}.
                </p>
            </a>
            <a class="mb-6 border-s-2 border-gray-200 dark:border-gray-700 ms-2 pl-2">

                <h3 class="text-xl underline font-normal text-gray-900 dark:text-white uppercase">Grand Total.</h3>
                <p class="md:text-2xl text-3xl font-medium uppercase underline text-cyan-500 dark:text-cyan-400">
                    <small class="text-xl">KSH</small> {{ Number(props.current.total).toLocaleString() }}.
                </p>
            </a>
        </section>
    </section>

    <!-- enter cycles form  -->
    <section :class="[classInfo.borderClass, 'col-span-3 md:h-fit m-1']">
        <h3 class="font-boldened  flex-col  w-full flex py-2 px-1">
            <span :class="[classInfo.mainHeader]">Add Cycles</span>
            <span class="text-xs text-gray-500 dark:text-gray-500/40 mb-0.5" v-if="props.cycles.length != 0">
                (upload an excel sheet to add more cycles)
            </span>
            <span class="text-xs text-gray-500 dark:text-gray-500/40 mb-0.5" v-else>
                (upload an excel sheet to add new cycles)
            </span>
        </h3>
        <!-- cycles forms tabs  -->
        <div
            class="text-sm font-boldened text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 w-full mb-2 mx-2 p-2">
            <ul class="flex flex-wrap -mb-px">
                <li class="me-2">
                    <a :class="[classInfo.tab1Bad, 'cursor-not-allowed']" @click="cycleAlert()"
                        v-if="props.current != null" preserve-scroll>
                        Upload Sheet.
                    </a>
                    <a :class="[classInfo.tab1]" @click="tabSwitch()" v-else preserve-scroll>
                        Upload Sheet.
                    </a>
                </li>
                <li class="me-2">
                    <a :class="[classInfo.tab2]" @click="tabSwitch()" preserve-scroll>
                        Enter cycles Form.
                    </a>
                </li>
            </ul>
        </div>
        <!-- end cycles forms tabs  -->

        <!-- upload sheet & form -->
        <div :class="[]">
            <h3 :class="[classInfo.mainHeader]">
                {{ classInfo.tabheader }}
            </h3>

            <form @submit.prevent="submitSheet" class="p-0 space-y-4" v-if="classInfo.tab1show">
                <div class="flex-col items-center justify-center w-full space-y">
                    <InputLabel for="year" value="Select Cycle Year" class="w-full" />

                    <div class="inline-flex items-center justify-center w-full space-x-2">
                        <select id="year" v-model="classInfo.year" name="year"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-1/4">
                            <option :value="moment().year() + 2">{{ moment().year() + 2}}</option>
                            <option :value="moment().year() + 1">{{ moment().year() + 1}}</option>
                            <option :value="moment().year()" selected>{{ moment().year() }}</option>
                            <option :value="moment().year() - 1">{{ moment().year() - 1}}</option>
                            <option :value="moment().year() - 2">{{ moment().year() - 2}}</option>
                            <option :value="moment().year() - 3">{{ moment().year() - 3}}</option>
                            <option :value="moment().year() - 4">{{ moment().year() - 4}}</option>
                        </select>

                        <a :href="'/download/template/cycle/' + classInfo.year" type="button"
                            :class="[classInfo.templateActive, 'w-3/4']">
                            Download {{ classInfo.year }} Template
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- <loading v-if="classInfo.isLoading"></loading> -->

                <div class="flex justify-center w-full flex-col">
                    <InputLabel for="excel" value="Excel sheet upload" />

                    <label for="dropzone-file" :class="[classInfo.label, classInfo.labelClass]">
                        <div class="flex flex-col items-center justify-center py-2">
                            <svg class="w-8 h-8 mb-4" aria-hidden="true" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm"><span class="font-normal underline">Click to upload</span> or drag
                                and drop</p>
                            <p class="text-xs">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input type="file" id="excel" name="excel" ref="excel"
                            class="overflow-hidden p-1 whitespace-nowrap w-4/5 text-sm text-center"
                            @change="onChangeFile" />
                    </label>

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
                </div>

                <div class="flex items-center justify-start mt-4">
                    <button
                        class="text-white bg-gradient-to-br from-cyan-600 to-green-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-blue-300 dark:focus:ring-green-800 font-medium rounded-lg text-base px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between w-full" :disabled="classInfo.isLoading"
                        @click.once="handleclick">
                        Upload cycles Excelsheet
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"
                            v-if="!classInfo.isLoading">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>

                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-6 h-6 animate-spin" v-else>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </button>
                </div>
            </form>

            <!-- cycles form  -->
            <form @submit.prevent="submit" v-if="!classInfo.tab1show">

                <div class="items-center justify-center w-full space-x-2 grid grid-cols-1 md:grid-cols-6">
                    <section class="col-span-2">
                        <div>
                            <InputLabel for="name" value="name" />

                            <TextInput id="name" type="name" v-model="form.name" required autofocus
                                v-if="form.errors.name != null" />

                            <TextInput id="name" type="name" v-model="form.name" required autofocus disabled="true"
                                class="hover:cursor-not-allowed  opacity-50 uppercase" v-else />

                            <InputError class="mt-2" :message="form.errors.name" v-if="form.errors.name != null" />

                            <div v-else>
                                <p class="text-xs pt-2 uppercase text-orange-400">Automatically Set</p>
                            </div>
                        </div>
                    </section>
                    <section class="col-span-2">
                        <InputLabel for="month" value="Select Cycle Month" class="w-full" />

                        <div class="inline-flex items-center justify-center w-full space-x-2">
                            <select id="month" v-model="form.month" name="month"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full uppercase"
                                @click="classInfo.monthTrue = true">
                                <option :value="moment().startOf('month').format('MMMM')" selected>{{
                                    moment().startOf('month').format('MMMM') }}</option>
                                <option :value="month.toUpperCase()" v-for="month in months">{{ month.toUpperCase() }}
                                </option>
                            </select>
                        </div>
                    </section>
                    <section class="col-span-2">
                        <InputLabel for="year" value="Select Cycle year" class="w-full" />

                        <select id="year" v-model="form.year" name="year"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full"
                            @click="classInfo.yearTrue = true">
                            <option :value="moment().year()" selected>{{ moment().year() }}</option>
                            <option :value="moment().year() + 1">{{ moment().year() + 1 }}</option>
                            <option :value="moment().year() + 2">{{ moment().year() + 2 }}</option>
                            <option :value="moment().year() + 3">{{ moment().year() + 3 }}</option>
                        </select>
                    </section>
                </div>

                <div>
                    <InputLabel for="date" value="date" />

                    <TextInput id="date" type="date" v-model="form.date" required autofocus />

                    <InputError class="mt-2" :message="form.errors.date" />
                </div>

                <div>
                    <InputLabel for="amount" value="Contribution per Person" />

                    <TextInput id="amount" type="number" v-model="form.amount" autofocus />

                    <InputError class="mt-2" :message="form.errors.amount" />
                </div>

                <div>
                    <InputLabel for="welfare_amnt" value="Welfare Amount Per Person" />

                    <TextInput id="welfare_amnt" type="number" v-model="form.welfare_amnt" autofocus />

                    <InputError class="mt-2" :message="form.errors.welfare_amnt" />
                </div>

                <div class="flex items-center justify-start mt-4">
                    <SubmitButton :disabled="form.processing" :loading="form.processing" :success="form.wasSuccessful"
                        :failed="form.hasErrors" :editting="form.isDirty">
                        Submit Cycle
                    </SubmitButton>
                </div>
            </form>

            <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-gray-300/30">

        </div>
        <!-- end upload sheet & form -->
    </section>
    <!-- end enter cycles form  -->

    <!-- flash alert  -->
    <alert :alertshow=alerts.alertShow :message=alerts.flashMessage :class=alerts.alertBody :type=alerts.alertType
        :title=alerts.alertType :time=alerts.alertDuration></alert>

    <alertview :alertshowview=alerts.alertShowView :message=alerts.flashMessage :class=alerts.alertBody
        :link=alerts.linkName :url=alerts.linkUrl :state=alerts.linkState></alertview>
</template>

<script setup>
    import { useForm, router } from '@inertiajs/vue3';

    //moment 
    import moment from 'moment';

    import { defineProps, reactive, onMounted, computed } from 'vue';
    
    const props = defineProps({
        settings: {
            type: Object,
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
        nextname: {
            type: String,
            required: true,
        },
        date: {
            type: String,
            required: true,
        }
    })

    const months = computed(() => {
        const end   = moment().startOf('year')
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

    const getName = computed(() => {
        let month = form.month;
        let year  = form.year;

        let name = month +' '+ year;

        return name;
    })

    const downloadState = computed(() => {
        if (classInfo.month != '' && classInfo.year != '') {
            classInfo.submitBtn = classInfo.templateActive;
            checkExist();
            return classInfo.submitBtn;
        } else {
            classInfo.submitBtn = classInfo.templateInactive;
            return classInfo.submitBtn;
        }
    })

    const form = useForm({
        name: '',
        date: '',
        month: '',
        year: '',
        amount: '',
        welfare_amnt: ''
    })

    const classInfo = reactive({
        isLoading: false,
        info: [],

        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        borderClass: 'overflow-hidden font-boldened flex-col  space-y-1 justify-between p-2 md:m-2 sm:m-0.5 sm:my-1 rounded-lg bg-gray-300 dark:bg-gray-800/50 shadow-md sm:rounded-lg border-[3px] border-cyan-300 dark:border-cyan-700',
        mainHeader: 'font-boldened text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 md:text-3xl text-2xl',

        year: moment().year(),
        monthTrue: false,
        yearTrue: true,
        
        // template btns 
        submitBtn: '',
        templateInactive: 'text-white bg-gradient-to-r from-rose-500 to-red-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-rose-300 dark:focus:ring-rose-800 font-medium rounded-lg text-sm px-4 py-3 text-center me-2 inline-flex justify-center cursor-not-allowed w-full',
        templateActive: 'text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-base px-4 py-3 text-center me-2 inline-flex justify-center uppercase w-full',
        label: 'flex flex-col items-center justify-center w-full h-[15rem] border-2 border-dashed rounded-lg cursor-pointer',
        labelClass: '',
        labelDef: 'border-gray-300 bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',
        labelInfo: 'border-cyan-300 bg-cyan-50 dark:hover:bg-cyan-800 dark:bg-cyan-700 hover:bg-cyan-100 dark:border-cyan-600 dark:hover:border-cyan-500 dark:hover:bg-cyan-600',
        labelDanger: 'border-red-300 bg-red-50 dark:hover:bg-red-800 dark:bg-red-700 hover:bg-red-100 dark:border-red-600 dark:hover:border-red-500 dark:hover:bg-red-600',
        labelLoading: 'border-orange-300 bg-orange-50 dark:hover:bg-orange-800 dark:bg-orange-700 hover:bg-orange-100 dark:border-orange-600 dark:hover:border-orange-500 dark:hover:bg-orange-600',
        labelSuccess: 'border-green-300 bg-green-50 dark:hover:bg-green-800 dark:bg-green-700 hover:bg-green-100 dark:border-green-600 dark:hover:border-green-500 dark:hover:bg-green-600',

        clicked: false,

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
        tab1Bad: 'inline-block p-2 border-b border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 text-xs cursor-not-allowed mx-1 uppercase',
        tab1show: true,
        tab2show: true,
        tabheader: '',

        // alerts
        alertShow: false,
        alertType: '',
        alertDuration: 60000,
        flashMessage: '',
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',

        file_size: '',
        file_name: '',
        upload_info: '',

        // exist records 
        exist: false,
        members_existing : '',
        members_left     : '',
        members_count    : '',
    })

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

    onMounted(() => {
        setFields()
        tabClass()
    })

    // tabs 
    function tabSwitch() {
        classInfo.tab1show = !classInfo.tab1show;

        tabClass();
    }

    function cycleAlert() {
        // alert('Use the regular form to create new payment cycles one at a time or use the plus button at the right to add either members or payments');
        alerts.flashMessage = 'Use the regular form to create new payment cycles one at a time or use the plus button at the right to add either members or payments';
        alerts.alertType    = 'warning';
        flashShow(alerts.flashMessage, alerts.alertType);
    }

    function tabClass() {
        if (props.cycles.length == 0) {
            classInfo.tab1show == true;
            classInfo.tabheader = 'Upload Ledger spreadsheets';
            check();
        } else {
            classInfo.tab1show = false;
            classInfo.tab2 = classInfo.tabActive;
            classInfo.tab1 = classInfo.tabInactive;
            classInfo.tabheader = 'Add Cycle form';
            check();
        }
    }

    function check() {
        if (classInfo.tab1show) {
            classInfo.tab1 = classInfo.tabActive100;
            classInfo.tab2 = classInfo.tabInactive100;
            classInfo.tabheader = 'Upload Ledger spreadsheets';
        } else {
            classInfo.tab2 = classInfo.tabActive100;
            classInfo.tab1 = classInfo.tabInactive100;
            classInfo.tabheader = 'Add Cycle form';
        }
    }

    function checkExist() {
        axios.get('/cycle/exist/' + form.month + '/' + form.year)
            .then(
                ({ data }) => {
                    if (data[0] > 0) {
                        classInfo.cycle_exist = true;
                        // reset
                        classInfo.month = '';
                        classInfo.monthTrue = false;
                        // flashMessage 
                        alerts.flashMessage = data[1];
                        alerts.alertBody = 'danger';
                        flashShow(alerts.flashMessage, alerts.alertBody);
                    } else {
                        classInfo.cycle_exist = false;
                        // flashMessage 
                        alerts.flashMessage = data[1];
                        alerts.alertBody = 'success';
                        flashShow(alerts.flashMessage, alerts.alertBody);
                    }
                });
    }

    function setFields() {
        form.name            = getName;
        form.date            = new Date().toISOString().slice(0, 10);
        form.month           = moment().startOf("month").format('MMMM');
        form.year            = moment().year();
        form.amount          = props.settings.payment_def;
        form.welfare_amnt    = props.settings.welfare_def;
        classInfo.labelClass = classInfo.labelDef;
    }

    function submit() {
        let url = '/cycle/';
        let name = form.name;

        form.post(url, {
            onFinish: () => setFields(),

            onSuccess: () => [
                alerts.flashMessage = 'New cycle: ' + name + ' Added!',
                alerts.alertType    = 'success',
                flashShow(alerts.flashMessage, alerts.alertType),
            ],

            onError: () => [
                formErrors(form)
                

                // console.log(form.errors),

                // let allErrors = form.errors,

                // allErrors.forEach(error => {
                //     alerts.flashMessage = error,
                //     alerts.alertType    = 'danger',
                //     flashShow(alerts.flashMessage, alerts.alertType),    
                // })
                
            ]
        });
    }

    function formErrors(form) {
        // if (form.hasErrors) {
            if (form.errors.name) {
                alerts.flashMessage = form.errors.name,
                alerts.alertType    = 'danger';
                flashShow(alerts.flashMessage, alerts.alertType); 
            }
            if (form.errors.date) {
                alerts.flashMessage = form.errors.date,
                alerts.alertType    = 'danger';
                flashShow(alerts.flashMessage, alerts.alertType); 
            }
            if (form.errors.amount) {
                alerts.flashMessage = form.errors.amount,
                alerts.alertType    = 'danger';
                flashShow(alerts.flashMessage, alerts.alertType); 
            }
            if (form.errors.welfare_amnt) {
                alerts.flashMessage = form.errors.welfare_amnt,
                alerts.alertType    = 'danger';
                flashShow(alerts.flashMessage, alerts.alertType); 
            }
        // }
    }

    // upload sheet 
    function handleclick() {
        if (!classInfo.clicked) {
            // console.log("click");
            classInfo.clicked = true;
        }
    }

    // on file change 
    function onChangeFile(event) {
        classInfo.labelClass   = classInfo.labelLoading;
        classInfo.fileSelected = event.target.files.length;
        classInfo.excel_file   = event.target.files[0];
        console.log('Uploaded sheet', classInfo.excel_file, classInfo.fileSelected);

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
                    if (data[0] > 0) {
                        if (data[1] > 0) {
                            classInfo.labelClass = classInfo.labelInfo;
                            // flashMessage 
                            alerts.flashMessage   = classInfo.members_existing + ' existing members and ' + classInfo.members_left +' New Member(s)!';
                            alerts.alertBody      = 'info';
                            flashShow(alerts.flashMessage, alerts.alertBody);
                        } else {
                            // flashMessage 
                            alerts.flashMessage = 'NOTE! '+ classInfo.members_existing + ' existing members information will be updated with the current sheet information!';
                            alerts.alertBody = 'danger';  
                            classInfo.labelClass = classInfo.labelInfo;
                            flashShow(alerts.flashMessage, alerts.alertBody); 
                        }  
                    } else {
                        classInfo.exist = false;
                        classInfo.labelClass = classInfo.labelInfo;
                        // flashMessage 
                        alerts.flashMessage = classInfo.members_left + ' new members will be added!!';
                        alerts.alertBody = 'info';
                        flashShow(alerts.flashMessage, alerts.alertBody);
                    }
                })
            .catch(error => {
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
        classInfo.labelClass     = classInfo.labelDef;
    }

    // submit product Sheet
    function submitSheet() {
        if (classInfo.fileSelected != 1) {
            // flashMessage 
            alerts.flashMessage   = 'Upload 1(One) file at a time!';
            alerts.alertBody      = 'info';
            flashShow(alerts.flashMessage, alerts.alertBody);
            classInfo.labelClass     = classInfo.labelDanger;
        } else {
            classInfo.isLoading = true;
            alerts.flashMessage   = 'Loading! Please Wait';
            alerts.alertBody      = 'info';
            flashLoading(alerts.flashMessage, alerts.alertBody);
            
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            let file     = classInfo.excel_file;
            let fileData = file;
            let data     = new FormData();
            data.append('excel', fileData);
            axios.post('/import/cycles/excel/'+ classInfo.year, data, config)
                .then(
                    ({ data }) => {
                        classInfo.isLoading = false;
                        // flashShowView();
                        flashUpload();
                        classInfo.labelClass    = classInfo.labelSuccess
                        clearFile();
                    })
                .catch (error => {
                    classInfo.labelClass = classInfo.labelDanger;
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

    function flashLoading(message, body, duration) {
        alerts.flashMessage   = message;
        alerts.alertType      = body;

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

        alerts.alertDuration  = duration;

        alerts.alertShow = !alerts.alertShow;
    }

    function flashShowView(message, body) {
        alerts.flashMessage   = 'File Upload Successful!';
        alerts.alertType      = body;
        alerts.linkName       = 'Payment Cycles';
        alerts.alertType      = alerts.alertSuccess;
        alerts.linkUrl        = '/cycles';
        alerts.linkState      = true;

        alerts.flashMessage   = message;

        alerts.alertShowView = !alerts.alertShowView;
    }

    function flashUpload() {
        let url = '/dashboard';
        router.get(url, {
            onSuccess: () => {
                return Promise.all([
                    alerts.flashMessage   = 'File Upload Successful!',
                    alerts.alertType      = 'success',
                    flashShow(alerts.flashMessage, alerts.alertType),
                    classInfo.labelClass = classInfo.labelInfo
                ])
            },
            onFinish: () => {
                console.log('pkaaaaaaaah');
                flashShowView();
            },
        })
    }

    function flashUploadFail() {
        alerts.flashMessage   = 'File Upload Failed!';
        alerts.alertType      = 'danger';
        flashShow(alerts.flashMessage, alerts.alertType);
    }
</script>