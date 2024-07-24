<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Contas Bancárias</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ bank_account.id ? 'Editar Conta' : 'Cadastrar Conta' }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputBankCode">Código do Banco</label>
                                <input type="text" class="form-control" id="inputBankCode"
                                    placeholder="Digite o Cód. do Banco" name="bank_code"
                                    v-model="bank_account.bank_code" maxlength="10">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputBankName">Nome Banco</label>
                                <input type="text" class="form-control" id="inputBankName"
                                    placeholder="Digite o Nome do Banco" name="bank_name" maxlength="30"
                                    v-model="bank_account.bank_name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputOwner">Proprietário da Conta</label>
                                <input type="text" class="form-control" id="inputOwner"
                                    placeholder="Digite o nome do Proprietário" maxlength="50" name="account_name"
                                    v-model="bank_account.owner">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputAccountType">Tipo da Conta</label>
                                <select class="custom-select" id="inputAccountType" name="account_type" required
                                    v-model="bank_account.account_type">
                                    <option value="">Selecione o Status</option>
                                    <option v-for="(value, key) in account_type" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputAgency">Agência</label>
                                <input type="text" class="form-control" id="inputAgency" maxlength="10"
                                    placeholder="Digite o Agência" name="agency" v-model="bank_account.agency">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputAccount">Número da Conta</label>
                                <input type="text" class="form-control" id="inputAccount" placeholder="Nº da Conta"
                                    name="account" maxlength="15" v-model="bank_account.account">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputAgreement">Contrato</label>
                                <input type="text" class="form-control" id="inputAgreement"
                                    placeholder="Digite o Número do Contrato" name="agreement"
                                    v-model="bank_account.agreement">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCovenant">Convênio</label>
                                <input type="text" class="form-control" id="inputCovenant"
                                    placeholder="Digite o Número do Convênio" name="covenant"
                                    v-model="bank_account.covenant">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputAccountName">Descrição da Conta</label>
                                <input type="text" class="form-control" id="inputAccountName"
                                    placeholder="Descreva a Conta" maxlength="20" name="account_name"
                                    v-model="bank_account.account_name">
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="bank_account.id" type="submit" class="btn btn-primary"
                        @click="updateBank()">Atualizar</button>
                    <button v-else type="submit" class="btn btn-primary" @click="saveBank()">Salvar</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { account_type, onError } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {

    data: function () {
        return {
            data: {},
            bank_account: {
                id: '',
                bank_code: '',
                bank_name: '',
                agency: '',
                account: '',
                account_type: '',
                account_name: '',
                agreement: '',
                covenant: '',
                owner: '',
            },
            account_type: account_type,
            onError: onError,
        }
    },

    methods: {
        getBank() {
            axios.get('/bank-accounts/' + this.$route.params.id)
                .then(response => {
                    this.bank_account = response.data.bank_account;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveBank() {
            axios.post('/bank-accounts', this.bank_account)
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
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });

                });
        },
        updateBank() {
            axios.put('/bank-accounts/' + this.$route.params.id, this.bank_account)
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
        back() {
            this.$router.go(-1);
        },
    },
    beforeMount() {
        if (this.$route.params.id) {
            this.getBank();
        }
    },
};
</script>
