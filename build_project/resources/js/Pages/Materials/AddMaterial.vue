<template>
    <div>
        <!-- Кнопка для открытия модального окна -->
        <button @click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded">
            Открыть модальное окно
        </button>

        <!-- Компонент модального окна -->
        <Modal :show="isModalOpen" @close="closeModal" maxWidth="lg">
            <p>Это содержимое модального окна!</p>
        </Modal>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Modal from "@/Components/Modal.vue";


const isModalOpen = ref(false);

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};
</script>
