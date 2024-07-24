<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2> Condomínios / Prédios</h2>
            <search :route="'condo'" @search="searchParams => getCondos(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Condomínio / Prédios </h3>
                </div>
                <div class="card-body table-responsive p-0" style="">
                    <div v-if="condos && condos.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Descrição</th>
                                    <th class="md='auto'">Tipo</th>
                                    <th class="md='auto'">Cidade</th>
                                    <th class="md='auto'"></th>
                                    <th class="md='auto'"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="condo in condos" :key="condo.id">
                                    <td><b>{{ condo.id }}</b></td>
                                    <td>{{ condo.description }}</td>
                                    <td>{{ type_condo[condo.type] }} </td>
                                    <td>{{ condo.city.name }}</td>
                                    <td>
                                        <router-link :to="'/condo/' + condo.id + '/edit'" class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td>
                                        <div style="text-align: center;">
                                            <button v-if="condo.deleted_at" type="button"
                                                class="btn btn-outline-success" @click="restoreCondo(condo.id)"
                                                data-toggle="modal" style="margin-top: -0.5em;"
                                                title="Restaurar Condomínio / Prédio">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-outline-danger"
                                                @click="deleteCondo(condo.id)" data-toggle="modal"
                                                style="margin-top: -0.5em;" title="Excluir Condomínio / Prédio">
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
                                    <td class="text-center"><b>Nenhum condomínio / prédio encontrado.</b></td>
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
import { type_condo } from '../../../utils';


export default {
    data: function () {
        return {
            condos: {},
            type_condo: type_condo,
            cities: {},
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
        getCondos(search = {}, page = 1) {
            search = search || {};
            search.page = page;

            axios.get('/condos', { params: search })
                .then(response => {
                    this.condos = response.data.condos.data;
                    this.currentPage = response.data.condos.current_page;
                    this.totalPages = response.data.condos.last_page;
                    this.totalResults = response.data.condos.total;
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
                this.getCondos(this.searchParams, page);
            }
        },
        delete(condo) {
            axios.delete('/condos/' + condo)
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
                        timer: 4500
                    });
                });
        },
        restore(condo) {
            axios.post('/condo/' + condo + '/restore')
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
        deleteCondo(condo) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, o condomínio/prédio será removido.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete(condo)
                }
            });
        },
        restoreCondo(condo) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, o condomínio/prédio será restaurado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.restore(condo)
                }
            });
        },
    },
    beforeMount() {
        this.getCondos();
    },
};
</script>
