<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Locatários</h2>
            <search :route="'renter'" @search="searchParams => getRenters(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Locatários</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <div v-if="renters.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Nome</th>
                                    <th class="md='auto'">E-mail</th>
                                    <th class="md='auto'">Telefone</th>
                                    <th class="md='auto'">Status</th>
                                    <th class="md='auto'"></th>
                                    <th class="md='auto'"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="renter in renters" :key="renter.id">
                                    <td><b>{{ renter.id }}</b></td>
                                    <td>{{ renter.people.name }} {{ renter.people.surname }}</td>
                                    <td>{{ renter.people.email }}</td>
                                    <td>{{ phoneMask(renter.people.cellphone) }}</td>
                                    <td v-if="!renter.deleted_at" style="color: #f89d52;"><b>Ativo</b></td>
                                    <td v-else style="color: red;"><b>Inativo</b></td>
                                    <td>
                                        <router-link :to="'/renter/' + renter.id + '/edit'" class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td>
                                        <div v-if="renter.transaction && renter.transaction.length == 0"
                                            style="text-align: center;">
                                            <button v-if="renter.deleted_at" type="button"
                                                class="btn btn-outline-success" @click="restoreRenter(renter.id)"
                                                data-toggle="modal" style="margin-top: -0.5em;"
                                                title="Restaurar Proprietário do Imóvel">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-outline-danger"
                                                @click="deleteRenter(renter.id)" data-toggle="modal"
                                                style="margin-top: -0.5em;" title="Excluir Proprietário do Imóvel">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div v-else style="text-align: center;">
                                            <button type="button" class="btn btn-outline-secondary"
                                                style="margin-top: -0.5em;" title="Nenhuma Ação" disabled>
                                                <i class="fas fa-hand-paper"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <table class="table table-head-fixed text-nowrap">
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-center"><b>Nenhum cliente encontrado.</b></td>
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
import { phoneMask } from '../../../utils';

export default {
    data: function () {
        return {
            renters: {},
            phoneMask: phoneMask,
            currentPage: 1,
            perPage: 30,
            totalPages: 0,
            totalResults: 0,
        };
    },
    computed: {
    },
    components: {
        Search,
    },
    methods: {
        getRenters(search = {}, page = 1) {
            search = search || {};
            search.page = page;
            axios.get('/renters', { params: search })
                .then(response => {
                    this.renters = response.data.renters.data;
                    this.currentPage = response.data.renters.current_page;
                    this.totalPages = response.data.renters.last_page;
                    this.totalResults = response.data.renters.total;
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
                this.getRenters(this.searchParams, page);
            }
        },
        delete(renter) {
            axios.delete('/renters/' + renter)
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
        restore(renter) {
            axios.post('/renter/' + renter + '/restore')
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
        deleteRenter(renter) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, locatário será removido.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete(renter)
                }
            });
        },
        restoreRenter(renter) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, o locatário será restaurado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.restore(renter)
                }
            });
        },

        updatePage(page) {
            this.currentPage = page;
            this.getRenters();
        },

    },
    beforeMount() {
        this.getRenters();
    },
};
</script>
