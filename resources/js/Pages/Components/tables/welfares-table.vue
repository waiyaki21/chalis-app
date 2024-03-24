<template>
    <h3 :class="[classInfo.mainHeader,'w-full mb-1 grid grid-cols-1 md:grid-cols-4']">
        <span class="w-full md:inline-flex flex-col justify-start col-span-3 grid grid-cols-1 md:grid-cols-5">
            <span class="underline md:text-4xl text-2xl px-2 col-span-3">{{ cycle.name }} Welfares.</span>
            <span class="text-gray-500 dark:text-gray-500 md:text-base text-xs md:mt-4 sm:mt-1">
                ( {{ allWelfares.length }} ) welfares
            </span>
        </span>
    </h3>

    <h3
        class="font-boldened text-2xl md:text-4xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1 inline-flex justify-between w-full">
        <!-- <label for="table-search" class="sr-only">Search</label> -->
        <div class="relative my-1 w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" id="table-search" v-model="classInfo.search"
                class="w-full block p-2 pl-14 text-sm text-gray-900 border border-gray-300 rounded-lg  bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 h-14"
                :placeholder="'SEARCH MEMBERS'">
        </div>

        <!-- options  -->
        <h3 :class="[classInfo.mainHeader, 'inline-flex justify-end']">
            <a @click="tabSwitch2()" type="button" :class="[classInfo.welfareOption]"
                v-tooltip="{ content: classInfo.btn1.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    :class="[classInfo.svgOption]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
            <a @click="welfareAll()" type="button" :class="[classInfo.welfareOption]"
                v-tooltip="{ content: classInfo.btn2.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    :class="[classInfo.svgOption]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                </svg>
            </a>
            <a @click="welfareIn()" type="button" :class="[classInfo.welfareOption]"
                v-tooltip="{ content: classInfo.btn3.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    :class="[classInfo.svgOption]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 9V4.5M9 9H4.5M9 9 3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5 5.25 5.25" />
                </svg>
            </a>
            <a @click="welfareOwed()" type="button" :class="[classInfo.welfareOption]"
                v-tooltip="{ content: classInfo.btn4.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    :class="[classInfo.svgOption]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                </svg>
            </a>
        </h3>
    </h3>

    <!-- welfares table  -->
    <div class="py-2 relative overflow-x-auto overflow-y-scroll h-auto max-h-[35rem]" v-if="!classInfo.isLoading">
        <h2 class="font-normal font-boldened text-[3rem] text-center text-amber-500 dark:text-amber-500 leading-tight uppercase underline py-1"
            v-if="allWelfares.length == 0">
            <span v-if="classInfo.search != ''">
                NO SUCH MEMBER IN THIS CYCLE:
                <br>
                <span class="text-amber-500 dark:text-amber-500 underline text-[2rem]">
                    {{ classInfo.search }}!!
                </span>
            </span>
            <span v-else>NO WELFARES IN THIS CYCLE!!</span>
        </h2>
        <table class="mx-auto w-full text-sm text-left text-gray-500 dark:text-gray-400" v-else>
            <thead class="text-gray-700 hover:text-gray-900 uppercase bg-transparent font-boldened text-base">
                <tr>
                    <td scope="col"
                        class="px-2 uppercase hover:underline dark:text-gray-400 dark:hover:text-white cursor-pointer"
                        @click="orderByID()">
                        <div class="flex items-center">
                            No.
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col"
                        class="px-2 uppercase hover:underline dark:text-gray-400 dark:hover:text-white cursor-pointer"
                        @click="orderByName()">
                        <div class="flex items-center">
                            Name
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col"
                        class="px-2 uppercase hover:underline dark:text-gray-400 dark:hover:text-white cursor-pointer">
                        <div class="flex items-center">
                            Type
                        </div>
                    </td>
                    <td scope="col"
                        class="px-2 uppercase hover:underline  dark:text-gray-400 dark:hover:text-white hover:cursor-pointer"
                        @click="orderByWelfares()" v-if="classInfo.welfarePaid">
                        <div class="flex items-center">
                            Paid.
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col"
                        class="px-2 uppercase hover:underline  dark:text-gray-400 dark:hover:text-white hover:cursor-pointer"
                        @click="orderByWelfareOwed()" v-if="classInfo.welfareOwed">
                        <div class="flex items-center">
                            Owed.
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col"
                        class="px-2 uppercase hover:underline  dark:text-gray-400 dark:hover:text-white hover:cursor-pointer hidden md:table-cell"
                        @click="orderByBefore()">
                        <div class="flex items-center">
                            Welfare B/F.
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col"
                        class="px-2 uppercase hover:underline dark:text-gray-400 dark:hover:text-white  hover:cursor-pointer hidden md:table-cell"
                        @click="orderByTotal()">
                        <div class="flex items-center">
                            T.Welfares.
                            <a>
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td scope="col"
                        class="px-2 uppercase hover:underline  dark:text-gray-400 dark:hover:text-white hover:cursor-pointer">
                        <div class="flex items-center">
                            Options.
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 font-boldened text-base uppercase"
                    v-for="(welfare, index) in allWelfares">
                    <td scope="row" class="py-4">
                        <span class="uppercase text-gray-900 whitespace-nowrap dark:text-white text-sm">
                            {{ welfare.id }}.
                        </span>
                    </td>
                    <td scope="row" class="px-2 py-4">
                        <a @click="getRoute(welfare.member_id)"
                            class="cursor-pointer hover:underline dark:hover:text-cyan-600 uppercase text-gray-900 whitespace-nowrap dark:text-white">
                            <span class="md:text-2xl text-base">
                                {{ welfare.member.name }}
                            </span>
                        </a>
                    </td>
                    <td class="px-2 py-4">
                        <span v-if="welfare.type == 0">
                            <span class="text-rose-500 uppercase underline text-lg">
                                Owed
                            </span>
                        </span>
                        <span v-else>
                            <span class="text-emerald-500 uppercase underline text-lg">
                                Paid
                            </span>
                        </span>
                    </td>
                    <td class="px-2 py-4" v-if="classInfo.welfarePaid">
                        <div class="text-blue-500 text-base">
                            <div class="font-normal underline">
                                ksh {{ Number(welfare.payment).toLocaleString() }}
                            </div>
                            <div class="font-normal text-xs dark:text-gray-300">
                                {{ moment(welfare.created_at).fromNow() }}
                            </div>
                        </div>
                    </td>
                    <td class="px-2 py-4" v-if="classInfo.welfareOwed">
                        <span v-if="welfare.type == 0">
                            <span class="text-red-500 underline text-base">
                                ksh {{ Number(welfare.payment).toLocaleString() }}
                            </span>
                        </span>
                        <span v-else>
                            <span class="text-red-500 underline text-base">
                                ksh 0
                            </span>
                        </span>
                    </td>
                    <td class="px-2 py-4 hidden md:table-cell">
                        <div class="text-orange-500 text-base">
                            <div class="font-normal underline">
                                ksh {{ Number(welfare.member.welfare_before).toLocaleString() }}
                            </div>
                            <div class="font-normal text-xs dark:text-gray-300">
                                {{ moment(welfare.created_at).fromNow() }}
                            </div>
                        </div>
                    </td>
                    <td class="px-2 py-4 hidden md:table-cell">
                        <span class="text-green-500 underline text-base" v-if="welfare.member.welfare_total > 0">
                            ksh {{ Number(welfare.member.welfare_total).toLocaleString() }}
                        </span>
                        <span class="text-red-500 underline text-base" v-else>
                            ksh {{ Number(welfare.member.welfare_total).toLocaleString() }}
                        </span>
                    </td>
                    <td class="px-2 py-4">
                        <div class="inline-flex rounded-md space-x-1" role="group">
                            <!-- edit  -->
                            <button type="button"
                                class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-cyan-700 dark:hover:text-cyan-400"
                                @click="showWelfare(welfare)">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                                <!-- Edit -->
                            </button>
                            <!-- delete  -->
                            <button type="button"
                                class="inline-flex items-center p-2 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-red-700 dark:hover:text-red-400"
                                @click="showWelfareDelete(welfare)">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5">
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
    <!--end welfares table  -->

    <loadingTable v-else>
    </loadingTable>

    <!-- update welfare modal  -->
    <welfaresupdate :info=classInfo.modalData :show=classInfo.isOpen :name=classInfo.modalName :cycle=props.cycle.name
        :payment=numFormat(classInfo.modalData.payment) @reload=getInfo @close=closeWelfare>
    </welfaresupdate>
    <!-- end update Welfare modal  -->

    <!-- delete welfare modal  -->
    <welfaresdelete :info=classInfo.deleteData :show=classInfo.isDeleteOpen :name=classInfo.modalName
        :url=classInfo.deleteWelfURL :payment=numFormat(classInfo.deleteData.payment) @reload=getInfo
        @close=closeWelfareDelete></welfaresdelete>
    <!-- end delete payment modal  -->
</template>

<script setup>
    import { reactive, computed, defineEmits, onMounted, defineProps, watch} from 'vue';
    import { router } from '@inertiajs/vue3';

    import moment from 'moment';
    
    const props = defineProps({
        cycle: {
            type: Object,
            required: true,
        },
    })

    const type = computed(() => props.cycle);

    watch(type, (newValue) => {
        classInfo.isLoading = true;
        getInfo();
    })

    const classInfo = reactive ({
        btn1: 'Add Welfares',
        btn2: 'Show All Welfares',
        btn3: 'Show All Paid Welfares',
        btn4: 'Show All Welfares Owed',

        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        borderClass: 'border-[3px] border-cyan-300 dark:border-cyan-700',
        mainHeader: 'font-boldened text-3xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1',

        info: [],
        welfareOption: 'text-gray-800 text-base dark:text-white bg-transparent dark:bg-transparent hover:text-slate-300 dark:hover:text-teal-300 p-2 text-center cursor-pointer',
        svgOption: 'md:w-8 md:h-8 w-4 h-4',

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
        deletePayURL: '/delete/welfare/',

        // sort 
        ascending: true,
        sortBy: 'id',

        alertType: '',
        flashMessage: '',

        welfarePaid: true,
        welfareOwed: true,
        isLoading: true,
    })

    const allWelfares = computed(() => {
        let tempWelfares = classInfo.info

        // search rows 
        if (classInfo.search != '' && classInfo.search) {
            tempWelfares = tempWelfares.filter((welfare) => {
                return welfare.member.name
                    .toUpperCase()
                    .includes(classInfo.search.toUpperCase())
            })
        }

        // Sort Welfares
        tempWelfares = tempWelfares.sort((a, b) => {
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
            } else if (classInfo.sortBy == 'payment') {
                return a.payment - b.payment
            } else if (classInfo.sortBy == 'welfare_before') {
                return a.member.welfare_before - b.member.welfare_before
            } else if (classInfo.sortBy == 'welfare_total') {
                return a.member.welfare_total - b.member.welfare_total
            }
        })

        // Show sorted array in descending or ascending order
        if (!classInfo.ascending) {
            tempWelfares.reverse()
        }

        return tempWelfares
    })

    onMounted(() => {
        classInfo.isLoading = true;
        getInfo();
    })

    const emit = defineEmits(['flash','progress','switch']);

    function getInfo() {
        axios.get('/api/getCycle/'+ props.cycle.id)
            .then(
                ({ data }) => {
                    classInfo.info    = data[2];
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

                        // flashMessage 
                        classInfo.flashMessage   = member.name + ' balance: ksh ' + balance + ' cleared!';
                        classInfo.alertType      = 'info';
                        LoadingOff();
                    });
        }
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
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' descending';
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
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function orderByWelfares() {
        LoadingOn();

        classInfo.welfareOwed = false;
        classInfo.welfarePaid = true;

        classInfo.sortBy = 'payments';

        // flash message 
        classInfo.ordername = 'TOTAL PAYMENTS';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function orderByWelfareOwed() {
        classInfo.welfareOwed = true;
        classInfo.welfarePaid = false;
        LoadingOn();

        classInfo.sortBy = 'payments_sum';

        // flash message 
        classInfo.ordername = 'TOTAL PAYMENTS CONTRIBUTED';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function orderByBefore() {
        LoadingOn();

        classInfo.sortBy = 'welfare_before';

        // flash message 
        classInfo.ordername = 'TOTAL AMOUNT CONTRIBUTED BEFORE';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function orderByTotal() {
        LoadingOn();

        classInfo.sortBy = 'welfare_total';

        // flash message 
        classInfo.ordername = 'TOTAL WELFARE AMOUNT';
        if(classInfo.ascending) {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            classInfo.flashMessage   = 'Welfares Sorted By: ' + classInfo.ordername + ' descending';
        }
        classInfo.alertType          = 'info';
        LoadingOff();
    }

    function tabSwitch2() {
        emit('switch');
    }

    function getRoute(a) {
        let url = '/member/' + a;

        router.visit(url, { preserveScroll: true });
    }

    function welfareAll() {
        getInfo();
        classInfo.welfareOwedClass    = false;
        classInfo.welfareInClass      = false;

        classInfo.welfarePaid = true;
        classInfo.welfareOwed = true;

        classInfo.flashMessage   = 'Showing All '+ props.cycle.name +' ( ' + classInfo.info.length + ' ) Welfares!';
        classInfo.alertType      = 'info';
        LoadingOff();
    }
    
    function welfareIn() {
        LoadingOn();
        classInfo.welfarePaid = true;
        classInfo.welfareOwed = false;
        axios.get('/api/getWelfares/in/'+ props.cycle.id)
            .then(
                ({ data }) => {
                    classInfo.info = data[0];
                    classInfo.welfareOwedClass = false;
                    classInfo.welfareInClass   = true; 
                    classInfo.flashMessage   = 'Showing All Paid '+ props.cycle.name +' ( ' + classInfo.info.length + ' ) Welfares!';
                    classInfo.alertType      = 'success';
                    LoadingOff();
                });
    }

    function welfareOwed() {
        LoadingOn();
        classInfo.welfarePaid = false;
        classInfo.welfareOwed = true;
        axios.get('/api/getWelfares/out/'+ props.cycle.id)
            .then(
                ({ data }) => {
                    classInfo.info = data[0];
                    classInfo.welfareOwedClass = true;
                    classInfo.welfareInClass   = false; 
                    classInfo.flashMessage   = 'Showing All Owed '+ props.cycle.name +' ( ' + classInfo.info.length + ' ) Welfares!';
                    classInfo.alertType      = 'danger';
                    LoadingOff();
                });
    }

    // welfare modal 
    function showWelfare(welfare) {
        classInfo.modalData = welfare;
        classInfo.isOpen = true;
        classInfo.modalName = welfare.member.name;
    }

    function closeWelfare() {
        classInfo.isOpen        = false;
        classInfo.modalData            = {};
    }

    function showWelfareDelete(welfare) {
        classInfo.deleteData = welfare;
        classInfo.deleteID = welfare.id;
        classInfo.isDeleteOpen = true;
        classInfo.modalName = welfare.member.name;
    }

    function closeWelfareDelete() {
        classInfo.isDeleteOpen = false;
        classInfo.deleteData = {};
        classInfo.deleteID = '';
    }
</script>