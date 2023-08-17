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
                    <InputContainer inputId="id" label="ID">
                        <input type="text" id="id" class="form-control" placeholder="ID da Marca">
                    </InputContainer>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <InputContainer inputId="nome" label="Nome">
                            <input type="text" id="nome" class="form-control" placeholder="Nome da Marca">
                        </InputContainer>
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
                :close-button="true">

                <template v-slot:modalAlert>
                    <Alert
                        v-if="status == 'success'"
                        type="success"
                        :details="statusDetails"
                    />
                    <Alert
                        v-if="status == 'error'"
                        type="danger"
                        :details="statusDetails"
                    />
                </template>

                <template v-slot:modalBody>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <InputContainer inputId="newMarcaName" label="Nome">
                                    <input
                                        type="text"
                                        id="newMarcaName"
                                        class="form-control"
                                        placeholder="Nome da Marca"
                                        v-model="newMarcaName"
                                    />
                                </InputContainer>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <InputContainer input-id="newMarcaImage" label="Imagem" help-Text="Apenas imagens PNG">
                                    <input
                                        type="file"
                                        id="newMarcaImage"
                                        class="form-control"
                                        @change="loadImage($event)"
                                    />
                                </InputContainer>
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
    import InputContainer from './InputContainer.vue';
    import Table from './Table.vue';
    import Card from './Card.vue';
    import Button from './Button.vue';
    import Modal from './Modal.vue';
    import Alert from './Alert.vue';

    export default {
        components: {
            InputContainer,
            Table,
            Card,
            Button,
            Modal,
            Alert
        },
        data() {
            return {
                newMarcaImage: '',
                newMarcaName: '',
                apiUrl: 'http://localhost:8000/api/v1',
                status: '',
                statusDetails: []
            }
        },
        computed: {
            token() {
                let token = document.cookie.split(';').find(index => index.includes('token=')) || '=';

                return token.split('=')[1];
            }
        },
        methods: {
            loadImage(event) {
                this.newMarcaImage = event.target.files
            },
            save() {

                const formData = new FormData();
                formData.append('nome', this.newMarcaName);
                formData.append('imagem', this.newMarcaImage[0]);

                const config = {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json'
                    }
                }

                axios
                    .post(`${this.apiUrl}/marca`, formData, config)
                    .then(response => {
                        this.status = 'success';
                        this.statusDetails = response;
                    })
                    .catch(error => {
                        this.status = 'error';
                        this.statusDetails = error.response;
                        console.log(error.response);
                    });
            }
        }
}
</script>
