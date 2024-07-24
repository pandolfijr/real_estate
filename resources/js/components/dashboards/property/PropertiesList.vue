<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Imóveis</h2>
            <search :route="'property'" @search="searchParams => getProperties(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Imóveis</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <div v-if="properties.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">Referência</th>
                                    <th class="md='auto'">Nome</th>
                                    <th class="md='auto'">Status</th>
                                    <th class="md='auto'">Proprietário</th>
                                    <th class="md='auto'">Locatário/Comprador</th>
                                    <th class="md='auto'"></th>
                                    <th class="md='auto'"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="property in properties" :key="property.id">
                                    <td><b>{{ property.reference }}</b></td>
                                    <td>{{ property.description }}</td>
                                    <td>{{ status_properties[property.status] }}</td>
                                    <td>
                                        {{ property && property.locator && property.locator.people ?
                                            property.locator.people.name + " " + property.locator.people.surname : ' - ' }}
                                    </td>
                                    <td>
                                        {{ property && property.renter && property.renter.people ?
                                            property.renter.people.name + " " + property.renter.people.surname : ' - ' }}
                                    </td>
                                    <td>
                                        <router-link :to="'/property/' + property.id + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i
                                                    :class="!property.id_transaction ? 'fas fa-pencil-alt' : 'fas fa-solid fa-eye'"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td>
                                        <div v-if="!property.id_transaction" style="text-align: center;">
                                            <button v-if="property.deleted_at" type="button"
                                                class="btn btn-outline-success" @click="restoreCustomer(property.id)"
                                                data-toggle="modal" style="margin-top: -0.5em;"
                                                title="Restaurar Fiador">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-outline-danger"
                                                @click="deleteProperty(property.id)" data-toggle="modal"
                                                style="margin-top: -0.5em;" title="Excluir Fiador">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div v-else>
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
                                    <td class="text-center"><b>Selecione o Status e clique em Buscar para pesquisar os
                                            imóveis</b></td>
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
import { status_properties } from '../../../utils';

export default {
    data: function () {
        return {
            properties: {
                locator: {
                    people: {}
                }
            },
            status_properties: status_properties,
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
        getProperties(search = {}, page = 1) {
            search = search || {};
            search.page = page;
            axios.get('/properties', { params: search })
                .then(response => {
                    this.properties = response.data.properties.data;
                    this.currentPage = response.data.properties.current_page;
                    this.totalPages = response.data.properties.last_page;
                    this.totalResults = response.data.properties.total;
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
                this.getProperties(this.searchParams, page);
            }
        },
        delete(property) {
            axios.delete('/properties/' + property)
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
        restore(property) {
            axios.post('/property/' + property + '/restore')
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
        deleteProperty(property) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, o imóvel será removido.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete(property)
                }
            });
        },
        restoreProperty(property) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, o imóvel será restaurado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.restore(property)
                }
            });
        },
        updatePage(page) {
            this.currentPage = page;
            this.getProperties();
        },
    },
};
</script>
