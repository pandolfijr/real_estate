<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Cheques</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ check.id ? 'Editar Cheque' : 'Cadastrar Cheque' }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCheckStatus">Status</label>
                                <select class="custom-select" id="inputCheckStatus" name="status"
                                    v-model="check.status">
                                    <option>Selecione a opção</option>
                                    <option v-for="(value, key) in status_check" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCheckStatus">Tipo de Movimentação</label>
                                <select class="custom-select" id="inputCheckStatus" name="status" v-model="check.type">
                                    <option value>Selecione a tipo</option>
                                    <option v-for="(value, key) in type_check" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCheckIssuanceDate">Data de Emissão</label>
                                <input type="date" class="form-control" id="inputCheckIssuanceDate" name="issuance_date"
                                    v-model="check.issuance_date" required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCheckDueDate">Data de Vencimento</label>
                                <input type="date" class="form-control" id="inputCheckDueDate" name="due_date"
                                    v-model="check.due_date" required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCheckCompensationDate">Data de Compensação</label>
                                <input type="date" class="form-control" id="inputCheckCompensationDate"
                                    name="compensation_date" v-model="check.compensation_date" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputTransaction">Transação</label>
                                <div class="form-control" readonly>{{ check.number }}</div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCheckNumber">Número do Cheque</label>
                                <input type="text" class="form-control" id="inputDescription"
                                    placeholder="Descreva a Conta" name="description" v-model="check.number">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCheckBankName">Banco</label>
                                <input type="text" class="form-control" id="inputCheckBankName"
                                    placeholder="Informe o Banco" name="bank_name" v-model="check.bank_name">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCheckBankAgency">Agência</label>
                                <input type="text" class="form-control" id="inputCheckBankAgency"
                                    placeholder="Informe a Agência" name="bank_agency" v-model="check.bank_agency">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCheckBankAccount">Conta</label>
                                <input type="text" class="form-control" id="inputCheckBankAccount"
                                    placeholder="Informe o Banco" name="bank_account" v-model="check.bank_account">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="inputCheckFavoredName">Nome do Favorecido</label>
                                <input type="text" class="form-control" id="inputCheckFavoredName"
                                    placeholder="Informe o nome do Favorecido" name="favored_name"
                                    v-model="check.favored_name">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="inputCheckDescription">Descrição</label>
                                <input type="text" class="form-control" id="inputCheckDescription"
                                    placeholder="Informe o nome do Favorecido" name="description"
                                    v-model="check.description">
                            </div>
                        </div>

                        <div v-if="check.status == 2" class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCheckDepositDate">Data de Depósito</label>
                                <input type="date" class="form-control" id="inputCheckDepositDate" name="deposit_date"
                                    v-model="check.deposit_date" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="check.id" type="submit" class="btn btn-primary"
                        @click="updateCheck()">Atualizar</button>
                    <button v-else type="submit" class="btn btn-primary" @click="saveCheck()">Salvar</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
import { status_check, type_check } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {

    data: function () {
        return {
            data: {},
            check: {
                number: '',
                issuance_date: '',
                due_date: '',
                deposit_date: '',
                compensation_date: '',
                bank_name: '',
                bank_agency: '',
                bank_account: '',
                favored_name: '',
                description: '',
                status: 1,
                type: '',
                id_transaction: ''
            },
            status_check: status_check,
            type_check: type_check,
            config: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false
            },
            showModal: false,
            suppliers: {},

        }
    },
    computed: {

    },
    methods: {
        getCheck() {
            axios.get('/check/' + this.$route.params.id)
                .then(response => {

                    this.check = response.data.check;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveCheck() {
            axios.post('/check', this.check)
                .then(response => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    // this.$router.go();
                })
                .catch(error => {

                    error = this.onError(error);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });

                });
        },
        updateCheck() {
            axios.put('/check/' + this.$route.params.id, this.check)
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
        onError(data) {
            const error = {};
            error.status = data.response.status;
            if (data.response.data.errors) {
                Object.keys(data.response.data.errors).forEach((item) => {
                    error.message = data.response.data.errors[item][0];
                });
            } else {
                error.message = data.body.message;
            }
            return error;
        },
    },
    beforeMount() {
        if (this.$route.params.id) {
            this.getCheck();
        }
    },
};
</script>
