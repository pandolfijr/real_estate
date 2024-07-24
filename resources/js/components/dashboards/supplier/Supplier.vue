<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Fornecedores</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ supplier.id ? 'Editar Fornecedor' : 'Cadastrar Fornecedor' }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputTypePerson">Tipo de Fornecedor</label>
                                <select class="custom-select" id="inputTypePerson" name="type_person"
                                    @input="treatTypePerson()" :required="true" v-model="supplier.type_person">
                                    <option value="">Selecione o Status</option>
                                    <option v-for="(value, key) in type_person" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>

                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="inputName">Nome da Empresa</label>
                                <input type="text" class="form-control" id="inputName" maxlength="100"
                                    placeholder="Digite o Nome da Empresa" name="name" v-model="supplier.name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div v-if="supplier.type_person == 2" class="form-group">
                                <label for="inputCpf">CPF</label>
                                <input type="text" class="form-control" id="inputCpf" placeholder="Digite o CPF"
                                    v-model="supplier.cpf" v-mask="'###.###.###-##'" name="cpf"
                                    :disabled="!supplier.type_person" :required="true">
                            </div>
                            <div v-else class="form-group">
                                <label for="inputCnpj">CNPJ</label>
                                <input type="text" class="form-control" id="inputCnpj" placeholder="Digite o CNPJ"
                                    v-model="supplier.cnpj" v-mask="'##.###.###/####-##'" name="cnpj"
                                    :disabled="!supplier.type_person" :required="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputTelephone">Telefone</label>
                                <input type="text" class="form-control" id="inputTelephone" name="telephone"
                                    v-model="supplier.telephone" placeholder="Informe o Telefone"
                                    v-mask="['(##) ####-####']" masked="false" required>

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCellphone">Celular</label>
                                <input type="text" class="form-control" id="inputCellphone" name="cellphone"
                                    v-model="supplier.cellphone" placeholder="Informe o Celular"
                                    v-mask="['(##) ####-####', '(##) #####-####']" masked="false">

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputResponsible">Responsável</label>
                                <input type="text" class="form-control" id="inputResponsible" maxlength="100"
                                    placeholder="Digite o Nome do Responsável" name="responsible"
                                    v-model="supplier.responsible">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="text" class="form-control" id="inputEmail" maxlength="40"
                                    v-model="supplier.email" name="email" placeholder="Informe o Email">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCategory">Categoria</label>
                                <select class="custom-select" id="inputCategory" name="category"
                                    v-model="supplier.category">
                                    <option value>Selecione a categoria</option>
                                    <option v-for="(value) in supplier_category" :key="value.id" :value="value.id">
                                        {{ value.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCidade">Cidade</label>
                                <select class="custom-select" id="inputCidade" name="cidade" required
                                    v-model="supplier.id_city">
                                    <option value>Selecione a Cidade</option>
                                    <option v-for="(value, key) in cities" :key="key" :id="key" :value="value.id">
                                        {{ value.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputAddress">Endereço</label>
                                <input type="text" class="form-control" id="inputAddress" maxlength="100"
                                    placeholder="Digite o Endereço" name="address" v-model="supplier.address">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputSite">Site</label>
                                <input type="text" class="form-control" id="inputSite" maxlength="100"
                                    placeholder="Digite o Endereço" name="site" v-model="supplier.site">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="inputObservations">Observações</label>
                                <input type="text" class="form-control" id="inputObservations" maxlength="100"
                                    placeholder="Digite as Observações" name="observations"
                                    v-model="supplier.observations">
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div><br>

                    <br>
                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="supplier.id" type="submit" class="btn btn-primary"
                        @click="updateSupplier()">Atualizar</button>
                    <button v-else type="submit" class="btn btn-primary" @click="saveSupplier()">Salvar</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { type_person, supplier_category, onError } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {

    data: function () {
        return {
            data: {},
            supplier: {
                type_person: '',
                cpf: '',
                cnpj: '',
                address: '',
                telephone: '',
                cellphone: '',
                email: '',
                site: '',
                responsible: '',
                category: '',
                observations: '',
                id_city: '',
            },
            cities: {},
            supplier_category: supplier_category,
            type_person: type_person,
            onError: onError,
        }
    },

    methods: {
        getSupplier() {
            axios.get('/suppliers/' + this.$route.params.id)
                .then(response => {
                    this.supplier = response.data.supplier;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveSupplier() {
            this.handlesSpecialCharacters();
            axios.post('/suppliers', this.supplier)
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
        updateSupplier() {
            this.handlesSpecialCharacters();
            axios.put('/suppliers/' + this.$route.params.id, this.supplier)
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
        getCities() {
            axios.get('/cities', {})
                .then(response => {
                    this.cities = response.data.cities;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        back() {
            this.$router.go(-1);
        },

        handlesSpecialCharacters() {
            this.supplier.cpf = this.supplier.cpf != null ? this.supplier.cpf.replace(/[.\-\s()/]/g, '') : '';
            this.supplier.cnpj = this.supplier.cnpj != null ? this.supplier.cnpj.replace(/[.\-\s()/]/g, '') : '';
            this.supplier.cellphone = this.supplier.cellphone != null ? this.supplier.cellphone.replace(/[.\-\s()/]/g, '') : '';
            this.supplier.telephone = this.supplier.telephone != null ? this.supplier.telephone.replace(/[.\-\s()/]/g, '') : '';
            this.supplier.cep = this.supplier.cep != null ? this.supplier.cep.replace(/[.\-\s()/]/g, '') : '';
        },

        treatTypePerson() {
            if (this.type_person == 1) {
                this.supplier.cpf = '';
            } else if (this.type_person == 2) {
                this.supplier.cnpj = '';
            } else {
                this.supplier.cnpj = '',
                    this.supplier.cpf = '';
            }
        },

    },
    created() {
        this.getCities();
        if (this.$route.params.id) {
            this.getSupplier();
        }
    },
}
</script>
