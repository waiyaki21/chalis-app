<script setup>
import { computed, onMounted, onUnmounted, defineEmits, ref } from 'vue';

const emit = defineEmits(['selected'])

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '72',
    },
    contentClasses: {
        type: String,
        default: 'py-1 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700',
    },
    cycle: {
        type: Object,
        required: true
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const listClass = computed(() => {
    let x = 'py-2 text-base text-gray-700 dark:text-gray-200';
    return x;
});

const selectClass = computed(() => {
    let x = 'block px-4 py-2 uppercase dark:hover:text-cyan-600 hover:underline text-lg';
    return x;
});

const widthClass = computed(() => {
    return {
        72: 'w-72',
    }[props.width.toString()];
});

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'origin-top-left left-0';
    } else if (props.align === 'right') {
        return 'origin-top-right right-0';
    } else {
        return 'origin-top';
    }
});

function downloadAll() {
    emit('all', props.cycle);
}

function downloadActive() {
    emit('active', props.cycle);
}

function download() {
    emit('down', props.cycle);
}

const open = ref(false);
</script>

<template>
    <div class="relative mt-0.5">
        <button
            class="inline-flex items-center px-2 pb-2 pt-2 text-sm font-medium text-amber-500 bg-transparent rounded-md hover:text-white focus:z-10 dark:text-amber-500 dark:hover:text-amber-500 mt-2.5"
            type="button" @click="open = !open">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                :class="['md:w-8 md:h-8 w-6 h-6']">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
            </svg>
        </button>


        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="fixed inset-0 z-40" @click="open = false"></div>

        <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-show="open" class="absolute z-50 mt-2 rounded-md shadow-lg border-2 border-cyan-500"
                :class="[widthClass, alignmentClasses]" style="display: none" @click="open = false">
                <div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
                    <slot name="content" />
                    <ul :class='listClass'>
                        <li>
                            <a @click="download" :class='selectClass'>Download Paid Members Sheet</a>
                        </li>
                        <li>
                            <a @click="downloadActive" :class='selectClass'>Download Active Members Sheet</a>
                        </li>
                        <li>
                            <a @click="downloadAll" :class='selectClass'>Download All Members</a>
                        </li>
                    </ul>
                </div>
            </div>
        </Transition>
    </div>
</template>
