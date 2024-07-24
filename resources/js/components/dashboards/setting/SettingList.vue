<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Configurações</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Configurações da Imobiliária</h3>
                </div>
                <div class="card-body table-responsive p-0 scrollable text-left" style="height: 100%;">
                    <table class="table table-head-fixed text-nowrap text-left table-striped">
                        <thead>
                            <tr>
                                <th class="md='auto'">Nome</th>
                                <th class="md='auto'">E-mail Principal</th>
                                <th class="md='auto'">Telefone</th>
                                <th class="md='auto'">WhatsApp</th>
                                <th class="md='auto'"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ settings.fantasy_name }}</td>
                                <td>{{ settings.first_email }}</td>
                                <td>{{ phoneMask(settings.first_telephone) }}</td>
                                <td>{{ phoneMask(settings.first_whatsapp) }}</td>
                                <td>
                                    <router-link :to="'/setting/' + settings.id + '/edit'" class="small-box-footer">
                                        <button type="button" class="btn btn-outline-primary" title="Editar"
                                            style="margin-top: -0.5em;">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Search from '../Search.vue';
import { phoneMask } from '../../../utils';

export default {
    data: function () {
        return {
            settings: {},
            phoneMask: phoneMask,
        };
    },

    components: {
        Search,
    },
    methods: {
        getSettings() {
            axios.get('/settings')
                .then(response => {
                    this.settings = response.data.settings;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
    },
    created() {
        this.getSettings();
    },
};
</script>
