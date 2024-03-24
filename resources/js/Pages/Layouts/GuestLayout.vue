<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100" preserve-scroll>
        <div>
            <Link href="/">
                <ApplicationLogo/>
            </Link>
        </div>

        <section class="font-normal leading-tight uppercase py-1 inline-flex justify-between mb-1 flex-col text-start border-2 border-cyan-800 bg-cyan-600/20 rounded-md w-full sm:max-w-md p-4 m-4 shadow">
            <span class="underline text-[6rem] text-cyan-800 dark:text-teal-900 decoration-teal-700 underline-offset-2 font-boldened">Athoni</span>
            <span class="text-[2rem] text-cyan-800 dark:text-gray-800">Development & Welfare.</span>
            <span class="text-[2rem] text-cyan-800 dark:text-gray-800 mt-2 font-boldened" v-if="$page.component === 'Auth/Register'">REGISTER PAGE.</span>
            <span class="text-[2rem] text-cyan-800 dark:text-gray-800 mt-2 font-boldened" v-else-if="$page.component === 'Auth/Login'">LOGIN PAGE.</span>
        </section>
                        
        <div class="w-full sm:max-w-md my-2 px-4 py-2 bg-white border-2 border-cyan-600 dark:border-cyan-800 shadow-md overflow-hidden rounded-lg font-boldened" preserve-scroll>
            <hr class="w-[90%] text-cyan-800 dark:text-cyan-900 my-1 mx-auto border-t-4 dark:border-cyan-600 shadow-lg shadow-cyan-400">
            <slot />
        </div>
    </div>
</template>
