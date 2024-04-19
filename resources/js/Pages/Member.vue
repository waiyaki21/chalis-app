<template>

    <Head>
        <title>{{ props.route }}</title>
    </Head>

    <!-- breadcrumb  -->
    <membercrumbs :member=classInfo.memberInfo></membercrumbs>
    <!-- end breadcrumb  -->

    <!-- body section  -->
    <div class="py-2 font-boldened">
        <!-- info panel  -->
        <memberinfo :member=classInfo.memberInfo @reload=reloadPayments @ledger=downloadLedger :border=classInfo.progressMainBorder
            :class=classInfo.progressMainClass :payPercent=payPercent :welPercent=welPercent :owePercent=owePercent>
        </memberinfo>
    </div>

    <!-- panel, table and form  -->
    <section class="w-full justify-between grid grid-cols-1 md:grid-cols-5">
        <!-- info panel  -->
        <memberside :member=classInfo.memberInfo :infosection=classInfo.infoSection :infoheader=classInfo.infoHeader
            :sectionborder=classInfo.sectionBorder></memberside>
        <!-- end info panel  -->

        <!-- body panel  -->
        <div class="py-2 pr-1 col-span-4 flex-row justify-between space-x-2">
            <!-- member tabs  -->
            <div
                class="text-sm font-boldened text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 w-full mb-2 mx-2 p-1 inline-flex justify-between uppercase">
                <ul class="flex flex-wrap -mb-px">
                    <li class="me-2">
                        <a :class="[classInfo.tab1]" @click="tabSwitch()">
                            {{ classInfo.tab1Name }}
                            <span
                                class="bg-blue-100 text-gray-800 md:text-sm font-normal mx-1 px-1.5 py-0.5 rounded-full dark:bg-cyan-900 dark:text-white border-2 border-cyan-900 dark:border-cyan-500">
                                {{ classInfo.paymentsInfo.length }}
                            </span>
                        </a>
                    </li>

                    <li class="me-2">
                        <a :class="[classInfo.tab3]" @click="tabSwitch3()">
                            {{ classInfo.tab3Name }}
                            <span
                                class="bg-blue-100 text-gray-800 text-sm font-normal mx-1 px-1.5 py-0.5 rounded-full dark:bg-cyan-900 dark:text-white border-2 border-cyan-900 dark:border-cyan-500">
                                {{ classInfo.welfaresInfo.length }}
                            </span>
                        </a>
                    </li>

                    <li class="me-2">
                        <a :class="[classInfo.tab2]" @click="tabSwitch2()">
                            Enter / Upload Info.
                        </a>
                    </li>
                </ul>
            </div>
            <!-- end member tabs  -->

            <!-- payments table  -->
            <div :class="['overflow-hidden rounded-lg md:rounded-md w-full p-1']" v-if="classInfo.tab1show">
                <!-- payments info section  -->
                <section :class="[classInfo.infoSection]">
                    <section
                        :class="['w-full justify-between m-1 p-1 text-left space-x font-boldened grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-1']">
                        <a class="block max-w-sm p-2 bg-transparent">
                            <h5 :class="[classInfo.infoHeader, 'md:text-[1.1rem] text-2xl']"
                                title="Total no of payments">
                                <span>Payments No.</span>
                                <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                            </h5>
                            <p
                                class="font-normal text-left md:text-3xl text-2xl text-blue-700 dark:text-blue-400 uppercase">
                                {{ numFormat(classInfo.paymentsInfo.length) }} Payments
                            </p>
                        </a>

                        <a class="block max-w-sm p-2 bg-transparent">
                            <h5 :class="[classInfo.infoHeader, 'md:text-[1.1rem] text-2xl']"
                                title="Total amount contributed before entering system data">
                                <span>Amount Before</span>
                                <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                            </h5>
                            <p class="font-normal text-left md:text-3xl text-2xl text-green-700 dark:text-green-400 uppercase"
                                :title="'ksh ' + Number(member.amount_before).toLocaleString()">
                                <!-- ksh {{ numFormat(paySum) }} -->
                                ksh {{ numFormat(member.amount_before) }}
                            </p>
                        </a>

                        <a class="block max-w-sm p-2 bg-transparent">
                            <h5 :class="[classInfo.infoHeader, 'md:text-[1.1rem] text-2xl']"
                                title="Total amount contributed in all cycles">
                                <span>T. Contributed</span>
                                <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                            </h5>
                            <p class="font-normal text-left md:text-3xl text-2xl text-green-700 dark:text-green-400 uppercase"
                                :title="'ksh ' + Number(member.payments_sum).toLocaleString()">
                                <!-- ksh {{ numFormat(paySum) }} -->
                                ksh {{ numFormat(member.payments_sum) }}
                            </p>
                        </a>

                        <a class="block max-w-sm p-2 bg-transparent">
                            <h5 :class="[classInfo.infoHeader, 'md:text-[1.1rem] text-2xl']"
                                title="Grand Total of all contributions in all cycles">
                                <span>Grand Total</span>
                                <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                            </h5>
                            <p class="font-normal text-left md:text-3xl text-2xl text-green-700 dark:text-green-400 uppercase"
                                :title="'ksh ' + Number(member.payments_total).toLocaleString()">
                                ksh {{ numFormat(member.payments_total) }}
                            </p>
                        </a>
                    </section>
                </section>

                <div
                    :class="['bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-md rounded-lg md:rounded-md w-full p-2', classInfo.borderClass]">
                    <h3 :class="[classInfo.mainHeader,'justify-between w-full mb-1 grid grid-cols-2 gap-1']">
                        <span class="underline col-span-2">{{ member.name }} Payments.</span>
                    </h3>

                    <!-- payments table  -->
                    <div class="py-2 relative overflow-x-auto">
                        <h2 class="font-normal font-boldened text-[3rem] text-center text-cyan-800 dark:text-cyan-300 leading-tight uppercase underline py-1"
                            v-if="allPayments.length == 0">
                            ADD MEMBER PAYMENTS!!
                        </h2>

                        <section class="overflow-y-scroll h-auto max-h-[35rem]" v-else>
                            <table class="mx-auto w-full text-base text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-gray-700 uppercase bg-transparent dark:text-gray-300 font-boldened text-base">
                                    <tr>
                                        <td scope="col"
                                            class="px-2 uppercase hover:underline dark:text-gray-400 dark:hover:text-white cursor-pointer"
                                            @click="orderByID()">
                                            <div class="flex items-center">
                                                No.
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
                                            class="px-2 uppercase hover:underline dark:text-gray-400 dark:hover:text-white cursor-pointer"
                                            @click="orderByPayments()">
                                            <div class="flex items-center">
                                                Total Paid.
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
                                        <td scope="col" class="px-2 uppercase hover:underline dark:hover:text-white">
                                            <div class="flex items-center">
                                                Date
                                            </div>
                                        </td>
                                        <td scope="col" class="px-2 uppercase hover:underline dark:hover:text-white">
                                            <div class="flex items-center">
                                                Options.
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-transparent border-b dark:bg-gray-800 dark:border-gray-700 font-boldened text-base uppercase"
                                        v-for="(payment, index) in allPayments">
                                        <td scope="row" class="px-2 py-4">
                                            <span class="uppercase text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ payment.id }}.
                                            </span>
                                        </td>
                                        <td class="px-2 py-4">
                                            <span class="">
                                                <span class="text-green-500 underline text-xl md:text-2xl">
                                                    ksh {{ numFormat(payment.payment) }}
                                                </span>
                                            </span>
                                        </td>
                                        <td class="px-2 py-4">
                                            <a @click="getRoute(payment.cycle_id)"
                                                class="text-white bg-gradient-to-r from-cyan-600 to-blue-700 hover:bg-gradient-to-bl focus:ring-2 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg p-2 text-center me-2 mb-2 flex w-full justify-between cursor-pointer">
                                                <span class="md:text-xl sm:text-lg ml-4">
                                                    {{ payment.cycle.name }}
                                                </span>
                                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="pl-3">
                                                <div class="font-normal">
                                                    {{ moment(payment.created_at).format("ddd, Do-MM-YY") }}
                                                </div>
                                                <div class="font-normal text-xs dark:text-gray-300 underline">
                                                    {{ moment(payment.created_at).fromNow() }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="inline-flex rounded-md shadow-sm space-x-1" role="group">
                                                <!-- edit  -->
                                                <button type="button"
                                                    class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-cyan-700 dark:hover:text-cyan-400"
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
                                                    class="inline-flex items-center p-2 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-red-700 dark:hover:text-red-400"
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
                        </section>
                    </div>
                    <!--end payments table  -->
                </div>
            </div>
            <!-- payments table  -->

            <!-- payments & welfare form  -->
            <section class="w-full overflow-hidden font-boldened flex-row" v-if="classInfo.tab2show">
                <h3 class="font-boldened p-2">
                    <span
                        :class="[classInfo.mainHeader, 'justify-between w-full mb-1 grid grid-cols-2 md:grid-cols-5 gap-1']">
                        <span class="underline col-span-5">Add Member Payments / Welfares.</span>
                    </span>
                </h3>
                <section class="w-full justify-between grid grid-cols-1 md:grid-cols-4 gap-1">
                    <div
                        :class="['p-2 col-span-4 rounded-lg bg-cyan-200/30 dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg h-fit', classInfo.borderClass]">
                        <form @submit.prevent="verify" class="p-2">
                            <section class="w-full grid grid-cols-2 gap-2">
                                <div>
                                    <InputLabel for="member_id" value="Member Name" />

                                    <select id="member_id" v-model="form.member_id" name="member_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-md">
                                        <option :value="member.id" selected>
                                            {{ member.name }}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.member_id" />
                                </div>

                                <div>
                                    <InputLabel for="cycle_id" value="Payment Cycle Name" />

                                    <select id="cycle_id" v-model="form.cycle_id" name="cycle_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-md"
                                        :placeholder="cycle.name">
                                        <option v-for="cycle in props.cycles" :value="cycle.id"
                                            @click="checkPayments(cycle)">
                                            {{ cycle.name }}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.cycle_id" />
                                </div>
                            </section>

                            <section class="w-full grid grid-cols-1 gap-2">
                                <div>
                                    <InputLabel for="payment" value="payment" />

                                    <span
                                        class="text-yellow-300 my-2 py-2 uppercase underline font-boldened font-normal">
                                        Enter <b>0</b> to represent no information
                                    </span>

                                    <TextInput id="payment" type="number" v-model="form.payment" autofocus
                                        v-if="classInfo.paysNo == 0" />

                                    <TextInput id="payment" type="number" v-model="form.payment"
                                        class="cursor-not-allowed" disabled v-else />

                                    <InputError class="mt-2" :message="form.errors.payment"
                                        v-if="classInfo.paysNo == 0" />

                                    <InputError class="mt-2" :message="'The member already has a payment in this cycle'"
                                        v-else />
                                </div>
                            </section>

                            <section class="w-full grid grid-cols-2 gap-2">
                                <div>
                                    <InputLabel for="welfare" value="welfare" />

                                    <TextInput id="welfare" type="number" v-model="form.welfare" autofocus />

                                    <InputError class="mt-2" :message="form.errors.welfare" />
                                </div>

                                <div>
                                    <InputLabel for="type" value="welfare type" />

                                    <select id="type" v-model="form.type" name="type"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-md"
                                        placeholder="">
                                        <option value="1" selected="true">Welfare Money In</option>
                                        <option value="0">Welfare Money Out</option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.type" />
                                </div>
                            </section>

                            <div class="flex items-center justify-start mt-4">
                                
                                <SubmitButton :disabled="form.processing" :loading="form.processing" :success="form.wasSuccessful" :failed="form.hasErrors" :editting="form.isDirty">
                                    Submit {{ classInfo.memberInfo.name }} Info
                                </SubmitButton>
                            </div>
                        </form>
                    </div>
                    <!-- end forms  -->
                </section>
            </section>
            <!-- payments & welfare form  -->

            <!-- welfares table  -->
            <div :class="['overflow-hidden rounded-lg md:rounded-md w-full p-1']" v-if="classInfo.tab3show">
                <!-- welfare info section  -->
                <section :class="[classInfo.infoSection, 'mb-2']">
                    <section
                        :class="['w-full justify-between m-1 p-1 text-left space-x font-boldened grid grid-cols-2 md:grid-cols-4 gap-1']">
                        <a class="block max-w-sm p-2 bg-transparent">
                            <h5 :class="[classInfo.infoHeader, 'md:text-[1.1rem] text-2xl']"
                                title="Total Welfare amount contributed before entering system data">
                                <span>Amount Before</span>
                                <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                            </h5>
                            <p class="font-normal text-left md:text-3xl text-2xl text-yellow-600 dark:text-yellow-300 uppercase"
                                :title="'ksh ' + Number(member.welfare_before).toLocaleString()">
                                <!-- ksh {{ numFormat(paySum) }} -->
                                ksh {{ numFormat(member.welfare_before) }}
                            </p>
                        </a>

                        <a class="block max-w-sm p-2 bg-transparent">
                            <h5 :class="[classInfo.infoHeader, 'md:text-[1.1rem] text-2xl']"
                                title="Total Welfares amount contributed in all cycles">
                                <span>T.Welfares In</span>
                                <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                            </h5>
                            <p class="font-normal text-left md:text-3xl text-2xl text-green-700 dark:text-green-400 uppercase"
                                :title="'ksh ' + Number(member.welfare_in).toLocaleString()">
                                <!-- ksh {{ numFormat(paySum) }} -->
                                ksh {{ numFormat(member.welfare_in) }}
                            </p>
                        </a>

                        <a class="block max-w-sm p-2 bg-transparent">
                            <h5 :class="[classInfo.infoHeader, 'md:text-[1.1rem] text-2xl']"
                                title="Total Welfare amount given out to the member">
                                <span>T.Welfares Out</span>
                                <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                            </h5>
                            <p class="font-normal text-left md:text-3xl text-2xl text-red-700 dark:text-red-700 uppercase"
                                :title="'ksh ' + Number(member.welfare_out).toLocaleString()">
                                <!-- ksh {{ numFormat(paySum) }} -->
                                ksh {{ numFormat(member.welfare_out) }}
                            </p>
                        </a>

                        <a class="block max-w-sm p-2 bg-transparent">
                            <h5 :class="[classInfo.infoHeader, 'md:text-[1.1rem] text-2xl']"
                                title="Grand Total of all welfare payments in all cycles">
                                <span>Grand Total</span>
                                <svg class="flex-shrink-0 inline w-5 h-5 ml-1" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                            </h5>
                            <p class="font-normal text-left md:text-3xl text-2xl text-blue-700 dark:text-blue-800 uppercase"
                                :title="'ksh ' + Number(member.welfare_total).toLocaleString()">
                                ksh {{ numFormat(member.welfare_total) }}
                            </p>
                        </a>
                    </section>
                </section>

                <div
                    :class="['bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-md rounded-lg w-full p-2', classInfo.borderClass]">
                    <h3 :class="[classInfo.mainHeader,'inline-flex justify-between w-full mb-1']">
                        <span class="underline col-span-3">{{ member.name }} Welfares.</span>
                        <!-- forms  -->
                        <a @click="tabSwitch2()" type="button"
                            class="text-white bg-gradient-to-br from-teal-500 to-blue-700 hover:bg-gradient-to-bl focus:ring-2 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-800 font-medium rounded-lg text-lg px-5 py-2.5 text-center me-2 mb-2 uppercase shadow-md cursor-pointer inline-flex justify-between">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add Welfares
                        </a>
                    </h3>

                    <!-- welfares table  -->
                    <div class="py-2 relative overflow-x-auto">
                        <h2 class="font-normal font-boldened text-[3rem] text-center text-cyan-800 dark:text-cyan-300 leading-tight uppercase underline py-1"
                            v-if="classInfo.welfaresInfo.length == 0">
                            ADD WELFARE PAYMENTS!!
                        </h2>

                        <section class="overflow-y-scroll h-auto max-h-[35rem]" v-else>
                            <table class="mx-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-gray-700 uppercase bg-transparent dark:text-gray-400 font-boldened text-sm">
                                    <tr>
                                        <td scope="col" class="px-2 uppercase hover:underline">
                                            No.
                                        </td>
                                        <td scope="col" class="px-2 uppercase hover:underline">
                                            <div class="flex items-center">
                                                Amount
                                            </div>
                                        </td>
                                        <td scope="col" class="px-2 uppercase hover:underline">
                                            <div class="flex items-center">
                                                Payment Cycle.
                                            </div>
                                        </td>
                                        <td scope="col" class="px-2 uppercase hover:underline">
                                            <div class="flex items-center">
                                                Date.
                                            </div>
                                        </td>
                                        <td scope="col" class="px-2 uppercase hover:underline">
                                            <div class="flex items-center">
                                                Type
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
                                    <tr class="bg-transparent border-b dark:bg-gray-800 dark:border-gray-700 font-boldened text-base uppercase"
                                        v-for="(welfare, index) in classInfo.welfaresInfo">
                                        <td scope="row" class="px-2 py-4">
                                            <span
                                                class="uppercase text-gray-900 whitespace-nowrap dark:text-emerald-500 text-base"
                                                v-if="welfare.type == 1">
                                                {{ index + 1 }}.
                                            </span>
                                            <span
                                                class="uppercase text-gray-900 whitespace-nowrap dark:text-rose-500 text-base"
                                                v-else>
                                                {{ index + 1 }}.
                                            </span>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="px-1 text-blue-600 text-xl md:text-2xl"
                                                v-if="welfare.type == 1">
                                                <div class="font-normal underline">
                                                    ksh {{ numFormat(welfare.payment) }}
                                                </div>
                                            </div>
                                            <div class="px-1 text-red-600 text-xl md:text-2xl" v-else>
                                                <div class="font-normal underline">
                                                    ksh {{ numFormat(welfare.payment) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <a @click="getRoute(welfare.cycle_id)"
                                                class="text-white bg-gradient-to-r from-cyan-600 to-blue-700 hover:bg-gradient-to-bl focus:ring-2 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg p-2 text-center me-2 mb-2 flex w-full justify-center"
                                                v-if="welfare.type == 1">
                                                <span class="md:text-xl sm:text-lg">
                                                    {{ welfare.cycle.name }}
                                                </span>
                                            </a>
                                            <a @click="getRoute(welfare.cycle_id)"
                                                class="text-white bg-gradient-to-r from-red-600 to-amber-700 hover:bg-gradient-to-bl focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg p-2 text-center me-2 mb-2 flex w-full justify-center"
                                                v-else>
                                                <span class="md:text-xl sm:text-lg">
                                                    {{ welfare.cycle.name }}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="pl-3">
                                                <div class="font-normal">
                                                    {{ moment(welfare.created_at).format("ddd, Do-MM-YY") }}
                                                </div>
                                                <div class="font-normal text-xs dark:text-gray-300 underline">
                                                    {{ moment(welfare.created_at).fromNow() }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <span v-if="welfare.type == 0">
                                                <span class="text-red-700 underline text-2xl">
                                                    OUT
                                                </span>
                                            </span>
                                            <span v-else>
                                                <span class="text-green-700 underline text-2xl">
                                                    IN
                                                </span>
                                            </span>
                                        </td>

                                        <td class="px-2 py-4">
                                            <div class="inline-flex rounded-md shadow-sm space-x-1" role="group">
                                                <!-- edit  -->
                                                <button type="button"
                                                    class="inline-flex items-center p-2 text-sm font-medium text-cyan-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-cyan-700 dark:hover:text-cyan-400"
                                                    @click="showWelfare(welfare)">
                                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                    <!-- Edit -->
                                                </button>
                                                <!-- delete  -->
                                                <button type="button"
                                                    class="inline-flex items-center p-2 text-sm font-medium text-red-900 bg-transparent rounded-md hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:text-red-700 dark:hover:text-red-400"
                                                    @click="showWelfareDelete(welfare)">
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
                        </section>
                    </div>
                    <!--end welfares table  -->
                </div>
            </div>
            <!-- welfares table  -->
        </div>
        <!-- end body panel  -->
    </section>
    <!-- end panel, table and form  -->

    <!-- update payment modal  -->
    <paymentsupdate :info=classInfo.modalData :show=classInfo.isOpen :name=props.member.name
        :payment=numFormat(classInfo.modalData.payment) @reload=reloadPayments @close=closePayment></paymentsupdate>
    <!-- end update payment modal  -->

    <!-- delete payment modal  -->
    <paymentsdelete :info=classInfo.deleteData :show=classInfo.isDeleteOpen :name=props.member.name
        :payment=numFormat(classInfo.deleteData.payment) @reload=reloadPayments @close=closeDelete></paymentsdelete>
    <!-- end delete payment modal  -->

    <!-- update welfare modal  -->
    <welfaresupdate :info=classInfo.modalData :show=classInfo.isWelfareOpen :name=props.member.name
        :payment=numFormat(classInfo.modalData.payment) @reload=reloadWelfares @close=closeWelfare></welfaresupdate>
    <!-- end update Welfare modal  -->

    <!-- delete welfare modal  -->
    <welfaresdelete :info=classInfo.deleteData :show=classInfo.isDeleteWelfareOpen :name=props.member.name
        :payment=numFormat(classInfo.deleteData.payment) @reload=reloadWelfares @close=closeWelfareDelete>
    </welfaresdelete>
    <!-- end delete payment modal  -->

    <!-- alert  -->
    <alert :alertshow=alerts.alertShow :message=alerts.flashMessage :class=alerts.alertBody :type=alerts.alertType
        :title=alerts.alertType :time=alerts.alertDuration></alert>

    <alertview :alertshowview=alerts.alertShowView :message=alerts.flashMessage :class=alerts.alertBody
        :link=alerts.linkName :url=alerts.linkUrl :state=alerts.linkState></alertview>
    <!-- end app body  -->
</template>

<script setup>
    import { useForm, router } from '@inertiajs/vue3';
    import { defineProps, reactive, onMounted, computed } from 'vue'

    //moment 
    import moment from 'moment';

    const props = defineProps({
        name: {
            type: String,
            required: true,
        },
        route: {
            type: String,
            required: true,
        },
        member: {
            type: Object,
            required: true,
        },
        payments: {
            type: Array,
            required: true,
        },
        welfares: {
            type: Array,
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
        },
        cycles: {
            type: Array,
            required: true,
        },
        cycle: {
            type: Object,
            required: true,
        },
        pays: {
            type: String,
            required: true,
        },
    });

    const classInfo = reactive({
        isOpen: false,
        isWelfareOpen: false,
    
        modalData: {},
        modalName: '',

        // delete info 
        isDeleteOpen: false,
        isDeleteWelfareOpen: false,
        deleteData: {},
        deleteID: '',
        deletePayURL: '/delete/payment/',
        deleteWelfURL: '/delete/welfare/',

        welfaresInfo: [],
        paymentsInfo: [],
        memberInfo: {},
        excel_file: '',
        fileSelected: '',

        // main progress bar 
        progressMainBorder: 'border border-cyan-500 p-1 overflow-hidden',
        progressMainClass: 'alerts flex h-6 items-center justify-center rounded-full bg-gradient-to-r from-gray-200 via-cyan-400 to-blue-500 text-base leading-none',
        infoSection: 'm-2 p-2 text-left mx-auto rounded-xl border-2 shadow-md border-2 border-cyan-500 p-1 overflow-hidden bg-cyan-400/10 dark:bg-cyan-400/10',
        infoHeader: 'text-cyan-900 dark:text-cyan-300 mb-1 md:mb-2 md:text-3xl text-2xl text-left font-normal underline tracking-tight uppercase',
        sectionBorder: 'w-full flex-col justify-between m-1 p-1 text-left',
        borderClass: 'border-[3px] border-cyan-300 dark:border-cyan-700',
        mainHeader: 'font-boldened md:text-3xl text-2xl text-gray-800 dark:text-gray-300 leading-tight uppercase py-1',

        // tabs 
        tabActive: 'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-sky-500 dark:border-blue-500 text-sm md:text-lg cursor-pointer',
        tabInactive: 'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:text-gray-300 dark:hover:text-gray-50 text-sm md:text-lg cursor-pointer',
        tab1: '',
        tab2: '',
        tab1show: true,
        tab2show: false,
        tab1Name: 'Payments Info',
        tab3Name: 'Welfares Info',

        templateBtn: '',
        templateInactive: 'text-white bg-gradient-to-r from-rose-500 to-red-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-rose-300 dark:focus:ring-rose-800 font-medium rounded-lg text-base px-5 py-2.5 text-center me-2 mb-2 inline-flex justify-between cursor-not-allowed',
        templateActive: 'text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-1 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-base px-5 py-2.5 text-center me-2 mb-2 inline-flex justify-between',
        labelClass: 'flex flex-col items-center justify-center w-full h-[15rem] border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',

        clicked: false,

        paysNo: '',

        modalCloseBtn: 'cursor-pointer dark:text-cyan-800 text-cyan-500 transition-transform hover:rotate-180 w-6 h-6 hover:w-8 hover:h-8',

        // sort 
        ascending: true,
        sortBy: 'id',
    })

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

    const form = useForm({
        member_id: '',
        cycle_id: '',
        payment: '',
        welfare: '',
        type: ''
    })

    onMounted(() => [
        setInfo(),
        setFields(),
        progressMain()
    ])

    const allPayments = computed(() => {
        let tempPayments = classInfo.paymentsInfo

        // Sort Payments
        tempPayments = tempPayments.sort((a, b) => {
            if (classInfo.sortBy == 'id') {
                return a.id - b.id
            } else if (classInfo.sortBy == 'payments') {
                return a.payments - b.payments
            } else if (classInfo.sortBy == 'cycle_id') {
                return a.cycle_id - b.cycle_id
            }
        })

        // Show sorted array in descending or ascending order
        if (!classInfo.ascending) {
            tempPayments.reverse()
        }

        return tempPayments
    })

    function setInfo() {
        classInfo.paymentsInfo = props.payments;
        classInfo.welfaresInfo = props.welfares;
        classInfo.memberInfo   = props.member;

        tabSwitch();
        // checkPayments(props.cycle);
        classInfo.paysNo = props.pays;
    }

    function numFormat(num) {
        if (num < 399999) {
            return Number(num).toLocaleString();
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

        router.get(url);
    }

    function progressMain() {
        classInfo.infoHeader             = classInfo.infoHeader;
        classInfo.infoSection            = classInfo.infoSection;
        classInfo.sectionBorder          = classInfo.sectionBorder;
        classInfo.borderClass            = classInfo.borderClass;
        classInfo.mainHeader             = classInfo.mainHeader;          
    }

    function tabSwitch() {
        resetTabClass();
        classInfo.tab1show = true;
        classInfo.tab2show = false;
        classInfo.tab3show = false;

        classInfo.tab1     = classInfo.tabActive;
    }

    function tabSwitch2() {
        resetTabClass();
        classInfo.tab1show = false;
        classInfo.tab2show = true;
        classInfo.tab3show = false;

        classInfo.tab2     = classInfo.tabActive;
    }

    function tabSwitch3() {
        resetTabClass();
        classInfo.tab1show = false;
        classInfo.tab2show = false;
        classInfo.tab3show = true;

        classInfo.tab3    = classInfo.tabActive;
    }

    function resetTabClass() {
        classInfo.tab1 = classInfo.tabInactive;
        classInfo.tab2 = classInfo.tabInactive;
        classInfo.tab3 = classInfo.tabInactive;
    }
    // end tabs methods 

    // order rows 
    function orderByID() {
        classInfo.ascending = !classInfo.ascending

        classInfo.sortBy = 'id';

        // flash message 
        classInfo.ordername = 'ID';
        if(classInfo.ascending) {
            alerts.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            alerts.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' descending';
        }
        alerts.alertBody          = alerts.alertInfo;
        
        flashShow(alerts.flashMessage, alerts.alertType);
    }

    function orderByPayments() {
        classInfo.ascending = !classInfo.ascending

        classInfo.sortBy = 'payments';

        // flash message 
        classInfo.ordername = 'TOTAL PAYMENTS';
        if(classInfo.ascending) {
            alerts.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            alerts.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' descending';
        }
        alerts.alertBody          = alerts.alertInfo;
        
        flashShow(alerts.flashMessage, alerts.alertType);
    }

    function orderByCycle() {
        classInfo.ascending = !classInfo.ascending

        classInfo.sortBy = 'cycle_id';

        // flash message 
        classInfo.ordername = 'PAYMENT CYCLES';
        if(classInfo.ascending) {
            alerts.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' ascending';
        } else {
            alerts.flashMessage   = 'Payments Sorted By: ' + classInfo.ordername + ' descending';
        }
        alerts.alertBody          = alerts.alertInfo;
        
        flashShow(alerts.flashMessage, alerts.alertType);
    }

    function verify() {
        let amount  = form.payment;
        let welfare = form.welfare;
        if (form.cycle_id == '') {
            alert('Select a cycle for this payment and welfare information!');
        } else {
            if (form.payment == 0 && form.welfare == 0) {
                if (confirm("The payment & welfare value are both 0 ,There is no information to be submitted, proceed?") == true) {
                    alerts.flashMessage = 'No Payment or Welfare to Submit both were 0!';
                    alerts.alertType    = 'warning';
                }   
            } else {
                if (form.payment == 0) {
                    if (confirm("Do you want to enter the welfare of ksh " + welfare +" only, The payment has a value of 0, proceed?") == true) {
                        alerts.flashMessage = 'Success!, New Welfare of ksh ' + welfare + ' entered!';
                        alerts.alertType    = 'warning';
                        submit();
                    }   
                } 
                if (form.welfare == 0) {
                    if (confirm("Do you want to enter the payment of ksh " + payment + " only, The welfare has a value of 0, proceed?") == true) {
                        alerts.flashMessage = 'Success!, New Payment of ksh ' + payment + ' entered!';
                        alerts.alertType    = 'warning';
                        submit();
                    }   
                }
            }
            if (form.payment != 0 && form.welfare != 0) {
                alerts.flashMessage   = 'New payment :ksh' + amount + ' & Welfare :ksh ' + welfare + ' Added!',
                alerts.alertType      = 'success',
                submit();
            }
        }
    }

    function submit() {
        let url = '/payment/member/' + props.member.id;
        form.post(url, {
            onFinish: () => clearFields(),

            onSuccess: () => [
                setFields(),
                tabSwitch2(),
                flashShow(alerts.flashMessage, alerts.alertType),
                reloadPayments()
            ],

            onError: () => [
                // console.log(form.errors),
                alerts.flashMessage   = 'Failed! Try Again',
                alerts.alertType      = 'danger',
                flashShow(alerts.flashMessage, alerts.alertType),
                tabSwitch2(),
            ] 
        });
    }

    function reloadPayments() {
        let link = 'desc';
        let linkTo = 'created_at/';

        axios.get('/api/getPays/member/'+ props.member.id +'/'+ linkTo + link)
            .then(
                ({ data }) => {
                    classInfo.paymentsInfo = data[0];
                    classInfo.welfaresInfo = data[1];
                    classInfo.memberInfo   = data[2];
                    progressMain();
                });
    }

    function checkPayments(cycle) {
        axios.get('/api/getPays/member/'+ props.member.id +'/'+ cycle.id)
            .then(
                ({ data }) => {
                    classInfo.paysNo = data;
                    if (data == 0) {
                        alerts.flashMessage = props.member.name + 'has (ZERO)' + data + ' payments in ' + cycle.name + '!';
                        alerts.alertBody = alerts.alertSuccess;    
                    } else {
                        alerts.flashMessage = props.member.name + 'already has ' + data + ' payments in ' + cycle.name + '!';
                        alerts.alertBody = alerts.alertInfo;
                    }
                    alerts.alertShow = !alerts.alertShow;
                });
    }

    function flashShow(message, body) {
        alerts.alertType      = body;
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
        // setInfo();
    }

    function downloadLedger(a, name) {
        alerts.flashMessage   = 'Download ' + name + ' Payments and Welfare Ledger!';
        alerts.linkName       = 'Download Member Excelsheet';
        alerts.alertType      = 'info';
        alerts.linkUrl        = '/download/current/member/' + a;
        alerts.linkState      = true;
        alerts.alertBody      = alerts.alertInfo;
        alerts.alertShowView  = !alerts.alertShowView;
    }

    function cycleFull() {
        alerts.flashMessage = 'The Member already has ( ' + classInfo.paysNo + ' ) or more payment(s) for this cycle!';
        alerts.alertType    = 'danger';
        flashShow(alerts.flashMessage, alerts.alertType);
    }

    function setFields() {
        form.cycle_id  = '';
        form.member_id = props.member.id;
        if (classInfo.paysNo != 0) {
            form.payment = '0';
        } else {
            form.payment = props.cycle.amount;                    
        }
        form.welfare   = props.cycle.welfare_amnt;
        form.type      = '1';
    }

    function clearFields() {
        form.cycle_id  = '';
        form.member_id = '';
        form.payment   = '';
        form.welfare   = '';
        form.type      = '';
    }

    // payment modals 
    function showPayment(payment) {
        // console.log(payment);
        // formFields(payment);
        classInfo.modalName  = props.member.name;
        classInfo.modalData  = payment;
        classInfo.isOpen     = true;
    }

    function closePayment() {
        classInfo.isOpen             = false;
        classInfo.modalName          = '';
        classInfo.modalData          = {};
    }

    function showDelete(payment) {
        classInfo.deleteData     = payment;
        classInfo.deleteID       = payment.id;
        classInfo.isDeleteOpen   = true;
    }

    function closeDelete() {
        classInfo.isDeleteOpen   = false;
        classInfo.deleteData     = {};
        classInfo.deleteID       = '';
    }

    // welfare modal 
    function showWelfare(welfare) {
        classInfo.modalData = welfare;
        classInfo.isWelfareOpen = true;
    }

    function closeWelfare() {
        classInfo.isWelfareOpen        = false;
        classInfo.modalData            = {};
    }

    function showWelfareDelete(welfare) {
        classInfo.deleteData = welfare;
        classInfo.deleteID = welfare.id;
        classInfo.isDeleteWelfareOpen = true;
    }

    function closeWelfareDelete() {
        classInfo.isDeleteWelfareOpen = false;
        classInfo.deleteData = {};
        classInfo.deleteID = '';
    }

    function reloadWelfares() {
        reloadPayments()
        tabSwitch3()
    }
</script>