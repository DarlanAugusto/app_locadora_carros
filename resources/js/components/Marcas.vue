<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Marcas</div>

                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Input from './Input.vue';

    export default {
    components: { Input, Input }
}
</script>
