<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Cidades</h2>
            <search :route="'city'" @search="getCities"></search>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cidades</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <div v-if="cities && cities.length > 0" class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left table-striped">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Nome</th>
                                    <th class="md='auto'">Estado</th>
                                    <th class="md='auto'"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="city in cities" :key="city.id">
                                    <td ><b>{{ city.id }}</b></td>
                                    <td >{{ city.name }}</td>
                                    <td >{{ city.state.name }}</td>
                                    <td >
                                        <router-link :to="'/city/' + city.id + '/edit'" class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary" title="Editar"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <pagination v-if="this.cities.length >= 30" :current-page="currentPage"
                            :total-pages="totalPages" @update-page="updatePage" /> -->
                    </div>
                    <div v-else>
                        <table class="table table-head-fixed text-nowrap">
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-center"><b>Nenhuma cidade encontrada.</b></td>
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

export default {
    data: function () {
        return {
            cities: {},
        };
    },
    components: {
        Search,
    },
    methods: {
        getCities(search) {
            axios.get('/cities', { params: search })
                .then(response => {
                    this.cities = response.data.cities;
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

    },
    beforeMount() {
        this.getCities();
    },
};
</script>
