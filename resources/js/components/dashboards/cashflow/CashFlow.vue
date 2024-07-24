<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>{{ bank_account ? bank_account.bank_name + ' (' + account_type[bank_account.account_type] + ') | ' +
                bank_account.account_name : '' }}</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Filtrar </h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="inputExpectDate">Data Início</label>
                                    <input type="date" class="form-control" id="inputExpectDate"
                                        placeholder="Informe a Data Esperada" name="expect_date"
                                        v-model="filter.initial_date" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="inputExpectDate">Data Fim</label>
                                    <input type="date" class="form-control" id="inputExpectDate"
                                        placeholder="Informe a Data Esperada" name="expect_date"
                                        v-model="filter.end_date" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="inputExpectDate">Ação</label>
                                    <select class="custom-select" id="inputPaymentMethod" name="payment_method"
                                        v-model="filter.action">
                                        <option value>Selecione a opção</option>
                                        <option v-for="(value, key) in casher_action" :key="key" :value="key">
                                            {{ value }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <button class="btn btn-primary" @click="getAccount()"
                                        style="margin-top: 2em;margin-right: 0.5em;">Filtrar</button>
                                    <button class="btn btn-danger" @click="back()"
                                        style="margin-top: 2em; margin-left: 0.5em;">Voltar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Fluxo de Caixa</h3>
                </div>

                <div v-if="cash_registers.length >= 1" class="card-body table-responsive p-0" style="">
                    <div v-if="cash_registers">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th>ID Conta</th>
                                    <th>Tipo de Conta</th>
                                    <th>Ação</th>
                                    <th>Conta</th>
                                    <th>Saldo Anterior</th>
                                    <th>Valor</th>
                                    <th>Saldo Atual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cash_register in cash_registers" :key="cash_register.id">
                                    <td><b>{{ cash_register.id }}</b></td>
                                    <td v-if="cash_register.id_account_pay_receive">
                                        <b>{{ cash_register.action == 1 ? 'Conta Recebida' : 'Conta Paga' }}</b>
                                    </td>
                                    <td v-else-if="cash_register.id_installment_transfer">
                                        <b>Repasse à Proprietário</b>
                                    </td>
                                    <td v-else-if="cash_register.id_installment">
                                        <b>Parcela de Imóvel</b>
                                    </td>
                                    <td v-else><b>-</b></td>

                                    <td v-if="cash_register.action == 1" style="color: #f89d52">
                                        <b>{{ casher_action[cash_register.action] }} </b>
                                    </td>
                                    <td v-else style="color: #c82333">
                                        <b>{{ casher_action[cash_register.action] }} </b>
                                    </td>

                                    <td v-if="cash_register.id_account_pay_receive">
                                        <router-link
                                            :to="cash_register.action == 1 ? '/account-receive/' + cash_register.id_account_pay_receive + '/pay-off' : '/account-pay/' + cash_register.id_account_pay_receive + '/pay-off'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-info"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-solid fa-eye"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td v-else-if="cash_register.id_installment">
                                        <router-link :to="'/installment/' + cash_register.id_installment + '/pay-off'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-info"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-solid fa-eye"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td v-else><b>-</b></td>
                                    <!-- <td v-else-if="cash_register.action == 2">
                                        <router-link
                                            :to="'/account-pay/' + cash_register.id_account_pay_receive + '/pay-off'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-info"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-solid fa-eye"></i>
                                            </button>
                                        </router-link>
                                    </td> -->



                                    <td>
                                        <b>R$ {{ (cash_register.previous_value && cash_register.previous_value != 0) ?
                                            cash_register.previous_value : '0.00'
                                            }}</b>
                                    </td>

                                    <td v-if="cash_register.action == 1" style="color: #f89d52">
                                        <b>
                                            + R$ {{ cash_register.account_value ? cash_register.account_value : '0.00'
                                            }}
                                        </b>
                                    </td>
                                    <td v-else style="color: #c82333">
                                        <b>
                                            - R$ {{ cash_register.account_value ? cash_register.account_value : '0.00'
                                            }}
                                        </b>
                                    </td>

                                    <td>
                                        <b>R$ {{ cash_register.current_value ? cash_register.current_value : '0.00' }}
                                        </b>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <table class="table table-head-fixed text-nowrap">
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-center"><b>Nenhuma conta bancária encontrada.</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-else>
                    <table class="table table-head-fixed text-nowrap">
                        <tbody>
                            <tr class="text-center">
                                <td class="text-center"><b>Nenhuma transação encontrada.</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
import { account_type, casher_action, getMonthDates } from '../../../utils';
import axios from 'axios';

export default {

    data: function () {
        return {
            cash_registers: {},
            bank_account: {},
            filter: {
                initial_date: '',
                end_date: '',
                action: '',
            },
            account_type: account_type,
            casher_action: casher_action,
            getMonthDates: getMonthDates,
        }
    },

    methods: {
        getAccount() {
            axios.get('/cashflow/' + this.$route.params.id, { params: this.filter })
                .then(response => {
                    this.cash_registers = response.data.cash_registers;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getBank() {
            axios.get('/bank-accounts/' + this.$route.params.id)
                .then(response => {
                    this.bank_account = response.data.bank_account;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getFilterMonthDates() {
            const { firstDayFormatted, lastDayFormatted } = this.getMonthDates();
            this.filter.initial_date = firstDayFormatted;
            this.filter.end_date = lastDayFormatted;

        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        },
        back() {
            this.$router.go(-1);
        },
    },
    beforeMount() {
        this.getFilterMonthDates();
        this.getBank();
        this.getAccount();
    },
};
</script>
