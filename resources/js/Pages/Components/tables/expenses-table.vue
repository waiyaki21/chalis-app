<template>
    <div
        class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg rounded-md col-span-3 border-2 border-cyan-300 dark:border-cyan-700 h-fit">
        <div class="p-2 w-full flex-col">
            <h3
                class="font-boldened text-2xl md:text-4xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1 px-1 whitespace-nowrap">
                <span class="underline text-gray-800 dark:text-gray-300 leading-tight uppercase">Expenses
                    Info.</span>
                <span class="mx-2 text-lg text-gray-500 dark:text-gray-500 leading-tight">( {{ allExpenses.length }}
                    expenses )</span>
            </h3>
            <h3
                class="font-boldened text-2xl md:text-4xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1 px-1 grid grid-flow-col md:grid-cols-5 grid-cols-2 gap-2">
                <!-- <label for="table-search" class="sr-only">Search</label> -->
                <div class="relative w-full md:col-span-5 col-span-2">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search" v-model="classInfo.search"
                        class="w-full block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg  bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search Project Expenses">
                </div>
            </h3>

            <!-- expenses table  -->
            <div class="py-2 relative overflow-x-auto overflow-y-scroll h-auto max-h-[35rem]" v-if="!classInfo.isLoading">
                <h2 class="font-normal font-boldened text-[3.4rem] text-center text-cyan-800 dark:text-cyan-300 leading-tight uppercase py-1"
                    v-if="allExpenses.length == 0">
                    <span v-if="classInfo.search != ''">
                        NO SUCH PROJECT Expense:
                        <br>
                        <span class="text-orange-500 dark:text-orange-500 underline text-[2rem]">
                            {{ classInfo.search }}!!
                        </span>
                    </span>
                    <span v-else>ADD Project Expenses TO GET STARTED!!</span>
                </h2>
                <table class="mx-auto w-full text-sm text-left text-gray-500 dark:text-gray-400" v-else>
                    <thead class="text-gray-700 uppercase bg-transparent dark:text-gray-400 font-boldened text-sm">
                        <tr>
                            <td scope="col" class="px-1 uppercase hover:underline hover:text-white cursor-pointer"
                                @click="orderByID()">
                                <div class="flex items-center">
                                    No.
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hover:text-white cursor-pointer"
                                @click="orderByName()">
                                <div class="flex items-center">
                                    Name
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hover:text-white cursor-pointer"
                                @click="orderByPaid">
                                <div class="flex items-center">
                                    Paid.
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col"
                                class="px-2 uppercase hover:underline dark:text-gray-400 dark:hover:text-white cursor-pointer"
                                @click="orderByCycle()">
                                <div class="flex items-center">
                                    Payment Cycle.
                                    <a>
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col"
                                class="px-2 uppercase hover:underline hover:text-white cursor-pointer hidden md:table-cell"
                                @click="orderByDate()">
                                <div class="flex items-center">
                                    Date
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline">
                                <div class="flex items-center">
                                    Options.
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-base uppercase"
                            v-for="(expense, index) in allExpenses">
                            <td scope="row" class="px-2 py-4 uppercase text-gray-900 whitespace-nowrap dark:text-white">
                                {{ expense.id }}.
                            </td>
                            <td scope="row"
                                class="px-2 py-4 uppercase text-gray-900 whitespace-nowrap dark:text-white text-lg hover:underline">
                                {{ expense.name }}
                            </td>
                            <td
                                class="px-2 py-4 uppercase text-cyan-700 underline whitespace-nowrap dark:text-cyan-700 text-xl">
                                ksh {{ Number(expense.amount).toLocaleString() }}
                            </td>
                            <td class="px-2 py-4">
                                <a @click="getRoute(expense.cycle_id)"
                                    class="text-white bg-gradient-to-r from-cyan-600 to-blue-700 hover:bg-gradient-to-bl focus:ring-2 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg p-2 text-center me-2 mb-2 flex w-full justify-between cursor-pointer">
                                    <span class="md:text-xl sm:text-lg ml-4">
                                        {{ expense.cycle.name }}
                                    </span>
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                </a>
                            </td>
                            <td class="px-2 py-4 hidden md:table-cell">
                                <div class="">
                                    <div class="font-normal">
                                        {{ moment(expense.created_at).format("ddd, Do-MM-YY") }}
                                    </div>
                                    <div class="font-normal text-xs dark:text-gray-300 underline">
                                        {{ moment(expense.created_at).fromNow() }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 py-4">
                                <div class="inline-flex rounded-md shadow-sm space-x-1 justify-end" role="group">
                                    <!-- edit  -->
                                    <button type="button"
                                        class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-cyan-700 dark:hover:text-cyan-400"
                                        @click="showExpense(expense)">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <!-- End edit -->

                                    <!-- delete  -->
                                    <button type="button"
                                        class="inline-flex items-center p-2 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-red-700 dark:hover:text-red-400"
                                        @click="showDelete(expense)">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                    <!-- End delete -->
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <loadingTable v-if="classInfo.isLoading"></loadingTable>
            <!--end expenses table  -->
        </div>
    </div>

    <!-- update expenses modal  -->
    <expensesupdate
        :info   = classInfo.modalData
        :show   = classInfo.isOpen
        :name   = classInfo.modalName
        :payment= numFormat(classInfo.modalData.payment)
        @reload = getInfo
        @close  = closeExpense
    ></expensesupdate>
    <!-- end update expenses modal  -->

    <!-- delete expenses modal  -->
    <expensesdelete
        :info   = classInfo.deleteData
        :show   = classInfo.isDeleteOpen
        :name   = classInfo.modalName
        :amount = numFormat(classInfo.deleteData.amount)
        @reload = getInfo
        @close  = closeDelete
    ></expensesdelete>
    <!-- end delete expenses modal  -->
</template>

<script setup>
    import { reactive, onMounted, defineEmits ,defineProps, watch, computed, onBeforeMount } from 'vue';
    import { router, useForm } from '@inertiajs/vue3';

    //moment 
    import moment           from 'moment';

    const props = defineProps({
        expenses : {
            type: Array,
            required: true
        },
        project: {
            type: Array,
            required: true,
        },
        reload: {
            type: Boolean,
            required: true
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
        deleteURL: '/delete/expense/',

        selected: false
    })

    const type = computed(() => props.expenses);

    watch(type, (newValue) => {
        classInfo.isLoading = true;
        getInfo();
    })

    const reset = computed(() => props.reload);

    watch(reset, (newValue) => {
        classInfo.isLoading = true;
        getInfo();
    })

    // computed 
    const allExpenses = computed(() => {
        let tempExpenses = classInfo.info

            // search rows 
            if (classInfo.search != '' && classInfo.search) {
                tempExpenses = tempExpenses.filter((expense) => {
                    return expense.name
                        .toUpperCase()
                        .includes(classInfo.search.toUpperCase())
                })
            }

            // Sort by orders
            tempExpenses = tempExpenses.sort((a, b) => {
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
                tempExpenses.reverse()
            }

            return tempExpenses
    })

    onMounted(() => {
        getInfo()
        setInfo()
    })

    const emit = defineEmits(['flash','reload', 'view'])

    function setInfo() {
        classInfo.sortBy    = 'id';

        // sort message
        classInfo.message   = allExpenses.length + ' Expenses Sorted by: ';

        // flash message 
        classInfo.ordername = 'ID';
        if(classInfo.ascending) {
            if (allExpenses.length != 0) {
                classInfo.flashMessage = classInfo.message + classInfo.ordername + ' ascending';
                classInfo.alertBody = 'info';
            }  
        }
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
        let url = '/cycle/' + a;

        router.visit(url, { preserveScroll: true });
    }
    // order rows 
    function orderByID() {
        LoadingOn();

        classInfo.sortBy = 'id';

        // flash message 
        classInfo.ordername = 'ID';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Project Expenses Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Project Expenses Sorted by: ' + classInfo.ordername + ' descending';
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
            classInfo.flashMessage   = 'Project Expenses Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Project Expenses Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    function orderByDate() {
        LoadingOn();

        classInfo.sortBy = 'created_at';

        // flash message 
        classInfo.ordername = 'DATE';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Project Expenses Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Project Expenses Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    function orderByPaid() {
        LoadingOn();

        classInfo.sortBy = 'amount';

        // flash message 
        classInfo.ordername = 'PAYMENTS';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Project Expenses Sorted by: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Project Expenses Sorted by: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertBody          = 'info';
        emit('flash', classInfo.flashMessage, classInfo.alertBody);

        LoadingOff();
    }

    function orderByCycle() {
        LoadingOn();

        classInfo.sortBy = 'cycle_id';

        // flash message 
        classInfo.ordername = 'PAYMENT CYCLES';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Project Expenses Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Project Expenses Sorted By: ' + classInfo.ordername + ' descending';
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
    function showExpense(expense) {
        classInfo.modalName = expense.name;
        classInfo.modalData = expense;
        classInfo.isOpen    = true;
    }

    function closeExpense() {
        classInfo.isOpen             = false;
        classInfo.modalName          = '';
        classInfo.modalData          = {};
    }

    function showDelete(expense) {
        classInfo.modalName      = expense.name;
        classInfo.deleteData     = expense;
        classInfo.deleteID       = expense.id;
        classInfo.isDeleteOpen   = true;
    }

    function closeDelete() {
        classInfo.isDeleteOpen   = false;
        classInfo.deleteData     = {};
        classInfo.deleteID       = '';
        classInfo.modalName      = '';
    }
    // end modal functions 

    // get all 
    function getInfo() {
        axios.get('/api/getExpenses/' + props.project.id)
            .then(
                ({ data }) => {
                    classInfo.info      = data[0];
                    classInfo.sortBy    = 'id';

                    LoadingOff();
                });
    }
</script>