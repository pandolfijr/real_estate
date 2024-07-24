<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ properties }} </h3>
                            <p>Imóveis Cadastrados</p>
                        </div>
                        <div class="icon">
                            <i class='fas fa-house-user' style='font-size:48px;color: #fff'></i>
                        </div>
                        <router-link :to="'/properties-list/'" class="small-box-footer">
                            Mais informações <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ renters }}</h3>
                            <p>Locatários</p>
                        </div>
                        <div class="icon">
                            <i class='fas fa-user-circle' style='font-size:48px;color:#fff'></i>
                        </div>
                        <router-link :to="'/renters-list/'" class="small-box-footer">
                            Mais informações <i class="fas fa-arrow-circle-right"></i>
                        </router-link>

                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success" style="color: #fff;">
                        <div class="inner" style="color: #fff;">
                            <h3>{{ locators }}</h3>
                            <p>Proprietários</p>
                        </div>
                        <div class="icon">
                            <i class='fas fa-users' style='font-size:48px;color:#fff'></i>
                        </div>
                        <router-link :to="'/locators-list/'" class="small-box-footer">
                            Mais informações <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ users }}</h3>
                            <p>Usuários</p>
                        </div>
                        <div class="icon">
                            <i class='fas fa-user-friends' style='font-size:48px;color:#fff'></i>
                        </div>
                        <router-link :to="'/users-list/'" class="small-box-footer">
                            Mais informações <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
            </div>
            <div v-if="accounts_pay.length > 0 || accounts_receive.length > 0 || installments_receive.length > 0" class="card card-primary">
                <div class="card-header">
                    Informações
                </div>
                <div class="form-control" style=" height: 5em;">
                    <span v-if="accounts_pay.length > 0" style="margin: 1em;">
                        Há <b>{{ accounts_pay.length }} Conta(s) à Pagar</b> com vencimento para <b>hoje!</b> <br>
                    </span>
                    <span v-if="accounts_receive.length > 0" style="margin: 1em;">
                        Há <b>{{ accounts_receive.length }} Conta(s) à Receber</b> com vencimento para <b>hoje!</b><br>
                    </span>

                    <span v-if="installments_receive.length > 0" style="margin: 1em;">
                        Há <b>{{ installments_receive.length }} Parcela(s) de Imóvel à receber</b> com vencimento para <b>hoje!</b><br>
                    </span>



                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import { getCurrentDate } from '../../utils';

export default {
    watch: {},
    data: function () {
        return {
            properties: '',
            locators: '',
            renters: '',
            users: '',
            date_now: '',
            accounts_pay: [],
            accounts_receive: [],
            installments_receive: [],
            getCurrentDate: getCurrentDate,
        };
    },
    computed: {

    },
    methods: {
        getTotalProperties() {
            axios.get('/property-total')
                .then(response => {
                    this.properties = response.data.properties ? response.data.properties : 0;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getTotalRenters() {
            axios.get('/renters-total')
                .then(response => {
                    this.renters = response.data.renters ? response.data.renters : 0;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getTotalLocators() {
            axios.get('/locators-total')
                .then(response => {
                    this.locators = response.data.locators ? response.data.locators : 0;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getTotalUsers() {
            axios.get('/users-total')
                .then(response => {
                    this.users = response.data.users ? response.data.users : 0;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        navigateToUsuario() {
            this.$router.push('/users-list');
        },

        getAccountsToPay() {
            axios.get('/accounts-pay', {
                params: {
                    expect_date: this.date_now,
                    status: 1,
                }
            })
                .then(response => {
                    this.accounts_pay = response.data.accounts.data;
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


        getAccountsToReceive() {
            axios.get('/accounts-receive', {
                params: {
                    expect_date: this.date_now,
                    status: 1,
                }
            })
                .then(response => {
                    this.accounts_receive = response.data.accounts.data;
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

        getInstallmentsToReceive() {
            axios.get('/installments', {
                params: {
                    status: 1,
                    due_date: this.date_now
                }
            })
                .then(response => {
                    this.installments_receive = response.data.installments.data;
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
        }
    },
    created() {
        this.date_now = this.getCurrentDate();
        this.getTotalProperties();
        this.getTotalRenters();
        this.getTotalLocators();
        this.getTotalUsers();
        this.getAccountsToPay();
        this.getAccountsToReceive();
        this.getInstallmentsToReceive();
    },
};
</script>
