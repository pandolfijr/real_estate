<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Proprietários</h2>
            <search :route="'locator'" @search="searchParams => getLocators(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Proprietários</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <div v-if="locators.length > 0" class="scrollable text-left">
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
                                <tr v-for="locator in locators" :key="locator.id">
                                    <td><b>{{ locator.id }}</b></td>
                                    <td>{{ locator.people.name }} {{ locator.people.surname }}</td>
                                    <td>{{ locator.people.email }}</td>
                                    <td>{{ phoneMask(locator.people.cellphone) }}</td>
                                    <td v-if="!locator.deleted_at" style="color: #f89d52;"><b>Ativo</b></td>
                                    <td v-else style="color: red;"><b>Inativo</b></td>
                                    <td>
                                        <router-link :to="'/locator/' + locator.id + '/edit'" class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td>
                                        <div v-if="locator.transaction && locator.transaction.length == 0"
                                            style="text-align: center;">
                                            <button v-if="locator.deleted_at" type="button"
                                                class="btn btn-outline-success" @click="restoreLocator(locator.id)"
                                                data-toggle="modal" style="margin-top: -0.5em;"
                                                title="Restaurar Proprietário do Imóvel">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-outline-danger"
                                                @click="deleteLocator(locator.id)" data-toggle="modal"
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
                                    <td class="text-center"><b>Nenhum proprietário encontrado.</b></td>
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
            locators: {
                people: {}
            },
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
        getLocators(search = {}, page = 1) {
            search = search || {};
            search.page = page;
            axios.get('/locators', { params: search })
                .then(response => {
                    this.locators = response.data.locators.data;
                    this.currentPage = response.data.locators.current_page;
                    this.totalPages = response.data.locators.last_page;
                    this.totalResults = response.data.locators.total;
                })
                .catch(error => {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.response.data.message,
                        title: "Você tem certeza?",
                        text: "Ao clicar em SIM, proprietário será removido.",
                        showConfirmButton: false,
                        timer: 2500
                    });
                });
        },
        goToPage(page) {
            if (page > 0 && page <= this.totalPages) {
                this.getLocators(this.searchParams, page);
            }
        },
        delete(locator) {
            axios.delete('/locators/' + locator)
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
                        timer: 4500
                    });
                });
        },
        restore(locator) {
            axios.post('/locator/' + locator + '/restore')
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
        deleteLocator(locator) {
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
                    this.delete(locator)
                }
            });
        },
        restoreLocator(locator) {
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
                    this.restore(locator)
                }
            });
        },
        updatePage(page) {
            this.currentPage = page;
            this.getLocators();
        },
    },
    beforeMount() {
        this.getLocators();
    },
};
</script>
