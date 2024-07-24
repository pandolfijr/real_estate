<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Conta à Pagar</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ account.id ? 'Editar Conta' : 'Cadastrar Conta' }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div :class="account.category == 6 ? 'col-sm-4' : 'col-sm-6'">
                            <div class="form-group">
                                <label for="inputCategory">Categoria</label>
                                <select class="custom-select" id="inputCategory" name="category"
                                    @change="treatCategory($event.target.value)" v-model="account.category">
                                    <option value>Selecione a categoria</option>
                                    <option v-for="(value, key) in category_account_pay" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div :class="account.category == 6 ? 'col-sm-4' : 'col-sm-6'">
                            <div class="form-group">
                                <label for="inputIdAccount">Fornecedor {{ account.id_supplier }}</label>
                                <select class="custom-select" id="inputIdAccount" name="id_supplier" required
                                    :disabled="!account.category" v-model="account.id_supplier">
                                    <option value="">Selecione o Fornecedor</option>
                                    <option v-for="(value) in suppliers" :key="value.id" :id="value.id"
                                        :value="value.id">
                                        {{ value.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div v-if="account.category == 6" class="col-sm-4">
                            <div class="form-group">
                                <label for="inputIdImovel">Imóvel</label>
                                <select class="custom-select" id="inputIdImovel" name="id_property" required
                                    v-model="account.id_property" @change="treatProperty($event.target.value)">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in properties" :key="key" :id="key" :value="value.id">
                                        {{ '[' + value.reference + '] - ' + value.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div v-if="account.category == 6" class="col-sm-4">
                            <div class="form-group">
                                <label for="inputIdAccount">Proprietário</label>

                                <div v-if="account.id" class="form-control" readonly>
                                    {{ account.locator.people.name + ' ' + account.locator.people.surname }}
                                </div>
                                <div v-else class="form-control" readonly> {{ (property && property.locator) ?
                                    property.locator.people.name + ' ' + property.locator.people.surname : '' }}</div>
                            </div>
                        </div>
                        <div :class="account.category == 6 ? 'col-sm-4' : 'col-sm-6'">
                            <div class="form-group">
                                <label for="inputDescription">Descrição</label>
                                <input type="text" class="form-control" id="inputDescription"
                                    placeholder="Descreva a Conta" name="description" v-model="account.description">
                            </div>
                        </div>

                        <div :class="account.category == 6 ? 'col-sm-4' : 'col-sm-6'">
                            <div class="form-group">
                                <label for="inputObservations">Observações</label>
                                <input type="text" class="form-control" id="inputObservations"
                                    placeholder="Descreva a Observação" name="observations"
                                    v-model="account.observations">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputExpectDate">Data Vencimento</label>
                                <input type="date" class="form-control" id="inputExpectDate"
                                    placeholder="Informe a Data Esperada" name="expect_date"
                                    v-model="account.expect_date" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputPaymentMethod">Método de Pagamento</label>
                                <select class="custom-select" id="inputPaymentMethod" name="payment_method"
                                    v-model="account.payment_method">
                                    <option value>Selecione a opção</option>
                                    <option v-for="(value, key) in payment_method" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputOriginalValue">Valor</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="account.original_value" v-bind="config"
                                        id="inputOriginalValue" placeholder="Venda" name="original_value"></money3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="account.id" type="submit" class="btn btn-primary"
                        @click="updateAccount()">Atualizar</button>
                    <button v-else type="submit" class="btn btn-primary" @click="saveAccount()">Salvar</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { category_account_pay, payment_method, onError } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
    data: function () {
        return {
            data: {},
            account: {
                id: '',
                description: '',
                original_value: '',
                penalty_value: '',
                final_value: '',
                type: 1,
                status: 1,
                payment_method: '',
                category: '',
                observations: '',
                discharge_date: '',
                expect_date: '',
                id_supplier: '',
                id_check: '',
                id_property: '',
            },
            category_account_pay: category_account_pay,
            payment_method: payment_method,
            onError: onError,
            config: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false
            },
            suppliers: {},
            properties: {},
            property: {}
        }
    },
    computed: {

    },
    methods: {
        getAccount() {
            axios.get('/accounts-pay/' + this.$route.params.id)
                .then(response => {
                    this.account = response.data.account;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveAccount() {
            return !this.validateDischargeDate()
                ? false
                : axios.post('/accounts-pay', this.account)
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
        updateAccount() {
            axios.put('/accounts-pay/' + this.$route.params.id, this.account)
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
        getSuppliers() {
            axios.get('/suppliers')
                .then(response => {
                    this.suppliers = response.data.suppliers.data;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },

        validateDischargeDate() {
            if (this.account.status == 2 && this.account.discharge_date == '') {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'O campo data de quitação é obrigatório',
                    showConfirmButton: false,
                    timer: 2500
                });
                return false;
            }
            return true;
        },
        back() {
            this.$router.go(-1);
        },
        treatCategory(id_category) {
            if (id_category == 6) {
                this.account.id_property = '';
                this.property = {};
            }
        },
        getProperties() {
            axios.get('/properties', {
                params: {
                    order: 'reference',
                }
            })
                .then(response => {
                    const properties = response.data.properties.data;
                    this.properties = properties.filter(property => property.transaction && property.transaction.length > 0);
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
        treatProperty(id) {
            if (id) {

                this.property = this.properties.filter((value, index) => value.id == id)[0];
                console.log(this.property);
                this.account.id_locator = this.property.id_locator;

            } else {
                this.property = {};
            }
        },
    },
    beforeMount() {
        this.getSuppliers();
        this.getProperties();
        if (this.$route.params.id) {
            this.getAccount();

        }

    },

};
</script>
