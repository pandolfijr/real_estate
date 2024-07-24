<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Fazer Repasse</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Parcela à Repassar</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputIdAccount">Parcela Atual</label>
                                <div class="form-control" id="inputCurrentInstallment" name="current_installment"
                                    readonly>
                                    {{ installment.current_installment }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputIdAccount">Total de Parcelas</label>
                                <div class="form-control" id="inputTotalInstallment" name="total_installment" readonly>
                                    {{ installment.total_installments }}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputDescription">Status</label>
                                <div class="form-control" readonly=true> {{
                                    types_post_installment[installment.type_installment] }} </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCheckDueDate">Data de Vencimento</label>
                                <input type="date" class="form-control" id="inputCheckDueDate" name="due_date"
                                    v-model="installment.due_date" disabled>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputDischargeDate">Data Recebimento</label>
                                <div class="form-control" readonly>{{ installment.date_received ? formatDate(installment.date_received) : 'Pendente' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputPaymentMethod">Método de Recebimento</label>
                                <div class="form-control" readonly>{{ payment_method[installment.payment_method]
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputDescription">Descrição</label>
                                <div class="form-control" readonly=true> {{ installment.description }} | {{
                                    installment.property.reference ? installment.property.reference : '' }} </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputIdLocator">Descrição do Imóvel</label>
                                <div v-if="installment && installment.property && installment.property.description"
                                    class="form-control" readonly=true>
                                    {{ installment.property.description.length > 30 ?
                                        installment.property.description.substring(0, 30) + '...' :
                                        installment.property.description }}
                                </div>
                                <div v-else class="form-control" readonly=true></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputLocator">Locatário</label>
                                <div class="form-control" readonly=true> {{ installment.renter.people.name }} </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputIdLocator">Proprietário do Imóvel</label>
                                <div class="form-control" readonly=true> {{ installment.locator.people.name }} </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputFinalValue">Valor Parcela</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <div class="form-control" readonly> {{
                                        installment.installment_value }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputDiscountValue">Taxa Adm.</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-percentage"></i>
                                        </span>
                                    </div>
                                    <div class="form-control" readonly> {{
                                        installment.property.administrative_tax_percentual }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputInstallmentValue">Comissão Imobiliária</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <div class="form-control" readonly> R$ {{
                                        installment.property.administrative_tax_value }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputInstallmentValue">Valor Repasse</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="installment.transfer_value" v-bind="config"
                                        id="inputAdministrativeTaxPercentual" name="transfer_value">
                                    </money3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputObservations">Conta para Retirada</label>
                                <select class="custom-select" id="inputIdAccount" name="id_bank_account" required
                                    v-model="installment.id_bank_account_transfer">
                                    <option value="">Selecione... </option>
                                    <option v-for="(value) in casher_account" :key="value.bank_account.id"
                                        :id="value.bank_account.id"
                                        :disabled="parseFloat(installment.transfer_value) > parseFloat(value.current_value)"
                                        :style="parseFloat(installment.transfer_value) > parseFloat(value.current_value) ? 'background-color: #e9ecef; color: red;' : ''"
                                        :value="value.bank_account.id">
                                        {{ value.bank_account.bank_name + ' - ' + value.bank_account.account_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary" @click="updateInstallment()"
                        :disabled="!installment.id_bank_account_transfer">Fazer Repasse</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { payment_method, types_post_installment, onError, formatDate } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
    watch: {

    },


    data: function () {
        return {
            data: {},
            installment: {
                id: '',
                current_installment: '',
                total_installments: '',
                status: '',
                due_date: '',
                date_received: '',
                description: '',
                identification_code: '',
                observations: '',
                type_installment: '',
                id_transact: '',
                id_locator: '',
                id_property: '',
                payment_method: '',
                id_check: '',
                installment_value: '',
                insurance_value: '',
                insurance_number: '',
                installment_total_value: '',
                id_renter: '',
                discount_value: '',
                penalty_value: '',
                id_casher: '',
                action: 2,
                id_bank_account: '',
                id_bank_account_transfer: '',
                property: {
                    reference: ''
                },
                renter: {
                    people: {}
                },
                locator: {
                    people: {}
                },
                transfer_value: ''
            },
            config: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false
            },
            payment_method: payment_method,
            types_post_installment: types_post_installment,
            onError: onError,
            formatDate:formatDate,
        }
    },

    methods: {
        getInstallment() {
            axios.get('/installments/' + this.$route.params.id)
                .then(response => {
                    this.installment = response.data.installment;
                    this.installment.transfer_value = this.installment.installment_total_value - this.installment.property.administrative_tax_value
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },

        updateInstallment() {
            axios.post('/transfer/' + this.$route.params.id + '/send-transfer', this.installment)
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
                });
        },

        back() {
            this.$router.go(-1);
        },
        getBankAccounts() {
            axios.get('/casher-account')
                .then(response => {
                    this.casher_account = response.data.casher_account.data;
                })
                .catch(error => {
                    error = this.onError(error);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                });
        },

    },
    beforeMount() {
        this.getBankAccounts();
        if (this.$route.params.id) {
            this.getInstallment();
        }
        // this.treatValues();
    },
};
</script>
