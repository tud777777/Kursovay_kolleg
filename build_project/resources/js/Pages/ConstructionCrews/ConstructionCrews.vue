<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Item from "@/Components/Item.vue";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    construction_crews: Array,
    add_success: Boolean,
})
const isModalOpen = ref(false);

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    props.add_success = false;
    form.name = ''
    form.description = ''
};
const form = useForm({
    name: '',
    description: '',
});

const submit = () => {
    form.post(route('construction_crews.add'));
};
</script>

<template>
    <Head title="Construction crews" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Construction crews
            </h2>
            <PrimaryButton @click="openModal">
                Add construction crews
            </PrimaryButton>
        </template>

        <Item v-if="construction_crews.length !== 0"
              v-for="construction_crew in construction_crews"
              :key="construction_crew.id"
              :name="construction_crew.name"
              :description="construction_crew.description"
              :id="construction_crew.id"
              nameOfItems="construction_crews"
        />
        <div v-else class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You don`t have any construction crews yet!
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="isModalOpen" @close="closeModal" maxWidth="lg">
            <div class="p-6">
                <form @submit.prevent="submit">
                    <div class="w-full flex justify-center items-center">
                        <h2 class="text-2xl">Add construction crew</h2>
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

                        <TextInput
                            id="description"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.description"
                        />

                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>
                    <p v-if="add_success" class="mt-1" style="color: green">Success!</p>
                    <div class="mt-4 flex items-center justify-center">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Add
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
