<template>
    <!-- cycles form  -->
    <form @submit.prevent="submit">

        <div class="items-center justify-center w-full grid grid-cols-6 gap-2">
            <section class="col-span-2 mt-6">
                <div>
                    <InputLabel for="name" value="name" />

                    <TextInput id="name" type="name" v-model="form.name" required autofocus
                        v-if="form.errors.name != null" />

                    <TextInput id="name" type="name" v-model="form.name" required autofocus disabled="true"
                        class="hover:cursor-not-allowed  opacity-50 uppercase" v-else />

                    <InputError class="mt-2" :message="form.errors.name" />

                    <LabelHelper for="name" value="Automatically Set" v-if="form.errors.name == null" />
                </div>
            </section>
            <section class="col-span-2">
                <InputLabel for="month" value="Cycle Month" class="w-full" />

                <div class="inline-flex items-center justify-center w-full space-x-2">
                    <select id="month" v-model="form.month" name="month"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full uppercase"
                        @click="checkExist()">
                        <option :value="moment().startOf('month').format('MMMM')" selected>{{
                            moment().startOf('month').format('MMMM') }}</option>
                        <option :value="month.toUpperCase()" v-for="month in months">{{ month.toUpperCase() }}</option>
                    </select>
                </div>
            </section>
            <section class="col-span-2">
                <InputLabel for="year" value="Cycle year" class="w-full" />

                <select id="year" v-model="form.year" name="year"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full"
                    @click="checkExist()">
                    <option :value="moment().year()" selected>{{ moment().year() }}</option>
                    <option :value="moment().year() + 1">{{ moment().year() + 1 }}</option>
                    <option :value="moment().year() + 2">{{ moment().year() + 2 }}</option>
                    <option :value="moment().year() + 3">{{ moment().year() + 3 }}</option>
                </select>
            </section>
        </div>

        <div>
            <InputLabel for="date" value="date" />

            <TextInput id="date" type="date" v-model="form.date" required autofocus />

            <InputError class="mt-2" :message="form.errors.date" />
        </div>

        <div class="items-center justify-center w-full grid grid-cols-2 gap-2">
            <div class="col-span-1">
                <InputLabel for="amount" value="Contribution" />

                <TextInput id="amount" type="number" v-model="form.amount" autofocus />

                <InputError class="mt-2" :message="form.errors.amount" />
            </div>

            <div class="col-span-1">
                <InputLabel for="welfare_amnt" value="Welfare" />

                <TextInput id="welfare_amnt" type="number" v-model="form.welfare_amnt" autofocus />

                <InputError class="mt-2" :message="form.errors.welfare_amnt" />
            </div>
        </div>

        <div class="flex items-center justify-start mt-4">
            <SubmitButton :disabled="form.processing" :loading="form.processing" :success="form.wasSuccessful"
                :failed="form.hasErrors" :editting="form.isDirty">
                Submit Cycle
            </SubmitButton>
        </div>
    </form>

    <hr class="w-[80%] text-gray-800 dark:text-gray-300/30 my-2 mx-auto border-t-4 dark:border-gray-300/30">

    <!-- flash alert  -->
    <alert :alertshow=alerts.alertShow :message=alerts.flashMessage :class=alerts.alertBody :type=alerts.alertType
        :title=alerts.alertType :time=alerts.alertDuration></alert>

    <alertview :alertshowview=alerts.alertShowView :message=alerts.flashMessage :class=alerts.alertBody
        :link=alerts.linkName :url=alerts.linkUrl :state=alerts.linkState></alertview>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';

    //moment 
    import moment from 'moment';

    import { defineProps, reactive, computed, onBeforeMount, defineEmits } from 'vue';

    const emit = defineEmits(['reload','loading'])
    
    const props = defineProps({
        settings: {
            type: Object,
            required: true,
        },
    })

    const months = computed(() => {
        const end   = moment().startOf('year')
        const start = moment().endOf('year')
        // console.log(end, start);
        let results = []
        let current = start
        while (end.format('MMMM YYYY') !== start.format('MMMM YYYY')) {
            results.push(current.format('MMMM'))
            current = current.subtract(1, 'month')
        }
        // need to add current one last time because the loop will have ended when it is equal to the end date, and will not have added it
        results.push(current.format('MMMM'))

        let list = results.reverse();

        return list;
    })

    const getName = computed(() => {
        let month = form.month;
        let year  = form.year;

        let name = month +' '+ year;

        return name;
    })

    const downloadState = computed(() => {
        if (classInfo.month != '' && classInfo.year != '') {
            classInfo.submitBtn = classInfo.templateActive;
            return classInfo.submitBtn;
        } else {
            classInfo.submitBtn = classInfo.templateInactive;
            return classInfo.submitBtn;
        }
    })

    const form = useForm({
        name: '',
        date: '',
        month: '',
        year: '',
        amount: '',
        welfare_amnt: ''
    })

    const classInfo = reactive({
        isLoading: false,
        info: [],

        infoSection: 'w-full m-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-300 mb-2 text-2xl text-left font-normal underline tracking-tight uppercase',
        borderClass: 'overflow-hidden font-boldened flex-col  space-y-1 justify-between p-2 md:m-2 sm:m-0.5 sm:my-1 rounded-lg bg-gray-300 dark:bg-gray-800/50 shadow-md sm:rounded-lg border-[3px] border-cyan-300 dark:border-cyan-700',
        mainHeader: 'font-boldened text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 md:text-3xl text-2xl',

        year: moment().year(),
        monthTrue: false,
        yearTrue: true,
        
        // template btns 
        submitBtn: '',
        templateInactive: 'text-white bg-gradient-to-r from-rose-500 to-red-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-rose-300 dark:focus:ring-rose-800 font-medium rounded-lg text-sm px-4 py-3 text-center me-2 inline-flex justify-center cursor-not-allowed w-full',
        templateActive: 'text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-base px-4 py-3 text-center me-2 inline-flex justify-center uppercase w-full',

        // exist records 
        exist: false,
        members_existing : '',
        members_left     : '',
        members_count    : '',
    })

    const alerts = reactive({
        // alerts
        alertShow: false,
        alertShowView: false,
        alertDuration: 15000,
        alertType: '',
        flashMessage: '',
        alertBody: 'border-b-[4px] border-gray-500 shadow-gray-900 dark:shadow-gray-900 bg-gray-100 dark:bg-gray-500',
        alertSuccess: 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
        alertInfo: 'border-b-[4px] border-blue-800 dark:border-blue-800 shadow-blue-900 dark:shadow-blue-900 bg-blue-100 dark:bg-blue-500',
        alertWarning: 'border-b-[4px] border-orange-800 dark:border-orange-800 shadow-orange-900 dark:shadow-orange-900 bg-orange-100 dark:bg-orange-500',
        alertDanger: 'border-b-[4px] border-red-800 dark:border-red-800 shadow-red-900 dark:shadow-red-900 bg-red-100 dark:bg-red-500',
        linkName: '',
        linkUrl: '',
        linkState: false,
    })

    onBeforeMount(() => {
        setFields()
    })

    function checkExist() {
        axios.get('/cycle/exist/' + form.month + '/' + form.year)
            .then(
                ({ data }) => {
                    if (data[0] > 0) {
                        classInfo.cycle_exist = true;
                        // reset
                        classInfo.month = '';
                        classInfo.monthTrue = false;
                        // flashMessage 
                        alerts.flashMessage = data[1];
                        alerts.alertBody = 'danger';
                        flashShow(alerts.flashMessage, alerts.alertBody);
                    } else {
                        classInfo.cycle_exist = false;
                        // flashMessage 
                        alerts.flashMessage = data[1];
                        alerts.alertBody = 'success';
                        flashShow(alerts.flashMessage, alerts.alertBody);
                    }
                });
    }

    function setFields() {
        form.name            = getName;
        form.date            = new Date().toISOString().slice(0, 10);
        form.month           = moment().startOf("month").format('MMMM');
        form.year            = moment().year();
        form.amount          = props.settings.payment_def;
        form.welfare_amnt    = props.settings.welfare_def;
        classInfo.labelClass = classInfo.labelDef;
    }

    function submit() {
        flashLoading()
        let url = '/cycle/';
        let name = form.name;

        form.post(url, {

            onSuccess: () => [
                alerts.flashMessage = 'New cycle: ' + name + ' Added!',
                alerts.alertType    = 'success',
                flashShow(alerts.flashMessage, alerts.alertType),
                emit('reload')
            ],

            onError: () => [
                // formErrors(form),

                // let allErrors = form.errors,

                // allErrors.forEach(error => {
                //     alerts.flashMessage = error,
                //     alerts.alertType    = 'danger',
                //     flashShow(alerts.flashMessage, alerts.alertType),    
                // })
                
            ],

            onFinish: () => setFields(),
        });
    }

    function formErrors(form) {
        // if (form.hasErrors) {
            if (form.errors.name) {
                alerts.flashMessage = form.errors.name,
                alerts.alertType    = 'danger';
                flashShow(alerts.flashMessage, alerts.alertType); 
            }
            if (form.errors.date) {
                alerts.flashMessage = form.errors.date,
                alerts.alertType    = 'danger';
                flashShow(alerts.flashMessage, alerts.alertType); 
            }
            if (form.errors.amount) {
                alerts.flashMessage = form.errors.amount,
                alerts.alertType    = 'danger';
                flashShow(alerts.flashMessage, alerts.alertType); 
            }
            if (form.errors.welfare_amnt) {
                alerts.flashMessage = form.errors.welfare_amnt,
                alerts.alertType    = 'danger';
                flashShow(alerts.flashMessage, alerts.alertType); 
            }
        // }
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

    function flashLoading() {
        alerts.flashMessage   = 'Loading! Please Wait';
        alerts.alertBody      = alerts.alertWarning;
        alerts.alertType      = 'warning';
        alerts.alertDuration  = 900000;
    }

    function flashShowView(message, body) {
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

        alerts.alertShowView = !alerts.alertShowView;
    }
</script>