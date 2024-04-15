<template>
    <div class="bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg rounded-md col-span-3 border-2 border-cyan-300 dark:border-cyan-700 h-fit">
        <div class="p-2 w-full flex-col">
            <h3 class="font-boldened text-2xl md:text-4xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1 px-1 whitespace-nowrap">
                <span class="underline text-gray-800 dark:text-gray-300 leading-tight uppercase">Payment Cycles Info.</span> 
                <span class="mx-2 text-lg text-gray-500 dark:text-gray-500 leading-tight">( {{ allCycles.length }} cycles )</span>
            </h3>
            <h3 class="font-boldened text-2xl md:text-4xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1 px-1 grid grid-cols-1 md:grid-cols-5 gap-1">    
                <!-- <label for="table-search" class="sr-only">Search</label> -->
                <div class="relative w-full col-span-3 pt-2">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 mt-2 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="table-search" v-model="classInfo.search" class="w-full block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg  bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 h-12 shadow-md" placeholder="Search Payment Cycles">
                </div>

                <section class="col-span-2 w-full grid grid-flow-col grid-cols-2 gap-1">
                    <Dropdown
                        @click      = 'classInfo.selected = true'
                        :name       = "'Cycle Year'"
                        :listsyear  = classInfo.cycleYears
                        @selected   = selectYears
                    ></Dropdown>

                    <Dropdown
                        @click      = 'classInfo.selected = true'
                        :name       = "'Cycle Month'"
                        :listsmonth = classInfo.cycleMonths
                        @selected   = selectMonths
                    ></Dropdown>
                </section>
            </h3>

            <!-- cycles table  -->
            <div class="py-2 relative overflow-x-auto overflow-y-scroll h-auto max-h-[35rem]" v-if = "!classInfo.isLoading">
                <h2 class="font-normal font-boldened text-[3.4rem] text-center text-cyan-800 dark:text-cyan-300 leading-tight uppercase py-1" v-if="allCycles.length == 0">
                    <span v-if="classInfo.search != ''">
                        NO SUCH PAYMENT CYCLE: 
                        <br>
                        <span class="text-orange-500 dark:text-orange-500 underline text-[2rem]">
                            {{ classInfo.search }}!!
                        </span>
                    </span>
                    <span v-else>ADD PAYMENT CYCLEs TO GET STARTED!!</span>
                </h2>
                <table class="mx-auto w-full text-sm text-left text-gray-500 dark:text-gray-400" v-else>
                    <thead class="text-gray-700 uppercase bg-transparent dark:text-gray-400 font-boldened text-sm">
                        <tr>
                            <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer" @click="orderByID()">
                                <div class="flex items-center">
                                    No.
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hover:text-white cursor-pointer" @click="orderByName()">
                                <div class="flex items-center">
                                    Name
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hover:text-white cursor-pointer hidden md:table-cell" @click="orderByDate()">
                                <div class="flex items-center">
                                    Date
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hover:text-white cursor-pointer" @click="orderByPaid">
                                <div class="flex items-center">
                                    Paid.
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hover:text-white cursor-pointer" @click="orderByWelfare">
                                <div class="flex items-center">
                                    Welfares.
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hover:text-white cursor-pointer hidden md:table-cell" @click="orderByMembers()">
                                <div class="flex items-center">
                                    Members.
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hover:text-white cursor-pointer">
                                <div class="flex items-center">
                                    Options.
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-transparent border-b dark:bg-transparent dark:border-gray-700 font-boldened text-base uppercase"
                            v-for="(cycle, index) in allCycles">
                            <td scope="row"
                                class="px-1 uppercase text-gray-900 whitespace-nowrap dark:text-white">
                                {{ cycle.id }}.
                            </td>
                            <td scope="row"
                                class="px-2 py-4 uppercase text-gray-900 whitespace-nowrap dark:text-white">
                                <!-- progress bar  -->
                                <a @click="getRoute(cycle)">
                                    <span class="hover:underline text-xl">{{ cycle.name }}</span>
                                    <!-- progress bar  -->
                                    <progressTable
                                        :percent = cycle.percent
                                        :name    = cycle.name 
                                    ></progressTable>
                                </a>
                                <!-- end progress bar  -->
                            </td>
                            <td class="px-2 py-4 hidden md:table-cell">
                                <div class="pl-3">
                                    <div class="font-normal">
                                        {{ moment(cycle.date).format("ddd, Do-MM-YY") }}
                                    </div>
                                    <div class="font-normal text-xs dark:text-gray-300 underline">
                                        {{ moment(cycle.date).fromNow() }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 py-4">
                                <span class="text-blue-500">ksh {{ numFormat(cycle.payments_total) }}</span> 
                            </td>
                            <td class="px-2 py-4">
                                <span class="text-purple-600">ksh {{ numFormat(cycle.welfares_total) }}</span> 
                            </td>
                            <td class="px-2 py-4 hidden md:table-cell">
                                <span class="text-amber-400">{{cycle.members_no}} Paid.</span> 
                            </td>
                            <td class="px-2 py-4">
                                <div class="inline-flex rounded-md shadow-sm space-x-1" role="group">
                                    <!-- download  -->
                                    <a @click="downloadSheet(cycle)" type="button" class="inline-flex items-center p-1 text-sm font-medium text-amber-500 bg-transparent rounded-md hover:text-gray-500 dark:text-amber-500 dark:hover:text-amber-500" v-tooltip="{ content: 'Download '+ cycle.name+' Excelsheet', placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                        </svg>
                                    </a >
                                    <!-- edit  -->
                                    <button type="button"
                                        class="inline-flex items-center p-1 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-gray-500 dark:text-cyan-700 dark:hover:text-cyan-400" @click="showCycle(cycle)">
                                        <svg fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                        <!-- Edit -->
                                    </button>
                                    <!-- delete  -->
                                    <button type="button"
                                        class="inline-flex items-center p-1 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-gray-500 dark:text-red-700 dark:hover:text-red-400"
                                        @click="showDelete(cycle)">
                                        <svg fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        <!-- Delete -->
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <loadingTable
                v-if     = "classInfo.isLoading"
            ></loadingTable>
            <!--end cycles table  -->
        </div>
    </div>

    <!-- update cycle modal  -->
    <cyclesupdate
        :info   = classInfo.modalData
        :show   = classInfo.isOpen
        @reload = resetCycles
        @close  = closeCycle
    ></cyclesupdate>
    <!-- end update cycle modal  -->

    <!-- delete cycle modal  -->
    <cyclesdelete
        :info   = classInfo.deleteData
        :show   = classInfo.isDeleteOpen
        @reload = resetCycles
        @close  = closeDelete
    ></cyclesdelete>
    <!-- end delete cycle modal  -->
</template>

<script setup>
    import { reactive, onMounted, defineEmits ,defineProps, watch, computed } from 'vue';
    import { router } from '@inertiajs/vue3';

    //moment 
    import moment           from 'moment';

    const props = defineProps({
        cycles : {
            type: Array,
            required: true
        },
        cycleinfo: {
            type: Array,
            required: true,
        }
    })

    const classInfo = reactive ({
        // search
        search: '',
        messgae: '',

        // order 
        nameOrder: true,
        dateOrder: false,
        totalOrder: false,
        percentOrder: false,

        // sort 
        ascending: false,
        sortBy: 'id',

        // loading 
        isLoading: true,

        // classess 
        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        borderClass: 'overflow-hidden font-boldened flex-col justify-between p-2 md:m-2 sm:m-1 sm:my-1 rounded-lg bg-gray-300 dark:bg-gray-800/50 shadow-md sm:rounded-lg border-[3px] border-cyan-300 dark:border-cyan-700',
        mainHeader: 'font-boldened text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 md:text-3xl text-2xl',

        info: [],
        cycleYears: [],
        cycleMonths: [],

        // search
        link: '',

        ordername: '',

        // page: 1
        isOpen: false,
        isOpenInfo: false,
        modalData: {},

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',
        deleteURL: '/delete/cycle/',

        selected: false
    })

    const type = computed(() => props.cycles);

    watch(type, (newValue) => {
        classInfo.isLoading = true;
        resetCycles();
    })

    // computed 
    const allCycles = computed(() => {
        let tempCycles = classInfo.info

            // search rows 
            if (classInfo.search != '' && classInfo.search) {
                tempCycles = tempCycles.filter((cycle) => {
                    return cycle.name
                        .toUpperCase()
                        .includes(classInfo.search.toUpperCase())
                })
            }

            // Sort by orders
            tempCycles = tempCycles.sort((a, b) => {
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
                } else if (classInfo.sortBy == 'welfares_total') {
                    return a.welfares_total - b.welfares_total
                } else if (classInfo.sortBy == 'members_no') {
                    return a.members_no - b.members_no
                } else if (classInfo.sortBy == 'total_amount') {
                    return a.total_amount - b.total_amount
                } else if (classInfo.sortBy == 'created_at') {
                    return a.created_at - b.created_at
                }
            })

            // Show sorted array in descending or ascending order
            if (!classInfo.ascending) {
                tempCycles.reverse()
            }

            return tempCycles
    })

    onMounted(() => {
        setInfo()
    })

    const emit = defineEmits(['flash','reload', 'view'])

    function setInfo() {
        classInfo.info      = props.cycles;

        classInfo.sortBy    = 'id';

        // sort message
        classInfo.message   = allCycles.length + ' Cycles Sorted by: ';

        // flash message 
        classInfo.ordername = 'ID';
        if(classInfo.ascending) {
            if (allCycles.length != 0) {
                classInfo.flashMessage = classInfo.message + classInfo.ordername + ' ascending';
                classInfo.alertBody = 'info';
            }  
        }

        classInfo.cycleYears    = props.cycleinfo[0]
        classInfo.cycleMonths   = props.cycleinfo[1]

        LoadingOff();
    }

    function selectYears(a) {
        LoadingOn();
        axios.get('/api/getCyclesBy/year/' + a)
            .then(
                ({ data }) => {
                    classInfo.info      = data[0];
                    classInfo.flashMessage   =  a + ' :Payment Cycles!';
                    classInfo.alertBody      = 'info';
                    emit('flash', classInfo.flashMessage, classInfo.alertBody);
                    LoadingOff();
                });
    }

    function selectMonths(a) {
        LoadingOn();
        axios.get('/api/getCyclesBy/month/' + a)
            .then(
                ({ data }) => {
                    classInfo.info           = data[0];
                    classInfo.flashMessage   = a + ' :Payment Cycles!';
                    classInfo.alertBody      = 'info';
                    emit('flash', classInfo.flashMessage, classInfo.alertBody);
                    LoadingOff();
                });
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
                let x = Number(num / 1000).toFixed(1);
                let y = x + ' k';
                return y;
            } 
        }
    }

    function getRoute(a) {
        let url = '/cycle/' + a.id;

        router.visit(url, { preserveScroll: true });
    }

    function downloadSheet(cycle) {
        classInfo.flashMessage   = 'Download '+ cycle.name +' Full Excelsheet!';
        classInfo.alertType      = 'info';

        emit('view', classInfo.flashMessage, classInfo.alertType, cycle);
    }

    // order rows 
    function orderByID() {
        LoadingOn();

        classInfo.sortBy = 'id';

        // flash message 
        classInfo.ordername = 'ID';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    function orderByName() {
        LoadingOn();

        classInfo.sortBy = 'name';

        // flash message 
        classInfo.ordername = 'NAME';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    function orderByDate() {
        LoadingOn();

        classInfo.sortBy = 'date';

        // flash message 
        classInfo.ordername = 'DATE';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    function orderByPaid() {
        LoadingOn();

        classInfo.sortBy = 'payments_total';

        // flash message 
        classInfo.ordername = 'TOTAL PAYMENTS';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    function orderByWelfare() {
        LoadingOn();

        classInfo.sortBy = 'welfares_total';

        // flash message 
        classInfo.ordername = 'TOTAL WELFARE';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    function orderByTotal() {
        LoadingOn();

        classInfo.sortBy = 'total_amount';

        // flash message 
        classInfo.ordername = 'TOTAL AMOUNT';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    function orderByMembers() {
        LoadingOn();

        classInfo.sortBy = 'members_no';

        // flash message 
        classInfo.ordername = 'MEMBERS CONTRIBUTED';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payment Cycles Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    // loading
    function LoadingOn() {
        classInfo.ascending = !classInfo.ascending;
        classInfo.isLoading = true 
    }

    function LoadingOff() {
        classInfo.isLoading = false
    }

    // modal functions 
    function showCycle(cycle) {
        classInfo.modalData = cycle;
        classInfo.isOpen    = true;
    }

    function closeCycle() {
        classInfo.isOpen    = false;
        classInfo.modalData = {};
    }

    function showDelete(cycle) {
        classInfo.deleteData   = cycle;
        classInfo.deleteID     = cycle.id;
        classInfo.isDeleteOpen = true;
    }

    function closeDelete() {
        classInfo.isDeleteOpen = false;
        classInfo.deleteData   = {};
        classInfo.deleteID     = '';
    }

    function resetCycles() {
        let link = 'desc';
        let linkTo = 'id/';

        axios.get('/api/getCycles/' + linkTo + link)
            .then(
                ({ data }) => {
                    classInfo.info      = data[0];
                    classInfo.sortBy    = 'id';

                    LoadingOff();
                });
    }
    // end modal functions 
</script>