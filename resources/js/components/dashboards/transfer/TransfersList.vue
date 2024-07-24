<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2> Repasses</h2>
            <search :route="'transfer'" @search="searchParams => getInstallments(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Contas </h3>
                </div>
                <div class="card-body table-responsive p-0" style="">
                    <div v-if="installments && installments.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Referência</th>
                                    <th class="md='auto'">Locatário</th>
                                    <th class="md='auto'">Proprietário</th>
                                    <th class="md='auto'">Data Vencimento</th>
                                    <th class="md='auto'">Data Recebimento</th>
                                    <th class="md='auto'">Valor Repasse Estimado</th>
                                    <th class="md='auto'">Valor Taxa Administrativa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="installment in installments" :key="installment.id">
                                    <td><b>{{ installment.id }}</b></td>
                                    <td><b>{{ installment.property.reference }}</b></td>
                                    <td>{{ installment.renter.people.name + ' ' + installment.renter.people.surname }}
                                    </td>
                                    <td>{{ installment.locator.people.name + ' ' + installment.locator.people.surname }}
                                    </td>
                                    <td>{{ installment.due_date ? formatDate(installment.due_date) : '-' }}
                                    </td>
                                    <td>{{ installment.date_received ? formatDate(installment.date_received) :
                                        'Pendente' }}
                                    </td>
                                    <td>{{ 'R$ ' + treatValue(installment.property, installment.installment_total_value)
                                        }}</td>
                                    <td>{{ 'R$ ' + installment.property.administrative_tax_value }}</td>
                                    <td v-if="!installment.status_transfer && !installment.id_casher_transfer">
                                        <router-link :to="'/transfer/' + installment.id + '/pay-off'"
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
import { formatDate } from '../../../utils';


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
            return axios.get('/installments', {
                params: {
                    ...search,
                    transfer: true,
                    category: 17
                }
            })
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
        validateStatus(input) {
            if (!input || (input && !input.status_transfer)) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'Selecione o Status do Repasse',
                    showConfirmButton: false,
                    timer: 2500
                });
                return false;
            }
            return true;
        },

        treatValue(property, installment) {
            let value = 0;
            value = installment - property.administrative_tax_value;
            return value.toFixed(2);
        },

    },
    beforeMount() {

    },
};
</script>
