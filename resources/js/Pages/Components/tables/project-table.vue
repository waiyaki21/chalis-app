<template>
    <!-- projects table  -->
    <div :class="classInfo.projectsPage ? classInfo.projectsClass : classInfo. cyclesClass">
        <div class="p-2 w-full">
            <h3
                class="font-boldened text-4xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1 w-full whitespace-nowrap">

                <span class="w-full inline-flex justify-start col-span-3" v-if="classInfo.projectsPage">
                    <span class="underline md:text-4xl text-3xl px-2 col-span-3">All Projects Info.</span>
                    <span class="text-gray-500 dark:text-gray-500 md:text-base text-xs md:mt-4 sm:mt-1">
                        ( {{ allProjects.length }} ) projects
                    </span>
                </span>

                <span class="w-full inline-flex justify-start col-span-3" v-else>
                    <span class="underline md:text-4xl text-2xl px-2">{{ cycle.name }} projects.</span>
                    <span class="text-gray-500 dark:text-gray-500 md:text-base text-xs md:mt-4 sm:mt-1">
                        ( {{ allProjects.length }} ) projects
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
                        :placeholder="'SEARCH PROJECTS'">
                </div>
            </h3>

            <div class="py-2 relative overflow-x-auto overflow-y-scroll h-auto max-h-[35rem]"
                v-if="!classInfo.isLoading">
                <h2 class="font-normal font-boldened text-[3.4rem] text-center text-red-800 dark:text-red-600 leading-tight uppercase underline py-1"
                    v-if="allProjects.length == 0">
                    <span v-if="classInfo.search != ''">
                        NO SUCH PROJECT IN THIS CYCLE:
                        <br>
                        <span class="text-amber-500 dark:text-amber-500 underline text-[2rem]">
                            {{ classInfo.search }}!!
                        </span>
                    </span>
                    <span v-else>NO PROJECTS IN THIS CYCLE!!</span>
                </h2>
                <table class="mx-auto w-full text-sm text-left text-gray-500 dark:text-gray-400" v-else>
                    <thead class="text-gray-700 uppercase bg-transparent dark:text-gray-400 font-boldened text-sm">
                        <tr>
                            <td scope="col" class="px-0.5 uppercase hover:underline hover:text-white cursor-pointer"
                                @click="orderByID()">
                                <div class="flex items-center">
                                    ID.
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="pr-2 uppercase hover:underline hover:text-white cursor-pointer"
                                @click="orderByName()">
                                <div class="flex items-center">
                                    Name.
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
                                @click="orderByTarget()">
                                <div class="flex items-center">
                                    Target
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
                                @click="orderByExp()">
                                <div class="flex items-center">
                                    T. Expenses.
                                    <a @click="classInfo.ascending = !classInfo.ascending">
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hidden md:table-cell">
                                <div class="flex items-center">
                                    Balances.
                                </div>
                            </td>
                            <td scope="col" class="px-2 uppercase hover:underline hidden md:table-cell">
                                <div class="flex items-center">
                                    Options.
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 font-boldened text-base uppercase"
                            v-for="(project, index) in allProjects" preserve-scroll>
                            <td class="p-1 text-gray-900 whitespace-nowrap dark:text-white">
                                {{ project.id }}.
                            </td>
                            <td scope="row" class="pr-2 py-4 uppercase text-gray-900 whitespace-nowrap dark:text-white">
                                <!-- progress bar  -->
                                <a @click="viewProject(project)" class="cursor-pointer">
                                    <span class="hover:underline text-2xl">
                                        {{ project.name }}
                                    </span>
                                    <!-- progress bar  -->
                                    <progressTable :percent=percentProject(project) :name=project.name></progressTable>
                                </a>
                                <!-- end progress bar  -->
                            </td>
                            <td class="px-2 py-4 text-blue-600">
                                ksh {{ Number(project.target).toLocaleString() }}
                            </td>
                            <td class="px-2 py-4 text-orange-500">
                                ksh {{ Number(project.total_expenses).toLocaleString() }}
                            </td>
                            <td class="px-2 py-4 inlne-flex hidden md:table-cell">
                                <section class="inline-flex justify-start">
                                    <span class="text-green-600 uppercase underline font-medium text-xl"
                                        v-if="percentProject(project) >= 100">
                                        cleared
                                    </span>
                                    <span class="text-red-600" v-else>
                                        ksh {{ Number(project.target - project.total_expenses).toLocaleString() }}
                                    </span>
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6 ml-1 text-green-600" v-if="percentProject(project) >= 100">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5 ml-1 text-red-600" v-else>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </section>
                            </td>
                            <td class="px-0.5">
                                <div class="inline-flex" role="group">
                                    <!-- edit  -->
                                    <button type="button"
                                        class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white dark:text-cyan-700 dark:hover:text-cyan-400 hidden md:table-cell"
                                        @click="showProject(project)">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <!-- delete  -->
                                    <button type="button"
                                        class="inline-flex items-center p-2 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-white dark:text-red-700 dark:hover:text-red-400 hidden md:table-cell"
                                        @click="showDelete(project)">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                    <!-- view  -->
                                    <a type="button"
                                        class="inline-flex items-center p-2 text-base font-medium text-gray-900 bg-transparent border dark:border-gray-300 rounded-md hover:bg-gray-900 hover:text-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 cursor-pointer dark:focus:bg-gray-700 uppercase"
                                        @click="viewProject(project)">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                                        </svg>
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <loadingTable v-else></loadingTable>
        </div>
    </div>

    <!-- projects form  -->
    <section class="col-span-1" v-if="classInfo.projectsPage">
        <div
            class="bg-gray-300 dark:bg-gray-800 sm:my-2 my-1  overflow-hidden shadow-sm sm:rounded-lg rounded-md font-boldened border-2 border-cyan-300 dark:border-cyan-700">
            <div class="p-2">
                <h3
                    class="font-boldened text-4xl text-gray-800 dark:text-gray-300 leading-tight uppercase underline py-1">
                    Add New projects.
                </h3>
                <form @submit.prevent="submit" class="p-2">
                    <div>
                        <InputLabel for="name" value="name" />

                        <TextInput id="name" type="name" v-model="form.name" autofocus />

                        <InputError class="mt-1" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="target" value="Project Target" />

                        <TextInput id="target" type="number" v-model="form.target" autofocus />

                        <InputError class="mt-1" :message="form.errors.target" />
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <SubmitButton :loading="form.processing" :success="form.wasSuccessful" :failed="form.hasErrors" :editting="form.isDirty">
                            Submit Projects
                        </SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- projects form  -->

    <!-- update project modal  -->
    <projectsupdate :info=classInfo.modalData :show=classInfo.isOpen @reload=getInfo @close=closeProject>
    </projectsupdate>
    <!-- end update project modal  -->

    <!-- delete project modal  -->
    <projectsdelete :info=classInfo.deleteData :show=classInfo.isDeleteOpen :url=classInfo.deleteURL @reload=getInfo
        @close=closeDelete></projectsdelete>
    <!-- end delete project modal  -->

    <!-- flash alert  -->
    <alert :alertshow=alerts.alertShow :message=alerts.flashMessage :class=alerts.alertBody :type=alerts.alertType
        :title=alerts.alertType :time=alerts.alertDuration></alert>
</template>

<script setup>
    import { useForm , router } from '@inertiajs/vue3';
    import { defineProps, reactive, computed, onMounted, watch } from 'vue'

    const props = defineProps({
        projects: {
            type: Array,
            required: true,
        },
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

    const form = useForm({
        name: '',
        target: '',
    })

    const formedit = useForm({
        name: '',
        target: '',
    })

    const classInfo = reactive ({
        // search
        search: '',
        // sort 
        ascending: true,
        sortBy: 'id',

        // form-data 
        isOpen: false,
        modalData: {},

        // delete info 
        isDeleteOpen: false,
        deleteData: {},
        deleteID: '',
        deleteURL: '/delete/project/',

        // projects data 
        info: [],

        // table progress classess
        progressClass100: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-gray-300 via-teal-500 to-green-600 text-base leading-none',
        progressClass: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-gray-300 via-cyan-500 to-blue-600 text-base leading-none',
        progressClassLow: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-gray-300 via-yellow-500 to-orange-600 text-base leading-none',
        progressClassZero: 'alerts flex h-1 items-center justify-center rounded-full bg-gradient-to-r from-gray-300 via-rose-500 to-red-600 text-base leading-none',

        progressInfo100: 'mx-2 text-sm font-normal text-green-500',
        progressInfo: 'mx-2 text-sm font-normal text-blue-500',
        progressInfoLow: 'mx-2 text-sm font-normal text-orange-500',
        progressInfoZero: 'mx-2 text-sm font-normal text-red-500',

        // order 
        nameOrder: true,
        targetOrder: false,
        expOrder: false,
        percentOrder: false,

        isLoading: true,

        projectsPage: true,

        projectsClass: 'bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg rounded-md sm:my-2 my-1 col-span-2 border-2 border-cyan-300 dark:border-cyan-700 h-fit',
        cyclesClass: 'bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg rounded-md sm:my-2 my-1 col-span-2 h-fit'
    })

    // computed 
    const allProjects = computed(() => {
        let tempProjects = classInfo.info

        // search rows 
        if (classInfo.search != '' && classInfo.search) {
            tempProjects = tempProjects.filter((project) => {
                return project.name
                    .toUpperCase()
                    .includes(classInfo.search.toUpperCase())
            })
        }

        // Sort Projects
        tempProjects = tempProjects.sort((a, b) => {
            if (classInfo.sortBy == 'id') {
                let fa = a.name.toLowerCase(), fb = b.name.toLowerCase()

                if (fa < fb) {
                    return -1
                }
                if (fa > fb) {
                    return 1
                }
                return 0

            } else if (classInfo.sortBy == 'name') {
                return a.id - b.id
            } else if (classInfo.sortBy == 'target') {
                return a.target - b.target
            } else if (classInfo.sortBy == 'total_expenses') {
                return a.total_expenses - b.total_expenses
            }
        })

        // Show sorted array in descending or ascending order
        if (!classInfo.ascending) {
            tempProjects.reverse()
        }

        return tempProjects
    })

    onMounted(() => {
        classInfo.isLoading = true;
        setInfo()
        getInfo()
    })

    function setInfo() {
        classInfo.info = props.projects;  
    }

    function percentProject(project) {
        let percent = Math.floor(project.total_expenses / project.target * 100);
        return percent;
    }

    function viewProject(project) {
        let url = '/project/' + project.id;
        router.visit(url, {
            preserveScroll: true
        })
    }

    function submit() {
        let name = form.name;
        let url = '/project/';

        form.post(url, {
            onFinish: () => form.reset(['name', 'target']),
            onSuccess: () => [
                alerts.flashMessage   = 'New Project: ' + name + ' Added!',
                alerts.alertType      = 'success',
                getInfo(),
                flashShow(alerts.flashMessage, alerts.alertType),
                clearFields(),
            ],
        });
    }

    function getInfo() {
        classInfo.info = [];
        let link = '';
        let linkTo = 'id/';

        if (classInfo.nameOrder == true) {
            link = 'desc';
        } else {
            link = 'asc';
        }

        if (route().current() == 'View Cycle Payments') {
            classInfo.projectsPage = false;
            let url = '/api/getCycleProjects/' + props.cycle.id

            axios.get(url)
                .then(
                    ({ data }) => {
                        classInfo.info = data[0];
                        classInfo.isLoading = false
                    });
        } else {
            classInfo.projectsPage = true;
            let url = '/api/getProjects/' + linkTo + link

            axios.get(url)
                .then(
                    ({ data }) => {
                        classInfo.info = data[0];
                        classInfo.isLoading = false
                    });
        }  
    }

    function LoadingOn() {
        classInfo.ascending = !classInfo.ascending;
        classInfo.isLoading = true 
    }

    function LoadingOff() {
        flashShow(alerts.flashMessage, alerts.alertType);
        classInfo.isLoading = false
    }

    // order rows 
    function orderByID() {
        LoadingOn();
        classInfo.sortBy = 'id';

        // flash message 
        classInfo.ordername = 'ID';
        if(classInfo.ascending) {
            alerts.flashMessage   = 'Sorting Projects by: ' + classInfo.ordername + ' ascending';
        } else {
            alerts.flashMessage   = 'Sorting Projects by: ' + classInfo.ordername + ' descending';
        }
        alerts.alertBody          = alerts.alertInfo;
        LoadingOff();
    }

    function orderByName() {
        LoadingOn();

        classInfo.sortBy = 'name';

        // flash message 
        classInfo.ordername = 'NAME';
        if(classInfo.ascending) {
            alerts.flashMessage   = 'Sorting Projects by: ' + classInfo.ordername + ' ascending';
        } else {
            alerts.flashMessage   = 'Sorting Projects by: ' + classInfo.ordername + ' descending';
        }
        alerts.alertBody          = alerts.alertInfo;
        LoadingOff();
    }

    function orderByTarget() {
        LoadingOn();

        classInfo.sortBy = 'target';

        // flash message 
        classInfo.ordername = 'TARGET';
        if (classInfo.ascending) {
            alerts.flashMessage = 'Sorting Projects by: ' + classInfo.ordername + ' ascending';
        } else {
            alerts.flashMessage = 'Sorting Projects by: ' + classInfo.ordername + ' descending';
        }
        alerts.alertBody = alerts.alertInfo;
        LoadingOff();
    }

    function orderByExp() {
        LoadingOn();

        classInfo.sortBy = 'total_expenses';

        // flash message 
        classInfo.ordername = 'TOTAL EXPENSES';
        if (classInfo.ascending) {
            alerts.flashMessage = 'Sorting Projects by: ' + classInfo.ordername + ' ascending';
        } else {
            alerts.flashMessage = 'Sorting Projects by: ' + classInfo.ordername + ' descending';
        }
        alerts.alertBody = alerts.alertInfo;
        LoadingOff();
    }

    function clearFields() {
        form.name = '';
        form.target = '';
    }

    // modals 

    function showProject(project) {
        classInfo.modalData = project;
        classInfo.isOpen    = true;
    }

    function closeProject() {
        classInfo.isOpen    = false;
        classInfo.modalData = {};
    }

    function showDelete(project) {
        classInfo.deleteData    = project;
        classInfo.deleteID      = project.id;
        classInfo.isDeleteOpen  = true;
    }

    function closeDelete() {
        classInfo.isDeleteOpen  = false;
        classInfo.deleteData    = {};
        classInfo.deleteID      = '';
    }

    // end modals 

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