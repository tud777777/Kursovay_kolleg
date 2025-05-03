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
        <div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <h1 class="text-4xl">Building plan: Smart Construction Project Management</h1>
                        <p class="text-lg">Building plan is a specialized web application for construction companies to create detailed projects, manage resources, and coordinate teams effortlessly. From material lists to heavy machinery and workforce allocation, BuildPlanner ensures every aspect of your project is optimized for efficiency and cost-effectiveness.<br>
                            Key Features:<br>
                            🏗 Complete Project Setup<br>
                            Define project scope, timelines, and milestones in minutes.<br>
                            Custom templates for residential, commercial, and industrial projects.<br>
                            📦 Material Management<br>
                            Create and track material lists with quantities, suppliers, and costs.<br>
                            Auto-calculate estimated expenses to stay within budget.<br>
                            🚜 Specialized Equipment & Machinery<br>
                            Assign excavators, cranes, trucks, and other machinery to tasks.<br>
                            Schedule usage to avoid downtime and reduce rental costs.<br>
                            👷 Crew & Workforce Coordination<br>
                            Assign teams (brigades) to specific tasks with clear deadlines.<br>
                            Monitor labor hours and productivity in real time.<br></p>
                    </div>

                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
