<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2> Contas à Pagar</h2>
            <search :route="'account-pay'" @search="searchParams => getAccounts(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Contas </h3>
                </div>
                <div class="card-body table-responsive p-0" style="">
                    <div v-if="accounts && accounts.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Fornecedor</th>
                                    <th class="md='auto'">Descrição</th>
                                    <th class="md='auto'">Valor</th>
                                    <th class="md='auto'">Categoria</th>
                                    <th class="md='auto'">Vencimento</th>
                                    <th class="md='auto'"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="account in accounts" :key="account.id">
                                    <td><b>{{ account.id }}</b></td>
                                    <td v-if="account.id_property">
                                        <!-- <b><i class="nav-icon fas fa-home" style="color: #f89d52; margin-right: 1em;"
                                                :title="'[' + account.property.reference + '] - ' + account.property.description"></i></b> -->
                                        {{ account.supplier.name ?? '' }}
                                    </td>
                                    <td v-else>{{ account.supplier.name ?? '' }}</td>
                                    <td>{{ account.description }}</td>
                                    <td>{{ account.final_value ? 'R$ ' + account.final_value : 'R$ ' +
                                        account.original_value }}</td>
                                    <td>{{ formatDate(account.expect_date) }}</td>
                                    <td>{{ category_account_pay[account.category] }}</td>
                                    <td>
                                        <router-link :to="'/account-pay/' + account.id + '/pay-off'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-info"
                                                style="margin-top: -0.5em;">
                                                <div v-if="!account.id_casher"><i class="fas fa-dollar-sign"
                                                        style="padding: 0.3em;"></i></div>
                                                <div v-else><i class="fas fa-solid fa-eye"></i></div>
                                            </button>
                                        </router-link>

                                        <router-link v-if="account.id_property"
                                            :to="'/property/' + account.id_property + '/edit'" class="small-box-footer">
                                            <button type="button" class="btn btn-outline-info"
                                                style="margin-top: -0.5em;margin-left: 0.5em;">
                                                <i class="nav-icon fas fa-home"></i>
                                            </button>
                                        </router-link>
                                        <router-link v-if="account.status != 2"
                                            :to="'/account-pay/' + account.id + '/edit'" class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;margin-left: 0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </router-link>

                                        <button v-if="account.status != 2 && account.deleted_at" type="button"
                                            class="btn btn-outline-success" @click="restoreAccount(account.id)"
                                            data-toggle="modal" style="margin-top: -0.5em;margin-left: 0.5em;"
                                            title="Restaurar Fornecedor">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button v-else-if="account.status != 2" type="button"
                                            class="btn btn-outline-danger" @click="deleteAccount(account.id)"
                                            data-toggle="modal" style="margin-top: -0.5em;margin-left: 0.5em;"
                                            title="Excluir Fornecedor">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <table class="table table-head-fixed text-nowrap">
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-center"><b>Nenhuma conta encontrado.</b></td>
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
import { category_account_pay, formatDate } from '../../../utils';


export default {
    data: function () {
        return {
            accounts: {
                id: '',
                description: '',
                original_value: '',
                penalty_value: '',
                final_value: '',
                type: '',
                status: '',
                payment_method: '',
                category: '',
                observations: '',
                discharge_date: '',
                expect_date: '',
                id_supplier: '',
                id_check: '',
            },
            category_account_pay: category_account_pay,
            formatDate: formatDate,
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
        getAccounts(search = {}, page = 1) {
            search = search || {};
            search.page = page;
            return axios.get('/accounts-pay', { params: search })
                .then(response => {
                    this.accounts = response.data.accounts.data;
                    this.currentPage = response.data.accounts.current_page;
                    this.totalPages = response.data.accounts.last_page;
                    this.totalResults = response.data.accounts.total;
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
                this.getAccounts(this.searchParams, page);
            }
        },
        delete(account) {
            axios.delete('/accounts-pay/' + account)
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
        restore(account) {
            axios.post('/accounts-pay/' + account + '/restore')
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
        deleteAccount(account) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, a conta será removida.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete(account)
                }
            });
        },
        restoreAccount(account) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, a conta será restaurada.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.restore(account)
                }
            });
        },
        validateCategory(input) {
            // if (!input || (input && !input.category)) {
            //     Swal.fire({
            //         position: "top-end",
            //         icon: "error",
            //         title: 'Selecione a Categoria',
            //         showConfirmButton: false,
            //         timer: 2500
            //     });
            //     return false;
            // }

            // if (!input || (input && !input.status)) {
            //     Swal.fire({
            //         position: "top-end",
            //         icon: "error",
            //         title: 'Selecione o Status',
            //         showConfirmButton: false,
            //         timer: 2500
            //     });
            //     return false;
            // }
            return true;
        }
    },
};
</script>

<style scoped></style>
