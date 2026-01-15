<script setup>
defineProps({ greeting: String });
</script>

<template>
    <div>
        <h1>{{ greeting }}</h1>
        <p>Hello from Vue + Inertia.</p>
    </div>
</template>