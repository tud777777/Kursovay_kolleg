<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Textarea from "@/Components/Textarea.vue";
import Select from "@/Components/Select.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {ref} from "vue";
const props = defineProps({
    equipments: Array,
    materials: Array,
    construction_crews: Array
})
const form = useForm({
    name: "",
    description: "",
    image: null,
    end_date: "",
    materials: [],
    equipments: [],
    construction_crews: []
})
function submit(){
    form.post(route("project.create"))
}
const materials_count = ref({count: 0})
const equipments_count = ref({count: 0})
const construction_crews_count = ref({count: 0})
function add_select(ref, form_elem){
    ref.count++
    form_elem.push({ id: "", count: "" });
}
function delete_select(i, form_elem, ref){
    form_elem.splice(i-1,1)
    ref.count--
}
</script>

<template>
    <Head title="Create Project" />
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="w-full flex justify-center items-center">
                    <h2 class="text-2xl">Create Project</h2>
                </div>
                <div class="mt-2">
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div class="mt-2">
                    <InputLabel for="description" value="Description" />

                    <Textarea
                        id="description"
                        class="mt-1 block w-full"
                        v-model="form.description"
                    />

                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div class="mt-2">
                    <InputLabel for="image" value="Add image" />

                    <input
                        id="image"
                        name="image"
                        type="file"
                        class="mt-1 block w-full"
                        @change="form.image = $event.target.files[0]"
                        accept="image/png, image/jpeg, image/jpg, image/webp"
                    >

                    <InputError class="mt-2" :message="form.errors.image" />
                </div>
                <div class="mt-2">
                    <InputLabel for="end_date" value="End date" />

                    <TextInput
                        id="end_date"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.end_date"
                    />

                    <InputError class="mt-2" :message="form.errors.end_date" />
                </div>
                <div class="mt-2">
                    <InputLabel value="Materials" />
                    <div v-for="i in materials_count.count" :key="i" class="flex justify-between items-center w-full gap-2 mt-1">
                        <Select
                            required
                            class="block w-full"
                            v-model="form.materials[i-1].id"
                        >
                            <option v-for="material in materials" :value="material.id">{{material.name}}</option>
                        </Select>
                        <TextInput
                            required
                            id="end_date"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.materials[i-1].count"
                            placeholder="Count"
                        />
                        <SecondaryButton @click.prevent="delete_select(i, form.materials, materials_count)">
                            <svg width="15" height="5" viewBox="0 0 15 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.125 0H1.875C1.37772 0 0.900805 0.263393 0.549175 0.732234C0.197544 1.20107 0 1.83696 0 2.5C0 3.16304 0.197544 3.79893 0.549175 4.26777C0.900805 4.73661 1.37772 5 1.875 5H13.125C13.6223 5 14.0992 4.73661 14.4508 4.26777C14.8025 3.79893 15 3.16304 15 2.5C15 1.83696 14.8025 1.20107 14.4508 0.732234C14.0992 0.263393 13.6223 0 13.125 0Z" fill="white"/>
                            </svg>
                        </SecondaryButton>
                    </div>

                    <InputError class="mt-2" :message="form.errors.materials" />

                    <PrimaryButton class="mt-1" @click.prevent="add_select(materials_count, form.materials)">Add material</PrimaryButton>
                </div>
                <div class="mt-2">
                    <InputLabel value="Equipments" />
                    <div v-for="i in equipments_count.count" :key="i" class="flex justify-between items-center w-full gap-2 mt-1">
                        <Select
                            class="block w-full"
                            v-model="form.equipments[i-1].id"
                            required
                        >
                            <option v-for="equipment in equipments" :value="equipment.id">{{equipment.name}}</option>
                        </Select>
                        <TextInput
                            required
                            id="end_date"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.equipments[i-1].count"
                            placeholder="Count"
                        />
                        <SecondaryButton @click.prevent="delete_select(i, form.equipments, equipments_count)">
                            <svg width="15" height="5" viewBox="0 0 15 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.125 0H1.875C1.37772 0 0.900805 0.263393 0.549175 0.732234C0.197544 1.20107 0 1.83696 0 2.5C0 3.16304 0.197544 3.79893 0.549175 4.26777C0.900805 4.73661 1.37772 5 1.875 5H13.125C13.6223 5 14.0992 4.73661 14.4508 4.26777C14.8025 3.79893 15 3.16304 15 2.5C15 1.83696 14.8025 1.20107 14.4508 0.732234C14.0992 0.263393 13.6223 0 13.125 0Z" fill="white"/>
                            </svg>
                        </SecondaryButton>
                    </div>

                    <InputError class="mt-2" :message="form.errors.equipments" />

                    <PrimaryButton class="mt-1" @click.prevent="add_select(equipments_count, form.equipments)">Add equipment</PrimaryButton>
                </div>
                <div class="mt-2">
                    <InputLabel value="Construction Crews" />
                    <div v-for="i in construction_crews_count.count" :key="i" class="flex justify-between items-center w-full gap-2 mt-1">
                        <Select
                            required
                            class="block w-full"
                            v-model="form.construction_crews[i-1].id"
                        >
                            <option v-for="construction_crew in construction_crews" :value="construction_crew.id">{{construction_crew.name}}</option>
                        </Select>
                        <SecondaryButton @click.prevent="delete_select(i,form.construction_crews,construction_crews_count)">
                            <svg width="15" height="5" viewBox="0 0 15 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.125 0H1.875C1.37772 0 0.900805 0.263393 0.549175 0.732234C0.197544 1.20107 0 1.83696 0 2.5C0 3.16304 0.197544 3.79893 0.549175 4.26777C0.900805 4.73661 1.37772 5 1.875 5H13.125C13.6223 5 14.0992 4.73661 14.4508 4.26777C14.8025 3.79893 15 3.16304 15 2.5C15 1.83696 14.8025 1.20107 14.4508 0.732234C14.0992 0.263393 13.6223 0 13.125 0Z" fill="white"/>
                            </svg>
                        </SecondaryButton>
                    </div>

                    <InputError class="mt-2" :message="form.errors.materials" />

                    <PrimaryButton class="mt-1" @click.prevent="add_select(construction_crews_count, form.construction_crews)">Add construction crew</PrimaryButton>
                </div>
                <div class="mt-4 flex items-center justify-center">
                    <PrimaryButton
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"

                    >
                        Create
                    </PrimaryButton>
                </div>
            </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
