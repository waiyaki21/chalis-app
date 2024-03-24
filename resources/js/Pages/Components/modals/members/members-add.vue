<template>
        <!-- update member modal  -->
    <Modal :show = classInfo.isOpen :maxWidth="classInfo.width">
        <section class="p-2">
            <div class="w-full inline-flex justify-between mb-2 p-2">
                <h2 class="font-boldened sm:text-base md:text-2xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 w-full">
                    Add New Members.
                </h2>

                <button @click="closeModal" :class="[classInfo.modalCloseBtn]">
                    <svg paymentfill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- add members tabs  -->
            <div class="max-h-full">
                <div class="mb-2 border-b border-gray-200 dark:border-gray-700">
                    <div class="sm:hidden px-2 my-2 w-full">
                        <label for="tabs" class="text-gray-300 underline uppercase mb-4">Select tab</label>

                        <select class="block appearance-none w-full bg-transparent border-b-2 border-gray-400 hover:border-gray-500 p-2 pr-8 rounded-md text-xl shadow leading-tight text-white">
                            <option @click="tab1show()" class="uppercase px-2">{{ classInfo.tab1name }}</option>
                            <option @click="tab2show()" class="uppercase px-2">{{ classInfo.tab2name }}</option>
                            <option @click="tab3show()" class="uppercase px-2">{{ classInfo.tab3name }}</option>
                            <option @click="tab4show()" class="uppercase px-2">{{ classInfo.tab4name }}</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4 text-white" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    <ul class="hidden sm:inline-flex flex-wrap mb-2 text-lg font-medium text-center" :data-tabs-toggle="['#' + classInfo.view_name]">
                        <li class="mr-2">
                            <button :class="[classInfo.btn1class]" :id="[classInfo.tab1name]" type="button" role="tab" @click="tab1show()">{{ classInfo.tab1name }}</button>
                        </li>
                        <li class="mr-2">
                            <button :class="[classInfo.btn2class]" :id="[classInfo.tab2name]" type="button" role="tab" @click="tab2show()">{{ classInfo.tab2name }}</button>
                        </li>
                        <li class="mr-2">
                            <button :class="[classInfo.btn3class]" :id="[classInfo.tab3name]" type="button" role="tab" @click="tab3show()" v-if="classInfo.exist">
                                {{ classInfo.tab3name }}
                                <span class="bg-blue-100 text-gray-800 text-sm font-normal mx-1 px-1.5 py-0.5 rounded-full dark:bg-cyan-900 dark:text-gray-300 border-2 border-cyan-900 dark:border-cyan-500">
                                    {{ classInfo.oldMembers.length }}
                                </span>
                            </button>
                        </li>
                        <li class="mr-2">
                            <button :class="[classInfo.btn4class]" :id="[classInfo.tab4name]" type="button" role="tab" @click="tab4show()" v-if="classInfo.exist">
                                {{ classInfo.tab4name }}
                                <span class="bg-blue-100 text-gray-800 text-sm font-normal mx-1 px-1.5 py-0.5 rounded-full dark:bg-cyan-900 dark:text-gray-300 border-2 border-cyan-900 dark:border-cyan-500">
                                    {{ classInfo.newMembers.length }}
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div :id="[classInfo.view_name]">
                    <div :class="[classInfo.tabBody]" v-if="classInfo.tab1body">
                        <div class="p-2 bg-white dark:bg-gray-800 w-full m-1 text-left mx-auto overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10 h-fit">
                            <form @submit.prevent="submitSheet" @drop.prevent="getDrop" class="p-0" v-if = "!classInfo.isLoading">
                                <h3 :class="[classInfo.infoHeader, 'text-lg p-2 border border-red-500 dark:border-red-500 bg-red-400/10 dark:bg-red-800/90 text-gray-900 dark:text-gray-200 rounded-md']" v-if="classInfo.countNo > 0">
                                    THIS FEATURE SHOULD BE USED TO <span class="text-2xl underline text-blue-600 mx-2">ADD NEW MEMBERS ONLY</span>! ANY EXISTING MEMBERS FOUND IN THE SPREADSHEET WILL BE <span class="text-2xl underline text-blue-600 mx-2">UPDATED</span> TO THE VALUES IN THE SPREADSHEET
                                </h3>

                                <a href="/download/template/members" type="button" :class="[classInfo.templateActive, 'w-full uppercase text-xl']">
                                    Download Template
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </a>
                        
                                <div class="flex items-center justify-center w-full flex-col">
                                    <!-- <InputLabel for="excel" value="Excel sheet upload" class="text-left" /> -->
                                    <label for="dropzone-file" :class="[classInfo.label, classInfo.labelClass]">
                                        <div class="flex flex-col items-center justify-center pt-2 pb-2">
                                            <svg class="w-8 h-8 mb-4" aria-hidden="true" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm"><span class="font-normal underline">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                        </div>
                                        <input type="file" id="excel" name="excel" ref="excel" class="overflow-hidden p-1 whitespace-nowrap w-4/5 text-sm" @change="onChangeFile"/>
                                    </label>
                                </div> 

                                <span :class="['inline-flex text-xs py-2 px-4 border border-cyan-700 dark:border-cyan-700 bg-sky-600 dark:bg-sky-300 text-gray-300 dark:text-gray-800 w-full justify-center my-2 rounded-md space-x-2']" v-if="classInfo.fileSelected != 0">
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-900 dark:text-gray-900 ml-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <p class="text-sm py-1">
                                        {{ classInfo.upload_info }}
                                    </p>
                                </span>

                                <section class="inline-flex w-full justify-between space-x-2" v-if="classInfo.exist">
                                    <button :class="['text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 w-full uppercase']" v-if="classInfo.exist && classInfo.members_existing != ''" @click="viewMembers('duplicate members')">
                                        {{ classInfo.members_existing }} Duplicate Records
                                    </button>
                                    <button :class="['text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 w-full uppercase']" v-if="classInfo.exist && classInfo.members_left != ''" @click="viewMembers('new members')">
                                        {{ classInfo.members_left }} New Records
                                    </button>
                                </section>

                                <div class="flex items-center justify-start mt-4">
                                    <button class="text-white bg-gradient-to-br from-cyan-600 to-green-500 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-blue-300 dark:focus:ring-green-800 font-medium rounded-lg text-xl px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between w-full" @click.once="handleclick" v-if="!classInfo.exist">
                                        Upload Members Excelsheet
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                        </svg>
                                    </button>
                                    <button class="text-white bg-gradient-to-br from-rose-500 to-red-800 hover:bg-gradient-to-bl focus:ring focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-base px-4 py-2.5 text-center mr-2 mb-2 uppercase inline-flex justify-between w-full" @click.once="handleclick" v-else>
                                        Members Already exist
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            <loading v-else
                            ></loading>
                        </div>
                    </div>
                    <div :class="[classInfo.tabBody]" v-if="classInfo.tab2body">
                        <div class="p-2 bg-white dark:bg-gray-800 w-full m-1 text-left mx-auto overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10">
                            <!-- members form  -->
                            <form @submit.prevent="submit">
                                <div>
                                    <InputLabel for="name" value="Member Name"/>

                                    <TextInput id="name" type="name" v-model="form.name" :placeholder="form.name" autofocus/>

                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>
                        
                                <div>
                                    <InputLabel for="telephone" value="Member Phonenumber"/>

                                    <TextInput id="telephone" type="name" v-model="form.telephone" :placeholder="form.telephone" autofocus/>

                                    <InputError class="mt-2" :message="form.errors.telephone" />
                                </div>

                                <div>
                                    <InputLabel for="amount_before" value="T.Contributions Before"/>

                                    <TextInput id="amount_before" type="name" v-model="form.amount_before" :placeholder="form.amount_before" autofocus/>

                                    <InputError class="mt-2" :message="form.errors.amount_before" />
                                </div>

                                <div>
                                    <InputLabel for="welfare_before" value="T.Welfare Before"/>

                                    <TextInput id="welfare_before" type="name" v-model="form.welfare_before" :placeholder="form.welfare_before" autofocus/>

                                    <InputError class="mt-2" :message="form.errors.welfare_before" />
                                </div>

                                <div class="w-full">
                                    <InputLabel for="welfareowed_before" value="T.Welfare Owed Before"/>

                                    <TextInput id="welfareowed_before" type="number" v-model="form.welfareowed_before" :placeholder="form.welfareowed_before" autofocus/>

                                    <InputError class="mt-2" :message="form.errors.welfareowed_before" />
                                </div>

                                <div class="w-full">
                                    <InputLabel for="active" value="Member Active"/>

                                    <select id="active" v-model="form.active" name="active" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full">
                                        <option :value="1">
                                            <span>Active</span>
                                        </option>
                                        <option :value="0">
                                            <span>Inactive</span>
                                        </option>
                                    </select>
                                </div>

                                <div class="flex items-center justify-start mt-4 w-full">
                                    <SubmitButton :class="[{ 'opacity-25': form.processing }, 'w-full']" :disabled="form.processing">
                                        Submit
                                    </SubmitButton>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div :class="[classInfo.tabBody]" v-if="classInfo.tab3body">
                        <div class="p-1 bg-white dark:bg-gray-800 w-full m-1 text-left mx-auto overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10">
                            <h2 class="font-normal font-boldened text-[3rem] text-center text-rose-800 dark:text-rose-800 leading-tight uppercase py-1" v-if="classInfo.oldMembers.length == 0">
                                <span>NO DUPLICATE MEMBERS!!</span>
                            </h2>

                            <table class="mx-auto w-full text-xs text-left text-gray-500 dark:text-gray-400" v-else>
                                <thead class="text-gray-700 uppercase bg-transparent dark:text-gray-400 font-boldened text-xs">
                                    <tr class="" preserve-scroll>
                                        <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer">
                                            <div class="flex items-center">
                                                ID.
                                            </div>
                                        </td>
                                        <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer">
                                            <div class="flex items-center">
                                                Name.
                                            </div>
                                        </td>
                                        <!-- <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer hidden sm:table-cell">
                                            <div class="flex items-center">
                                                T.Paid.
                                            </div>
                                        </td> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-transparent dark:border-gray-700 font-boldened text-xs uppercase" v-for="(member) in classInfo.oldMembers" preserve-scroll>
                                        <td scope="row" class="p-1 uppercase text-gray-900 md:whitespace-nowrap sm:whitespace-normal dark:text-white text-xs">
                                            {{ member.id }}.
                                        </td>
                                        <td scope="row" class="sm:p-1 md:p-1.5 uppercase text-gray-900 md:whitespace-nowrap sm:whitespace-normal dark:text-white">
                                            <a @click="getRoute(member.id)" class="text-base sm:text-base md:text-xl hover:underline hover:cursor-pointer">{{ member.name }}</a>.
                                        </td>
                                        <!-- <td class="sm:p-1 md:p-1.5 hidden sm:table-cell">
                                            <span class="uppercase underline text-cyan-800 dark:text-cyan-800 text-base">
                                                ksh {{ Number(member.total).toLocaleString() }}
                                            </span>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div :class="[classInfo.tabBody]" v-if="classInfo.tab4body">
                        <div class="p-1 bg-white dark:bg-gray-800 w-full m-1 text-left mx-auto overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10">
                            <h2 class="font-normal font-boldened text-[3rem] text-center text-rose-800 dark:text-rose-800 leading-tight uppercase py-1" v-if="classInfo.newMembers.length == 0">
                                <span>NO NEW MEMBERS!!</span>
                            </h2>

                            <table class="mx-auto w-full text-xs text-left text-gray-500 dark:text-gray-400" v-else>
                                <thead class="text-gray-700 uppercase bg-transparent dark:text-gray-400 font-boldened text-xs">
                                    <tr class="" preserve-scroll>
                                        <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer">
                                            <div class="flex items-center">
                                                ID.
                                            </div>
                                        </td>
                                        <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer">
                                            <div class="flex items-center">
                                                Name.
                                            </div>
                                        </td>
                                        <!-- <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer hidden sm:table-cell">
                                            <div class="flex items-center">
                                                T.Paid.
                                            </div>
                                        </td> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-transparent dark:border-gray-700 font-boldened text-xs uppercase" v-for="(member) in classInfo.newMembers" preserve-scroll>
                                        <td scope="row" class="p-1 uppercase text-gray-900 md:whitespace-nowrap sm:whitespace-normal dark:text-white text-xs">
                                            {{ member.row_id }}.
                                        </td>
                                        <td scope="row" class="sm:p-1 md:p-1.5 uppercase text-gray-900 md:whitespace-nowrap sm:whitespace-normal dark:text-white">
                                            <a class="text-base sm:text-base md:text-xl hover:underline hover:cursor-pointer">{{ member.name }}</a>.
                                        </td>
                                        <!-- <td class="sm:p-1 md:p-1.5 hidden sm:table-cell">
                                            <span class="uppercase underline text-cyan-800 dark:text-cyan-800 text-base">
                                                ksh {{ Number(member.total).toLocaleString() }}
                                            </span>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-gray-300/30">
            <!-- end enter members form  -->
        </section>
    </Modal>
    <!-- end update member modal  -->

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
    import { useForm, router } from '@inertiajs/vue3';
    import { defineProps, onBeforeMount, reactive, computed, watch, defineEmits, onMounted, onUnmounted } from 'vue'

    const emit = defineEmits(['reload', 'close', 'view'])

    const props = defineProps({
        show : {
            type: Boolean,
            required:true
        }
    });

    onBeforeMount(() => {
        tab2show();
        setInfo();
    })

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

    // alerts classes 
    const alerts = reactive({
        alertShow: false,
        alertShowView: false,
        alertType: '',
        alertDuration: 15000,
        flashMessage: '',
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',
    })

    // classes 
    const classInfo = reactive({
        // width 
        width: '2xl',
        // modals 
        isOpen: false,
        isDupOpen: false,
        modalData: {},

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',

        isLoading: false,

        modalCloseBtn: 'cursor-pointer dark:text-cyan-800 text-cyan-500 transition-transform hover:rotate-180 w-6 h-6 hover:w-8 hover:h-8',

        info: [],
        countNo: '',
        newMember: {},
        oldMembers: [],
        newMembers: [],

        infoSection: 'w-full m-2 p-2 text-left mx-auto border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        borderClass: 'overflow-hidden font-boldened flex-col space-y-1 justify-between p-0 md:m-2 sm:m-0.5 sm:my-1 rounded-lg bg-gray-300 dark:bg-gray-800/50 shadow-md border-[3px] border-cyan-300 dark:border-cyan-700',
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

        // page name 
        view_name: "add_members",

        // tabs
        // classes
        activeTab: 'inline-block p-4 py-3 border-b-2 border-blue-700 uppercase text-blue-700 font-boldened dark:text-blue-700 dark:hover:text-cyan-500 text-sm',
        inactiveTab: 'inline-block p-4 py-3 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 uppercase font-boldened dark:text-gray-300 dark:hover:text-cyan-300 text-sm',
        tabBody: 'bg-transparent dark:bg-transparent relative flex flex-col min-w-0 break-words w-full mb-4 p-1 font-boldened',
        btn1class: '',
        btn2class: '',
        btn3class: '',
        btn4class: '',

        // bodies 
        tab1body: false,
        tab2body: true,
        tab3body: false,
        tab4body: false,

        // bodies 
        tab1name: 'Upload Sheet',
        tab2name: 'Enter Member',
        tab3name: 'Duplicate Members',
        tab4name: 'New Members',

        file_size: '',
        file_name: '',
        upload_info: '',

        modalName: '',
        modalLists: [],
    })

    const form = useForm({
        name: '',
        telephone: '',
        amount_before: '0',
        welfare_before: '0',
        welfareowed_before: '0',
        active: 1,
    })

    function getRoute(a) {
        let url = '/member/' + a;

        router.get(url);
        closeModal();
    }

    function showModal(info) {
        formFields(info);
        classInfo.modalData = info;
        classInfo.isOpen    = props.show;
    }

    function closeModal() {
        classInfo.modalData = {};
        clearFields();
        emit('close');
        classInfo.isOpen = props.show;
    }

    function formFields() {
        form.name               = '';
        form.telephone          = '';
        form.amount_before      = '0';
        form.welfare_before     = '0';
        form.welfareowed_before = '0';
        form.active             = 1;
    }

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
    // show tabs 
    function tab1show() {
        classInfo.tab1body     = true;
        classInfo.tab2body     = false;
        classInfo.tab3body     = false;
        classInfo.tab4body     = false;
        classInfo.btn1class    = classInfo.activeTab;
        classInfo.btn2class    = classInfo.inactiveTab;
        classInfo.btn3class    = classInfo.inactiveTab;
        classInfo.btn4class    = classInfo.inactiveTab;
    }

    function tab2show() {
        classInfo.tab1body     = false;
        classInfo.tab2body     = true;
        classInfo.tab3body     = false;
        classInfo.tab4body     = false;
        classInfo.btn1class    = classInfo.inactiveTab;
        classInfo.btn2class    = classInfo.activeTab;
        classInfo.btn3class    = classInfo.inactiveTab;
        classInfo.btn4class    = classInfo.inactiveTab;
    }

    function tab3show() {
        classInfo.tab1body     = false;
        classInfo.tab2body     = false;
        classInfo.tab3body     = true;
        classInfo.tab4body     = false;
        classInfo.btn1class    = classInfo.inactiveTab;
        classInfo.btn2class    = classInfo.inactiveTab;
        classInfo.btn3class    = classInfo.activeTab;
        classInfo.btn4class    = classInfo.inactiveTab;
    }

    function tab4show() {
        classInfo.tab1body     = false;
        classInfo.tab2body     = false;
        classInfo.tab3body     = false;
        classInfo.tab4body     = true;
        classInfo.btn1class    = classInfo.inactiveTab;
        classInfo.btn2class    = classInfo.inactiveTab;
        classInfo.btn3class    = classInfo.inactiveTab;
        classInfo.btn4class    = classInfo.activeTab;
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
                alerts.flashMessage = 'New member: ' + name + ' Added!',
                alerts.alertType = 'success',
                flashShow(alerts.flashMessage, alerts.alertType),
                getNewMember(),
            ],

            onError: () => [
                alerts.flashMessage = 'Failed! Try Again',
                alerts.alertType = 'danger',
                flashShow(alerts.flashMessage, alerts.alertType),
            ]
        });
    }

    function getNewMember() {
        axios.get('/api/getMember/new')
            .then(
                ({ data }) => {
                    classInfo.newMember = data[0];
                    alerts.linkUrl      = '/member/'+ data[0].id;
                    let name            = data[0].name;
                    emit('close');
                    alerts.flashMessage   = 'New Member: '+ name +'!';
                    alerts.linkName       = 'View Member';
                    alerts.alertType      = 'info';
                    alerts.linkState      = true;
                    flashShowView(alerts.flashMessage, alerts.alertType);
                });
    }

    function getAllMembers() {
        alerts.linkUrl      = '/members';
        emit('close');
        alerts.flashMessage   = 'All New Members!';
        alerts.linkName       = 'View Members';
        alerts.alertType      = 'success';
        alerts.linkState      = true;
        flashShowView(alerts.flashMessage, alerts.alertType);
    }

    // upload sheet 
    function handleclick() {
        if (!classInfo.clicked) {
            classInfo.clicked = true;
        }
    }

    // on file change 
    function getDrop(event) {
        console.log(event);
    }

    function onChangeFile(event) {
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

                    classInfo.tab3 = classInfo.tabInactive;
                    classInfo.tab4 = classInfo.tabInactive;

                    if (data[0] > 0) {
                        classInfo.exist = true;
                        classInfo.tab3 = classInfo.tabInactive;
                        classInfo.tab4 = classInfo.tabInactive;
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
                });
    }

    function viewMembers(a) {
        if (a == 'duplicate members') {
            classInfo.modalLists = classInfo.oldMembers;
            classInfo.modalName = a;
            tabSwitch(1);
        } else {
            classInfo.modalLists = classInfo.newMembers;
            classInfo.modalName = a;
            tabSwitch(2);
        }
        
        // classInfo.isDupOpen    = true;
    }

    function closeMembers() {
        classInfo.isDupOpen    = false;
        classInfo.modalData = {};
        classInfo.modalLists = []
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
        classInfo.isLoading = true;
        if (classInfo.fileSelected != 1) {
            // flashMessage 
            alerts.flashMessage   = 'Upload 1(One) file at a time!';
            alerts.alertBody      = 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500';
            flashShow(alerts.flashMessage, alerts.alertBody);
            classInfo.labelClass     = classInfo.labelDanger;
        } else {
            alerts.flashMessage   = 'Loading! Please Wait';
            flashLoading(alerts.flashMessage);

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
                        classInfo.info = data[0];
                        clearFile();
                        alerts.flashMessage = data[1];
                        alerts.alertType    = 'success';
                        flashShow(alerts.flashMessage, alerts.alertType);
                        getAllMembers();
                        classInfo.isLoading = false;
                    })
                .catch(function (err) {
                    alerts.flashMessage = 'Upload Failed!';
                    alerts.alertType    = 'danger';
                    flashShow(alerts.flashMessage, alerts.alertType);
                    classInfo.labelClass   = classInfo.labelDanger;
                    classInfo.isLoading = false;
                });
        }
    }

    // flash messages 
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

    function flashLoading(message) {
        alerts.flashMessage   = message;
        alerts.alertBody      = classInfo.alertWarning;

        alerts.alertDuration  = 100000000;

        classInfo.isLoading      = true;
        alerts.alertType = 'warning';
        alerts.alertShow      = !alerts.alertShow;
    }

    function flashShowView(message, body) {
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

        alerts.alertShowView = !alerts.alertShowView;
    }
</script>