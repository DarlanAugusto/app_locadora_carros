<template>
    <button :type="type" class="btn" :class="className">
        <slot name="icon"/>
        {{ label }}
    </button>
</template>

<script>
    export default {
        props: ['label', 'className', 'type']
    }
</script>
