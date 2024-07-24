<template>
  <div class="container-fluid">
    <div class="col-md-12">
      <h2>Locatário</h2>
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">
            {{ renter.id ? "Editar Locatário" : "Cadastrar Locatário" }}
          </h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputName">Nome</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputName"
                  name="name"
                  :disabled="renter.people_exists"
                  placeholder="Informe o Nome"
                  maxlength="20"
                  value=""
                  v-model="renter.people.name"
                />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputSurname">Sobrenome</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputSurname"
                  placeholder="Informe o Sobrenome"
                  name="surname"
                  maxlength="70"
                  :disabled="renter.people_exists"
                  v-model="renter.people.surname"
                />
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputBirthDate">Dt. Nascimento</label>
                <input
                  type="date"
                  class="form-control"
                  id="inputBirthDate"
                  placeholder="Informe a Data de Nascimento"
                  name="birth_date"
                  :disabled="renter.people_exists"
                  v-model="renter.people.birth_date"
                />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputMaritalStatus">Estado Civil</label>
                <select
                  class="custom-select"
                  id="inputMaritalStatus"
                  name="marital_status"
                  :disabled="renter.people_exists"
                  v-model="renter.people.marital_status"
                >
                  <option value>Selecione Estado Civil</option>
                  <option
                    v-for="(value, key) in marital_status"
                    :key="key"
                    :id="key"
                    :value="key"
                  >
                    {{ value }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputCpf">CPF</label>
                <input
                  type="text"
                  class="form-control cpf"
                  id="inputCpf"
                  name="cpf"
                  :disabled="renter.people_exists"
                  @blur="getPeopleByCpf($event)"
                  v-model="renter.people.cpf"
                  placeholder="Informe o CPF"
                  v-mask="'###.###.###-##'"
                  masked="false"
                />
              </div>
            </div>

            <div class="col-sm-3">
              <label class="form-label" for="customFile">Comprovante de CPF</label><br />
              <div v-if="validateDocument('cpf') && !send_cpf">
                <label>Comprovante Enviado</label>
                <button
                  type="button"
                  class="btn btn-outline-primary"
                  title="Enviar Novo Documento"
                  style="margin-top: -0.5em; margin-left: 1em"
                  @click="send_cpf = true"
                >
                  <i class="fas fa-upload"></i>
                </button>
              </div>
              <input
                v-else
                class="form-label"
                type="file"
                id="cpf_proof"
                name="cpf_proof"
                :disabled="renter.people_exists"
                @change="handleFileUpload($event, 'cpf')"
              />
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputRg">RG</label>
                <input
                  type="text"
                  class="form-control cpf"
                  id="inputRg"
                  name="rg"
                  maxlength="11"
                  :disabled="renter.people_exists"
                  v-model="renter.people.rg"
                  placeholder="Informe o RG"
                  @keypress="isNumber($event)"
                />
              </div>
            </div>
            <div class="col-sm-3">
              <label class="form-label" for="customFile">Comprovante de RG</label><br />
              <div v-if="validateDocument('rg') && !send_rg">
                <label>Comprovante Enviado</label>
                <button
                  type="button"
                  class="btn btn-outline-primary"
                  title="Enviar Novo Documento"
                  style="margin-top: -0.5em; margin-left: 1em"
                  @click="send_rg = true"
                >
                  <i class="fas fa-upload"></i>
                </button>
              </div>
              <input
                v-else
                class="form-label"
                type="file"
                id="rg_proof"
                name="rg_proof"
                :disabled="renter.people_exists"
                @change="handleFileUpload($event, 'rg')"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputCellphone">Celular</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputCellphone"
                  name="cellphone"
                  :disabled="renter.people_exists"
                  v-model="renter.people.cellphone"
                  placeholder="Informe o Celular"
                  v-mask="['(##) ####-####', '(##) #####-####']"
                  masked="false"
                />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputEmail"
                  maxlength="40"
                  :disabled="renter.people_exists"
                  v-model="renter.people.email"
                  name="email"
                  placeholder="Informe o Email"
                />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="inputAddress">Endereço</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputAddress"
                  :disabled="renter.people_exists"
                  v-model="renter.people.address"
                  placeholder="Digite o Endereço"
                  name="address"
                  maxlength="100"
                />
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label for="inputNumber">Número</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputNumber"
                  v-model="renter.people.number"
                  :disabled="renter.people_exists"
                  placeholder="No."
                  name="number"
                  maxlength="11"
                  @keypress="isNumber($event)"
                />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <div class="form-group">
                <label for="inputDistrict">Bairro</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputDistrict"
                  :disabled="renter.people_exists"
                  v-model="renter.people.district"
                  placeholder="Digite o Bairro"
                  maxlength="50"
                  name="district"
                />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputComplement">Complemento</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputComplement"
                  :disabled="renter.people_exists"
                  v-model="renter.people.complement"
                  placeholder="Digite o Complemento"
                  name="complement"
                  maxlength="100"
                />
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label for="inputIdCity">Cidade</label>
                <select
                  class="custom-select"
                  id="inputIdCity"
                  name="id_city"
                  :disabled="renter.people_exists"
                  v-model="renter.people.id_city"
                >
                  <option value>Selecione a Cidade</option>
                  <option
                    v-for="(value, key) in cities"
                    :key="key"
                    :id="key"
                    :value="value.id"
                  >
                    {{ value.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label for="inputCep">CEP</label>
                <input
                  type="text"
                  class="form-control cep"
                  id="cep"
                  placeholder="Digite o CEP"
                  :disabled="renter.people_exists"
                  v-mask="'#####-###'"
                  masked="false"
                  name="cep"
                  v-model="renter.people.cep"
                />
              </div>
            </div>
            <div class="col-sm-3">
              <label class="form-label" for="customFile">Comprovante de Residência</label
              ><br />
              <div v-if="validateDocument('address') && !send_address">
                <label>Comprovante Enviado</label>
                <button
                  type="button"
                  class="btn btn-outline-primary"
                  title="Enviar Novo Documento"
                  style="margin-top: -0.5em; margin-left: 1em"
                  @click="send_address = true"
                >
                  <i class="fas fa-upload"></i>
                </button>
              </div>
              <input
                v-else
                class="form-label"
                type="file"
                id="address_proof"
                name="address_proof"
                @change="handleFileUpload($event, 'address')"
              />
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
                <input
                  type="text"
                  class="form-control"
                  id="inputProfession"
                  maxlength="40"
                  v-model="renter.people.profession"
                  name="profession"
                  placeholder="Informe a Profissão"
                />
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
                  <money3
                    class="form-control"
                    v-model="renter.income"
                    v-bind="config"
                    id="inputIncome"
                    placeholder="Valor da Renda"
                    name="sale_value"
                  ></money3>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <label class="form-label" for="customFile">Comprovante de Renda</label
              ><br />
              <div v-if="validateDocument('income') && !send_income">
                <label>Comprovante Enviado</label>
                <button
                  type="button"
                  class="btn btn-outline-primary"
                  title="Enviar Novo Documento"
                  style="margin-top: -0.5em; margin-left: 1em"
                  @click="send_income = true"
                >
                  <i class="fas fa-upload"></i>
                </button>
              </div>
              <input
                v-else
                class="form-label"
                type="file"
                id="income_proof"
                name="income_proof"
                @change="handleFileUpload($event, 'income')"
              />
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
            <button
              v-if="renter.id"
              type="submit"
              class="btn btn-primary"
              @click="updateRenter()"
            >
              Atualizar
            </button>
            <button v-else type="submit" class="btn btn-primary" @click="saveRenter()">
              Salvar
            </button>
            <button class="btn btn-danger" @click="back()">Voltar</button>
            <button @click="clearFilter()" class="btn btn-secondary">Limpar</button>
          </div>
        </div>
      </div>

      <div
        v-if="renter.transaction && renter.transaction.length >= 1"
        class="card card-primary"
      >
        <div class="card-header">
          <h3 class="card-title">Imóvel associado à {{ renter.people.name }}</h3>
        </div>
        <div class="card-body">
          <div class="scrollable text-left">
            <table class="table table-head-fixed text-nowrap text-left">
              <thead>
                <tr>
                  <th class="md='auto'">Referência</th>
                  <th class="md='auto'">Transação</th>
                  <th class="md='auto'">Status do Contrato</th>
                  <th class="md='auto'">Modalidade</th>
                  <th class="md='auto'">Proprietário do Imóvel</th>
                  <th class="md='auto'">Ver Proprietário</th>
                  <th class="md='auto'">Ver Imóvel</th>
                  <th class="md='auto'">Ver Transação</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="transaction in renter.transaction" :key="transaction.id">
                  <td>
                    <b>{{ transaction.property.reference }}</b>
                  </td>
                  <td>{{ transaction_type[transaction.transaction_type] }}</td>
                  <td>{{ contract_status[transaction.contract_status] }}</td>
                  <td>{{ modality[transaction.modality] }}</td>
                  <td>
                    {{
                      transaction.locator.people.name +
                      " " +
                      transaction.locator.people.surname
                    }}
                  </td>
                  <td>
                    <router-link
                      :to="'/renter/' + transaction.id_renter + '/edit'"
                      class="small-box-footer"
                    >
                      <button
                        type="button"
                        class="btn btn-outline-primary"
                        style="margin-top: -0.5em"
                      >
                        <i class="fas fa-solid fa-eye"></i>
                      </button>
                    </router-link>
                  </td>
                  <td>
                    <router-link
                      :to="'/property/' + transaction.id + '/edit'"
                      class="small-box-footer"
                    >
                      <button
                        type="button"
                        class="btn btn-outline-primary"
                        style="margin-top: -0.5em"
                      >
                        <i class="fas fa-solid fa-eye"></i>
                      </button>
                    </router-link>
                  </td>
                  <td>
                    <router-link
                      :to="'/transaction/' + transaction.id + '/edit'"
                      class="small-box-footer"
                    >
                      <button
                        type="button"
                        class="btn btn-outline-primary"
                        style="margin-top: -0.5em"
                      >
                        <i class="fas fa-solid fa-eye"></i>
                      </button>
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div
        v-if="transactions.length > 0 && accounts.length > 0"
        class="card card-primary"
      >
        <div class="card-header">
          <h3 class="card-title">Avarias no Imóvel</h3>
        </div>
        <div class="card-body">
          <div class="scrollable text-left">
            <table class="table table-head-fixed text-nowrap text-left">
              <thead>
                <tr>
                  <th class="md='auto'">ID</th>
                  <th class="md='auto'">Descrição</th>
                  <th class="md='auto'">Data de Compensação</th>
                  <th class="md='auto'">Valor</th>
                  <th class="md='auto'">Ver Conta</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="account in accounts" :key="account.id">
                  <td>{{ account.id }}</td>
                  <td>{{ account.description }}</td>
                  <td>{{ formatDate(account.discharge_date) }}</td>
                  <td>R$ {{ account.final_value }}</td>
                  <td>
                    <router-link
                      :to="'/account-pay/' + account.id + '/pay-off'"
                      class="small-box-footer"
                    >
                      <button
                        type="button"
                        class="btn btn-outline-primary"
                        style="margin-top: -0.5em"
                      >
                        <i class="fas fa-solid fa-eye"></i>
                      </button>
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div v-if="transactions && deposit_modality" class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Caução</h3>
        </div>
        <div class="card-body">
          <div class="scrollable text-left">
            <table class="table table-head-fixed text-nowrap text-left">
              <thead>
                <tr>
                  <th class="md='auto'">Referência</th>
                  <th class="md='auto'"><b>Total Caução</b></th>
                  <th class="md='auto'"><b>Total Avarias</b></th>
                  <th class="md='auto'"><b>Restante Caução</b></th>
                  <th class="md='auto'"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="transaction in transactions" :key="transaction.id">
                  <th>
                    <b>{{ transaction.property.reference }}</b>
                  </th>
                  <th>
                    <b
                      >R$
                      {{ total_security_deposit ? total_security_deposit : "0.00" }}</b
                    >
                  </th>
                  <th style="color: red">
                    <b>R$ {{ total_property_damage ? total_property_damage : "0.00" }}</b>
                  </th>
                  <th style="color: #f89d52">
                    R$
                    {{
                      parseFloat(total_security_deposit) -
                      parseFloat(total_property_damage)
                    }}
                  </th>
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
  transaction_type,
  contract_status,
  handleFileUpload,
  onError,
  isNumber,
  formatDate,
  modality,
} from "../../../utils";

export default {
  data: function () {
    return {
      data: {},
      renter: {
        income: "",
        income_proof: "",
        address_proof: "",
        rg: "",
        cpf: "",
        id_people: "",
        id_people: "",
        people: {
          name: "",
          surname: "",
          cpf: "",
          rg: "",
          cep: "",
          cellphone: "",
          email: "",
          address: "",
          complement: "",
          number: "",
          marital_status: "",
          birth_date: "",
          district: "",
          id_city: "",
          profession: "",
        },
      },
      cities: {},
      config: {
        decimal: ",",
        thousands: ".",
        prefix: "R$ ",
        precision: 2,
        masked: false,
      },
      documents: [],
      marital_status: marital_status,
      transaction_type: transaction_type,
      contract_status: contract_status,
      modality: modality,
      handleFileUpload: handleFileUpload,
      onError: onError,
      isNumber: isNumber,
      formatDate: formatDate,
      send_cpf: false,
      send_rg: false,
      send_address: false,
      send_income: false,
      transaction: {},
      accounts: {},
      transactions: {},
      total_security_deposit: "",
      total_property_damage: 0,
      deposit_modality: false,
    };
  },

  methods: {
    getRenter() {
      axios
        .get("/renters/" + this.$route.params.id)
        .then((response) => {
          this.renter = response.data.renter;
          if (this.renter.id) {
            this.extractTransactions();
          }
        })
        .catch((error) => {
          console.error("Houve um problema com a requisição:", error);
        });
    },
    extractTransactions() {
      if (this.renter && this.renter.transaction && this.renter.transaction.length > 0) {
        this.transactions = this.renter.transaction;
        const property = this.renter.transaction[0].id_property;
        this.getAccountsSecurityByIdRenter(property);
        this.sumSecurityDeposits();
        this.hasDepositModality();
      } else {
        this.transaction = {};
      }
    },
    saveRenter() {
      this.handlesSpecialCharacters();
      if (this.documents.length > 0) {
        this.renter.documents = this.documents;
      }
      axios
        .post("/renters", this.renter)
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
    updateRenter() {
      this.handlesSpecialCharacters();
      if (this.documents.length > 0) {
        this.locator.documents = this.documents;
      }
      axios
        .put("/renters/" + this.$route.params.id, this.renter)
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
      this.renter.people.cpf =
        this.renter.people.cpf != null
          ? this.renter.people.cpf.replace(/[.\-\s()]/g, "")
          : "";
      this.renter.people.rg =
        this.renter.people.rg != null
          ? this.renter.people.rg.replace(/[.\-\s()]/g, "")
          : "";
      this.renter.people.cellphone =
        this.renter.people.cellphone != null
          ? this.renter.people.cellphone.replace(/[.\-\s()]/g, "")
          : "";
      this.renter.people.cep =
        this.renter.people.cep != null
          ? this.renter.people.cep.replace(/[.\-\s()]/g, "")
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
            this.renter.id_people = response.data.people.id;
            this.renter.people = response.data.people;
            this.renter.people_exists = true;
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
      if (this.renter.people.documents) {
        const docs = this.renter.people.documents;
        return docs.some((doc) => doc.type_document === type);
      }
      return false;
    },
    getAccountsSecurityByIdRenter(property) {
      axios
        .get("/accounts-pay", {
          params: {
            type: 1,
            status: 2,
            category: 6,
            id_property: property,
            id_casher: true,
          },
        })
        .then((response) => {
          this.accounts = response.data.accounts.data;
          if (this.accounts.length > 0) {
            this.sumAccounts();
          }
        })
        .catch((error) => {
          console.error("Houve um problema com a requisição:", error);
        });
    },
    sumSecurityDeposits() {
      this.total_security_deposit =
        this.transactions.reduce((total, transaction) => {
          return total + parseFloat(transaction.security_deposit);
        }, 0) ?? "0.00";
    },
    sumAccounts() {
      this.total_property_damage =
        this.accounts.reduce((total, account) => {
          return total + parseFloat(account.final_value);
        }, 0) ?? "0.00";
    },
    hasDepositModality() {
      this.deposit_modality = this.transactions.some(
        (transaction) => transaction.modality === 2
      );
    },
  },
  beforeMount() {
    this.getCities();
    if (this.$route.params.id) {
      this.getRenter();
    }
  },
};
</script>
