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
    id: String,
    name: String,
    description: String,
    count: String,
})

const descriptionRef = ref(null);
const arrowRef = ref(null);
const open = ()=>{
    descriptionRef.value.classList.toggle('hidden');
    arrowRef.value.classList.toggle('rotate-180');
}
</script>

<template>
    <div class="pb-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div
                @click.prevent="open"
                class="overflow-hidden bg-white shadow-sm rounded-lg"
            >
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div class="flex gap-2 items-center">
                        <p>Name:</p>
                        <p>{{name}}</p>
                    </div>
                    <div v-if="count" class="flex gap-2">
                        <p>Count:</p>
                        <p>{{count}}</p>
                    </div>
                    <img ref="arrowRef" class="transition-all" src="../../images/arrow-down.svg" alt="arrow">
                </div>
                <div ref="descriptionRef" class="p-6 flex flex-col gap-2 items-start text-gray-900 hidden">
                    <div class="flex gap-2">
                        <p>Description:</p>
                        <p>{{description || "The description is missing"}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    img{
        transition: 0.2s;
    }
    img:hover{
        filter: brightness(60%);
    }
</style>
