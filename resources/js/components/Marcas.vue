<template>
    <Card header="Marcas">
        <template v-slot:headerActions>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMarcaModal" @click="$store.state.status = ''; $store.state.statusMessage = [];">
                <i class="bi bi-plus"></i>
                Nova
            </button>
        </template>

        <template v-slot:body>
            <!-- Form search -->
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
                :show="{
                    visible: true,
                    target: '#showMarcaModal'
                }"
                :update="{
                    visible: true,
                    target: '#upMarcaModal'
                }"
                :remove="{
                    visible: true,
                    target: '#deleteMarcaModal'
                }"
            />

            <!-- Modal Adicionar Marca -->
            <Modal
                id="newMarcaModal"
                title-id="newMarcaModalLabel"
                title="Nova Marca"
                :close-button="true">

                <template v-slot:modalAlert>
                    <Alert
                        v-if="$store.state.status == 'success'"
                        type="success"
                        :details="$store.state.statusMessage"
                    />
                    <Alert
                        v-if="$store.state.status == 'error'"
                        type="danger"
                        :details="$store.state.statusMessage"
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

            <!-- Modal Visualizar Marca -->
            <Modal
                id="showMarcaModal"
                title-id="showMarcaModalLabel"
                :title="'Marca ' + $store.state.item.nome"
                :close-button="true">
                <template v-slot:modalBody>
                    <div class="row mb-3">
                        <div class="col-6 text-end">
                                <img v-if="$store.state.item.imagem" :src="'/storage/' + $store.state.item.imagem" :alt="'Logo da marca ' + $store.state.item.nome" class="img-thumbnail rounded shadow-sm">
                        </div>
                        <div class="col-6 text-start">
                            <p>Cód: <b>{{ $store.state.item.id }}</b></p>
                            <p>Nome: {{ $store.state.item.nome }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><hr></div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>Criada em: {{ $store.state.item.created_at }}</p>
                            <p>Atualizada em: {{ $store.state.item.updated_at }}</p>
                        </div>
                    </div>
                </template>
                <template v-slot:modalFooter>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </template>
            </Modal>

            <!-- Modal Remoção Marca -->
            <Modal
                id="deleteMarcaModal"
                title-id="deleteMarcaModalLabel"
                :title="($store.state.status == 'success') ? 'Tudo certo!' : 'Remover marca: ' + $store.state.item.nome + ' ?'"
                :close-button="true">

                <template v-slot:modalAlert>
                    <Alert
                        v-if="$store.state.status == 'success'"
                        type="success"
                        :details="$store.state.statusMessage"
                    />
                    <Alert
                        v-if="$store.state.status == 'error'"
                        type="danger"
                        :details="$store.state.statusMessage"
                    />
                </template>

                <template v-slot:modalBody v-if="$store.state.status == ''">
                    <div class="row mb-3">
                        <div class="col-6 text-end">
                                <img v-if="$store.state.item.imagem" :src="'/storage/' + $store.state.item.imagem" :alt="'Logo da marca ' + $store.state.item.nome" class="img-thumbnail rounded shadow-sm">
                        </div>
                        <div class="col-6 text-start">
                            <p>Cód: <b>{{ $store.state.item.id }}</b></p>
                            <p>Nome: {{ $store.state.item.nome }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><hr></div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>Criada em: {{ $store.state.item.created_at }}</p>
                            <p>Atualizada em: {{ $store.state.item.updated_at }}</p>
                        </div>
                    </div>
                </template>
                <template v-slot:modalFooter>
                    <button type="button" :class="'btn btn-' + (($store.state.status == '') ? 'secondary' : 'primary')" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" @click="deleteMarca()" v-if="$store.state.status == ''">Remover</button>
                </template>
            </Modal>

            <!-- Modal Atualizar Marca -->
            <Modal
                id="upMarcaModal"
                title-id="upMarcaModalLabel"
                :title="($store.state.status == 'success') ? 'Tudo certo!' : 'Editando marca: ' + $store.state.item.nome"

                :close-button="true">

                <template v-slot:modalAlert>
                    <Alert
                        v-if="$store.state.status == 'success'"
                        type="success"
                        :details="$store.state.statusMessage"
                    />
                    <Alert
                        v-if="$store.state.status == 'error'"
                        type="danger"
                        :details="$store.state.statusMessage"
                    />
                </template>

                <template v-slot:modalBody>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <InputContainer inputId="upMarcaName" label="Nome">
                                    <input
                                        type="text"
                                        id="upMarcaName"
                                        class="form-control"
                                        placeholder="Nome da Marca"
                                        v-model="$store.state.item.nome"
                                    />
                                </InputContainer>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <InputContainer input-id="upMarcaImage" label="Imagem" help-text="Apenas imagens PNG">
                                    <input
                                        type="file"
                                        id="upMarcaImage"
                                        class="form-control"
                                        @change="loadImage($event)"
                                    />
                                </InputContainer>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-slot:modalFooter>
                    <button type="button" class="btn btn-warning" @click="update()">Salvar Alterações</button>
                </template>
            </Modal>
        </template>

        <template v-slot:footer>
            <!-- Pagination -->
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
    import axios from 'axios';

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
                },
                showMarca: {}
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

                axios
                    .get(url)
                    .then(respose => {
                        this.marcas = respose.data;
                        // console.log(this.marcas);
                    })
            },

            deleteMarca() {

                let url = `${this.apiUrl}/${this.$store.state.item.id}`;

                axios
                    .post(url, { _method: 'DELETE' })
                    .then(response => {
                        this.$store.state.status = 'success';
                        this.$store.state.statusMessage = response;

                        this.getMarcas();
                    })
                    .catch(error => {
                        console.log(error);
                        this.$store.state.status = 'error';
                        this.$store.state.statusMessage = error.response;
                    });
            },

            save() {
                const formData = new FormData();
                formData.append('nome', this.newMarcaName);
                formData.append('imagem', this.newMarcaImage[0]);

                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios
                    .post(this.apiUrl, formData, config)
                    .then(response => {
                        this.$store.state.status = 'success';
                        this.$store.state.statusMessage = response;

                        this.getMarcas();
                    })
                    .catch(error => {
                        this.$store.state.status = 'error';
                        this.$store.state.statusMessage = error.response;
                        console.log(error.response);
                    });
            },

            update() {
                const formData = new FormData();
                formData.append('_method', 'PATCH');
                formData.append('nome', this.$store.state.item.nome);

                if(this.newMarcaImage[0]) {
                    formData.append('imagem', this.newMarcaImage[0]);
                }

                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios
                    .post(`${this.apiUrl}/${this.$store.state.item.id}`, formData, config)
                    .then(response => {
                        upMarcaImage.value = '';
                        this.$store.state.status = 'success';
                        this.$store.state.statusMessage = response;
                    })
                    .catch(error => {
                        this.$store.state.status = 'error';
                        this.$store.state.statusMessage = error.response;
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
