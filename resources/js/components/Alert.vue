<template>
    <div :class="className" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" v-if="closeButton"></button>

        <template v-if="details.data.message">{{ details.data.message }}</template>
        <template v-if="details.data.id">Operação realizada com sucesso ({{ details.data.id }})!</template>

        <ul v-if="details.data.errors">
            <li v-for="error, key in details.data.errors" :key="key">{{ error[0] }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: [
        'type',
        'closeButton',
        'details'
    ],
    computed: {
        className() {
            return `alert alert-${this.type}`;
        }
    }
}
</script>
