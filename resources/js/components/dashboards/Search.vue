<template>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"> Pesquisar </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <div class="card-body">
                <div class="row">
                    <div
                        :class="(route == 'account-pay' || route == 'account-receive' || route == 'transfer') ? 'col-sm-3' : 'col-sm-4'">
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputCelular" name="celular"
                                placeholder="Faça sua pesquisa..." v-model="input.search">
                        </div>
                    </div>

                    <div v-if="route == 'account-pay'" :class="'col-sm-2'">
                        <select class="custom-select" id="inputStatus" name="status" v-model="input.status">
                            <option value="">Selecione o Status</option>
                            <option v-for="(value, key) in status_account" :key="key" :value="key">
                                {{ value }}
                            </option>
                        </select>
                    </div>

                    <div v-if="route == 'account-receive'" :class="'col-sm-2'">
                        <select class="custom-select" id="inputStatus" name="status" v-model="input.status">
                            <option value="">Selecione o Status</option>
                            <option v-for="(value, key) in status_account_receive" :key="key" :value="key">
                                {{ value }}
                            </option>
                        </select>
                    </div>

                    <div v-if="route == 'transfer'" :class="'col-sm-3'">
                        <select class="custom-select" id="inputStatus" name="status" v-model="input.status_transfer">
                            <option value="">Selecione o Status do Repasse</option>
                            <option v-for="(value, key) in status_transfers" :key="key" :value="key">
                                {{ value }}
                            </option>
                        </select>
                    </div>

                    <div v-if="route == 'property' || route == 'account-receive' || route == 'account-pay' || route == 'installment'|| validateRoute()"
                        class="col-sm-2">
                        <div class="form-group">
                            <select v-if="route == 'property'" class="custom-select" id="inputStatus" name="status"
                                v-model="input.status">
                                <option value="">Selecione o Status</option>
                                <option v-for="(value, key) in status_properties" :key="key" :value="key">
                                    {{ value }}
                                </option>
                            </select>
                            <select v-else-if="route == 'installment'" class="custom-select" id="inputStatus" name="status"
                                v-model="input.status">
                                <option value="">Selecione o Status</option>
                                <option v-for="(value, key) in status_installment" :key="key" :value="key">
                                    {{ value }}
                                </option>
                            </select>
                            <select v-else-if="route == 'account-pay'" class="custom-select" id="inputStatus"
                                name="status" v-model="input.category">
                                <option value>Selecione a Categoria</option>
                                <option v-for="(value, key) in category_account_pay" :key="key" :value="key">
                                    {{ value }}
                                </option>
                            </select>
                            <select v-else-if="route == 'account-receive'" class="custom-select" id="inputStatus"
                                name="status" v-model="input.category" @blur="treatCategory()">
                                <option value>Selecione a Categoria</option>
                                <option v-for="(value, key) in category_account_receive" :key="key" :value="key">
                                    {{ value }}
                                </option>
                            </select>
                            <select v-else-if="validateRoute()" class="custom-select" id="inputStatus" name="status"
                                v-model="input.status">
                                <!-- <option value="">Selecione o Status</option> -->
                                <option v-for="(value, key) in registration_status" :key="key"
                                    :value="key != 1 ? key : ''">
                                    {{ value }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div v-if="route !== 'renter' && route !== 'locator' && route !== 'guarantor' && route !== 'supplier' && route !== 'city' && route !== 'city' && route !== 'property' && route !== 'user' && route !== 'transaction'  && route !== 'bank-account'"
                        class="col-sm-2">
                        <div class="form-group">
                            <select class="custom-select" id="inputMonth" name="month" required v-model="input.month">
                                <option value="">Selecione o Mês...</option>
                                <option v-for="(value, key) in months" :key="key" :id="key" :value="key">
                                    {{ value }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div v-if="route !== 'renter' && route !== 'locator' && route !== 'guarantor' && route !== 'supplier' && route !== 'city' && route !== 'user' && route !== 'property' && route !== 'transaction' && route !== 'bank-account'"
                        class="col-sm-1">
                        <div class="form-group">
                            <select class="custom-select" id="inputYear" name="year" required v-model="input.year">
                                <option value="">Selecione o Ano...</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                            </select>
                        </div>
                    </div>
                    <div v-if="route == 'transaction'"
                        class="col-sm-2">
                        <div class="form-group">
                            <select class="custom-select" id="inputContractStatus" name="contract_status" required v-model="input.contract_status">
                                <option value="">Selecione o Status do Contrato...</option>
                                <option v-for="(value, key) in contract_status" :key="key" :id="key" :value="key">
                                    {{ value }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div :class="'col'">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" @click="filter()"
                                style="margin-right: 0.5em">Buscar</button>
                            <router-link v-if="route != 'transfer'" :to="'/' + route + '/create'"
                                class="small-box-footer">
                                <button type="submit" class="btn btn-primary"
                                    style="margin-left: 0.5em">Cadastrar</button>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';
import { status_properties, registration_status, status_account, type_transaction, supplier_category, category_account_pay, category_account_receive, months, status_account_receive, status_transfers, contract_status, status_installment } from '../../utils';

export default {
    data() {
        return {
            input: {
                search: '',
                status: '',
                type: '',
                category: '',
                id_renter: '',
                year: '',
                month: '',
                status_transfer: '',
                contract_status: '',
            },
            status_properties: status_properties,
            registration_status: registration_status,
            status_account: status_account,
            type_transaction: type_transaction,
            supplier_category: supplier_category,
            category_account_pay: category_account_pay,
            category_account_receive: category_account_receive,
            status_account_receive: status_account_receive,
            status_transfers: status_transfers,
            months: months,
            contract_status:contract_status,
            status_installment:status_installment,
            statusRoutes: [
                'locator', 'supplier', 'condo', 'bank-account', 'renter', 'guarantor', 'city',
            ],
            renters: {},
            locators: {},
        }
    },
    props: {
        route: '',
    },
    methods: {
        filter: function () {
            this.$emit("search", this.input);
        },
        validateRoute: function () {
            return this.statusRoutes.includes(this.route);
        },
        getRenters() {
            axios.get('/renters')
                .then(response => {
                    this.renters = response.data.renters.data;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getLocators() {
            axios.get('/locators', {})
                .then(response => {
                    this.locators = response.data.locators.data;

                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        treatCategory() {
            this.input.id_renter = '';
        },
        getDateNow() {
            const date = new Date();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();
            this.input.month = month;
            this.input.year = year;
        },
    },
    beforeMount() {
        if (this.route != 'account-receive' && this.route != 'transfer' && this.route != 'property' && this.route != 'account-pay' && this.route != 'installment') {
            this.filter();
        } else {
            this.input.month = '';
            this.input.year = '';
        }
        this.getRenters();
        this.getLocators();
        this.getDateNow();
    },

};
</script>
