<template>
    <Card header="Marcas">
        <template v-slot:headerActions>
            <Button className="btn-primary btn-small" label="Novo">
                <template v-slot:icon>
                    <i class="bi bi-plus"></i>
                </template>
            </Button>
        </template>

        <template v-slot:body>
            <div class="row">
                <div class="col-5">
                    <Input
                        id="id"
                        label="ID"
                        type="text"
                        placeholder="ID da Marca"

                    />
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <Input
                            id="nome"
                            label="Nome"
                            type="text"
                            placeholder="Nome da Marca"
                        />
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button type="button" class="btn btn-primary form-control">Buscar</button>
                    </div>
                </div>
            </div>

            <hr>

            <Table />
        </template>

    </Card>
</template>

<script>
    import Input from './Input.vue';
    import Table from './Table.vue';
    import Card from './Card.vue';
    import Button from './Button.vue';

    export default {
        components: { Input, Table, Card, Button }
}
</script>
