<template>
    <!-- header  -->
    <section class="font-normal text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 grid grid-cols-3 md:grid-cols-3">
        <section class="flex flex-col col-span-2 w-full">
            <span class="underline text-2xl md:text-4xl">{{ member.name }}.</span>
            <span class="text-gray-500 md:text-base sm:text-sm">{{ member.telephone }}</span>
        </section>
        
        <div class="inline-flex rounded-md shadow-sm space-x-1 justify-end col-auto" role="group">
            <!-- clear  -->
            <button type="button" :class="member.welfare_out > 0 ? 'inline-flex items-center p-2 text-sm font-medium text-amber-500 bg-transparent rounded-md hover:text-white focus:z-10 dark:text-amber-500 dark:hover:text-amber-500' : 'inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white focus:z-10 dark:text-emerald-600 dark:hover:text-emerald-600'" v-tooltip="{ content: classInfo.btn1.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}"
                @click="showClearMember(member)">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="[classInfo.svgClass]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                </svg>
            </button>
            <!-- edit  -->
            <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white focus:z-10 dark:text-cyan-700 dark:hover:text-cyan-600" v-tooltip="{ content: classInfo.btn2.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}"
                @click="showMember(member)">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="[classInfo.svgClass]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
            </button>
            <!-- delete  -->
            <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-white focus:z-10 dark:text-red-700 dark:hover:text-red-600" v-tooltip="{ content: classInfo.btn3.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}"
                @click="showDelete(member)">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="[classInfo.svgClass]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
            <!-- download  -->
            <a type="button" class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white focus:z-10 dark:text-cyan-700 dark:hover:text-cyan-600" v-tooltip="{ content: classInfo.btn4.toUpperCase(), placement: 'top', trigger: 'hover', distance: '10', skidding: '0', popperClass: 'v-popper__theme-main animate__animated animate__fadeIn'}" @click="downloadLedger(member.id)">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="[classInfo.svgClass]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                </svg>
            </a >
        </div>
    </section>
    <!-- end header  -->

    <!-- member status -->
    <section class="font-normal text-xl leading-tight uppercase py-1 w-full inline-flex justify-between">
        <span class="text-gray-800 dark:text-gray-300">MEMBER STATUS:</span>
        <span class="text-green-800 dark:text-green-500 underline underline-offset-4 md:text-3xl sm:text-xl" v-if="member.active">
            ACTIVE
        </span>
        <span class="text-red-800 dark:text-red-500 underline underline-offset-4 md:text-3xl sm:text-xl" v-else>
            INACTIVE
        </span>
    </section>
    <!-- end member status -->

    <!-- progress bar  -->
    <progressInfo
        :name1 = '"Payments"'
        :name2 = '"Welfares"'
        :name3 = '"Owed"'
        :percent1 = payPercent
        :percent2 = welPercent
        :percent3 = owePercent
    ></progressInfo>
    <!-- end progress bar  -->

    <!-- clear member arrears modal  -->
    <clearWelfares
        :info   = classInfo.modalData
        :show   = classInfo.isClearOpen
        @reload = resetMembers
        @close  = closeClearMember
    ></clearWelfares>
    <!-- end clear member arrears modal  -->

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
        :url    = classInfo.deleteURL
        @reload = resetMembers
        @close  = closeDelete
    ></membersdelete>
    <!-- end delete member modal  -->

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
    import { defineProps, defineEmits, reactive, onMounted } from 'vue'

    const emit = defineEmits(['reload'])

    const props = defineProps({
        member: {
            type: String,
            required: true,
        },
        payPercent: {
            type: String,
            required: true,
        },
        welPercent: {
            type: String,
            required: true,
        },
        owePercent: {
            type: String,
            required: true,
        }
    });

    const classInfo = reactive({
        btn1: '',
        btn2: '',
        btn3: '',
        btn4: '',

        isOpen: false,
        isClearOpen: false,
        isOpenInfo: false,
        isDebtOpen: false,
        modalData: {},

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',
        deleteURL: '/delete/member/reset/',

        svgClass: 'md:w-8 md:h-8 w-4 h-4'
    })

    onMounted(() => {
        set()
    })

    function set() {
        let name = 'Member';

        classInfo.btn1 = 'Clear '+ name + ' Welfares';
        classInfo.btn2 = 'Update '+ name;
        classInfo.btn3 = 'Delete '+ name;
        classInfo.btn4 = 'Download '+ name + ' Excelsheet';
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

    function showClearMember(member) {
        classInfo.modalData = member;
        classInfo.isClearOpen    = true;
    }

    function closeClearMember() {
        classInfo.isClearOpen    = false;
        classInfo.modalData = {};
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

    function downloadLedger(a) {

        let name = props.member.name;
        alerts.flashMessage   = 'Download ' + name + ' Payments and Welfare Ledger!';
        alerts.linkName       = 'Download Member Excelsheet';
        alerts.alertType      = 'info';
        alerts.linkUrl        = '/download/current/member/' + a;
        alerts.linkState      = true;
        alerts.alertBody      = alerts.alertInfo;
        alerts.alertShowView  = !alerts.alertShowView;
    }

    const alerts = reactive({
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

    // reset
    function resetMembers() {
        // let link = 'desc';
        // let linkTo = 'id/';

        // axios.get('/api/getMembers/' + linkTo + link)
        //     .then(
        //         ({ data }) => {
        //             classInfo.info = data[0];
        //             // orderByID();
        //         });

        emit('reload')
    }
    // end modal functions 
</script>