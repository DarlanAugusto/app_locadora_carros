<template>
    <div class="form-group">
        <label :for="inputId">{{ label }}</label>
        <slot/>
        <span class="fs-6 text-muted" v-if="helpText">{{ helpText }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            inputId: String,
            label: String,
            helpText: String
        }
    }
</script>
