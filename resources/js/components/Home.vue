<template>
    <Card header="Home">
        <template v-slot:body>
            <p>Você está logado!</p>
        </template>
    </Card>
</template>

<script>
    import Card from './Card.vue';

    export default {
        components: { Card }
    }
</script>
