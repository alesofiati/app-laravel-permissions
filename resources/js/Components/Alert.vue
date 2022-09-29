<script setup>

defineProps({
    color: String,
    message: String
})

</script>

<template>
    <div :class="color" role="alert">
        <p class="font-bold">Atenção</p>
        <p>{{ message }}</p>
    </div>
</template>
