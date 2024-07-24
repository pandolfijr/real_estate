<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Transações</h2>
            <search :route="'transaction'" @search="searchParams => getTransactions(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Transações </h3>
                </div>
                <div class="card-body table-responsive p-0" style="">
                    <div v-if="transactions && transactions.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">Referência</th>
                                    <th class="md='auto'">Propriedade </th>
                                    <th class="md='auto'">Proprietário</th>
                                    <th class="md='auto'">Locatário </th>
                                    <th class="md='auto'">Status do Contrato</th>
                                    <th class="md='auto'">Data Inicial</th>
                                    <th class="md='auto'">Data Final</th>
                                    <th class="md='auto'"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="transaction in transactions" :key="transaction.id">
                                    <td><b>{{ transaction.property.reference }}</b></td>
                                    <td>{{ transaction.property.description }}</td>
                                    <td>
                                        {{ transaction.locator.people.name + ' ' + transaction.locator.people.surname }}
                                    </td>
                                    <td>
                                        {{ transaction.renter.people.name + ' ' + transaction.renter.people.surname }}
                                    </td>
                                    <td> {{ contract_status[transaction.contract_status] }}</td>
                                    <td> {{ formatDate(transaction.contract_start_date) }}</td>
                                    <td> {{ formatDate(transaction.contract_end_date) }}</td>
                                    <td>
                                        <router-link :to="'/transaction/' + transaction.id + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-info"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-solid fa-eye"></i> </button>
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                    <div v-if="totalResults >= 30" class=""
                        style=" display: flex; justify-content: center; margin-bottom:1em; margin-top:1em;">
                        <button class="btn btn-primary" @click="goToPage(currentPage - 1)"
                            :disabled="currentPage === 1">Anterior</button>
                        <span style="margin-left: 1em;margin-right: 1em;">Página {{ currentPage }} de {{ totalPages
                            }}</span>
                        <button class="btn btn-primary" @click="goToPage(currentPage + 1)"
                            :disabled="currentPage === totalPages">Próxima</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import Search from '../Search.vue';
import { contract_status, formatDate } from '../../../utils';

export default {
    data: function () {
        return {
            transactions: {},
            formatDate: formatDate,
            contract_status: contract_status,
            currentPage: 1,
            perPage: 30,
            totalPages: 0,
            totalResults: 0,
        };
    },
    components: {
        Search,
    },
    methods: {
        getTransactions(search = {}, page = 1) {
            search = search || {};
            search.page = page;
            axios.get('/transactions', { params: search })
                .then(response => {
                    this.transactions = response.data.transactions.data;
                    this.currentPage = response.data.transactions.current_page;
                    this.totalPages = response.data.transactions.last_page;
                    this.totalResults = response.data.transactions.total;
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
        goToPage(page) {
            if (page > 0 && page <= this.totalPages) {
                this.getTransactions(this.searchParams, page);
            }
        },
        delete(transaction) {
            axios.delete('/transactions/' + transaction)
                .then(response => {
                    Swal.fire({
                        text: response.data.message,
                        icon: "success"
                    });
                })
                .catch(error => {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 4500
                    });
                });
        },
        restore(transaction) {
            axios.post('/transaction/' + transaction + '/restore')
                .then(response => {
                    Swal.fire({
                        text: response.data.message,
                        icon: "success"
                    });
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
        deleteTransaction(transaction) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, proprietário será removido.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete(transaction)
                }
            });
        },
        restoreTransaction(transaction) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, o proprietário será restaurado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.restore(transaction)
                }
            });
        },
    },
    beforeMount() {
        this.getTransactions();
    },
};
</script>
