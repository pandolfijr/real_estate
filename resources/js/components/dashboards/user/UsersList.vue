<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Usuários</h2>
            <search :route="'user'" @search="searchParams => getUsers(searchParams)"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Usuários do Sistema</h3>
                </div>
                <div class="card-body table-responsive p-0" style="height: 100%;">
                    <div v-if="users.length >= 1" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Nome</th>
                                    <th class="md='auto'">E-mail</th>
                                    <th class="md='auto'">Tipo</th>
                                    <th class="md='auto'">Telefone</th>
                                    <th class="md='auto'"></th>
                                    <th class="md='auto'"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td><b>{{ user.id }}</b></td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ users_type[user.type] }}</td>
                                    <td>{{ phoneMask(user.cellphone) }}</td>
                                    <td>
                                        <router-link :to="'/user/' + user.id + '/edit'" class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td>
                                        <div v-if="my_id != user.id">
                                            <button v-if="user.deleted_at" type="button" class="btn btn-outline-success"
                                                @click="restoreUser(user.id)" data-toggle="modal"
                                                style="margin-top: -0.5em;" title="Restaurar Usuário">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-outline-danger"
                                                @click="deleteUser(user.id)" data-toggle="modal"
                                                style="margin-top: -0.5em;" title="Excluir Usuário">
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
import { users_type, phoneMask, getMonthDates } from '../../../utils';

export default {
    data: function () {
        return {
            users: {},
            filter: {
                status: '',
                search: '',
            },
            my_id: '',
            users_type: users_type,
            phoneMask: phoneMask,
            getMonthDates: getMonthDates,
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
        getUsers(search = {}, page = 1) {
            search = search || {};
            search.page = page;

            axios.get('/users', { params: this.filter })
                .then(response => {
                    this.users = response.data.users.data;
                    this.my_id = response.data.my_id;
                    this.currentPage = response.data.users.current_page;
                    this.totalPages = response.data.users.last_page;
                    this.totalResults = response.data.users.total;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        goToPage(page) {
            if (page > 0 && page <= this.totalPages) {
                this.getUsers(this.searchParams, page);
            }
        },
        delete(user) {
            axios.delete('/users/' + user)
                .then(response => {
                    Swal.fire({
                        text: response.data.message,
                        icon: "success"
                    });
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        restore(user) {
            axios.post('/user/restore/' + user)
                .then(response => {
                    Swal.fire({
                        text: response.data.message,
                        icon: "success"
                    });
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        updatePage(page) {
            this.currentPage = page;
            this.getUsers();
        },
        deleteUser(user) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, usuário será removido.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete(user)
                }
            });
        },
        restoreUser(user) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, o usuário será restaurado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.restore(user)
                }
            });
        },
    },
    created() {
        this.getUsers();
    },
};
</script>
