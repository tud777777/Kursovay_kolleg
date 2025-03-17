<script setup>
import {ref} from "vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    project: Object,
})

const isModalDeleteOpen = ref(false);
const openDeleteModal = () => {
    isModalDeleteOpen.value = true;
};
const closeDeleteModal = () => {
    isModalDeleteOpen.value = false;
};

const descriptionRef = ref(null);
const arrowRef = ref(null);

const form = useForm({
    id: props.project.id,
})
function delete_item(){
    form.delete(route(`project.delete`))
    closeDeleteModal()
}
function show() {
    form.get(route(`project.current`))
}
function edit() {
    form.get(route(`project.edit`))
}
</script>

<template>
    <div class="pt-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div
                class="overflow-hidden bg-white shadow-sm rounded-lg"
                @click.prevent="show"
            >
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div class="flex gap-2 items-center">
                        <p>Name:</p>
                        <p>{{project.name}}</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <p>Created by:</p>
                        <p>{{project.owner.last_name}}</p>
                        <p>{{project.owner.first_name}}</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <p>End date:</p>
                        <p>{{project.end_date}}</p>
                    </div>
                    <div class="flex gap-4 items-center">
                        <PrimaryButton @click.stop.prevent="edit">
                            <svg width="10" height="15" viewBox="0 0 10 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.58821 1.19096L7.95667 0.138202C7.75891 0.0108332 7.51997 -0.0306853 7.2924 0.0227776C7.06482 0.0762405 6.86725 0.220307 6.74314 0.423292L6.09949 1.47456L9.22179 3.48652L9.86496 2.43625C10.1234 2.01306 9.99996 1.45625 9.58821 1.19096ZM0.545777 10.5524L3.66712 12.5649L8.75412 4.25072L5.63182 2.23777L0.545294 10.5529L0.545777 10.5524ZM0.0684632 13.1093L0 15L1.62962 14.115L3.14352 13.2944L0.131141 11.3512L0.0684632 13.1093Z" fill="white"/>
                            </svg>
                        </PrimaryButton>
                        <DangerButton @click.stop.prevent="openDeleteModal">
                            <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 0.833333H9L8.14286 0H3.85714L3 0.833333H0V2.5H12M0.857143 13.3333C0.857143 13.7754 1.03775 14.1993 1.35925 14.5118C1.68074 14.8244 2.11677 15 2.57143 15H9.42857C9.88323 15 10.3193 14.8244 10.6408 14.5118C10.9622 14.1993 11.1429 13.7754 11.1429 13.3333V3.33333H0.857143V13.3333Z" fill="white"/>
                            </svg>
                        </DangerButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Modal :show="isModalDeleteOpen" @close="closeDeleteModal" maxWidth="lg">
        <div class="p-6 flex flex-col gap-1">
            <div class="w-full flex justify-start items-center">
                <h2 class="text-2xl">Delete "{{project.name}}"?</h2>
            </div>
            <div class="w-full flex justify-end items-center gap-2">
                <PrimaryButton @click.prevent="closeDeleteModal">
                    No
                </PrimaryButton>
                <DangerButton @click.prevent="delete_item">
                    Yes
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>

<style scoped>
    img{
        transition: 0.2s;
    }
    img:hover{
        filter: brightness(60%);
    }
</style>
