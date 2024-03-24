<template>
    <!-- update member modal  -->
    <Modal :show=classInfo.isOpen>
        <section class="p-2">
            <div class="w-full inline-flex justify-between mb-2 p-2">
                <h2
                    class="font-boldened sm:text-base md:text-2xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 w-full">
                    Edit {{ classInfo.modalData.name }} Info.
                </h2>

                <button @click="closeModal" :class="[classInfo.modalCloseBtn]">
                    <svg paymentfill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-2 py-1 font-boldened">
                <!-- update member form  -->
                <form @submit.prevent="submitEdit" class="p-2 flex-col space-y-1">

                    <section class="inline-flex w-full justify-between space-x-2">
                        <div class="w-full">
                            <InputLabel for="name" value="name" />

                            <TextInput id="name" type="name" v-model="formedit.name"
                                :placeholder="classInfo.modalData.name" required autofocus />

                            <InputError class="mt-2" :message="formedit.errors.name" />
                        </div>

                        <div class="w-full">
                            <InputLabel for="telephone" value="telephone" />

                            <TextInput id="telephone" type="name" v-model="formedit.telephone"
                                :placeholder="classInfo.modalData.telephone" required autofocus />

                            <InputError class="mt-2" :message="formedit.errors.telephone" />
                        </div>
                    </section>


                    <section class="inline-flex w-full justify-between space-x-2">
                        <div class="w-full">
                            <InputLabel for="amount_before" value="T.Contributions Before" />

                            <TextInput id="amount_before" type="number" v-model="formedit.amount_before"
                                :placeholder="classInfo.modalData.amount_before" required autofocus />

                            <InputError class="mt-2" :message="formedit.errors.amount_before" />
                        </div>

                        <div class="w-full">
                            <InputLabel for="welfare_before" value="T.Welfare Before" />

                            <TextInput id="welfare_before" type="number" v-model="formedit.welfare_before"
                                :placeholder="formedit.welfare_before" autofocus />

                            <InputError class="mt-2" :message="formedit.errors.welfare_before" />
                        </div>
                    </section>

                    <section class="inline-flex w-full justify-between space-x-2">
                        <div class="w-full">
                            <InputLabel for="welfareowed_before" value="T.Welfare Owed Before" />

                            <TextInput id="welfareowed_before" type="number" v-model="formedit.welfareowed_before"
                                :placeholder="formedit.welfareowed_before" autofocus />

                            <InputError class="mt-2" :message="formedit.errors.welfareowed_before" />
                        </div>

                        <div class="w-full">
                            <InputLabel for="active" value="Member Active" />

                            <select id="active" v-model="formedit.active" name="active"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full">
                                <option v-if="formedit.active" :value="1">
                                    <span>Active</span>
                                </option>
                                <option v-if="formedit.active" :value="0">
                                    <span>Inactive</span>
                                </option>

                                <option v-if="!formedit.active" :value="0">
                                    <span>Inactive</span>
                                </option>
                                <option v-if="!formedit.active" :value="1">
                                    <span>Active</span>
                                </option>
                            </select>
                        </div>
                    </section>

                    <section class="inline-flex w-full justify-between space-x-2">
                        <div class="flex items-center w-full justify-start mt-4">
                            <SubmitButton @click="submitEdit(classInfo.modalData.id)" :disabled="formedit.processing"
                                :loading="formedit.processing" :success="formedit.wasSuccessful"
                                :failed="formedit.hasErrors" :editting="formedit.isDirty">
                                Update Member
                            </SubmitButton>
                        </div>
                    </section>
                </form>
                <!-- end update member form  -->
            </div>
        </section>
    </Modal>
    <!-- end update member modal  -->

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

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',

        modalCloseBtn: 'cursor-pointer dark:text-cyan-800 text-cyan-500 transition-transform hover:rotate-180 w-6 h-6 hover:w-8 hover:h-8'
    })

    const formedit = useForm({
        name: '',
        telephone: '',
        amount_before: '',
        welfare_before: '',
        welfareowed_before: '',
        active: '',
    })

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

    function clearFields() {
        formedit.name           = '';
        formedit.telephone      = '';
        formedit.amount_before  = '';
        formedit.welfare_before = '';
        formedit.active         = '';
    }

    function formFields(info) {
        formedit.name               = info.name;
        formedit.telephone          = info.telephone;
        formedit.amount_before      = info.amount_before;
        formedit.welfare_before     = info.welfare_before;
        formedit.welfareowed_before = info.welfareowed_before;
        formedit.active             = info.active;
    }

    function submitEdit(id) {
        let url  = '/update/member/' + classInfo.modalData.id;
        let name = classInfo.modalData.name;

        formedit.put(url, {
            onFinish: () => [
                clearFields(),
            ],

            onSuccess: () => [
                closeModal(),
                alerts.flashMessage   = name + ': Member Info Editted',
                alerts.alertType      = 'success',
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
</script>