<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Conta à Receber</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ account.id ? 'Editar Conta' : 'Cadastrar Conta' }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputCategory">Categoria</label>
                                <select class="custom-select" id="inputCategory" name="category"
                                    v-model="account.category">
                                    <option value>Selecione a categoria</option>
                                    <option v-for="(value, key) in category_account_receive" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputIdAccount">Fornecedor</label>
                                <select class="custom-select" id="inputIdAccount" name="id_supplier" required
                                    v-model="account.id_supplier">
                                    <option value="">Selecione o Fornecedor</option>
                                    <option v-for="(value) in suppliers" :key="value.id" :id="value.id"
                                        :value="value.id">
                                        {{ value.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputDescription">Descrição</label>
                                <input type="text" class="form-control" id="inputDescription"
                                    placeholder="Descreva a Conta" name="description" v-model="account.description">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <div class="form-control" id="inputStatus" name="status" readonly>
                                    {{ status_account[account.status] }}
                                </div>
                            </div>
                        </div>
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
                    </div>

                    <div class="row">
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
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="inputObservations">Observações</label>
                                <input type="text" class="form-control" id="inputObservations"
                                    placeholder="Descreva a Observação" name="observations"
                                    v-model="account.observations">
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
import { status_account, category_account_receive, payment_method, onError } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
    watch: {

    },


    data: function () {
        return {
            data: {},
            account: {
                id: '',
                description: '',
                original_value: '',
                penalty_value: '',
                final_value: '',
                type: 2,
                status: 1,
                payment_method: '',
                category: '',
                observations: '',
                discharge_date: '',
                expect_date: '',
                id_supplier: '',
                id_check: '',
            },
            config: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false
            },
            suppliers: {},
            status_account: status_account,
            category_account_receive: category_account_receive,
            payment_method: payment_method,
            onError: onError,

        }
    },

    methods: {
        getAccount() {
            axios.get('/accounts-receive/' + this.$route.params.id)
                .then(response => {
                    this.account = response.data.account;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveAccount() {
            return !this.validateDischargeDate() ?
                false :
                axios.post('/accounts-receive', this.account)
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
            axios.put('/accounts-receive/' + this.$route.params.id, this.account)
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
    },
    created() {
        this.getSuppliers();
        if (this.$route.params.id) {
            this.getAccount();
        }
    },

};
</script>
