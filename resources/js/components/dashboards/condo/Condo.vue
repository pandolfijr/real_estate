<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Condomínios/Prédios</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ condo.id ? 'Editar Condomínio/Prédio' : 'Cadastrar Condomínio/Prédio' }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputDescription">Descrição do Condomínio / Prédio</label>
                                <input type="text" class="form-control" id="inputDescription"
                                    placeholder="Descreva o Condomínio / Prédio" name="description" maxlength="255"
                                    v-model="condo.description">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputIdCity">Cidade</label>
                                <select class="custom-select" id="inputIdCity" name="id_city" required
                                    v-model="condo.id_city">
                                    <option value>Selecione a Cidade</option>
                                    <option v-for="(value, key) in cities" :key="key" :id="key" :value="value.id">
                                        {{ value.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputType">Tipo</label>
                                <select class="custom-select" id="inputType" name="type" v-model="condo.type">
                                    <option value>Selecione o tipo</option>
                                    <option v-for="(value, key) in type_condo" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCep">CEP</label>
                                <input type="text" class="form-control cep" id="cep" placeholder="Digite o CEP"
                                    v-mask="'#####-###'" masked="false" name="cep" v-model="condo.cep">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="inputAddress">Endereço</label>
                                <input type="text" class="form-control" id="inputAddress" maxlength="255"
                                    placeholder="Digite o Endereço" name="address" v-model="condo.address">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="inputNumber">Número</label>
                                <input type="text" class="form-control" id="inputNumber" placeholder="No." name="number"
                                    @keypress="isNumber($event)" maxlength="5" v-model="condo.number">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputDistrict">Bairro</label>
                                <input type="text" class="form-control" id="inputDistrict" placeholder="Digite o Bairro"
                                    maxlength="20" name="district" v-model="condo.district">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputNumberFloors">Número de Andares</label>
                                <input type="text" class="form-control" id="inputNumberFloors"
                                    placeholder="Digite a quantidade de Andares" :maxlength="'2'"
                                    @keypress="isNumber($event)" name="number_floors" v-model="condo.number_floors">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputNumberTowers">Número de Torres</label>
                                <input type="text" class="form-control numero" id="inputNumberTowers" maxlength="2"
                                    placeholder="Digite a quantidade de Torres" @keypress="isNumber($event)"
                                    name="number_towers" v-model="condo.number_towers">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputNumberLots">Número de Lotes</label>
                                <input type="text" class="form-control" id="inputNumberLots"
                                    placeholder="Digite a quantidade de Lotes" v-model="condo.number_lots" maxlength="2"
                                    @keypress="isNumber($event)" name="number_lots">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputNumberCourts">Número de Quadras</label>
                                <input type="text" class="form-control" id="inputNumberCourts"
                                    v-model="condo.number_courts" @keypress="isNumber($event)"
                                    placeholder="Digite a quantidade de Quadras" maxlength="2" name="number_courts">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="condo.id" type="submit" class="btn btn-primary"
                        @click="updateCondo()">Atualizar</button>
                    <button v-else type="submit" class="btn btn-primary" @click="saveCondo()">Salvar</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
import { type_condo, isNumber } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {

    data: function () {
        return {
            data: {},
            condo: {
                description: '',
                type: '',
                number_floors: '',
                number_towers: '',
                number_lots: '',
                number_courts: '',
                address: '',
                number: '',
                district: '',
                cep: '',
                id_city: '',
            },
            cities: {},
            type_condo: type_condo,
            isNumber:isNumber,
        }
    },

    methods: {
        getCondo() {
            axios.get('/condos/' + this.$route.params.id)
                .then(response => {
                    this.condo = response.data.condo;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveCondo() {
            this.handlesSpecialCharacters();
            axios.post('/condos', this.condo)
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
        updateCondo() {
            this.handlesSpecialCharacters();
            axios.put('/condos/' + this.$route.params.id, this.condo)
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
        getCities() {
            axios.get('/cities')
                .then(response => {
                    this.cities = response.data.cities;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        handlesSpecialCharacters() {
            this.condo.cep = this.condo.cep != null ? this.condo.cep.replace(/[.\-\s()/]/g, '') : '';
        },
    },
    beforeMount() {
        this.getCities();
        if (this.$route.params.id) {
            this.getCondo();
        }
    },
};
</script>
