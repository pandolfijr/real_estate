<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Proprietário</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ locator && locator.id ? "Editar Proprietário" : "Cadastrar Proprietário" }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputName">Nome<b>*</b></label>
                                <input type="text" class="form-control" id="inputName" name="name"
                                    placeholder="Informe o Nome" maxlength="20" value=""
                                    :disabled="locator.people_exists" v-model="locator.people.name" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputSurname">Sobrenome<b>*</b></label>
                                <input type="text" class="form-control" id="inputSurname"
                                    placeholder="Informe o Sobrenome" name="surname" maxlength="70"
                                    :disabled="locator.people_exists" v-model="locator.people.surname" />
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputBirthDate">Dt. Nascimento</label>
                                <input type="date" class="form-control" id="inputBirthDate"
                                    placeholder="Informe a Data de Nascimento" name="birth_date"
                                    :disabled="locator.people_exists" v-model="locator.people.birth_date" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputMaritalStatus">Estado Civil</label>
                                <select class="custom-select" id="inputMaritalStatus" name="marital_status"
                                    :disabled="locator.people_exists" v-model="locator.people.marital_status">
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
                                    v-model="locator.people.cnpj" placeholder="Informe o CNPJ"
                                    v-mask="'##.###.###/####-##'" :disabled="locator.people_exists"
                                    @blur="getPeopleByCnpj($event)" masked="false" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCpf">CPF</label>

                                <input type="text" class="form-control cpf" id="inputCpf" name="cpf"
                                    v-model="locator.people.cpf" placeholder="Informe o CPF" v-mask="'###.###.###-##'"
                                    :disabled="locator.people_exists" @blur="getPeopleByCpf($event)" masked="false" />
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
                                :disabled="locator.people_exists" @change="handleFileUpload($event, 'cpf')" />
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputRg">RG</label>
                                <input type="text" class="form-control cpf" id="inputRg" name="rg" maxlength="11"
                                    :disabled="locator.people_exists" v-model="locator.people.rg"
                                    placeholder="Informe o RG" />
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
                                :disabled="locator.people_exists" @change="handleFileUpload($event, 'rg')" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCellphone">Celular<b>*</b></label>
                                <input type="text" class="form-control" id="inputCellphone" name="cellphone"
                                    v-model="locator.people.cellphone" placeholder="Informe o Celular"
                                    :disabled="locator.people_exists" v-mask="['(##) ####-####', '(##) #####-####']"
                                    masked="false" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputEmail">Email<b>*</b></label>
                                <input type="text" class="form-control" id="inputEmail" maxlength="40"
                                    v-model="locator.people.email" name="email" placeholder="Informe o Email"
                                    :disabled="locator.people_exists" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputAddress">Endereço<b>*</b></label>
                                <input type="text" class="form-control" id="inputAddress"
                                    v-model="locator.people.address" placeholder="Digite o Endereço" name="address"
                                    :disabled="locator.people_exists" maxlength="255" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputNumber">Número</label>
                                <input type="number" class="form-control" id="inputNumber"
                                    v-model="locator.people.number" @keypress="isNumber($event)" placeholder="No."
                                    :disabled="locator.people_exists" name="number" maxlength="11" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputDistrict">Bairro</label>
                                <input type="text" class="form-control" id="inputDistrict"
                                    v-model="locator.people.district" placeholder="Digite o Bairro" maxlength="50"
                                    :disabled="locator.people_exists" name="district" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputComplement">Complemento</label>
                                <input type="text" class="form-control" id="inputComplement"
                                    v-model="locator.people.complement" placeholder="Digite o Complemento"
                                    :disabled="locator.people_exists" name="complement" maxlength="100" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputIdCity">Cidade<b>*</b></label>
                                <select class="custom-select" id="inputIdCity" name="id_city"
                                    :disabled="locator.people_exists" v-model="locator.people.id_city">
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
                                    :disabled="locator.people_exists" v-mask="'#####-###'" masked="false" name="cep"
                                    v-model="locator.people.cep" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label" for="customFile">Comprovante de Residência </label><br />
                            <div v-if="validateDocument('address') && !send_address">
                                <label>Comprovante Enviado</label>
                                <button type="button" class="btn btn-outline-primary" title="Enviar Novo Documento"
                                    style="margin-top: -0.5em; margin-left: 1em" @click="send_address = true">
                                    <i class="fas fa-upload"></i>
                                </button>
                            </div>
                            <input v-else class="form-label" type="file" id="address_proof" name="address_proof"
                                :disabled="locator.people_exists" @change="handleFileUpload($event, 'address')" />
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
                                    v-model="locator.people.profession" name="profession"
                                    placeholder="Informe a Profissão" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputIncome">Renda Mensal<b>*</b></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="locator.income" v-bind="config"
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
                        <button v-if="locator.id" type="submit" class="btn btn-primary" @click="updateLocator()">
                            Atualizar
                        </button>
                        <button v-else type="submit" class="btn btn-primary" @click="saveLocator()">
                            Salvar
                        </button>
                        <button class="btn btn-danger" @click="back()">Voltar</button>
                        <button @click="clearFilter()" class="btn btn-secondary">Limpar</button>
                    </div>
                </div>
            </div>

            <div v-if="locator.property && locator.property.length >= 1" class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Propriedades de {{ locator.people.name }}</h3>
                </div>
                <div class="card-body">
                    <div class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left">
                            <thead>
                                <tr>
                                    <th class="md='auto'">Referência</th>
                                    <th class="md='auto'">Nome</th>
                                    <th class="md='auto'">Tipo</th>
                                    <th class="md='auto'">Status</th>
                                    <th class="md='auto'">Ver Imóvel</th>
                                    <th class="md='auto'">Ver Transação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="property in locator.property" :key="property.id">
                                    <td>
                                        <b>{{ property.reference }}</b>
                                    </td>
                                    <td>{{ property.description }}</td>
                                    <td>
                                        {{ properties_type[property.type].description ?? "Não informado" }}
                                    </td>
                                    <td>{{ status_properties[property.status] }}</td>
                                    <td>
                                        <router-link :to="'/property/' + property.id + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary"
                                                style="margin-top: -0.5em">
                                                <i class="fas fa-solid fa-eye"></i>
                                            </button>
                                        </router-link>
                                    </td>

                                    <td v-if="property.id_transaction">
                                        <router-link :to="'/transaction/' + property.id_transaction + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary"
                                                style="margin-top: -0.5em">
                                                <i class="fas fa-solid fa-eye"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td v-else>
                                        <button type="button" class="btn btn-outline-secondary"
                                            style="margin-top: -0.5em" title="Nenhuma Ação" disabled>
                                            <i class="fas fa-hand-paper"></i>
                                        </button>
                                    </td>
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
import Swal from "sweetalert2";
import axios from "axios";

import {
    marital_status,
    status_properties,
    properties_type,
    handleFileUpload,
    onError,
    isNumber,
} from "../../../utils";

export default {
    data: function () {
        return {
            data: {},
            locator: {
                id: "",
                income: "",
                income_proof: "",
                address_proof: "",
                rg: "",
                cpf: "",
                id_people: "",
                people: {
                    name: "",
                    surname: "",
                    cpf: "",
                    rg: "",
                    cellphone: "",
                    email: "",
                    cep: "",
                    address: "",
                    complement: "",
                    number: "",
                    marital_status: "",
                    birth_date: "",
                    district: "",
                    id_city: "",
                    profession: "",
                    cnpj: "",
                },
                people_exists: false,
            },
            config: {
                decimal: ",",
                thousands: ".",
                prefix: "R$ ",
                precision: 2,
                masked: false,
            },
            documents: [],
            send_cpf: false,
            send_rg: false,
            send_address: false,
            send_income: false,
            cities: {},
            marital_status: marital_status,
            status_properties: status_properties,
            properties_type: properties_type,
            handleFileUpload: handleFileUpload,
            onError: onError,
            isNumber: isNumber,
        };
    },

    methods: {
        getLocator() {
            axios
                .get("/locators/" + this.$route.params.id)
                .then((response) => {
                    if (response.data.locator) {
                        this.locator = response.data.locator;
                    }
                })
                .catch((error) => {
                    console.error("Houve um problema com a requisição:", error);
                });
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
                        this.locator.id_people = response.data.people.id;
                        this.locator.people = response.data.people;
                        this.locator.people_exists = true;
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
                        this.locator.id_people = response.data.people.id;
                        this.locator.people = response.data.people;
                        this.locator.people_exists = true;
                    }
                })
                .catch((error) => {
                    console.error("Houve um problema com a requisição:", error);
                });
        },
        saveLocator() {
            this.handlesSpecialCharacters();
            if (this.documents.length > 0) {
                this.locator.documents = this.documents;
            }
            axios
                .post("/locators", this.locator)
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
        updateLocator() {
            this.handlesSpecialCharacters();
            if (this.documents.length > 0) {
                this.locator.documents = this.documents;
            }
            axios
                .put("/locators/" + this.$route.params.id, this.locator)
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
            this.locator.people.cpf =
                this.locator.people.cpf != null
                    ? this.locator.people.cpf.replace(/[.\-\s()]/g, "")
                    : "";
            this.locator.people.rg =
                this.locator.people.rg != null
                    ? this.locator.people.rg.replace(/[.\-\s()]/g, "")
                    : "";
            this.locator.people.cellphone =
                this.locator.people.cellphone != null
                    ? this.locator.people.cellphone.replace(/[.\-\s()]/g, "")
                    : "";
            this.locator.people.cep =
                this.locator.people.cep != null
                    ? this.locator.people.cep.replace(/[.\-\s()]/g, "")
                    : "";
            this.locator.people.cnpj =
                this.locator.people.cnpj != null
                    ? this.locator.people.cnpj.replace(/[.\/-\s()]/g, "")
                    : "";
        },

        clearFilter() {
            this.$router.go();
        },
        validateDocument(type) {
            if (this.locator.people.documents) {
                const docs = this.locator.people.documents;
                return docs.some((doc) => doc.type_document === type);
            }
            return false;
        },
    },
    created() {
        this.getCities();
        if (this.$route.params.id) {
            this.getLocator();
        }
    },
};
</script>
