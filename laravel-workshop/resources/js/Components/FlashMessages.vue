<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const flashMessage = ref(null);
const show = ref(false);

// Watch the shared flash success prop
watch(
    () => page.props.flash?.success,
    (value) => {
        if (value) {
            flashMessage.value = value;
            show.value = true;

            // Auto-hide after 4 seconds
            setTimeout(() => {
                show.value = false;
                // Clear message after transition completes
                setTimeout(() => {
                    flashMessage.value = null;
                }, 200);
            }, 4000);
        }
    },
    { immediate: true }
);
</script>

<template>
    <Transition
        enter-active-class="transition transform ease-out duration-300"
        enter-from-class="opacity-0 translate-x-6"
        enter-to-class="opacity-100 translate-x-0"
        leave-active-class="transition transform ease-in duration-200"
        leave-from-class="opacity-100 translate-x-0"
        leave-to-class="opacity-0 translate-x-6"
    >
        <div
            v-if="show && flashMessage"
            class="fixed bottom-4 right-4 z-50 bg-pixl text-white rounded-lg px-4 py-2 shadow-lg"
            aria-live="polite"
            role="status"
        >
            {{ flashMessage }}
        </div>
    </Transition>
</template>