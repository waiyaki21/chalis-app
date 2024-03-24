<template>
    <!-- update welfares modal  -->
    <Modal :show=classInfo.isOpen>
        <section class="p-2">
            <div class="w-full inline-flex justify-between mb-2 p-2">
                <h2
                    class="font-boldened text-2xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 w-full">
                    Edit {{ props.name }}'s Welfare
                </h2>

                <button @click="closeModal" :class="[classInfo.modalCloseBtn]">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <h2 class="font-sans inline-flex justify-between text-base text-gray-800 dark:text-gray-300 p-2 w-full">
                <span>CYCLE: <u class="font-boldened font-medium text-xl uppercase">{{ classInfo.modalData.cycle.name
                        }}</u></span>
                <span>PAYMENT: <u class="font-boldened font-medium text-xl uppercase"> ksh {{ props.payment
                        }}</u></span>
            </h2>

            <div class="p-2 font-boldened">
                <!-- update Welfare form  -->
                <form @submit.prevent="submitEdit" class="">
                    <div>
                        <InputLabel for="payment" value="payment" />

                        <TextInput id="payment" type="number" v-model="formedit.payment" :placeholder="formedit.payment"
                            required autofocus />

                        <InputError class="mt-2" :message="formedit.errors.payment" />
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <SubmitButton @click="submitEdit(classInfo.modalData.id)"  :disabled="formedit.processing" :loading="formedit.processing" :success="formedit.wasSuccessful" :failed="formedit.hasErrors" :editting="formedit.isDirty">
                            Update Welfare
                        </SubmitButton>
                    </div>
                </form>
                <!-- end update Welfare form  -->
            </div>
        </section>
    </Modal>
    <!-- end update welfares modal  -->

    <!-- flash alert  -->
    <alert :alertshow=alerts.alertShow :message=alerts.flashMessage :class=alerts.alertBody :type=alerts.alertType
        :title=alerts.alertType :time=alerts.alertDuration></alert>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
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
        },
        name : {
            type: String,
            required: true
        }, 
        payment: {
            type: String,
            required: true
        },  
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
        alertSuccess: 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',
    })

    // classes 
    const classInfo = reactive({
        // modals 
        isOpen: false,
        modalData: {},

        modalCloseBtn: 'cursor-pointer dark:text-cyan-800 text-cyan-500 transition-transform hover:rotate-180 w-6 h-6 hover:w-8 hover:h-8'
    })

    const formedit = useForm({
        payment: '',
    })

    function showModal(info) {
        formFields(info);
        classInfo.modalData = info;
        classInfo.isOpen    = props.show;
    }

    function closeModal() {
        classInfo.modalData          = {};
        formedit.member_id           = '';
        formedit.payment             = '';
        clearFields();
        emit('close');
        classInfo.isOpen            = props.show;
    }

    function clearFields() {
        formedit.member_id           = '';
        formedit.payment             = '';
    }

    function formFields(info) {
        formedit.member_id = info.member_id;
        formedit.payment   = info.payment;
    }

    function submitEdit(id) {
        let url     = '/update/welfare/' + id;
        let amnt    = classInfo.modalData.payment;

        formedit.put(url, {
            onFinish: () => [
                clearFields()
            ],

            onSuccess: () => [
                alerts.flashMessage   = 'ksh' + amnt + ' Welfare Updated Successfully!',
                alerts.alertType      = 'success',
                closeModal(),
                flashShow(alerts.flashMessage, alerts.alertType),
                emit('reload')
            ],

            onError: () => [
                alerts.flashMessage   = 'Failed! Try Again',
                alerts.alertType      = 'danger',
                flashShow(alerts.flashMessage, alerts.alertType),
            ] 
        });
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

        alerts.alertShow      = !alerts.alertShow;
    }
</script>