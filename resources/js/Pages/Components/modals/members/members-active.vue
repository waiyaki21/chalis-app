<template>
    <Modal :show=classInfo.isOpen>
        <section class="p-2 font-boldened">
            <div class="w-full inline-flex justify-between mb-2 p-2">
                <h2 class="font-normal text-3xl text-red-800 dark:text-red-600 leading-tight uppercase underline py-1 w-full">
                    Switch Active State.
                </h2>

                <button @click="closeModal" :class="[classInfo.modalCloseBtn]">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <section class="flex w-full justify-center text-center my-1 bg-orange-100/10 border border-orange-500 rounded-lg py-4 shadow-lg">
                <h3 class="font-normal sm:text-lg md:text-xl text-orange-500 dark:text-orange-500 uppercase py-1 w-full decoration-orange-500 font-sans">
                    Are you sure you want to switch {{ classInfo.modalData.name }}'s active state?
                </h3>
            </section>

            <!-- member status -->
            <section class="font-normal text-xl leading-tight uppercase py-1 w-full inline-flex justify-between font-boldened my-2">
                <span class="text-gray-800 dark:text-gray-300 md:text-3xl sm:text-xl">MEMBER STATE:</span>
                <span class="text-green-800 dark:text-green-500 underline underline-offset-4 md:text-3xl sm:text-xl font-medium" v-if="classInfo.modalData.active">
                    ACTIVE
                </span>
                <span class="text-red-800 dark:text-red-500 underline underline-offset-4 md:text-3xl sm:text-xl font-medium" v-else>
                    INACTIVE
                </span>
            </section>
            <!-- end member status -->

            <section class="inline-flex w-full justify-between space-x-1">
                <button class="w-3/5 focus:outline-none text-white bg-teal-700 hover:bg-teal-600 focus:ring-1 focus:ring-teal-300 font-medium rounded-md text-base px-5 py-2.5 mr-2 mb-2 dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-900 cursor-pointer uppercase shadow hover:shadow-md dark:border-2 dark:border-teal-900" @click="activeInfo" v-if="!classInfo.modalData.active">
                    SWITCH: <span class="font-medium underline">ACTIVE</span>
                </button>
                <button class="w-3/5 focus:outline-none text-white bg-cyan-700 hover:bg-cyan-600 focus:ring-1 focus:ring-cyan-300 font-medium rounded-md text-base px-5 py-2.5 mr-2 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-red-900 cursor-pointer uppercase shadow hover:shadow-md dark:border-2 dark:border-cyan-900" @click="activeInfo" v-if="classInfo.modalData.active">
                    SWITCH: <span class="font-medium underline">INACTIVE</span>
                </button>
                <button type="button" class="w-2/5 text-white bg-blue-700 hover:bg-red-800 focus:ring-1 focus:ring-red-300 font-medium rounded text-base px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-blue-800 shadow hover:shadow-md dark:border dark:border-red-900 uppercase" @click="closeModal">
                    No
                </button>
            </section>

        </section>
    </Modal>

    <!-- flash alert  -->
    <alert
        :alertshow  = alerts.alertShow
        :message    = alerts.flashMessage
        :class      = alerts.alertBody
        :type       = alerts.alertType
        :title      = alerts.alertType
        :time       = alerts.alertDuration
    ></alert>
</template>

<script setup>
    import { defineProps, reactive, computed, watch, defineEmits, onMounted, onUnmounted } from 'vue'

    const emit = defineEmits(['reload', 'close'])

    const props = defineProps({
        info: {
            type: Object,
            required: true,
        },
        show : {
            type: Boolean,
            required:true
        }
    });

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
        alertType: '',
        alertDuration: 15000,
        flashMessage: '',
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[4px] border-teal-800 dark:border-teal-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',
    })

    // classes 
    const classInfo = reactive({
        // active info 
        isOpen: false,
        modalData: {},
        modalID: '',

        modalURL: '/active/member/',

        modalCloseBtn: 'cursor-pointer dark:text-red-800 text-red-500 transition-transform hover:rotate-180 w-6 h-6 hover:w-8 hover:h-8'
    })

    function showModal(info) {
        classInfo.modalData   = info;
        classInfo.modalID     = info.id;
        classInfo.isOpen = props.show;
    }

    function closeModal() {
        classInfo.modalData   = {};
        classInfo.modalID     = '';
        emit('close');
        classInfo.isOpen = props.show;
    }

    function activeInfo() {
        let url  = classInfo.modalURL + classInfo.modalID;
        let name = classInfo.modalData.name;

        axios.get(url)
            .then(
                ({ data }) => {
                    closeModal(),

                    // flashMessage 
                    alerts.flashMessage = name + ': Member State Switched!';
                    alerts.alertBody = 'info';
                    flashShow(alerts.flashMessage, alerts.alertBody);
                    emit('reload');
                });
    }

    function flashShow(message, body) {
        alerts.alertType = body;
        alerts.flashMessage   = message;
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
</script>