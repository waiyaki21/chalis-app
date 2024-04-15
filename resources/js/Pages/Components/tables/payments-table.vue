<template>
    <h3 :class="[classInfo.mainHeader, 'w-full grid grid-cols-4 md:grid-cols-4']">
        <span class="w-full md:inline-flex flex-col justify-start col-span-3 grid grid-cols-1 md:grid-cols-5">
            <span class="underline md:text-4xl text-2xl px-2 col-span-3">{{ cycle.name }} Payments.</span>
            <span class="text-gray-500 dark:text-gray-500 md:text-base text-xs md:mt-4 sm:mt-1 md:hidden">
                ( {{ allPayments.length }} ) payments
            </span>
        </span>

        <h3 :class="['font-boldened text-3xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1 inline-flex justify-end w-full']">
            <button type="button" class="bg-rose-100 text-gray-800 text-xl text-left font-normal px-2.5 py-1.5 rounded-md dark:bg-rose-900 dark:text-rose-300 border-2 border-rose-900 dark:border-rose-500 cursor-pointer uppercase whitespace-nowrap shadow-md" @click="clearAllBalances()" v-if="props.percent >= props.cycle.members_no">
                Clear All Balances
            </button>
            <!-- forms  -->
            <a @click="formSwitch()" type="button" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-base px-5 py-2.5 text-center uppercase cursor-pointer inline-flex justify-between whitespace-nowrap shadow-md">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Payments
            </a >
        </h3>
    </h3>

    <h3 class="font-boldened text-2xl md:text-4xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1 px-1">    
        <!-- <label for="table-search" class="sr-only">Search</label> -->
        <div class="relative w-full my-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 my-1" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" id="table-search" v-model="classInfo.search" class="w-full block p-2 pl-14 text-sm text-gray-900 border border-gray-300 rounded-lg  bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 h-14 my-2 shadow-md" :placeholder="'SEARCH MEMBERS'">
        </div>
    </h3>

    <!-- payments table  -->
    <div class="py-4 px-2 relative overflow-x-auto h-fit max-h-[540px] overflow-y-scroll"  v-if = "!classInfo.isLoading">
        <h2 class="font-normal font-boldened text-[3rem] text-center text-amber-500 dark:text-amber-500 leading-tight uppercase underline py-1" v-if="allPayments.length == 0">
            <span v-if="classInfo.search != ''">
                NO SUCH MEMBER IN THIS CYCLE: 
                <br>
                <span class="text-amber-500 dark:text-amber-500 underline text-[2rem]">
                    {{ classInfo.search }}!!
                </span>
            </span>
            <span v-else>NO PAYMENTS IN THIS CYCLE!!</span>
        </h2>
        <table class="mx-auto w-full text-sm text-left text-gray-500 dark:text-gray-400" v-else>
            <thead class="text-gray-700 hover:text-gray-900 uppercase bg-transparent font-boldened text-base">
                <tr>
                    <td scope="col" class="px-2 uppercase hover:underline dark:text-gray-400 dark:hover:text-white cursor-pointer" @click="orderByID()">
                        <div class="flex items-center">
                            Name
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col" class="px-2 uppercase hover:underline  dark:text-gray-400 dark:hover:text-white hover:cursor-pointer" @click="orderByPayments()">
                        <div class="flex items-center">
                            Paid.
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col" class="px-2 uppercase hover:underline  dark:text-gray-400 dark:hover:text-white hover:cursor-pointer" @click="orderByPaymentSum()">
                        <div class="flex items-center">
                            T.Contr.
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col" class="px-2 uppercase hover:underline  dark:text-gray-400 dark:hover:text-white hover:cursor-pointer hidden md:table-cell" @click="orderByBefore()">
                        <div class="flex items-center">
                            Amnt B/F.
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col" class="px-2 uppercase hover:underline dark:text-gray-400 dark:hover:text-white  hover:cursor-pointer" @click="orderByTotal()">
                        <div class="flex items-center">
                            G.Total.
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <!-- <td scope="col" class="px-2 uppercase hover:underline  dark:text-gray-400 dark:hover:text-white hover:cursor-pointer hidden md:table-cell">
                        <div class="flex items-center">
                            Date
                        </div>
                    </td> -->
                    <td scope="col" class="px-2 uppercase hover:underline  dark:text-gray-400 dark:hover:text-white hover:cursor-pointer">
                        <div class="flex items-center">
                            Options.
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-transparent border-b dark:bg-transparent dark:border-gray-700 font-boldened text-base uppercase" v-for="(payment, index) in allPayments" preserve-scroll>
                    <td scope="row" class="sm:p-1 md:p-1.5 uppercase text-gray-900 md:whitespace-nowrap sm:whitespace-normal dark:text-white">
                        <span class="uppercase text-gray-900 whitespace-nowrap dark:text-white mr-1 text-sm">
                            {{ index + 1 }}.
                        </span>
                        <a @click="getRoute(payment.member_id)" class="cursor-pointer hover:underline dark:hover:text-cyan-600 uppercase text-gray-900 whitespace-nowrap dark:text-white md:text-2xl text-xl">{{ payment.member.name }}</a>.
                        <br>
                        <span class="uppercase underline text-gray-800 dark:text-gray-300 text-xs">
                            {{ payment.member.telephone }}
                        </span>
                    </td>
                    <!-- <td class="px-2 py-4" v-if="payment.payment > cycle.amount"> -->
                    <td class="px-2 py-4">
                        <span class="">
                            <span class="text-green-500 underline text-lg">
                                ksh {{ numFormat(payment.payment) }}
                            </span>
                        </span>
                    </td>
                    <!-- <td class="px-2 py-4 flex flex-col" v-else>
                            <span class="mb-1">Paid: 
                            <span class="text-green-500 underline text-lg">
                                ksh {{ Number(payment.payment).toLocaleString() }}
                            </span>
                        </span>
                        <button type="button" class="bg-rose-100 text-gray-800 text-sm text-left font-normal px-2.5 py-1.5 rounded-md dark:bg-rose-900 dark:text-gray-300 border-2 border-rose-900 dark:border-rose-500 cursor-pointer w-2/3" @click="clearBalance([payment.member, payment])">
                            Clear Balance: ksh {{ Number(cycle.amount - payment.payment).toLocaleString() }}
                        </button>
                    </td> -->
                    <td class="px-2 py-4">
                        <span class="">
                            <span class="text-blue-500 underline text-lg">
                                ksh {{ numFormat(payment.member.payments_sum) }}
                            </span>
                        </span>
                    </td>
                    <td class="px-2 py-4 hidden md:table-cell">
                        <span class="">
                            <span class="text-amber-500 underline text-lg">
                                ksh {{ numFormat(payment.member.amount_before) }}
                            </span>
                        </span>
                    </td>
                    <td class="px-2 py-4">
                        <span class="text-rose-500 underline text-lg">
                            ksh {{ numFormat(payment.member.payments_total) }}
                        </span>
                    </td>
                    <!-- <td class="px-2 py-4 hidden md:table-cell">
                        <div class="pl-1">
                            <div class="font-normal">
                                {{ moment(payment.created_at).format("ddd, Do-MM-YY") }}
                            </div>
                            <div class="font-normal text-xs dark:text-gray-300 underline">
                                {{ moment(payment.created_at).fromNow() }}
                            </div>
                        </div>
                    </td> -->
                
                    <td class="px-2 py-4">
                        <div class="inline-flex rounded-md shadow-sm space-x-1" role="group">
                            <!-- edit  -->
                            <button type="button"
                                class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-gray-500 focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-cyan-700 dark:hover:text-cyan-400"
                                @click="showPayment(payment)">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                                <!-- Edit -->
                            </button>
                            <!-- delete  -->
                            <button type="button"
                                class="inline-flex items-center p-2 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-gray-500 focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-red-700 dark:hover:text-red-400"
                                @click="showDelete(payment)">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
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
    <!--end payments table  -->

    <loadingTable v-else
    ></loadingTable>

    <!-- update payment modal  -->
    <paymentsupdate
        :info   = classInfo.modalData
        :show   = classInfo.isOpen
        :name   = classInfo.modalName
        :payment= numFormat(classInfo.modalData.payment)
        @reload = getInfo
        @close  = closePayment
    ></paymentsupdate>
    <!-- end update payment modal  -->

    <!-- delete payment modal  -->
    <paymentsdelete
        :info   = classInfo.deleteData
        :show   = classInfo.isDeleteOpen
        :name   = classInfo.modalName
        :payment= numFormat(classInfo.deleteData.payment)
        @reload = getInfo
        @close  = closeDelete
    ></paymentsdelete>
    <!-- end delete payment modal  -->
</template>

<script setup>
    import { reactive, computed, defineEmits, onMounted, watch } from 'vue';
    import { router } from '@inertiajs/vue3';
    
    const props = defineProps({
        cycle: {
            type: Object,
            required: true,
        }
    })

    const type = computed(() => props.cycle);

    watch(type, (newValue) => {
        classInfo.isLoading = true;
        getInfo();
    })

    const classInfo = reactive ({
        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        borderClass: 'border-[3px] border-cyan-300 dark:border-cyan-700',
        mainHeader: 'font-boldened text-3xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1',

        info: [],

        // search
        search: '',
        link: '',

        // order 
        nameOrder: true,
        paidOrder: false,
        welfareOrder: false,
        totalOrder: false,
        ordername: '',
        ordertype: '',

        // page: 1
        isOpen: false,
        isOpenInfo: false,
        modalData: {},

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',
        deletePayURL: '/delete/payment/',

        // sort 
        ascending: true,
        sortBy: 'id',

        alertType: '',
        flashMessage: '',
        isLoading: true,
    })

    const allPayments = computed(() => {
        let tempPayments = classInfo.info

        // search rows 
        if (classInfo.search != '' && classInfo.search) {
            tempPayments = tempPayments.filter((payment) => {
                return payment.member.name
                    .toUpperCase()
                    .includes(classInfo.search.toUpperCase())
            })
        }

        // Sort Payments
        tempPayments = tempPayments.sort((a, b) => {
            if (classInfo.sortBy == 'name') {
                let fa = a.member.name.toLowerCase(), fb = b.member.name.toLowerCase()

                if (fa < fb) {
                    return -1
                }
                if (fa > fb) {
                    return 1
                }
                return 0

            } else if (classInfo.sortBy == 'id') {
                return a.id - b.id
            } else if (classInfo.sortBy == 'payments') {
                return a.payments - b.payments
            } else if (classInfo.sortBy == 'payments_sum') {
                return a.member.payments_sum - b.member.payments_sum
            } else if (classInfo.sortBy == 'amount_before') {
                return a.member.amount_before - b.member.amount_before
            } else if (classInfo.sortBy == 'payments_total') {
                return a.member.payments_total - b.member.payments_total
            }
        })

        // Show sorted array in descending or ascending order
        if (!classInfo.ascending) {
            tempPayments.reverse()
        }

        return tempPayments
    })

    onMounted(() => {
        classInfo.isLoading = true;
        getInfo()
    })

    const emit = defineEmits(['flash','progress','switch2']);

    function getInfo() {
        let link    = 'asc';
        let linkTo  = 'created_at/';

        axios.get('/api/getPayments/'+ props.cycle.id + '/' + linkTo + link)
            .then(
                ({ data }) => {
                    classInfo.info = data[0];
                    classInfo.isLoading = false
                });
    }

    function numFormat(num) {
        if (num < 19999) {
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

    function clearBalance([member, payment]) {
        // info 
        let balance = Number(props.cycle.amount - payment.payment).toLocaleString();
        let message = 'Clear '+ member.name + ': balance of ksh ' + balance + '?';

        // confirm clearance
        if (confirm(message) == true) {
            axios.get('/clear/balance/' + props.cycle.id + '/' + member.id)
                .then(
                    ({ data }) => {
                        classInfo.info       = data[0];
                        classInfo.cycleinfo  = data[1];
                        progressMain();
                    });
        }

        // flashMessage 
        classInfo.flashMessage   = member.name + ' balance: ksh ' + balance + ' cleared!';
        classInfo.alertType      = 'info';
        LoadingOff();
    }

    function clearAllBalances() {
        let message = 'Automatically fill in all member balances?';
        if (confirm(message) == true) {
            axios.get('/clear/all/balances/' + props.cycle.id)
                .then(
                    ({ data }) => {
                        classInfo.info       = data[0];
                        classInfo.cycleinfo  = data[1];
                        progressMain();
                    });
        }
    }

    function formSwitch() {
        emit('switch2');
    }

    function progressMain() {
        emit('progress');
    }

    function LoadingOn() {
        classInfo.ascending = !classInfo.ascending;
        classInfo.isLoading = true 
    }

    function LoadingOff() {
        emit('flash', classInfo.flashMessage, classInfo.alertType);
        classInfo.isLoading = false
    }

    // order rows 
    function orderByID() {
        LoadingOn();

        classInfo.sortBy = 'id';

        // flash message 
        classInfo.ordername = 'ID';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function orderByName() {
        LoadingOn();

        classInfo.sortBy = 'name';

        // flash message 
        classInfo.ordername = 'NAME';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function orderByPayments() {
        LoadingOn();

        classInfo.sortBy = 'payments';

        // flash message 
        classInfo.ordername = 'TOTAL PAYMENTS';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function orderByPaymentSum() {
        LoadingOn();

        classInfo.sortBy = 'payments_sum';

        // flash message 
        classInfo.ordername = 'TOTAL PAYMENTS CONTRIBUTED';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function orderByBefore() {
        LoadingOn();

        classInfo.sortBy = 'amount_before';

        // flash message 
        classInfo.ordername = 'TOTAL AMOUNT CONTRIBUTED BEFORE';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function orderByTotal() {
        LoadingOn();

        classInfo.sortBy = 'payments_total';

        // flash message 
        classInfo.ordername = 'GRAND TOTAL AMOUNT';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function getRoute(a) {
        let url = '/member/' + a;

        router.visit(url, { preserveScroll: true });
    }

    // modals 
    // payment modals 
    function showPayment(payment) {
        // console.log(payment);
        // formFields(payment);
        classInfo.modalName  = payment.member.name;
        classInfo.modalData  = payment;
        classInfo.isOpen     = true;
    }

    function closePayment() {
        classInfo.isOpen             = false;
        classInfo.modalName          = '';
        classInfo.modalData          = {};
    }

    function showDelete(payment) {
        classInfo.modalName      = payment.member.name;
        classInfo.deleteData     = payment;
        classInfo.deleteID       = payment.id;
        classInfo.isDeleteOpen   = true;
    }

    function closeDelete() {
        classInfo.isDeleteOpen   = false;
        classInfo.deleteData     = {};
        classInfo.deleteID       = '';
        classInfo.modalName      = '';
    }
</script>