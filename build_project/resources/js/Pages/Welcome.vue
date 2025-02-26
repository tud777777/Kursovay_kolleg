<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {provide} from "vue";
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean
})
provide('canLogin', props.canLogin)
provide('canRegister', props.canRegister)
</script>

<template>
    <Head title="Welcome" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <h1 class="text-4xl">Welcome to my web app Building plan!</h1>
                        <p class="text-lg">To continue register or log in.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
