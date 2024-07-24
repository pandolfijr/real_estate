<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2> Fiadores</h2>
            <search :route="'guarantor'" @search="searchParams => getGuarantors(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Fiadores</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <div v-if="guarantors.length > 0" class="scrollable text-left">
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
                                <tr v-for="guarantor in guarantors" :key="guarantor.id">
                                    <td><b>{{ guarantor.id }}</b></td>
                                    <td>{{ guarantor.people.name }} {{ guarantor.people.surname }}</td>
                                    <td>{{ guarantor.people.email }}</td>
                                    <td>{{ phoneMask(guarantor.people.cellphone) }}</td>
                                    <td v-if="!guarantor.deleted_at" style="color: #f89d52;"><b>Ativo</b></td>
                                    <td v-else style="color: red;"><b>Inativo</b></td>
                                    <td>
                                        <router-link :to="'/guarantor/' + guarantor.id + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td>
                                        <div style="text-align: center;">
                                            <button v-if="guarantor.deleted_at" type="button"
                                                class="btn btn-outline-success" @click="restoreGuarantor(guarantor.id)"
                                                data-toggle="modal" style="margin-top: -0.5em;"
                                                title="Restaurar Fiador">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-outline-danger"
                                                @click="deleteGuarantor(guarantor.id)" data-toggle="modal"
                                                style="margin-top: -0.5em;" title="Excluir Fiador">
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
                                    <td class="text-center"><b>Nenhum fiador encontrado.</b></td>
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
            guarantors: {},
            filter: {
                current_page: 1,
                status: '',
                search: '',
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
        getGuarantors(search = {}, page = 1) {
            search = search || {};
            search.page = page;
            axios.get('/guarantors', { params: search })
                .then(response => {
                    this.guarantors = response.data.guarantors.data;
                    this.currentPage = response.data.guarantors.current_page;
                    this.totalPages = response.data.guarantors.last_page;
                    this.totalResults = response.data.guarantors.total;
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
                this.getGuarantors(this.searchParams, page);
            }
        },
        delete(guarantor) {
            axios.delete('/guarantors/' + guarantor)
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
        restore(guarantor) {
            axios.post('/guarantor/' + guarantor + '/restore')
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
        deleteGuarantor(guarantor) {
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
                    this.delete(guarantor)
                }
            });
        },
        restoreGuarantor(guarantor) {
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
                    this.restore(guarantor)
                }
            });
        },

        updatePage(page) {
            this.currentPage = page;
            this.getGuarantors();
        },
    },
    created() {
        this.getGuarantors();
    },
};
</script>
