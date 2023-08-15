<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Marcas</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input class="form-control" type="text" id="id" placeholder="ID da Marca" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input class="form-control" type="text" id="nome" placeholder="Nome da Marca" autocomplete="off">
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
    export default {

    }
</script>
