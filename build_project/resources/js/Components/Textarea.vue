<script setup>
const model = defineModel({
    required: true
})
</script>

<template>
<textarea
    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 resize-none"
    style="height: 90px"
    v-model="model"
>

</textarea>
</template>

<style scoped>

</style>
