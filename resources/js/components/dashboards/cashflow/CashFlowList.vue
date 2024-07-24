<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Caixa</h2>
            <!-- <search :route="'cashflow'" @search="getCashFlows"></search> -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Caixa </h3>
                </div>

                <div class="card-body table-responsive p-0" style="">
                    <div v-if="Object.values(banks).length > 0" style="padding: 1em;">
                        <div class="row">
                            <div class="col-sm-4" v-for="bank in banks" :key="bank.id">
                                <div class="card card-widget widget-user shadow">
                                    <div class="widget-user-header" style="background-color: #f89d52; color: #fff;">
                                        <h3 class="widget-user-username">{{ bank.bank_account.account_name }}</h3>
                                        <h5 class="widget-user-desc">{{ bank.bank_account.bank_name + ' | ' +
                                            account_type[bank.bank_account.account_type] }}</h5>
                                        <router-link :to="'/cashflow/' + bank.id_bank_account + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-dark"
                                                style="margin-top: 0.5em; color: #fff; border-color: #fff">Ver
                                                Fluxo</button>
                                        </router-link>
                                    </div>

                                    <div class="" style="padding-top: 1.5em">
                                        <div class="row">
                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">{{
                                                        formatDate(bank.date_current_action) }}</h5>
                                                    <span class="description-text">Últ. Mov.</span>
                                                </div>

                                            </div>

                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">

                                                    <h5 class="description-header">R$ {{ bank.current_value }}</h5>
                                                    <span class="description-text"> Em Caixa</span>

                                                </div>

                                            </div>

                                            <div class="col-sm-4">
                                                <div class="description-block">
                                                    <h5 class="description-header">{{ casher_action[bank.action] }}</h5>
                                                    <span class="description-text">Últ. Ação</span>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <table class="table table-head-fixed text-nowrap">
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-center"><b>Nenhuma movimentação gerada.</b></td>
                                </tr>
                            </tbody>
                        </table>
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
import { status_properties, account_type, casher_action } from '../../../utils';

export default {
    data: function () {
        return {
            banks: {},
            status_properties: status_properties,
            account_type: account_type,
            casher_action: casher_action,
        };
    },
    computed: {

    },
    components: {
        Search,
    },
    methods: {
        getCasher() {
            axios.get('/cashflow')
                .then(response => {
                    this.banks = response.data.cash_registers;
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
        formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

    },
    beforeMount() {
        this.getCasher();
    },
};
</script>
