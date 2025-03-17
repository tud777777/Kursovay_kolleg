<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {provide} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "../../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/NavLink.vue";
import Project from "@/Components/Project.vue";
const props = defineProps({
    projects: Array,
    canLogin: Boolean,
    canRegister: Boolean,
})
provide('canLogin', props.canLogin)
provide('canRegister', props.canRegister)
</script>

<template>
    <Head title="Projects" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Projects
            </h2>
            <a :href="route('project.index')">
                <PrimaryButton>
                    Create project
                </PrimaryButton>
            </a>
        </template>
        {{projects}}
        <Project
            v-if="projects.length !== 0"
            v-for="project in projects"
            :project="project"
        />
        <div v-else class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You don`t have any projects yet!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
