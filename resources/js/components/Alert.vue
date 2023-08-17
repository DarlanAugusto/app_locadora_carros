<template>
    <div :class="className" role="alert">
        <slot />
    </div>
</template>

<script>
export default {
    props: {
        type: String
    },
    computed: {
        className() {
            return `alert alert-${this.type}`;
        }
    }
}
</script>
