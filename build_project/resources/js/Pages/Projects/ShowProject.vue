<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ItemForProject from "@/Components/ItemForProject.vue";
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    project: Array,
    equipments: Array,
    materials: Array,
    construction_crews: Array
})

</script>

<template>
    <Head :title="project.name" />
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="w-full flex justify-center items-center">
                    <h2 class="text-2xl">{{project.name}}</h2>
                </div>
                <div v-if="project.image" class="mt-2 flex gap-2 sm:px-6 lg:px-8 pb-3">
                    <img class="w-[100px] h-[75px] object-cover rounded-md border border-gray-200 shadow-sm" :src="`/images/${project.image}`" alt="ne to">
                </div>
                <div class="mt-2 flex gap-2 sm:px-6 lg:px-8 pb-3">
                    <p class="block font-medium text-gray-700">Created by:</p>
                    <p class="block font-medium text-gray-700">{{project.owner.last_name}} {{project.owner.first_name}}</p>
                </div>
                <div class="mt-2 flex gap-2 sm:px-6 lg:px-8 pb-3">
                    <p class="block font-medium text-gray-700">Description:</p>
                    <p class="block font-medium text-gray-700">{{project.description}}</p>
                </div>
                <div class="mt-2 flex gap-2 sm:px-6 lg:px-8 pb-3">
                    <p class="block font-medium text-gray-700">End date:</p>
                    <p class="block font-medium text-gray-700">{{project.end_date}}</p>
                </div>
                <div class="mt-2">
                    <div class="mt-2 sm:px-6 lg:px-8">
                        <p class="block font-medium text-gray-700">Materials:</p>
                    </div>
                    <ItemForProject
                        v-for="material in materials"
                        :key="material.material.id"
                        :id="material.material.id"
                        :count="material.count"
                        :name="material.material.name"
                        :description="material.material.description"
                    />
                </div>
                <div class="mt-2">
                    <div class="mt-2 sm:px-6 lg:px-8">
                        <p class="block font-medium text-gray-700">Equipments:</p>
                    </div>
                    <ItemForProject
                        v-for="equipment in equipments"
                        :key="equipment.equipment.id"
                        :id="equipment.equipment.id"
                        :count="equipment.count"
                        :name="equipment.equipment.name"
                        :description="equipment.equipment.description"
                    />
                </div>
                <div class="mt-2">
                    <div class="mt-2 sm:px-6 lg:px-8">
                        <p class="block font-medium text-gray-700">Construction crews:</p>
                    </div>
                    <ItemForProject
                        v-for="construction_crew in construction_crews"
                        :key="construction_crew.construction_crew.id"
                        :id="construction_crew.construction_crew.id"
                        :count="construction_crew.count"
                        :name="construction_crew.construction_crew.name"
                        :description="construction_crew.construction_crew.description"
                    />
                </div>
                <div class="mt-4 flex items-center justify-center">
                    <Link :href="route('dashboard')">
                        <PrimaryButton
                            class="ms-4"
                        >
                            Exit
                        </PrimaryButton>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
