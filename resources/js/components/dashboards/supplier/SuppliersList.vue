<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Fornecedores</h2>
            <search :route="'supplier'" @search="searchParams => getSuppliers(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Fornecedores </h3>
                </div>
                <div class="card-body table-responsive p-0" style="">
                    <div v-if="suppliers && suppliers.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Nome</th>
                                    <th class="md='auto'">E-mail</th>
                                    <th class="md='auto'">Telefone</th>
                                    <th class="md='auto'"></th>
                                    <th class="md='auto'"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="supplier in suppliers" :key="supplier.id">
                                    <td><b>{{ supplier.id }}</b></td>
                                    <td>{{ supplier.name }} {{ supplier.surname }}</td>
                                    <td>{{ supplier.email }}</td>
                                    <td>{{ phoneMask(supplier.cellphone) }}</td>
                                    <td>
                                        <router-link :to="'/supplier/' + supplier.id + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td>
                                        <div style="text-align: center;">
                                            <button v-if="supplier.deleted_at" type="button"
                                                class="btn btn-outline-success" @click="restoreSupplier(supplier.id)"
                                                data-toggle="modal" style="margin-top: -0.5em;"
                                                title="Restaurar Fornecedor">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-outline-danger"
                                                @click="deleteSupplier(supplier.id)" data-toggle="modal"
                                                style="margin-top: -0.5em;" title="Excluir Fornecedor">
                                                <i class="fas fa-trash"></i>
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
                                    <td class="text-center"><b>Nenhum fornecedor encontrado.</b></td>
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
            suppliers: {},
            phoneMask: phoneMask,
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
        getSuppliers(search = {}, page = 1) {
            search = search || {};
            search.page = page;
            axios.get('/suppliers', { params: search })
                .then(response => {
                    this.suppliers = response.data.suppliers.data;
                    this.currentPage = response.data.suppliers.current_page;
                    this.totalPages = response.data.suppliers.last_page;
                    this.totalResults = response.data.suppliers.total;
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
                this.getSuppliers(this.searchParams, page);
            }
        },
        delete(supplier) {
            axios.delete('/suppliers/' + supplier)
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
        restore(supplier) {
            axios.post('/supplier/' + supplier + '/restore')
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
        deleteSupplier(supplier) {
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
                    this.delete(supplier)
                }
            });
        },
        restoreSupplier(supplier) {
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
                    this.restore(supplier)
                }
            });
        },
        updatePage(page) {
            this.currentPage = page;
            this.getSupplier();
        },
    },
    created() {
        this.getSuppliers();
    },
};
</script>
