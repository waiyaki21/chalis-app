<template>
    <section :class="[classInfo.borderClass, 'col-span-3 h-fit']">
        <h3 class="font-boldened flex-col w-full flex py-2 px-1 whitespace-nowrap">
            <span :class="[classInfo.mainHeader]">View Members</span>
            <span class="text-xs text-gray-500 dark:text-gray-500/40 mb-0.5">
                (view all members in the system)
            </span>
        </h3>
        <!-- members table -->
        <div class="text-sm font-boldened text-center text-gray-500 dark:text-gray-400 w-full mb-2 mx-2 p-1">
            <div class="w-full">
                <h3 class="font-boldened md:text-3xl sm:text-xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1 w-full flex-col justify-between space-y-1 whitespace-nowrap">
                    <span class="w-full inline-flex justify-start">
                        <span class="underline mr-1">Members' Information.</span>
                        <span class="text-gray-500 dark:text-gray-500 md:text-base sm:text-sm md:mt-4 sm:mt-1">
                            ( {{ allMembers.length }} ) members
                        </span>
                    </span>
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="table-search-users" v-model="classInfo.search" class="w-full block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg  bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 h-12 shadow-md" placeholder="Search for members">
                    </div>
                </h3>

                <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-cyan-300/30 border-cyan-800/20">

                <!-- members table  -->
                <div class="py-2 relative overflow-x-auto overflow-y-scroll h-auto max-h-[34.8rem]"  v-if = "!classInfo.isLoading">
                    <h2 class="font-normal font-boldened text-[3rem] text-center text-cyan-800 dark:text-cyan-300 leading-tight uppercase py-1" v-if="allMembers.length == 0">
                        <span v-if="classInfo.search != ''">
                            NO SUCH MEMBER: 
                            <br>
                            <span class="text-orange-500 dark:text-orange-500 underline text-[2rem]">
                                {{ classInfo.search }}!!
                            </span>
                        </span>
                        <span v-else>ADD MEMBERS TO GET STARTED!!</span>
                    </h2>

                    <table class="mx-auto w-full text-xs text-left text-gray-500 dark:text-gray-400" v-else>
                        <thead class="text-gray-700 uppercase bg-transparent dark:text-gray-400 font-boldened text-xs">
                            <tr class="" preserve-scroll>
                                <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer" @click="orderByID()">
                                    <div class="flex items-center">
                                        ID.
                                        <a @click="classInfo.ascending = !classInfo.ascending">
                                            <div :class="[classInfo.svgSize]" v-html="classInfo.svgOrder"></div>
                                        </a>
                                    </div>
                                </td>
                                <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer" @click="orderByName()">
                                    <div class="flex items-center">
                                        Name.
                                        <a @click="classInfo.ascending = !classInfo.ascending">
                                            <div :class="[classInfo.svgSize]" v-html="classInfo.svgOrder"></div>
                                        </a>
                                    </div>
                                </td>
                                <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer" @click="orderByPercent()">
                                    <div class="flex items-center">
                                        %Age.
                                        <a @click="classInfo.ascending = !classInfo.ascending">
                                            <div :class="[classInfo.svgSize]" v-html="classInfo.svgOrder"></div>
                                        </a>
                                    </div>
                                </td>
                                <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer" @click="orderByActive()">
                                    <div class="flex items-center">
                                        Active.
                                        <a @click="classInfo.ascending = !classInfo.ascending">
                                            <div :class="[classInfo.svgSize]" v-html="classInfo.svgOrder"></div>
                                        </a>
                                    </div>
                                </td>
                                <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer hidden md:table-cell" @click="orderByPaid()">
                                    <div class="flex items-center">
                                        T.Paid.
                                        <a @click="classInfo.ascending = !classInfo.ascending">
                                            <div :class="[classInfo.svgSize]" v-html="classInfo.svgOrder"></div>
                                        </a>
                                    </div>
                                </td>
                                <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer hidden md:table-cell" @click="orderByWelfare()">
                                    <div class="flex items-center">
                                        T.Welfare.
                                        <a @click="classInfo.ascending = !classInfo.ascending">
                                            <div :class="[classInfo.svgSize]" v-html="classInfo.svgOrder"></div>
                                        </a>
                                    </div>
                                </td>
                                <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer" @click="orderByTotal()">
                                    <div class="flex items-center">
                                        T.Investment.
                                        <a @click="classInfo.ascending = !classInfo.ascending">
                                            <div :class="[classInfo.svgSize]" v-html="classInfo.svgOrder"></div>
                                        </a>
                                    </div>
                                </td>
                                <td scope="col" class="px-1 uppercase hover:text-white cursor-pointer">
                                    <div class="flex justify-center underline">
                                        Options.
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-transparent border-b dark:bg-transparent dark:border-gray-700 font-boldened text-xs uppercase" v-for="(member, index) in allMembers" preserve-scroll>
                                <td scope="row" class="p-0.5 uppercase text-gray-900 md:whitespace-nowrap sm:whitespace-normal dark:text-white text-xs">
                                    {{ member.id }}.
                                </td>
                                <td scope="row" class="sm:p-1 md:p-1.5 uppercase text-gray-900 md:whitespace-nowrap sm:whitespace-normal dark:text-white flex flex-col">
                                    <a @click="getRoute(member.id)" class="text-base md:text-lg hover:underline hover:cursor-pointer">{{ member.name }}.</a>
                                    
                                    <span class="uppercase underline text-gray-800 dark:text-gray-300 text-xs">
                                        {{ member.telephone }}
                                    </span>
                                </td>
                                <td scope="row" class="p-0.5 uppercase text-gray-900 md:whitespace-nowrap sm:whitespace-normal dark:text-white text-xs">
                                    {{ Number(member.total_shares).toFixed(2) }}%.
                                </td>
                                <td scope="row" class="p-1 uppercase text-gray-900 md:whitespace-nowrap sm:whitespace-normal dark:text-white text-center hover:cursor-pointer" @click="showActive(member)">
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 sm:w-8 sm:h-8 text-sky-600 hover:text-sky-500 cursor-pointer transition-transform hover:rotate-360" v-if="member.active" v-tooltip="{ content: 'Switch ' +member.name+ ' Inactive!'}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 sm:w-8 sm:h-8 text-rose-600 hover:text-rose-500 cursor-pointer transition-transform hover:rotate-360" v-if="!member.active" v-tooltip="{ content: 'Switch ' +member.name+ ' Active!'}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </td>
                                <td class="sm:p-1 md:p-1.5 hidden md:table-cell">
                                    <span class="uppercase underline text-cyan-800 dark:text-cyan-800 text-base whitespace-nowrap">
                                        ksh {{ numFormat(member.payments_total) }}
                                    </span>
                                </td>
                                <td class="sm:p-1 md:p-1.5 text-center hidden md:table-cell">
                                    <span class="uppercase underline text-orange-800 dark:text-orange-600 text-base whitespace-nowrap">
                                        ksh {{ numFormat(member.welfare_total) }}
                                    </span>
                                </td>
                                <td class="sm:p-1 md:p-1.5 text-center">
                                    <span class="uppercase underline text-green-800 dark:text-green-600 text-base whitespace-nowrap">
                                        ksh {{ numFormat(member.total_investment) }}
                                    </span>
                                </td>
                                <td class="sm:p-1 md:p-1.5">
                                    <div class="inline-flex justify-end space-x w-full" role="group">
                                        <!-- download  -->
                                        <a @click="downloadSheet(member)" type="button" class="inline-flex items-center p-1 text-sm font-medium text-amber-500 bg-transparent rounded-md hover:text-gray-500 dark:text-amber-500 dark:hover:text-amber-500" v-tooltip="{ content: 'Download '+ member.name+' Excelsheet', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                            </svg>
                                        </a >
                                        <!-- edit  -->
                                        <button type="button"
                                            class="inline-flex items-center p-0.5 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-gray-500 dark:text-cyan-700 dark:hover:text-cyan-400" @click="showMember(member)" preserve-scroll>
                                            <svg fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                            </svg>
                                            <!-- Edit -->
                                        </button>
                                        <!-- delete  -->
                                        <button type="button"
                                            class="inline-flex items-center p-0.5 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-gray-500 dark:text-red-700 dark:hover:text-red-400"
                                            @click="showDelete(member)" preserve-scroll>
                                            <svg fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                            <!-- Delete -->
                                        </button>
                                        <a type="button" class="inline-flex items-center p-0.5 text-xs font-medium text-gray-900 bg-transparent border dark:border-gray-300 rounded-md hover:bg-gray-900 hover:text-gray-500 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 uppercase sm:hidden" @click="getRoute(member.id)">
                                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                                            </svg>
                                            Info
                                        </a >
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <loadingTable
                    v-else
                ></loadingTable>

                <!--end members table  -->
                <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-cyan-300/30 border-cyan-800/20">
            </div>
        </div>
    </section>

    <!-- update member modal  -->
    <membersupdate
        :info   = classInfo.modalData
        :show   = classInfo.isOpen
        @reload = resetMembers
        @close  = closeMember
    ></membersupdate>
    <!-- end update member modal  -->

    <!-- delete member modal  -->
    <membersdelete
        :info   = classInfo.deleteData
        :show   = classInfo.isDeleteOpen
        @reload = resetMembers
        @close  = closeDelete
    ></membersdelete>
    <!-- end delete member modal  -->

    <!-- toggle active member modal  -->
    <membersactive
        :info   = classInfo.activeData
        :show   = classInfo.isActiveOpen
        @reload = resetMembers
        @close  = closeActive
    ></membersactive>
    <!-- end toggle active member modal  -->

    <alertview
        :alertshowview  = classInfo.alertShowView
        :message        = classInfo.flashMessage
        :class          = classInfo.alertBody
        :link           = classInfo.linkName
        :url            = classInfo.linkUrl
        :state          = classInfo.linkState
    ></alertview>
</template>

<script setup>
    import { reactive, defineEmits ,defineProps, watch, computed, onMounted } from 'vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        members : {
            type: Array,
            required: true
        },

        loading : {
            type: Boolean,
            required: true
        }
    })

    const classInfo = reactive ({
        // search
        search: '',

        // sort 
        ascending: true,
        sortBy: 'id',

        // loading 
        isLoading: true,

        // classess 
        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        borderClass: 'overflow-hidden font-boldened flex-col justify-between p-2 md:m-2 sm:m-1 sm:my-1 rounded-lg bg-cyan-50 dark:bg-gray-800/50 shadow-md sm:rounded-lg border-[3px] border-cyan-300 dark:border-cyan-700',
        mainHeader: 'font-boldened text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 md:text-3xl text-2xl',

        info: [],
        message: '',

        // search
        link: '',

        svgOrder: '<svg class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24"><path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" /></svg>',
        svgSize: 'w-3 h-3 ml-1',

        // page: 1
        isOpen: false,
        isOpenInfo: false,
        modalData: {},

        // active info 
        isActiveOpen: false,
        activeData: {},
        activeID: '',
        activeURL: '/active/member/',

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',
        deleteURL: '/delete/member/',

        // alerts
        alertShow: false,
        alertShowView: false,
        alertDuration: 15000,
        alertType: '',
        flashMessage: '',
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        linkName: '',
        linkUrl: '',
        linkState: false,
    })

    const type = computed(() => props.members);

    watch(type, (newValue) => {
        classInfo.isLoading = true;
        setInfo();
    })

    const allMembers = computed(() => {
        
        let tempMembers = classInfo.info

        // search rows 
        if (classInfo.search != '' && classInfo.search) {
            tempMembers = tempMembers.filter((member) => {
                return member.name
                    .toUpperCase()
                    .includes(classInfo.search.toUpperCase())
            })
        }

        // Sort members
        tempMembers = tempMembers.sort((a, b) => {
            if (classInfo.sortBy == 'name') {
                let fa = a.name.toLowerCase(), fb = b.name.toLowerCase()

                if (fa < fb) {
                    return -1
                }
                if (fa > fb) {
                    return 1
                }
                return 0

            } else if (classInfo.sortBy == 'id') {
                return a.id - b.id
            } else if (classInfo.sortBy == 'payments_total') {
                return a.payments_total - b.payments_total
            } else if (classInfo.sortBy == 'welfare_total') {
                return a.welfare_total - b.welfare_total
            } else if (classInfo.sortBy == 'total_amount') {
                return a.total_amount - b.total_amount
            } else if (classInfo.sortBy == 'last_pay') {
                return a.last_pay.payment - b.last_pay.payment
            } else if (classInfo.sortBy == 'active') {
                return  Number(a.active) - Number(b.active)
            } else if (classInfo.sortBy == 'total_shares') {
                return  Number(a.total_shares) - Number(b.total_shares)
            }
        })

        // Show sorted array in descending or ascending order
        if (!classInfo.ascending) {
            tempMembers.reverse()
        }

        return tempMembers
    })

    onMounted(() => {
        if (router.page.component != 'Settings') {
            classInfo.isLoading = true;
            resetMembers()
        }
    })

    const emit = defineEmits(['flash','reload','view'])

    function setInfo() {
        classInfo.isLoading = true;
        classInfo.info      = props.members;
        classInfo.sortBy    = 'id';

        // sort message
        classInfo.message   = classInfo.info.length + ' Members Sorted by: ';

        classInfo.isLoading = false
    }

    function numFormat(num) {
        if (num < 9999) {
            return num;
        } else {
            if (num > 999999) {
                let x = Number(num / 1000000).toFixed(2);
                let y = x + ' m';
                return y;
            } else {
                let x = Number(num / 1000).toFixed(2);
                let y = x + ' k';
                return y;
            } 
        }
    }

    function getRoute(a) {
        let url = '/member/' + a;

        router.visit(url , { preserveScroll: true });
    }

    function downloadSheet(member) {
        let name                 = member.name;
        classInfo.flashMessage   = 'Download ' + name + ' Payments and Welfare Ledger!';
        classInfo.linkName       = 'Download Member Excelsheet';
        classInfo.alertType      = 'info';
        classInfo.linkUrl        = '/download/current/member/' + member.id
        classInfo.linkState      = true;
        classInfo.alertBody      = classInfo.alertInfo;
        classInfo.alertShowView  = !classInfo.alertShowView;
    }

    // order rows 
    function orderByID() {
        LoadingOn()
        classInfo.sortBy = 'id';

        // flash message 
        classInfo.ordername = 'ID';
        if(classInfo.ascending) {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        LoadingOff()
    }

    function orderByName() {
        LoadingOn()
        classInfo.sortBy = 'name';

        // flash message 
        classInfo.ordername = 'NAME';
        if(classInfo.ascending) {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        
        LoadingOff()
    }

    function orderByPercent() {
        LoadingOn()
        classInfo.sortBy = 'total_shares';

        // flash message 
        classInfo.ordername = 'Percentage Shares';
        if(classInfo.ascending) {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        
        LoadingOff()
    }

    function orderByActive() {
        LoadingOn();

        classInfo.sortBy = 'active';

        // flash message 
        classInfo.ordername = 'ACTIVE';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Sorting Inactive Members';
        } else {
            classInfo.flashMessage   = 'Sorting Active Members';
        }
        classInfo.alertBody          = classInfo.alertInfo;
        
        // end loading 
        LoadingOff();
    }

    function orderByPaid() {
        LoadingOn()
        classInfo.sortBy = 'payments_total';

        // flash message 
        classInfo.ordername = 'TOTAL PAYMENTS';
        if(classInfo.ascending) {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        
        LoadingOff()
    }

    function orderByWelfare() {
        LoadingOn()
        classInfo.sortBy = 'welfare_total';

        // flash message 
        classInfo.ordername = 'TOTAL WELFARE';
        if(classInfo.ascending) {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        
        LoadingOff()
    }

    function orderByTotal() {
        LoadingOn()
        classInfo.sortBy = 'total_investment';

        // flash message 
        classInfo.ordername = 'TOTAL INVESTED';
        if(classInfo.ascending) {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = classInfo.message + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        
        LoadingOff()
    }

    function LoadingOn() {
        classInfo.ascending = !classInfo.ascending;
        classInfo.isLoading = true 
    }

    function LoadingOff() {
        emit('flash', classInfo.flashMessage, classInfo.alertBody);
        classInfo.isLoading = false;
    }

    // modal functions 
    function showMember(member) {
        classInfo.modalData = member;
        classInfo.isOpen    = true;
    }

    function closeMember() {
        classInfo.isOpen    = false;
        classInfo.modalData = {};
    }

    function showActive(member) {
        classInfo.activeData   = member;
        classInfo.activeID     = member.id;
        classInfo.isActiveOpen = true;
    }

    function closeActive() {
        classInfo.isActiveOpen = false;
        classInfo.activeData   = {};
        classInfo.activeID     = '';
    }

    function showDelete(member) {
        classInfo.deleteData   = member;
        classInfo.deleteID     = member.id;
        classInfo.isDeleteOpen = true;
    }

    function closeDelete() {
        classInfo.isDeleteOpen = false;
        classInfo.deleteData   = {};
        classInfo.deleteID     = '';
    }

    function resetMembers() {
        // emit('reload');
        let link = 'asc';
        let linkTo = 'id/';

        axios.get('/api/getMembers/' + linkTo + link)
            .then(
                ({ data }) => {
                    classInfo.info = data[0];
                    classInfo.isLoading = false;
                    // orderByID();
                });
    }
    // end modal functions 
</script>