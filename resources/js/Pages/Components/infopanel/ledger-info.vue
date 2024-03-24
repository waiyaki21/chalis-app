<template>
    <!-- header  -->
    <section class="font-normal text-cyan-800 dark:text-gray-300 leading-tight uppercase py-1 px-2 grid grid-cols-1 md:grid-cols-5 gap-1 font-boldened">
        <section class="inline-flex justify-start w-full col-span-5">
            <span class="underline text-3xl md:text-5xl">{{ props.header }}</span>
            <span class="text-sm text-gray-500 dark:text-gray-500 ml-4 md:mt-10">
                ( Admin )
            </span>
        </section>
    </section>
    <!-- end header  -->
</template>

<script setup>

    import { defineProps } from 'vue'

    const props = defineProps({
        header: {
            type: String,
            required: true,
        },
    });
</script>
