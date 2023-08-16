<template>
    <div class="form-group">
        <label :for="id">{{ label }}</label>
        <input
            class="form-control"
            :class="className"
            :type="type"
            :id="id"
            :placeholder="placeholder"
            :autocomplete="autocomplete"
            v-model="vModel"
        />
        <span class="fs-6 text-muted" v-if="helpText">{{ helpText }}</span>
    </div>
</template>

<script>
    export default {
        props: [
            'type',
            'id',
            'placeholder',
            'label',
            'helpText',
            'className',
            'autocomplete',
            'vModel'
        ]
    }
</script>
