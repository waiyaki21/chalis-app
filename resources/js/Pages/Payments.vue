<template>

    <Head>
        <title>{{ props.route }}</title>
    </Head>

    <!-- breadcrumb  -->
    <paymentcrumbs :cycle=cycle></paymentcrumbs>
    <!-- end breadcrumb  -->

    <!-- body section  -->
    <div class="py-2 font-boldened">
        <!-- info panel  -->
        <paymentinfo :cycle=classInfo.cycleInfo :percent=classInfo.cycleInfo.percent @editCycle=showCycle
            @deleteCycle=showCycleDelete @view=flashShowView :border=classInfo.progressMainBorder
            :class=classInfo.progressMainClass></paymentinfo>

        <!-- panel, table and form  -->
        <section class="w-full justify-between grid grid-cols-1 md:grid-cols-5">
            <!-- info panel  -->
            <paymentSide :cycle=classInfo.cycleInfo :infosection=classInfo.infoSection :infoheader=classInfo.infoHeader
                :sectionborder=classInfo.sectionBorder></paymentSide>

            <!-- body panel  -->
            <div class="py-2 pr-1 col-span-4 flex-row justify-between space-x-2">
                <!-- cycle tabs  -->
                <div class="sm:hidden px-2 my-2 w-full">
                    <label for="tabs" class="text-gray-300 underline uppercase mb-4">Select tab</label>

                    <select
                        class="block appearance-none w-full bg-transparent border-b-2 border-gray-400 hover:border-gray-500 p-2 pr-8 rounded-md text-xl shadow leading-tight text-white">
                        <option @click="tabSwitch()" class="uppercase px-2 text-black">{{ classInfo.tab1Name }}</option>
                        <option @click="tabSwitch3()" class="uppercase px-2 text-black">{{ classInfo.tab3Name }}
                        </option>
                        <option @click="tabSwitch4()" class="uppercase px-2 text-black">{{ classInfo.tab4Name }}
                        </option>
                        <option @click="tabSwitch2()" class="uppercase px-2 text-black">Upload Info</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4 text-white" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
                <div
                    class="hidden sm:inline-flex flex-wrap text-xs font-boldened text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 w-full mb-2 mx-2 p-1 justify-between uppercase">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="me-2">
                            <a :class="[classInfo.tab1]" @click="tabSwitch()">
                                {{ classInfo.tab1Name }}
                                <span
                                    class="bg-blue-100 text-gray-800 text-sm font-normal mx-1 px-1.5 py-0.5 rounded-full dark:bg-cyan-900 dark:text-gray-300 border-2 border-cyan-900 dark:border-cyan-500">
                                    {{ classInfo.cycleInfo.payments_count }}
                                </span>
                            </a>
                        </li>

                        <li class="me-2">
                            <a :class="[classInfo.tab3]" @click="tabSwitch3()">
                                {{ classInfo.tab3Name }}
                                <span
                                    class="bg-blue-100 text-gray-800 text-sm font-normal mx-1 px-1.5 py-0.5 rounded-full dark:bg-cyan-900 dark:text-gray-300 border-2 border-cyan-900 dark:border-cyan-500">
                                    {{ classInfo.cycleInfo.welfares_count }}
                                </span>
                            </a>
                        </li>

                        <li class="me-2">
                            <a :class="[classInfo.tab4]" @click="tabSwitch4()">
                                {{ classInfo.tab4Name }}
                                <span
                                    class="bg-blue-100 text-gray-800 text-sm font-normal mx-1 px-1.5 py-0.5 rounded-full dark:bg-cyan-900 dark:text-gray-300 border-2 border-cyan-900 dark:border-cyan-500">
                                    {{ classInfo.cycleInfo.projects_count }}
                                </span>
                            </a>
                        </li>

                        <li class="me-2">
                            <a :class="[classInfo.tab2]" @click="tabSwitch2()">
                                Upload Info
                                <span
                                    class="bg-rose-100 text-gray-800 text-sm font-normal mx-1 px-1.5 py-0.5 rounded-full dark:bg-rose-900 dark:text-gray-300 border-2 border-rose-900 dark:border-rose-500">
                                    {{ classInfo.unpaidMembers.length }}
                                </span>
                            </a>
                        </li>

                        <li class="me-2">
                            <!-- <a :class="[classInfo.tab4, 'uppercase']" @click="tabSwitch4()">
                                Enter Welfares Form / Upload
                            </a> -->
                            <a @click="tabSwitch2()" :href="'/download/template/' + cycle.id" type="button"
                                class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-base px-5 py-2.5 text-center me-2 my-2 uppercase shadow-md cursor-pointer inline-flex justify-between">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Download Cycle Template
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- end cycle tabs  -->

                <!-- payments table  -->
                <div :class="['bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg rounded-md w-full', classInfo.borderClass]"
                    v-if="classInfo.tab1show">
                    <div class="p-2 w-full">
                        <!-- payments table  -->
                        <paymentstable :ref="paymentsRefs" :cycle=classInfo.cycleInfo @flash=flashShow
                            @switch2=tabSwitch2 @progress=progressMain></paymentstable>
                        <!--end payments table  -->
                    </div>
                </div>
                <!-- payments table  -->

                <!-- payments & welfare form  -->
                <section class="w-full overflow-hidden font-boldened flex-row" v-if="classInfo.tab2show">
                    <h3 class="font-boldened p-2">
                        <span :class="[classInfo.mainHeader, 'w-full inline-flex justify-between']">
                            <span class="underline">Add Cycle Payments</span>
                            <!-- forms  -->
                            <a @click="tabSwitch()" type="button"
                                class="inline-flex items-center p-2 text-base font-medium text-gray-900 bg-transparent dark:bg-blue-600 border dark:border-blue-600 rounded-md hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700 uppercase shadow-md cursor-pointer">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Payments Table
                            </a>
                        </span>
                        <br>
                        <span class="text-base text-gray-500 dark:text-gray-500 my-1">
                            (you use can use the form or upload an excel sheet)
                        </span>
                    </h3>
                    <section class="w-full justify-between grid grid-cols-1 md:grid-cols-2">
                        <!-- upload sheet  -->
                        <div
                            :class="['p-2 m-2 rounded-lg bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg', classInfo.borderClass]">
                            <h3 :class="[classInfo.mainHeader, 'underline']">
                                Upload Excelsheet.
                            </h3>
                            <form @submit.prevent="submitSheet" class="p-2">
                                <h3
                                    :class="[classInfo.infoHeader, 'text-sm p-2 border border-red-500 dark:border-red-500 bg-red-600/50 dark:bg-red-600/50 text-gray-900 dark:text-gray-900 rounded-md']">
                                    THIS FEATURE SHOULD BE USED TO <b class="text-lg underline">ADD NEW PAYMENTS &
                                        WELFARES ONLY</b>! ANY EXISTING PAYMENTS & WELFARES FOUND IN THE SPREADSHEET
                                    WILL BE UPDATED TO THE VALUES IN THE SPREADSHEET
                                </h3>
                                <a type="button" :class="[classInfo.templateInactive]" v-if="cycle.percent == 100"
                                    @click="submitTemplateAnyway">
                                    Download {{ cycle.name }} Template
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6 ml-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </a>
                                <a :href="'/download/template/' + cycle.id" type="button"
                                    :class="[classInfo.templateActive]" v-else>
                                    Download {{ cycle.name }} Template
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6 ml-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </a>

                                <div class="flex items-center justify-center w-full flex-col">
                                    <!-- <InputLabel for="excel" value="Excel sheet upload" class="text-left" /> -->
                                    <label for="dropzone-file" :class="[classInfo.labelClass]">
                                        <div class="flex flex-col items-center justify-center pt-2 pb-2">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                aria-hidden="true" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                    class="font-normal underline">Click to upload</span> or drag and
                                                drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF
                                                (MAX. 800x400px)</p>
                                        </div>
                                        <input type="file" id="excel" name="excel" ref="excel"
                                            class="overflow-hidden p-1 whitespace-nowrap w-4/5 text-sm"
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
                                        class="text-white bg-gradient-to-br from-cyan-600 to-green-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-green-800 font-medium rounded-lg text-base px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between w-full"
                                        @click.once="handleclick">
                                        Submit {{ props.cycle.name }} File
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6" v-if="!classInfo.isLoading">
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
                        </div>
                        <!-- end upload sheet  -->
                        <!-- forms  -->
                        <div
                            :class="['p-2 m-2 rounded-lg bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg h-auto', classInfo.borderClass]">
                            <h3 :class="[classInfo.mainHeader,'underline']">
                                Enter Member Payments.
                            </h3>
                            <span
                                class="w-full inline-flex justify-between text-sm uppercase text-gray-300 dark:text-gray-300 mb-1 opacity-50">
                                Remaining Members:
                                <span class="underline text-rose-500">{{ classInfo.unpaidMembers.length }}
                                    Members</span>
                            </span>
                            <form @submit.prevent="submit" class="p-2">
                                <div>
                                    <InputLabel for="member_id" value="Member Name" />

                                    <select id="member_id" v-model="form.member_id" name="member_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                        <option selected v-if="props.cycle.percent == 100">All members entered</option>
                                        <option selected v-else>Select a member</option>
                                        <option v-for="member in classInfo.unpaidMembers" :value="member.id"
                                            @click="getname(member)">
                                            {{ member.name }}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.member_id" />
                                </div>

                                <div>
                                    <InputLabel for="payment" value="payment" />

                                    <TextInput id="payment" type="number" v-model="form.payment" required autofocus />

                                    <InputError class="mt-2" :message="form.errors.payment" />
                                </div>

                                <div>
                                    <InputLabel for="welfare" value="welfare in" />

                                    <TextInput id="welfare" type="number" v-model="form.welfare" required autofocus />

                                    <InputError class="mt-2" :message="form.errors.welfare" />
                                </div>

                                <div>
                                    <InputLabel for="welfare_owed" value="welfare owed" />

                                    <TextInput id="welfare_owed" type="number" v-model="form.welfare_owed" required
                                        autofocus />

                                    <InputError class="mt-2" :message="form.errors.welfare_owed" />
                                </div>

                                <div class="flex items-center justify-start mt-4">
                                    <button
                                        class="text-white bg-gradient-to-br from-rose-600 to-red-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-rose-300 dark:focus:ring-red-800 font-medium rounded-lg text-base px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between cursor-not-allowed"
                                        @click="submitAnyway" v-if="classInfo.unpaidMembers.length == 0">
                                        Cycle Payment Complete
                                    </button>
                                    <button
                                        class="text-white bg-gradient-to-br from-cyan-600 to-green-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-green-800 font-medium rounded-lg text-base px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between w-full"
                                        @click="submit" v-else>
                                        Submit {{ props.cycle.name }} Payment
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6" v-if="!form.processing">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                        </svg>

                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 animate-spin" v-else>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                    </button>
                                    <SubmitButton @click="submit" :disabled="form.processing" :loading="form.processing" :success="form.wasSuccessful" :failed="form.hasErrors" :editting="form.isDirty" v-else>
                                        Submit {{ props.cycle.name }} Payment
                                    </SubmitButton>
                                </div>
                            </form>
                        </div>
                        <!-- end forms  -->
                    </section>
                </section>
                <!-- payments & welfare form  -->

                <!-- welfares table  -->
                <div :class="['bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg rounded-md w-full', classInfo.borderClass]"
                    v-if="classInfo.tab3show">
                    <div class="p-2 w-full">
                        <!-- welfares table  -->
                        <welfarestable :ref="welfaresRefs" :cycle=classInfo.cycleInfo @flash=flashShow
                            @switch=tabSwitch2 @progress=progressMain></welfarestable>
                        <!--end welfares table  -->
                    </div>
                </div>
                <!-- welfares table  -->

                <!-- projects table  -->
                <div :class="['bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg rounded-md w-full', classInfo.borderClass]"
                    v-if="classInfo.tab4show">
                    <div class="p-2 w-full">
                        <!-- projects table  -->
                        <projecttable :ref="projectsRefs" :cycle=classInfo.cycleInfo @flash=flashShow></projecttable>
                        <!--end projects table  -->
                    </div>
                </div>
                <!-- projects table  -->
            </div>
            <!-- end body panel  -->
        </section>
        <!-- end panel, table and form  -->
    </div>
    <!-- end body section  -->

    <!-- update cycle modal  -->
    <cyclesupdate :info=classInfo.modalData :show=classInfo.isCycleOpen @reload=getInfo @close=closeCycle>
    </cyclesupdate>
    <!-- end update cycle modal  -->

    <!-- delete cycle modal  -->
    <cyclesdelete :info=classInfo.deleteData :show=classInfo.isDeleteCycleOpen @reload=getInfo @close=closeCycleDelete>
    </cyclesdelete>
    <!-- end delete cycle modal  -->

    <!-- flash alert  -->
    <alert :alertshow=alerts.alertShow :message=alerts.flashMessage :class=alerts.alertBody :type=alerts.alertType
        :title=alerts.alertType :time=alerts.alertDuration></alert>

    <alertview :alertshowview=alerts.alertShowView :message=alerts.flashMessage :class=alerts.alertBody
        :link=alerts.linkName :url=alerts.linkUrl :state=alerts.linkState :type=alerts.alertType></alertview>
    <!-- end app body  -->
</template>

<script setup>
    import {  useForm } from '@inertiajs/vue3';
    import { defineProps, reactive, onBeforeMount } from 'vue'


    const props = defineProps({
        name: {
            type: String,
            required: true,
        },
        route: {
            type: String,
            required: true,
        },
        cycle: {
            type: String,
            required: true,
        },
        unpaid: {
            type: Array,
            required: true,
        },
        unpaidWel: {
            type: Array,
            required: true,
        },
    });

    const form = useForm({
        member_id: '',
        payment: '',
        welfare: '',
        welfare_owed: '',
    })

    const classInfo = reactive ({
        isOpen: false,
        isCycleOpen: false,
        isWelfareOpen: false,
    
        modalData: {},
        modalName: '',

        cycleInfo: {},

        // delete info 
        isDeleteOpen: false,
        isDeleteCycleOpen: false,
        isDeleteWelfareOpen: false,
        deleteData: {},
        deleteID: '',

        info: [],
        welfareinfo: [],
        unpaidMembers:[],
        unpaidMembersWels: [],
        excel_file: '',
        fileSelected: '',

        // main progress bar 
        progressMainBorder: 'border border-cyan-500 p-1 overflow-hidden',
        progressMainClass: 'alerts flex h-6 items-center justify-center rounded-l-full bg-gradient-to-r from-gray-200 via-cyan-400 to-blue-500 text-base leading-none',
        infoSection: 'm-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border-2 border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        sectionBorder: 'w-full flex-col justify-between m-1 p-1 text-left',
        borderClass: 'border-[3px] border-cyan-300 dark:border-cyan-700',
        mainHeader: 'font-boldened md:text-3xl text-2xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1',

        // tabs 
        tabActive: 'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 text-base cursor-pointer',
        tabInactive: 'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 text-base cursor-pointer',
        tab1: '',
        tab2: '',
        tab3: '',
        tab4: '',
        tab1show: true,
        tab2show: false,
        tab3show: false,
        tab4show: false,
        tab1Name: 'Payments Info',
        tab3Name: 'Welfares Info',
        tab4Name: 'Projects Info',

        templateBtn: '',
        templateInactive: 'text-white bg-gradient-to-r from-rose-500 to-red-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-rose-300 dark:focus:ring-rose-800 font-medium rounded-lg text-base px-5 py-2.5 text-center me-2 mb-2 inline-flex justify-between cursor-not-allowed w-full uppercase',
        templateActive: 'text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-base px-5 py-2.5 text-center me-2 mb-2 inline-flex justify-between w-full uppercase',
        labelClass: 'flex flex-col items-center justify-center w-full h-[13.5rem] border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',

        clicked: false,

        // welfare state
        welfareAllClass: true,
        welfareInClass: true,
        welfareOwedClass: false,

        file_size: '',
        file_name: '',
        upload_info: '',

        isWelfareOpen: false,
        isLoading: false
    })

    // alerts classes 
    const alerts = reactive({
        // alerts
        alertShow: false,
        alertShowView: false,
        alertDuration: 15000,
        alertType: '',
        flashMessage: '',
        alertBody: 'border-b-[5px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[5px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[5px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[5px] border-amber-500 dark:border-amber-500 shadow-amber-500 dark:shadow-amber-500 bg-amber-500 dark:bg-amber-500',
        alertDanger: 'border-b-[5px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',
        linkName: '',
        linkUrl: '',
        linkState: false,
    })

    onBeforeMount(() => [
        setInfo()
    ])

    function setInfo() {
        classInfo.cycleInfo      = props.cycle;
        classInfo.unpaidMembers      = props.unpaid;
        classInfo.unpaidMembersWels  = props.unpaidWel; 

        tabSwitch();
    }

    function getInfo() {
        axios.get('/api/getCycle/'+ props.cycle.id)
            .then(
                ({ data }) => {
                    classInfo.cycleInfo      = data[0]; 
                    classInfo.unpaidMembers      = data[3];
                    classInfo.unpaidMembersWels  = data[4]; 
                });
    }
    // tabs methods
    function tabSwitch() {
        resetTabClass();
        classInfo.tab1show = true;

        classInfo.tab1     = classInfo.tabActive;
    }

    function tabSwitch2() {
        resetTabClass();
        setFields();
        classInfo.tab2show = true;

        classInfo.tab2    = classInfo.tabActive;
    }

    function tabSwitch3() {
        resetTabClass();
        classInfo.tab3show = true;

        classInfo.tab3    = classInfo.tabActive;
    }

    function tabSwitch4() {
        resetTabClass();
        classInfo.tab4show = true;

        classInfo.tab4    = classInfo.tabActive;
    }

    function resetTabClass() {
        classInfo.tab1show = false;
        classInfo.tab2show = false;
        classInfo.tab3show = false;
        classInfo.tab4show = false;

        classInfo.tab1 = classInfo.tabInactive;
        classInfo.tab2 = classInfo.tabInactive;
        classInfo.tab3 = classInfo.tabInactive;
        classInfo.tab4 = classInfo.tabInactive;
    }
    // end tabs methods 
    function getname(member) {
        classInfo.formName = member.name;
    }

    function setFields() {
        form.member_id = '';
        form.payment   = props.cycle.amount;
        form.welfare   = props.cycle.welfare_amnt;
        form.welfare_owed = '0';
    }

    function submit() {
        let amount  = form.payment;
        let welfare = form.welfare;
        let name    = classInfo.formName;

        let url = '/payment/' + props.cycle.id;
        form.post(url, {
            onFinish: () => [
                setFields()
            ],

            onSuccess: () => [
                getInfo(),
                classInfo.formName    = '',
                // flashMessage 
                alerts.flashMessage   = name + ' ksh' + amount + ' & Welfare ksh '+ welfare +' Added!',
                alerts.alertType      = 'success',
                flashShow(alerts.flashMessage, alerts.alertType)
            ]
        });
    }

    function submitAnyway() {
        if (confirm("Everyone has already contributed for this cycle and we are at 100%, do you wish to continue with this action") == true) {
            submit();
        }
    }

    function submitSheetAnyway() {
        if (confirm("Everyone has already contributed for this cycle and we are at 100%, do you wish to continue with this action") == true) {
            submit();
        }
    }

    function submitTemplateAnyway() {
        confirm("A template cant be created as Everyone has already contributed for this cycle and we are at 100%");
    }

    function showCycleDelete(cycle) {
        classInfo.deleteData = cycle;
        classInfo.deleteID = cycle.id;
        classInfo.isDeleteCycleOpen = true;
    }

    function closeCycleDelete() {
        classInfo.isDeleteCycleOpen = false;
        classInfo.deleteData = {};
        classInfo.deleteID = '';
    }

    function handleclick() {
        if (!classInfo.clicked) {
            console.log("click");
            classInfo.clicked = true;
        }
    }

    // on file change 
    function onChangeFile(event) {
        classInfo.fileSelected   = event.target.files.length;
        classInfo.excel_file     = event.target.files[0];
        console.log('Uploaded sheet', classInfo.excel_file, classInfo.fileSelected);

        classInfo.file_name      = event.target.files[0].name;
        classInfo.file_size      = Number(event.target.files[0].size/ (1024 * 1024)).toFixed(2);
        classInfo.upload_info    = 'File Name ' + classInfo.file_name + ' ' + classInfo.file_size + ' MBs';
    }

    function clearFile() {
        classInfo.fileSelected   = '';
        classInfo.excel_file     = '';
        classInfo.file_name      = '';
        classInfo.file_size      = '';
        classInfo.upload_info    = '';
    }

    // submit product Sheet
    function submitSheet() {
        classInfo.isLoading = true;
        // flashMessage 
        alerts.flashMessage   = 'Loading! Please Wait';
        alerts.alertType      = 'info';
        flashShow(alerts.flashMessage, alerts.alertType);

        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }

        let file = classInfo.excel_file;

        // get file name
        let fileName = file.name;
        let fileData = file;
        let data = new FormData();
        data
            .append('excel', fileData);
        axios
            .post('/cycle/excel/add/' + props.cycle.id, data, config)
            .then(
                ({ data }) => {
                    clearFile();
                    alerts.flashMessage = fileName + ' Upload Successful!';
                    alerts.alertType    = 'success';
                    flashShow(alerts.flashMessage, alerts.alertType);
                    classInfo.isLoading = false;
                    getInfo();
                });
    }

    // cycle modal 
    function showCycle(cycle) {
        classInfo.modalData = cycle;
        classInfo.isCycleOpen = true;
    }

    function closeCycle() {
        classInfo.isCycleOpen        = false;
        classInfo.modalData          = {};
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
        alerts.alertShow     = !alerts.alertShow;
    }

    function flashShowView(message, body, name, link, cycle) {
        alerts.flashMessage   = message;
        alerts.alertType      = body;

        alerts.linkName       = name;
        alerts.linkUrl        = link;
        alerts.linkState      = true;

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

        alerts.alertShowView  = !alerts.alertShowView;
    }
</script>