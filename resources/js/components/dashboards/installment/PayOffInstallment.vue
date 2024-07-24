<template>
  <div class="container-fluid">
    <div class="col-md-12">
      <h2 v-if="!installment.id_casher">Baixar Parcela de Imóvel</h2>
      <h2 v-else>Visualizar Parcela Paga</h2>
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Conta à Receber</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-2">
              <div class="form-group">
                <label for="inputIdAccount">Parcela Atual</label>
                <div
                  class="form-control"
                  id="inputCurrentInstallment"
                  name="current_installment"
                  readonly
                >
                  {{ installment.current_installment }}
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label for="inputIdAccount">Total de Parcelas</label>
                <div
                  class="form-control"
                  id="inputTotalInstallment"
                  name="total_installment"
                  readonly
                >
                  {{ installment.total_installments }}
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="inputDescription">Descrição</label>
                <div class="form-control" readonly="true">
                  {{ installment.description }} |
                  {{
                    installment.property.reference ? installment.property.reference : ""
                  }}
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label for="inputDescription">Status</label>
                <div class="form-control" readonly="true">
                  {{ types_installment[installment.type_installment] }}
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label for="inputCheckDueDate">Data de Vencimento</label>
                <input
                  type="date"
                  class="form-control"
                  id="inputCheckDueDate"
                  name="due_date"
                  v-model="installment.due_date"
                  disabled
                />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputLocator">Locatário</label>
                <div class="form-control" readonly="true">
                  {{ installment.renter.people.name }}
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputIdLocator">Proprietário do Imóvel</label>
                <div class="form-control" readonly="true">
                  {{ installment.locator.people.name }}
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputIdLocator">Descrição do Imóvel</label>
                <div
                  v-if="
                    installment &&
                    installment.property &&
                    installment.property.description
                  "
                  class="form-control"
                  readonly="true"
                >
                  {{
                    installment.property.description.length > 30
                      ? installment.property.description.substring(0, 30) + "..."
                      : installment.property.description
                  }}
                </div>
                <div v-else class="form-control" readonly="true"></div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputFinalValue">Valor Parcela</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                  </div>
                  <money3
                    class="form-control"
                    v-model="installment.installment_value"
                    v-bind="config"
                    id="inputInstallmentValue"
                    placeholder="Valor Parcela"
                    name="installment_value"
                    readonly
                  ></money3>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="inputPaymentMethod">Método de Pagamento</label>
                <select
                  v-if="!installment.id_casher"
                  class="custom-select"
                  id="inputPaymentMethod"
                  name="payment_method"
                  v-model="installment.payment_method"
                >
                  <option value>Selecione a opção</option>
                  <option v-for="(value, key) in payment_method" :key="key" :value="key">
                    {{ value }}
                  </option>
                </select>
                <div v-else class="form-control" readonly>
                  {{ payment_method[installment.payment_method] }}
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="inputDischargeDate">Data Quitação</label>
                <input
                  v-if="!installment.id_casher"
                  type="date"
                  class="form-control"
                  id="inputDischargeDate"
                  placeholder="Informe a data de Quitação"
                  name="discharge_date"
                  v-model="installment.discharge_date"
                  required
                />
                <div v-else class="form-control" readonly>
                  {{ installment.discharge_date }}
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="inputStatus">Status</label>
                <select
                  v-if="!installment.id_casher"
                  class="custom-select"
                  id="inputStatus"
                  name="status"
                  v-model="installment.status"
                  @blur="treatValues()"
                >
                  <option>Selecione o status</option>
                  <option
                    v-for="(value, key) in status_account_receive"
                    :key="key"
                    :value="key"
                  >
                    {{ value }}
                  </option>
                </select>
                <div v-else class="form-control" readonly>
                  {{ status_account_receive[installment.status] }}
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputPenaltyValue">Valor Multa</label>
                <div v-if="!installment.id_casher" class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                  </div>
                  <money3
                    class="form-control"
                    v-model="installment.penalty_value"
                    v-bind="config"
                    id="inputPenaltyValue"
                    placeholder="Locacao"
                    name="penalty_value"
                    @blur="treatValues()"
                  ></money3>
                </div>
                <div v-else class="form-group">
                  <div class="form-control" readonly>
                    R$
                    {{ installment.penalty_value ? installment.penalty_value : "0.00" }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputDiscountValue">Valor Desconto</label>
                <div v-if="!installment.id_casher" class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                  </div>
                  <money3
                    class="form-control"
                    v-model="installment.discount_value"
                    v-bind="config"
                    id="inputDiscountValue"
                    placeholder="Locacao"
                    name="discount value"
                    @blur="treatValues()"
                  ></money3>
                </div>
                <div v-else class="form-group">
                  <div class="form-control" readonly>
                    R$
                    {{ installment.discount_value ? installment.discount_value : "0.00" }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputInstallmentValue">Valor Final</label>
                <div v-if="!installment.id_casher" class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                  </div>
                  <money3
                    v-if="installment.installment_total_value"
                    class="form-control"
                    v-model="installment.installment_total_value"
                    v-bind="config"
                    id="inputFinalValue"
                    name="installment_total_value"
                    readonly
                  ></money3>
                  <money3
                    v-else
                    class="form-control"
                    v-model="installment.installment_total_value"
                    v-bind="config"
                    id="inputFinalValue"
                    name="final_value"
                    readonly
                  ></money3>
                </div>
                <div v-else class="form-group">
                  <div class="form-control" readonly>
                    R$ {{ installment.installment_total_value }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="inputObservations">Conta para Recebimento</label>
                <select
                  v-if="!installment.id_casher"
                  class="custom-select"
                  id="inputIdAccount"
                  name="id_bank_account"
                  required
                  v-model="installment.id_bank_account"
                >
                  <option value="">Selecione...</option>
                  <option
                    v-for="value in bank_accounts"
                    :key="value.id"
                    :id="value.id"
                    :value="value.id"
                  >
                    {{ value.id + " - " + value.bank_name + " - " + value.account_name }}
                  </option>
                </select>
                <div v-else class="form-control" readonly>
                  {{ instal }}
                  {{
                    installment.bank_account.id +
                    " - " +
                    installment.bank_account.bank_name +
                    " - " +
                    installment.bank_account.account_name
                  }}
                </div>
              </div>
            </div>
          </div>
          <br />
        </div>
        <div class="modal-footer justify-content-center">
          <button
            v-if="!installment.id_casher"
            type="submit"
            class="btn btn-primary"
            @click="updateInstallment()"
            :title="installment.status != 2 ? 'Altere o Status para Recebido' : ''"
            :disabled="installment.status != 2 || !installment.id_bank_account"
          >
            Baixar
          </button>
          <button class="btn btn-danger" @click="back()">Voltar</button>
        </div>
      </div>
    </div>

    <div v-if="installment.id_bank_account_transfer" class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Repasse Realizado ao Proprietário</h3>
      </div>
      <div class="card-body">
        <div class="scrollable text-left">
          <table class="table table-head-fixed text-nowrap text-left">
            <thead>
              <tr>
                <th class="col-sm-1">ID</th>
                <th class="col-sm-1">ID Registro Transferência</th>
                <th class="col-sm-2">Banco</th>
                <th class="col-sm-2">Valor</th>
                <th class="col-sm-2">Data De Transferência</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="col-sm-1">{{ installment.id }}</td>
                <td class="col-sm-1">{{ installment.casher.id }}</td>
                <td v-if="installment.bank_account" class="col-sm-2">
                  {{
                    installment.bank_account.bank_name +
                    " | " +
                    installment.bank_account.account_name
                  }}
                </td>
                <td v-else>Parcela em Aberto | Repasse Realizado</td>
                <td class="col-sm-1">
                  <b>R$ {{ installment.casher.account_value }}</b>
                </td>
                <td class="col-sm-1">
                  <b> {{ formatDate(installment.casher.date_current_action) }}</b>
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
import {
  status_account_receive,
  payment_method,
  types_installment,
  onError,
  getCurrentDate,
  formatDate,
} from "../../../utils";
import Swal from "sweetalert2";
import axios from "axios";

export default {
  data: function () {
    return {
      data: {},
      bank_accounts: {},
      locators: {},
      renters: {},
      installment: {
        id: "",
        current_installment: "",
        total_installments: "",
        status: "",
        due_date: "",
        date_received: "",
        description: "",
        identification_code: "",
        observations: "",
        type_installment: "",
        id_transact: "",
        id_locator: "",
        id_property: "",
        payment_method: "",
        id_check: "",
        installment_value: "",
        insurance_value: "",
        insurance_number: "",
        installment_total_value: "",
        id_renter: "",
        discount_value: "",
        penalty_value: "",
        id_casher: "",
        action: 2,

        property: {
          reference: "",
        },
        renter: {
          people: {},
        },
        locator: {
          people: {},
        },
      },
      config: {
        decimal: ",",
        thousands: ".",
        prefix: "R$ ",
        precision: 2,
        masked: false,
      },
      status_account_receive: status_account_receive,
      payment_method: payment_method,
      types_installment: types_installment,
      onError: onError,
      getCurrentDate: getCurrentDate,
      formatDate: formatDate,
    };
  },
  computed: {},
  methods: {
    getInstallment() {
      axios
        .get("/installments/" + this.$route.params.id)
        .then((response) => {
          this.installment = response.data.installment;
          if (!this.installment.discharge_date) {
            this.installment.discharge_date = this.getCurrentDate();
          }
          if (this.installment.id_bank_account == null) {
            this.installment.id_bank_account = "";
          }
        })
        .catch((error) => {
          console.error("Houve um problema com a requisição:", error);
        });
    },

    updateInstallment() {
      this.installment.action = 1;
      axios
        .put("/installments/" + this.$route.params.id, this.installment)
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

    back() {
      this.$router.go(-1);
    },
    getBankAccounts(search) {
      axios
        .get("/bank-accounts", { params: search })
        .then((response) => {
          this.bank_accounts = response.data.bank_accounts.data;
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

    treatValues() {
      const original_value = this.installment.installment_value
        ? parseFloat(this.installment.installment_value)
        : 0;
      const penalty_value = this.installment.penalty_value
        ? parseFloat(this.installment.penalty_value)
        : 0;
      const discount_value = this.installment.discount_value
        ? parseFloat(this.installment.discount_value)
        : 0;
      this.installment.installment_total_value =
        original_value + penalty_value - discount_value;
    },
  },
  created() {
    if (this.$route.params.id) {
      this.getInstallment();
    }
    this.getBankAccounts();
    this.treatValues();
  },
};
</script>
