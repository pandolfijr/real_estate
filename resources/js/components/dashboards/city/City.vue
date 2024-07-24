<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Cidades</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ city.id ? 'Editar Cidade' : 'Cadastrar Cidade' }}</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="inputNome">Nome</label>
                                <input type="text" class="form-control" id="inputNome" name="nome"
                                    placeholder="Informe o Nome" maxlength="100" value="" v-model="city.name"
                                    required />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="inputCidade">Estado</label>
                            <select class="custom-select" id="inputCidade" name="cidade" required
                                v-model="city.id_state">
                                <option value>Selecione Estado</option>
                                <option v-for="(value, key) in states" :key="key" :id="key" :value="value.id">
                                    {{ value.name }}
                                </option>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="city.id" type="submit" class="btn btn-primary"
                        @click="updateCity()">Atualizar</button>
                    <button v-else type="submit" class="btn btn-primary" @click="saveCity()">Salvar</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Swal from 'sweetalert2';
import axios from 'axios';
import { onError } from '../../../utils';
export default {

    data: function () {
        return {
            data: {},
            city: {
                id: '',
                name: '',
                id_state: '',
            },
            states: {},
            onError: onError,
        }
    },
    computed: {

    },
    methods: {
        getCity() {
            axios.get('/cities/' + this.$route.params.id)
                .then(response => {
                    this.city = response.data.city;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveCity() {
            axios.post('/cities', this.city)
                .then(response => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    this.$router.go(-1);
                })
                .catch(error => {
                    error = this.onError(error);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.message,
                        showConfirmButton: false,
                        timer: 2500
                    });

                });
        },
        updateCity() {
            axios.put('/cities/' + this.$route.params.id, this.city)
                .then(response => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    this.$router.go(-1);
                })
                .catch(error => {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                });
        },
        back() {
            this.$router.go(-1);
        },
        getStates() {
            axios.get('/states')
                .then(response => {
                    this.states = response.data.states;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },

    },
    created() {
        this.getStates();
        if (this.$route.params.id) {
            this.getCity();
        }
    },
};
</script>
