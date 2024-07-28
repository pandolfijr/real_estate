<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Fiadores</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ guarantor.id ? "Editar Fiador" : "Cadastrar Fiador" }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputName">Nome</label>
                                <input type="text" class="form-control" id="inputName" name="name"
                                    :disabled="guarantor.people_exists" placeholder="Informe o Nome" maxlength="20"
                                    value="" v-model="guarantor.people.name" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputSurname">Sobrenome</label>
                                <input type="text" class="form-control" id="inputSurname"
                                    :disabled="guarantor.people_exists" placeholder="Informe o Sobrenome" name="surname"
                                    maxlength="70" v-model="guarantor.people.surname" />
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputBirthDate">Dt. Nascimento</label>
                                <input type="date" class="form-control" id="inputBirthDate"
                                    placeholder="Informe a Data de Nascimento" name="birth_date"
                                    :disabled="guarantor.people_exists" v-model="guarantor.people.birth_date" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputMaritalStatus">Estado Civil</label>
                                <select class="custom-select" id="inputMaritalStatus" name="marital_status"
                                    :disabled="guarantor.people_exists" v-model="guarantor.people.marital_status">
                                    <option value>Selecione Estado Civil</option>
                                    <option v-for="(value, key) in marital_status" :key="key" :id="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCpf">CNPJ</label>

                                <input type="text" class="form-control cnpj" id="inputCnpj" name="cnpj"
                                    v-model="guarantor.people.cnpj" placeholder="Informe o CNPJ"
                                    v-mask="'##.###.###/####-##'" :disabled="guarantor.people_exists"
                                    @blur="getPeopleByCnpj($event)" masked="false" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCpf">CPF</label>
                                <input type="text" class="form-control cpf" id="inputCpf" name="cpf"
                                    :disabled="guarantor.people_exists" v-model="guarantor.people.cpf"
                                    placeholder="Informe o CPF" v-mask="'###.###.###-##'" @blur="getPeopleByCpf($event)"
                                    masked="false" />
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <label class="form-label" for="customFile">Comprovante de CPF/CNPJ</label><br />
                            <div v-if="validateDocument('cpf') && !send_cpf">
                                <label>Comprovante Enviado</label>
                                <button type="button" class="btn btn-outline-primary" title="Enviar Novo Documento"
                                    style="margin-top: -0.5em; margin-left: 1em" @click="send_cpf = true">
                                    <i class="fas fa-upload"></i>
                                </button>
                            </div>
                            <input v-else class="form-label" type="file" id="cpf_proof" name="cpf_proof"
                                :disabled="guarantor.people_exists" @change="handleFileUpload($event, 'cpf')" />
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputRg">RG</label>
                                <input type="text" class="form-control cpf" id="inputRg" name="rg" maxlength="11"
                                    v-model="guarantor.people.rg" placeholder="Informe o RG"
                                    :disabled="guarantor.people_exists" @keypress="isNumber($event)" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label" for="customFile">Comprovante de RG</label><br />
                            <div v-if="validateDocument('rg') && !send_rg">
                                <label>Comprovante Enviado</label>
                                <button type="button" class="btn btn-outline-primary" title="Enviar Novo Documento"
                                    style="margin-top: -0.5em; margin-left: 1em" @click="send_rg = true">
                                    <i class="fas fa-upload"></i>
                                </button>
                            </div>
                            <input v-else class="form-label" type="file" id="rg_proof" name="rg_proof"
                                :disabled="guarantor.people_exists" @change="handleFileUpload($event, 'rg')" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCellphone">Celular</label>
                                <input type="text" class="form-control" id="inputCellphone" name="cellphone"
                                    v-model="guarantor.people.cellphone" placeholder="Informe o Celular"
                                    :disabled="guarantor.people_exists" v-mask="['(##) ####-####', '(##) #####-####']"
                                    masked="false" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="text" class="form-control" id="inputEmail" maxlength="40"
                                    :disabled="guarantor.people_exists" v-model="guarantor.people.email" name="email"
                                    placeholder="Informe o Email" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputAddress">Endereço</label>
                                <input type="text" class="form-control" id="inputAddress"
                                    :disabled="guarantor.people_exists" v-model="guarantor.people.address"
                                    placeholder="Digite o Endereço" name="address" maxlength="100" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputNumber">Número</label>
                                <input type="text" class="form-control" id="inputNumber"
                                    :disabled="guarantor.people_exists" v-model="guarantor.people.number"
                                    placeholder="No." name="number" maxlength="11" @keypress="isNumber($event)" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputDistrict">Bairro</label>
                                <input type="text" class="form-control" id="inputDistrict"
                                    :disabled="guarantor.people_exists" v-model="guarantor.people.district"
                                    placeholder="Digite o Bairro" maxlength="50" name="district" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputComplement">Complemento</label>
                                <input type="text" class="form-control" id="inputComplement"
                                    :disabled="guarantor.people_exists" v-model="guarantor.people.complement"
                                    placeholder="Digite o Complemento" name="complement" maxlength="100" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputIdCity">Cidade</label>
                                <select class="custom-select" id="inputIdCity" name="id_city"
                                    :disabled="guarantor.people_exists" v-model="guarantor.people.id_city">
                                    <option value>Selecione a Cidade</option>
                                    <option v-for="(value, key) in cities" :key="key" :id="key" :value="value.id">
                                        {{ value.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCep">CEP</label>
                                <input type="text" class="form-control cep" id="cep" placeholder="Digite o CEP"
                                    :disabled="guarantor.people_exists" v-mask="'#####-###'" masked="false" name="cep"
                                    v-model="guarantor.people.cep" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label" for="customFile">Comprovante de Residência</label><br />
                            <input class="form-label" type="file" id="address_proof" name="address_proof"
                                @change="handleFileUpload($event, 'address')" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label" for="customFile">Comprovante de Registro de Imóvel</label><br />
                            <div v-if="validateDocument('property') && !send_property">
                                <label>Comprovante Enviado</label>
                                <button type="button" class="btn btn-outline-primary" title="Enviar Novo Documento"
                                    style="margin-top: -0.5em; margin-left: 1em" @click="send_property = true">
                                    <i class="fas fa-upload"></i>
                                </button>
                            </div>
                            <input v-else class="form-label" type="file" id="property_registration"
                                name="property_registration" @change="handleFileUpload($event, 'property')" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputProfession">Profissão</label>
                                <input type="text" class="form-control" id="inputProfession" maxlength="40"
                                    v-model="guarantor.people.profession" name="profession"
                                    placeholder="Informe a Profissão" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputIncome">Renda Mensal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="guarantor.income" v-bind="config"
                                        id="inputIncome" placeholder="Valor da Renda" name="sale_value"></money3>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label" for="customFile">Comprovante de Renda</label><br />
                            <div v-if="validateDocument('income') && !send_income">
                                <label>Comprovante Enviado</label>
                                <button type="button" class="btn btn-outline-primary" title="Enviar Novo Documento"
                                    style="margin-top: -0.5em; margin-left: 1em" @click="send_income = true">
                                    <i class="fas fa-upload"></i>
                                </button>
                            </div>
                            <input v-else class="form-label" type="file" id="income_proof" name="income_proof"
                                @change="handleFileUpload($event, 'income')" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button v-if="guarantor.id" type="submit" class="btn btn-primary" @click="updateGuarantor()">
                            Atualizar
                        </button>
                        <button v-else type="submit" class="btn btn-primary" @click="saveGuarantor()">
                            Salvar
                        </button>
                        <button class="btn btn-danger" @click="back()">Voltar</button>
                        <button @click="clearFilter()" class="btn btn-secondary">Limpar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";

import { marital_status, handleFileUpload, onError, isNumber } from "../../../utils";

export default {
    data: function () {
        return {
            data: {},
            guarantor: {
                id: "",
                income: "",
                income_proof: "",
                address_proof: "",
                cpf_proof: "",
                rg_proof: "",
                rg: "",
                cpf: "",
                id_people: "",
                people_exists: false,
                people: {
                    name: "",
                    surname: "",
                    cpf: "",
                    rg: "",
                    cellphone: "",
                    email: "",
                    address: "",
                    cep: "",
                    complement: "",
                    number: "",
                    marital_status: "",
                    birth_date: "",
                    district: "",
                    id_city: "",
                    profession: "",
                    cnpj: "",
                },
            },
            config: {
                decimal: ",",
                thousands: ".",
                prefix: "R$ ",
                precision: 2,
                masked: false,
            },
            documents: [],
            cities: {},
            send_cpf: false,
            send_rg: false,
            send_address: false,
            send_income: false,
            send_property: false,
            marital_status: marital_status,
            handleFileUpload: handleFileUpload,
            onError: onError,
            isNumber: isNumber,
        };
    },
    computed: {},
    methods: {
        getGuarantor() {
            axios
                .get("/guarantors/" + this.$route.params.id)
                .then((response) => {
                    this.guarantor = response.data.guarantor;
                })
                .catch((error) => {
                    console.error("Houve um problema com a requisição:", error);
                });
        },
        saveGuarantor() {
            this.handlesSpecialCharacters();
            if (this.documents.length > 0) {
                this.guarantor.documents = this.documents;
            }
            axios
                .post("/guarantors", this.guarantor)
                .then((response) => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 2500,
                    });
                    this.$router.go(-1);
                })
                .catch((error) => {
                    if (error && error.response.data.errors) {
                        error = this.onError(error);
                    } else {
                        error = error.response.data;
                    }
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.message,
                        showConfirmButton: false,
                        timer: 2500,
                    });
                });
        },
        updateGuarantor() {
            this.handlesSpecialCharacters();
            if (this.documents.length > 0) {
                this.locator.documents = this.documents;
            }
            axios
                .put("/guarantors/" + this.$route.params.id, this.guarantor)
                .then((response) => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 2500,
                    });
                    this.$router.go(-1);
                })
                .catch((error) => {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 2500,
                    });
                });
        },
        getCities() {
            axios
                .get("/cities", {})
                .then((response) => {
                    this.cities = response.data.cities;
                })
                .catch((error) => {
                    console.error("Houve um problema com a requisição:", error);
                });
        },
        back() {
            this.$router.go(-1);
        },

        handlesSpecialCharacters() {
            this.guarantor.people.cpf =
                this.guarantor.people.cpf != null
                    ? this.guarantor.people.cpf.replace(/[.\-\s()]/g, "")
                    : "";
            this.guarantor.people.rg =
                this.guarantor.people.rg != null
                    ? this.guarantor.people.rg.replace(/[.\-\s()]/g, "")
                    : "";
            this.guarantor.people.cellphone =
                this.guarantor.people.cellphone != null
                    ? this.guarantor.people.cellphone.replace(/[.\-\s()]/g, "")
                    : "";
            this.guarantor.people.cep =
                this.guarantor.people.cep != null
                    ? this.guarantor.people.cep.replace(/[.\-\s()]/g, "")
                    : "";
        },

        getPeopleByCpf(event) {
            let cpf = event.target.value;
            cpf = cpf != null ? cpf.replace(/[.\-\s()]/g, "") : null;
            if (!cpf) return false;

            axios
                .get("/people/" + this.$route.params.id + "/get-by-cpf", {
                    params: {
                        cpf: cpf,
                    },
                })
                .then((response) => {
                    if (response.data.people) {
                        this.guarantor.id_people = response.data.people.id;
                        this.guarantor.people = response.data.people;
                        this.guarantor.people_exists = true;
                    }
                })
                .catch((error) => {
                    console.error("Houve um problema com a requisição:", error);
                });
        },
        getPeopleByCnpj(event) {
            let cnpj = event.target.value;
            cnpj = cnpj != null ? cnpj.replace(/[.\/-\s()]/g, "") : null;
            if (!cnpj) return false;

            axios
                .get("/people/" + this.$route.params.id + "/get-by-cnpj", {
                    params: {
                        cnpj: cnpj,
                    },
                })
                .then((response) => {
                    if (response.data.people) {
                        this.guarantor.id_people = response.data.people.id;
                        this.guarantor.people = response.data.people;
                        this.guarantor.people_exists = true;
                    }
                })
                .catch((error) => {
                    console.error("Houve um problema com a requisição:", error);
                });
        },
        clearFilter() {
            this.$router.go();
        },
        validateDocument(type) {
            if (this.guarantor.people.documents) {
                const docs = this.guarantor.people.documents;
                return docs.some((doc) => doc.type_document === type);
            }
            return false;
        },
    },
    created() {
        this.getCities();
        if (this.$route.params.id) {
            this.getGuarantor();
        }
    },
};
</script>
