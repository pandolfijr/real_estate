<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Usuários</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ user.id ? 'Editar Usuário' : 'Cadastrar Usuário' }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputName">Nome</label>
                                <input type="text" class="form-control" id="inputName" name="name" v-model="user.name"
                                    placeholder="Digite o Nome" required maxlength="50">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputCellphone">Celular</label>
                                <input type="text" class="form-control" id="inputCellphone"
                                    placeholder="Informe o celular" name="cellphone" v-model="user.cellphone"
                                    v-mask="['(##) ####-####', '(##) #####-####']" masked="false" required>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputCpf">CPF</label>
                                <input type="text" class="form-control" id="inputCpf" placeholder="Digite o CPF"
                                    v-model="user.cpf" v-mask="'###.###.###-##'" name="cpf">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="text" class="form-control" id="inputEmail" placeholder="Digite o Email"
                                    name="email" maxlength="140" v-model="user.email" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputPassword">Senha</label>
                                <input type="password" class="form-control" id="inputPassword"
                                    placeholder="************" v-model="user.password" name="password">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputType">Tipo</label>
                                <select class="custom-select" id="inputType" name="type" v-model="user.type" required>
                                    <option value="">Selecione o Tipo</option>
                                    <option v-for="(value, key) in users_type" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select class="custom-select" id="inputStatus" name="status" required
                                    v-model="user.status">
                                    <option value="">Selecione o Status</option>
                                    <option v-for="(value, key) in status" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="user.id" type="submit" class="btn btn-primary"
                        @click="updateUser()">Atualizar</button>
                    <button v-else type="submit" class="btn btn-primary" @click="saveUser()">Salvar</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>

            </div>
        </div>
    </div>
</template>


<script>
import { users_type, status } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {

    data: function () {
        return {
            user: {
                id: '',
                name: '',
                cellphone: '',
                cpf: '',
                email: '',
                type: '',
                status: '',

            },
            status: status,
            users_type: users_type,

        }
    },

    methods: {
        getUser() {
            axios.get('/users/' + this.$route.params.id)
                .then(response => {
                    this.user = response.data.user;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveUser() {
            axios.post('/users', this.user)
                .then(response => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    this.$router.go(-1);
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
        updateUser() {
            axios.put('/users/' + this.$route.params.id, this.user)
                .then(response => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    this.$router.go(-1);
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
        back() {
            this.$router.go(-1);
        },

    },
    beforeMount() {
        if (this.$route.params.id) {
            this.getUser();
        }

    },
};
</script>
