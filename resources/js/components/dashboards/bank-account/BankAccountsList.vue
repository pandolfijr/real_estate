<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2> Contas Bancárias</h2>
            <search :route="'bank-account'" @search="searchParams => getBanks(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Contas Bancárias </h3>
                </div>
                <div class="card-body table-responsive p-0" style="">
                    <div v-if="banks && banks.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Descrição da Conta</th>
                                    <th class="md='auto'">Banco</th>
                                    <th class="md='auto'">Conta</th>
                                    <th class="md='auto'"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="bank in banks" :key="bank.id">
                                    <td><b>{{ bank.id }}</b></td>
                                    <td>{{ bank.account_name }}</td>
                                    <td>{{ bank.bank_name }}</td>
                                    <td>{{ bank.account }}</td>
                                    <td>
                                        <router-link :to="'/bank-account/' + bank.id + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
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
                                    <td class="text-center"><b>Nenhuma conta bancária encontrada.</b></td>
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
import { } from '../../../utils';


export default {
    data: function () {
        return {
            banks: {},
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

        getBanks(search = {}, page = 1) {
            search = search || {};
            search.page = page;
            axios.get('/bank-accounts', { params: search })
                .then(response => {
                    this.banks = response.data.bank_accounts.data;
                    this.currentPage = response.data.banks.current_page;
                    this.totalPages = response.data.banks.last_page;
                    this.totalResults = response.data.banks.total;
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
                this.getBanks(this.searchParams, page);
            }
        },
        delete(bank) {
            axios.delete('/bank-accounts/' + bank)
                .then(response => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    this.$router.go();
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
        restore(bank) {
            axios.post('/bank-accounts/' + bank + '/restore')
                .then(response => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    this.$router.go();
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

        updatePage(page) {
            this.currentPage = page;
            this.getBank();
        },
    },
    created() {
        this.getBanks();
    },
};
</script>
