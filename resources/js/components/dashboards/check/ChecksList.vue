<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2> Cheques</h2>
            <search :route="'check'" @search="getChecks"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cheques</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <div v-if="checks && checks.length > 0">
                        <table class="table table-head-fixed text-nowrap text-center table-striped">
                            <thead>
                                <tr>
                                    <th class="col-sm-1">ID</th>
                                    <th>Descrição</th>
                                    <th>Transação</th>
                                    <th>Status</th>
                                    <th>Tipo</th>
                                    <th class="col-sm-1"></th>
                                    <th class="col-sm-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="check in checks" :key="check.id">
                                    <td class="col-sm-1"><b>{{ check.id }}</b></td>
                                    <td>{{ check.description }}</td>
                                    <td>{{ check.id_transaction }}</td>
                                    <td>{{ status_check[check.status] }}</td>
                                    <td>{{ type_check[check.type] }}</td>
                                    <td class="col-sm-1">
                                        <router-link :to="'/check/' + check.id + '/edit'" class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </router-link>

                                    </td>
                                    <td class="col-sm-1">
                                        <div style="text-align: center;">
                                            <button v-if="check.deleted_at" type="button" class="btn btn-outline-success"
                                                @click="restoreCheck(check.id)" data-toggle="modal"
                                                style="margin-top: -0.5em;" title="Restaurar Cheque">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-outline-danger"
                                                @click="deleteCheck(check.id)" data-toggle="modal"
                                                style="margin-top: -0.5em;" title="Excluir Cheque">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination v-if="this.checks.length >= 30" :current-page="currentPage"
                            :total-pages="totalPages" @update-page="updatePage" />
                    </div>
                    <div v-else>
                        <table class="table table-head-fixed text-nowrap">
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-center"><b>Nenhum cheque encontrada.</b></td>
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

import { status_check, type_check } from '../../../utils';

import axios from 'axios';
import Swal from 'sweetalert2';
import Search from '../Search.vue';

export default {
    data: function () {
        return {
            checks: {},
            status_check: status_check,
            type_check: type_check,
        };
    },
    computed: {

    },
    components: {
        Search,
    },
    methods: {
        getChecks(search) {
            axios.get('/check', { params: search })
                .then(response => {
                    this.checks = response.data.checks;
                })
                .catch(error => {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        delete(check) {
            axios.delete('/checks/' + check)
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
        restore(check) {
            axios.post('/check/' + check + '/restore')
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
        deleteCheck(check) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, a cheque será removido.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete(check)
                }
            });
        },
        restoreCheck(check) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, a cheque será restaurado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.restore(check)
                }
            });
        },

    },
    beforeMount() {
        this.getChecks();
    },
};
</script>
