<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Parcelas de Imóveis</h2>
            <search :route="'installment'" @search="searchParams => getInstallments(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Contas </h3>
                </div>
                <div v-if="installments && installments.length > 0" class="card-body table-responsive p-0" style="">
                    <div v-if="installments && installments.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Imóvel</th>
                                    <th class="md='auto'">Descrição</th>
                                    <th class="md='auto'">Locatário</th>
                                    <th class="md='auto'">Proprietário</th>
                                    <th class="md='auto'">Data Vencimento</th>
                                    <th class="md='auto'">Ações</th>
                                    <th class="md='auto'">Recibo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="installment in installments" :key="installment.id">
                                    <td><b>{{ installment.id }}</b></td>
                                    <td><b>{{ installment.property ? installment.property.reference : '' }}</b></td>
                                    <td>{{ installment.description }}</td>
                                    <td>{{ installment.renter && installment.renter.people ?
                                        installment.renter.people.name + ' ' + installment.renter.people.surname : '' }}
                                    </td>
                                    <td>{{ installment.locator && installment.locator.people ?
                                        installment.locator.people.name + ' ' + installment.locator.people.surname :
                                        '' }}
                                    </td>
                                    <td>{{ installment.date_received ? 'RECEBIDO' : formatDate(installment.due_date) }}
                                    </td>
                                    <td v-if="installment.status != 2">
                                        <router-link :to="'/installment/' + installment.id + '/pay-off'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-info" title="Fazer Repasse"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-dollar-sign" style="padding: 0.3em;"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td v-else>
                                        <button type="button" class="btn btn-outline-secondary"
                                            style="margin-top: -0.5em;" title="Nenhuma Ação" disabled>
                                            <i class="fas fa-hand-paper"></i>
                                        </button>
                                    </td>
                                    <td v-if="installment.date_received != null">
                                        <a :href="'/receipt/' + installment.id + '/installment'" target="_blank" class="small-box-footer">
                                            <button type="button" class="btn btn-outline-info" title="Gerar Recibo" style="margin-top: -0.5em;">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td v-else>

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
                </div>
                <div v-else>
                    <table class="table table-head-fixed text-nowrap">
                        <tbody>
                            <tr class="text-center">
                                <td class="text-center"><b>Preencha os filtros e faça sua pesquisa.</b></td>
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
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import Search from '../Search.vue';
import { status_account, category_account_receive, formatDate } from '../../../utils';


export default {
    data: function () {
        return {
            installments: {
                current_installment: '',
                total_installments: '',
                status: '',
                due_date: '',
                date_received: '',
                description: '',
                identification_code: '',
                observations: '',
                type_installment: '',
                id_transact: '',
                id_locator: '',
                id_property: '',
                payment_method: '',
                id_check: '',
                installment_value: '',
                insurance_value: '',
                insurance_number: '',
                installment_total_value: '',
                id_renter: '',
                property: {},
                locator: {},
                renter: {},
            },
            search: {},
            status_account: status_account,
            category_account_receive: category_account_receive,
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

        getInstallments(search = {}, page = 1) {
            search = search || {};
            search.page = page;
            return !this.validateCategory(search)
                ? false
                : axios.get('/installments', { params: search })
                    .then(response => {
                        this.installments = response.data.installments.data;
                        this.currentPage = response.data.installments.current_page;
                        this.totalPages = response.data.installments.last_page;
                        this.totalResults = response.data.installments.total;
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
                this.getInstallments(this.searchParams, page);
            }
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
