<template>
    <div class="flex-col space-y-2" id="member" role="tabpanel" aria-labelledby="member-tab">

        <section class="grid grid-cols-1 md:grid-cols-5 gap-1">
            <!-- forms  -->
            <membersform
                :count      = classInfo.info.length
                @flash      = flashReload
                @loading    = flashLoading
                @reload     = getInfo
            ></membersform>

            <!-- table  -->
            <memberstable
                :members = classInfo.info
                :loading = classInfo.isLoading
                @flash   = flashReload
                @reload  = getInfo
            ></memberstable>
        </section>

        <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-cyan-300/30 border-cyan-800/20">
    </div>

     <!-- flash alert  -->
    <alert
        :alertshow  = classInfo.alertShow
        :message    = classInfo.flashMessage
        :class      = classInfo.alertBody
        :type       = classInfo.alertType
        :title      = classInfo.alertType
        :time       = classInfo.alertDuration
    ></alert>

    <alertview
        :alertshowview  = classInfo.alertShowView
        :message        = classInfo.flashMessage
        :class          = classInfo.alertBody
        :link           = classInfo.linkName
        :url            = classInfo.linkUrl
        :state          = classInfo.linkState
        :type           = classInfo.alertType
        :title          = classInfo.alertType
    ></alertview>
</template>

<script setup>
    import { reactive, onBeforeMount, defineEmits } from 'vue'

    const props = defineProps({
        route: {
            type: String,
            required: true,
        }
    })
    
    const classInfo = reactive ({
        routeCheck: false,
        isLoading: false,

        info: [],

        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        borderClass: 'border-[3px] border-cyan-600 dark:border-cyan-700',
        mainHeader: 'font-boldened text-2xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1',

        // tabs settings 
        viewShow: false,
        headerMain: 'font-normal text-[1.95rem] text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 w-full inline-flex justify-between my-1 hover:text-cyan-500 dark:hover:text-cyan-500 cursor-pointer',

        // alerts
        alertShow: false,
        alertShowView: false,
        alertType: '',
        flashMessage: '',
        alertDuration: 15000,
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',

        link: ''
    })

    onBeforeMount(() => {
        getInfo()
    })

    const emit = defineEmits(['changed'])

    function getInfo() {
        classInfo.isLoading = true;
        let link    = 'asc';
        let linkTo  = 'id/';

        axios.get('/api/getMembers/' + linkTo + link)
            .then(
                ({ data }) => {
                    classInfo.info      = data[0];
                    classInfo.isLoading = false;
                    emit('changed', classInfo.info.length)
                });
    }

    function flashReload(message, body) {
        if (body == 'success') {
            classInfo.alertBody = classInfo.alertSuccess; 
        } 
        if(body == 'info') {
            classInfo.alertBody = classInfo.alertInfo;
        } 
        if(body == 'warning') {
            classInfo.alertBody = classInfo.alertWarning;
        } 
        if(body == 'danger') {
            classInfo.alertBody = classInfo.alertDanger; 
        }

        classInfo.flashMessage   = message;
        classInfo.alertType      = body;
        classInfo.alertShow      = !classInfo.alertShow;
    }

    function flashLoading() {
        classInfo.flashMessage   = 'Loading! Please Wait';
        classInfo.alertType      = 'warning';
        classInfo.alertBody      = classInfo.alertWarning;
        classInfo.alertDuration  = 60000;
        classInfo.isLoading      = true;
        classInfo.alertShow      = !classInfo.alertShow;
    }
</script>