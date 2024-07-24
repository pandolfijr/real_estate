<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2 v-if="!account.id_casher">Baixar Conta</h2>
            <h2 v-else>Visualizar Conta Paga</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Conta à Pagar</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputCategory">Categoria</label>
                                <div class="form-control" id="inputCategory" name="category" readonly>
                                    {{ category_account_pay[account.category] }}
                                </div>
                            </div>
                        </div>
                        <div v-if="account.category != 6" class="col-sm-8">
                            <div class="form-group">
                                <label for="inputIdAccount">Fornecedor</label>
                                <div class="form-control" id="inputSupplier" name="supplier" readonly>
                                    {{ account.supplier.name }}
                                </div>
                            </div>
                        </div>
                        <div v-else class="col-sm-4">
                            <div class="form-group">
                                <label for="inputIdImovel">Imóvel</label>
                                <div class="form-control" id="inputSupplier" name="supplier" readonly>
                                    {{ '[' + account.property.reference + '] - ' + account.property.description }}
                                </div>
                            </div>
                        </div>

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
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputDescription">Descrição</label>
                                <input type="text" class="form-control" id="inputDescription"
                                    placeholder="Descreva a Conta" name="description" v-model="account.description"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputExpectDate">Data Vencimento</label>
                                <input type="date" class="form-control" id="inputExpectDate"
                                    placeholder="Informe a Data Esperada" name="expect_date"
                                    v-model="account.expect_date" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputOriginalValue">Valor Original</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="account.original_value" v-bind="config"
                                        id="inputOriginalValue" placeholder="Venda" name="original_value" readonly>
                                    </money3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputObservations">Observações</label>
                                <input type="text" class="form-control" id="inputObservations"
                                    placeholder="Descreva a Observação" name="observations" readonly
                                    v-model="account.observations">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputPaymentMethod">Método de Pagamento</label>
                                <select v-if="!account.id_casher" class="custom-select" id="inputPaymentMethod"
                                    name="payment_method" v-model="account.payment_method">
                                    <option value>Selecione a opção</option>
                                    <option v-for="(value, key) in payment_method" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                                <div v-else class="form-control" readonly>{{ payment_method[account.payment_method] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputDischargeDate">Data Quitação</label>
                                <input v-if="!account.id_casher" type="date" class="form-control"
                                    id="inputDischargeDate" placeholder="Informe a data de Quitação"
                                    name="discharge_date" v-model="account.discharge_date" required>
                                <div v-else class="form-control" readonly>{{ account.discharge_date }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select v-if="!account.id_casher" class="custom-select" id="inputStatus" name="status"
                                    v-model="account.status" @blur="treatValues()">
                                    <option>Selecione o status</option>
                                    <option v-for="(value, key) in status_account" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                                <div v-else class="form-control" readonly>{{ status_account[account.status] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputPenaltyValue">Valor Multa</label>
                                <div v-if="!account.id_casher" class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="account.penalty_value" v-bind="config"
                                        id="inputPenaltyValue" placeholder="Locacao" name="penalty_value"
                                        @blur="treatValues()"></money3>
                                </div>
                                <div v-else class="form-group">
                                    <div class="form-control" readonly> R$ {{ account.penalty_value }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputDiscountValue">Valor Desconto</label>
                                <div v-if="!account.id_casher" class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="account.discount_value" v-bind="config"
                                        id="inputDiscountValue" placeholder="Locacao" name="discount value"
                                        @blur="treatValues()"></money3>
                                </div>
                                <div v-else class="form-group">
                                    <div class="form-control" readonly> R$ {{ account.discount_value ?
                                        account.discount_value : '0.00' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputFinalValue">Valor Final</label>
                                <div v-if="!account.id_casher" class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 v-if="account.final_value" class="form-control"
                                        v-model="account.final_value" v-bind="config" id="inputFinalValue"
                                        placeholder="Iptu" name="final_value" readonly></money3>
                                    <money3 v-else class="form-control" v-model="account.original_value" v-bind="config"
                                        id="inputFinalValue" placeholder="Iptu" name="final_value" readonly></money3>
                                </div>
                                <div v-else class="form-group">
                                    <div class="form-control" readonly> R$ {{ account.final_value }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputObservations">Conta para Retirada</label>
                                <select v-if="!account.id_casher" class="custom-select" id="inputIdAccount"
                                    name="id_bank_account" required v-model="account.id_bank_account"
                                    :disabled="account.status != 2">
                                    <option value="">Selecione... </option>
                                    <option v-for="(value) in casher_account" :key="value.bank_account.id"
                                        :id="value.bank_account.id"
                                        :disabled="parseFloat(account.final_value) > parseFloat(value.current_value)"
                                        :style="parseFloat(account.final_value) > parseFloat(value.current_value) ? 'background-color: #e9ecef; color: red;' : ''"
                                        :value="value.bank_account.id">
                                        {{ value.bank_account.bank_name + ' - ' + value.bank_account.account_name }}
                                    </option>
                                </select>
                                <div v-else class="form-control" readonly>{{ account.bank_account.id + ' - ' +
                                    account.bank_account.bank_name + ' - ' + account.bank_account.account_name }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row"></div>
                    <br>
                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="!account.id_casher" type="submit" class="btn btn-primary" @click="updateAccount()"
                        :title="account.status != 2 ? 'Altere o Status para Pago' : ''"
                        :disabled="(account.status != 2 || !account.id_bank_account)">Baixar</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { status_account, category_account_pay, payment_method, onError, getCurrentDate } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
    watch: {

    },


    data: function () {
        return {
            data: {},
            casher_account: {},
            account: {
                id: '',
                description: '',
                original_value: '',
                penalty_value: '',
                final_value: '',
                type: '',
                status: 1,
                payment_method: '',
                category: '',
                observations: '',
                discharge_date: '',
                expect_date: '',
                id_supplier: '',
                id_check: '',
                id_bank_account: '',
                supplier: {
                    name: '',
                }
            },
            config: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false
            },
            status_account: status_account,
            category_account_pay: category_account_pay,
            payment_method: payment_method,
            getCurrentDate: getCurrentDate,
            onError: onError,
        }
    },

    methods: {
        getAccount() {
            axios.get('/accounts-pay/' + this.$route.params.id)
                .then(response => {
                    this.account = response.data.account;
                    if (!this.account.discharge_date) {
                        this.account.discharge_date = this.getCurrentDate();
                    }
                    if (this.account.id_bank_account == null) {
                        this.account.id_bank_account = '';
                    }
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },

        updateAccount() {
            this.account.action = 2;
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

        getBankAccounts() {
            axios.get('/casher-account')
                .then(response => {
                    this.casher_account = response.data.casher_account.data;
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
        treatValues() {
            const original_value = this.account.original_value ? parseFloat(this.account.original_value) : 0;
            const penalty_value = this.account.penalty_value ? parseFloat(this.account.penalty_value) : 0;
            const discount_value = this.account.discount_value ? parseFloat(this.account.discount_value) : 0;
            this.account.final_value = original_value + penalty_value - discount_value;
        },


    },
    beforeMount() {
        this.getBankAccounts();
        if (this.$route.params.id) {
            this.getAccount();
        }
        this.treatValues();


    },
};
</script>
