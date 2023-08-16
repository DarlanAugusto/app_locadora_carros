<template>
    <Card header="Marcas">
        <template v-slot:headerActions>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMarcaModal">
                <i class="bi bi-plus"></i>
                Nova
            </button>
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

            <Modal
                id="newMarcaModal"
                title-id="newMarcaModalLabel"
                title="Nova Marca"
                :close-button="true"
            >
                <template v-slot:modalBody>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <Input
                                    id="nome"
                                    label="Nome"
                                    type="text"
                                    placeholder="Nome da Marca"
                                    :v-model="newMarcaName"
                                />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <Input
                                    id="iamgem"
                                    label="Imagem"
                                    type="file"
                                    placeholder="Selecionar PNG"
                                    class-name="form-control-file"
                                    help-text="Apenas imagens PNG"
                                    @change="loadImage($event)"
                                />
                            </div>
                        </div>
                    </div>
                </template>

                <template v-slot:modalFooter>
                    <button type="button" class="btn btn-primary" @click="save()">Salvar</button>
                </template>
            </Modal>
        </template>
    </Card>
</template>

<script>
    import Input from './Input.vue';
    import Table from './Table.vue';
    import Card from './Card.vue';
    import Button from './Button.vue';
    import Modal from './Modal.vue';

    export default {
        components: { Input, Table, Card, Button, Modal },
        data() {
            return {
                newMarcaImage: '',
                newMarcaName: '',
                apiUrl: 'http://localhost:8000/api/v1'
            }
        },
        methods: {
            loadImage(event) {
                this.newMarcaImage = event.target.files
            },
            save() {
                const newMarca = {
                    nome: this.newMarcaName,
                    imagem: this.newMarcaImage
                }

                axios
                    .post(`${this.apiUrl}/marca`, newMarca)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => console.log(error));
            }
        }
}
</script>
