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
                <div class="col-4">
                    <InputContainer inputId="id" label="ID">
                        <input type="text" id="id" class="form-control" placeholder="ID da Marca" v-model="search.id">
                    </InputContainer>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <InputContainer inputId="nome" label="Nome">
                            <input type="text" id="nome" class="form-control" placeholder="Nome da Marca" v-model="search.nome">
                        </InputContainer>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button type="button" class="btn btn-primary form-control" @click="filter()">Buscar</button>
                    </div>
                </div>
            </div>

            <hr v-if="marcas.data">

            <Table
                v-if="marcas.data"
                :data="marcas.data"
                :headers="headers"
            />

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

        <template v-slot:footer>
            <Paginate>
                <li
                    class="page-item"
                    v-for="page, key in marcas.links"
                    :key="key"
                    :class="page.active ? 'active' : ''"
                    >

                    <a class="page-link" :href="page.url" v-html="page.label" @click.prevent="paginate(page)"></a>
                </li>
            </Paginate>
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
    import Paginate from './Paginate.vue';

    export default {
        components: {
            InputContainer,
            Table,
            Card,
            Button,
            Modal,
            Alert,
            Paginate
        },
        data() {
            return {
                newMarcaImage: '',
                newMarcaName: '',
                apiUrl: 'http://localhost:8000/api/v1/marca',
                urlPaginate: '',
                urlFilter: '',
                status: '',
                statusDetails: [],
                marcas: {},
                headers: {
                    id: { title: "Id", type: "text" },
                    nome: { title: "Nome", type: "text" },
                    imagem: { title: "Imagem", type: "file" },
                    created_at: { title: "Data de Criação", type: "date" }
                },
                search: {
                    id: '',
                    nome: ''
                }
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
            getMarcas() {
                let url = this.apiUrl;

                if(this.urlPaginate != '') {
                    url += `?${this.urlPaginate}`;
                }

                if(this.urlFilter != '') {
                    url += (this.urlPaginate != '') ? '&' : '?';
                    url += `filter=${this.urlFilter}`;
                }

                const config = {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Accept': 'application/json'
                    }
                }

                axios
                    .get(url, config)
                    .then(respose => {
                        this.marcas = respose.data;
                        // console.log(this.marcas);
                    })
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
                    .post(this.apiUrl, formData, config)
                    .then(response => {
                        this.status = 'success';
                        this.statusDetails = response;
                    })
                    .catch(error => {
                        this.status = 'error';
                        this.statusDetails = error.response;
                        console.log(error.response);
                    });
            },
            paginate(page) {

                if(!page.url) return;

                let paginate = page.url.split('?');
                this.urlPaginate = paginate[1];

                this.getMarcas();
            },
            filter() {

                let filters = '';

                for (const key in this.search) {

                    if(this.search[key]) {

                        filters += (filters != '') ? `;${key}:like:%${this.search[key]}%` : `${key}:like:%${this.search[key]}%`;

                    }

                    if(filters != '') {
                        this.urlPaginate = '';
                    }

                }

                this.urlFilter = filters;
                this.getMarcas();
            }
        },
        mounted() {
            this.getMarcas();
        }
}
</script>
