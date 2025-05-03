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
                    <div class="flex gap-2 items-center overflow-hidden pr-1.5 box-border">
                        <p>Name:</p>
                        <p class="truncate max-w-80 block">{{name}}</p>
                    </div>
                    <div v-if="count" class="md:flex hidden gap-2 pr-1.5 overflow-hidden box-border">
                        <p>Count:</p>
                        <p class="truncate max-w-[150px] block">{{count}}</p>
                    </div>
                    <img ref="arrowRef" class="transition-all" src="../../images/arrow-down.svg" alt="arrow">
                </div>
                <div ref="descriptionRef" class="p-6 flex hidden flex-col gap-2 items-start text-gray-900">
                    <div v-if="count" class="flex md:hidden gap-2 pr-1.5 overflow-hidden box-border">
                        <p>Count:</p>
                        <p class="truncate max-w-[150px] block">{{count}}</p>
                    </div>
                    <div class="flex gap-2 overflow-hidden">
                        <p>Description:</p>
                        <p class="whitespace-normal break-words max-w-[500px]">{{description || "The description is missing"}}</p>
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
