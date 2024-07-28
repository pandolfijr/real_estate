<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Transações</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ transaction.id ? 'Editar Transação' : 'Cadastrar Transação' }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputContractStatus">Status do Contrato</label>
                                <div v-if="transaction.id == ''" class="form-control" readonly> {{
                                    contract_status[transaction.contract_status] }}</div>
                                <select v-else class="custom-select" id="inputContractStatus" name="contract_status" :disabled="transaction.termination_contract != null"
                                    v-model="transaction.contract_status">
                                    <option value="">Selecione... </option>
                                    <option v-for="(value, key) in action_contract_status" :key="key" :value="key"
                                        :disabled="((validateContractEndDate(transaction.contract_end_date) && (key == 5 || key == 2)) || ((validateContractExpirationDate(transaction.contract_end_date)) && (key == 2 || key == 3 || key == 1)))"
                                        :style="((validateContractEndDate(transaction.contract_end_date) && (key == 5 || key == 2)) || ((validateContractExpirationDate(transaction.contract_end_date)) && (key == 2 || key == 3 || key == 1))) ? 'background-color: #e9ecef;' : ''">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputLocator">Locatário</label>
                                <select v-if="transaction.id" class="custom-select" id="inputIdRenter" name="id_renter"
                                    required v-model="transaction.id_renter" :disabled="edit">
                                    <option v-for="(value) in renters" :key="value.id" :id="value.id" :value="value.id">
                                        {{ value.people.name + ' ' + value.people.surname + ' - [' + value.id + ']' }}
                                    </option>
                                </select>
                                <select v-else-if="renters_filtered.length > 0" class="custom-select" id="inputIdRenter"
                                    name="id_renter" required v-model="transaction.id_renter" :disabled="edit">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value) in renters_filtered" :key="value.id" :id="value.id"
                                        :value="value.id">
                                        {{ value.people.name + ' ' + value.people.surname + ' - [' + value.id + ']' }}
                                    </option>
                                </select>
                                <div v-else class="form-control" readonly> Nenhum locatário disponível</div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputIdLocator">Proprietário do Imóvel</label>
                                <select class="custom-select" id="inputIdLocator" name="id_locator" required
                                    v-model="transaction.id_locator" :disabled="edit"
                                    @change="getPropertiesByIdLocator(transaction.id_locator)">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value) in locators" :key="value.id" :id="value.id"
                                        :value="value.id">
                                        {{ value.people.name + ' ' + value.people.surname + ' - [' + value.id + ']' }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div v-if="edit && transaction.property" class="col-sm-3">
                            <div class="form-group">
                                <label for="inputIdImovel">Imóvel </label>
                                <input class="form-control" type="hidden" :value="transaction.property.id">
                                <div class="form-control" readonly> {{ '[' + transaction.property.reference + '] - ' +
                                    transaction.property.description }}</div>
                            </div>
                        </div>
                        <div v-else class="col-sm-3">
                            <div class="form-group">
                                <label v-if="transaction.id_locator != '' && properties.length == 0"
                                    :style="'color: #f89d52;'"><b>Nenhum Imóvel Disponível</b></label>
                                <label v-else for="inputIdImovel">Imóvel</label>

                                <select class="custom-select" id="inputIdImovel" name="id_property" required
                                    @change="treatProperty($event.target.value)" v-model="transaction.id_property"
                                    :disabled="transaction.id_locator == '' || transaction.id_locator != '' && properties.length == 0">
                                    <option v-if="transaction.id_locator != '' && properties.length == 0" value="">
                                        Nenhum Imóvel...</option>
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in properties" :key="key" :id="key" :value="value.id">
                                        {{ '[' + value.reference + '] - ' + value.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div :class="transaction.transaction_type == 2 ? 'col-sm-3' : 'col-sm-6'">
                            <div class="form-group">
                                <label for="inputTransactionType">Tipo de Transação</label>
                                <select class="custom-select" id="inputTransactionType" name="transaction_type"
                                    v-model="transaction.transaction_type"
                                    :disabled="edit || transaction.id_property == ''">
                                    <option value="">Selecione..</option>
                                    <option v-for="(value, key) in transaction_type" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div v-if="transaction.transaction_type == 2"
                            :class="transaction.transaction_type == 1 ? 'col-sm-4' : 'col-sm-3'">
                            <div class="form-group">
                                <label for="inputResponsibleIptu">Responsável IPTU</label>
                                <select class="custom-select" id="inputResponsibleIptu" name="responsible_iptu"
                                    @change="treatIptu($event.target.value)" v-model="transaction.responsible_iptu"
                                    :disabled="edit">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in responsible_iptu" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div :class="transaction.transaction_type == 2 ? 'col-sm-3' : 'col-sm-6'">
                            <div class="form-group">
                                <label for="inputTypeOfCharge">Tipo de Pagamento</label>
                                <select class="custom-select" id="inputTypeOfCharge" name="type_of_charge"
                                    :disabled="edit" v-model="transaction.type_of_charge">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in type_of_charge" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div v-if="transaction.transaction_type == 2" class="col-sm-3">
                            <div class="form-group">
                                <label for="inputModality">Modalidade</label>
                                <select class="custom-select" id="inputModality" name="modality" :disabled="edit"
                                    v-model="transaction.modality" @change="treatModality($event.target.value)">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in modality" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div
                            :class="transaction.transaction_type == 2 || transaction.transaction_type == '' ? 'col-sm-3' : 'col-sm-6'">
                            <div class="form-group">
                                <label for="inputIdBroken">Corretor</label>
                                <select class="custom-select" id="inputIdBroken" name="id_broker" :disabled="edit"
                                    v-model="transaction.id_broker">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in brokers" :key="key" :id="key" :value="value.id">
                                        {{ value.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div
                            :class="transaction.transaction_type == 2 || transaction.transaction_type == '' ? 'col-sm-3' : 'col-sm-6'">
                            <div class="form-group">
                                <label for="inputDueDay">Dia de Vencimento</label>
                                <select class="custom-select" id="inputDueDay" name="due_day" :disabled="edit"
                                    v-model="transaction.due_day">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in due_day" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div v-if="transaction.transaction_type == 2" class="col-sm-3">
                            <div class="form-group">
                                <label for="inputContractStartDate">Início do Contrato</label>
                                <input type="date" class="form-control" id="inputContractStartDate"
                                    name="contract_start_date" v-model="transaction.contract_start_date"
                                    :disabled="edit" @change="treatDate($event.target.value)">
                            </div>
                        </div>
                        <div v-if="transaction.transaction_type == 2" class="col-sm-3">
                            <div class="form-group">
                                <label for="inputContractEndDate">Término Previsto para o Contrato</label>
                                <input type="date" class="form-control" id="inputContractEndDate"
                                    name="contract_end_date" v-model="transaction.contract_end_date"
                                    :disabled="edit || transaction.contract_start_date == '' || transaction.contract_status == 1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputWitness">Testemunha</label>
                                <input type="text" class="form-control" id="inputWitness"
                                    placeholder="Informe a Testemunha" name="witness" maxlength="100" :disabled="edit"
                                    v-model="transaction.witness">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputObservations">Observações</label>
                                <input type="text" class="form-control" id="inputObservations"
                                    placeholder="Descreva as Observações" name="observations" maxlength="255"
                                    :disabled="edit" v-model="transaction.observations">
                            </div>
                        </div>
                    </div>

                    <div v-if="transaction.transaction_type == 2 && transaction.modality" class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div v-if="transaction.transaction_type == 2 && transaction.modality == 1" class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputIdFirstGuarantor">1º Fiador</label>
                                <select class="custom-select" id="inputIdFirstGuarantor" name="id_first_guarantor"
                                    required v-model="transaction.id_first_guarantor" :disabled="edit"
                                    @change="treatGuarantor($event.target.value)">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value) in guarantors" :key="value.id" :id="value.id"
                                        :value="value.id">
                                        {{ value.people.name + " " + value.people.surname }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputIdSecondGuarantor">2º Fiador</label>
                                <select class="custom-select" id="inputIdSecondGuarantor" name="id_second_guarantor"
                                    required v-model="transaction.id_second_guarantor"
                                    :disabled="edit || transaction.id_first_guarantor == ''">
                                    <option value="">Selecione o Fiador</option>
                                    <option v-for="(value, key) in filteredGuarantors" :key="key" :id="key"
                                        :value="value.id">
                                        {{ value.people.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div v-if="transaction.transaction_type == 2 && transaction.modality == 2" class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputSecurityDeposit">Valor Caução</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.security_deposit" v-bind="config"
                                        id="inputSecurityDeposit" name="security_deposit" :disabled="edit"></money3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="transaction.transaction_type == 2 && transaction.modality == 3" class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputInsuranceNumber">Número do Seguro</label>
                                <input type="text" class="form-control" id="inputInsuranceNumber"
                                    placeholder="Informe o Número do Seguro" name="insurance_number" maxlength="300"
                                    v-model="transaction.insurance_number" :disabled="edit">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputResponsibleInsurance">Responsável Seguro</label>
                                <select class="custom-select" id="inputResponsibleInsurance"
                                    @change="treatInsurance($event.target.value)" name="responsible_insurance" required
                                    v-model="transaction.responsible_insurance" :disabled="edit">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in responsible_insurance" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div v-if="transaction.responsible_insurance == 2" class="col-sm-3">
                            <div class="form-group">
                                <label for="inputInsuranceValue">Valor Parcela Seguro</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.insurance_value" v-bind="config"
                                        @blur="treatValues()" id="inputInsuranceValue" name="insurance_value"
                                        :disabled="edit"></money3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="transaction.transaction_type == 2" class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div v-if="transaction.transaction_type == 2" :class="'col-sm-3'">
                            <div class="form-group">
                                <label for="inputNumberInstallments">Parcelas</label>
                                <input type="text" class="form-control" id="inputNumberInstallments"
                                    placeholder="Quant." name="number_installments" maxlength="2"
                                    v-model="transaction.number_installments" :disabled="edit">
                            </div>
                        </div>
                        <div :class="'col-sm-3'">
                            <div class="form-group">
                                <label for="inputValueProperty">R$ Propriedade</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.property_value" v-bind="config"
                                        @blur="treatValues()" id="inputValueProperty" name="property_value"
                                        :disabled="edit"></money3>
                                </div>
                            </div>
                        </div>
                        <div :class="'col-sm-3'" v-if="transaction.transaction_type">
                            <div class="form-group">
                                <label for="InputPercentualAdministrativeTax">% Taxa Administ. </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-solid fa-percentage"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="setting.administrative_tax"
                                        @blur="treatValues()" v-bind="config" id="InputPercentualAdministrativeTax"
                                        :disabled="edit" name="percentual_administrative_tax">
                                    </money3>

                                </div>
                            </div>
                        </div>
                        <div :class="'col-sm-3'" v-if="transaction.transaction_type">
                            <div class="form-group">
                                <label for="inputAdministrativeTax">R$ Taxa Administ.</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.administrative_tax"
                                        :disabled="edit" v-bind="config" id="inputAdministrativeTax"
                                        name="administrative_tax">
                                    </money3>
                                </div>
                            </div>
                        </div>

                        <div v-if="transaction.responsible_iptu == 2 && transaction.transaction_type == 2"
                            class="col-sm-3">
                            <div class="form-group">
                                <label for="inputIptuValue">IPTU</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.iptu_value" v-bind="config"
                                        @blur="treatValues()" id="inputIptuValue" name="iptu_value" :disabled="edit">
                                    </money3>
                                </div>
                            </div>
                        </div>

                        <div v-if="[1, 5, 10, 12, 18, 21].includes(property.type)" class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCondoValue">Valor do Condomínio</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.condo_value" v-bind="config"
                                        :disabled="edit" id="inputCondoValue" name="condo_value" @blur="treatValues()"
                                        readonly></money3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputOthersTransfers">Out. Repasses</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.other_transfers" v-bind="config"
                                        :disabled="edit" @blur="treatValues()" id="inputOthersTransfers"
                                        name="other_transfers"></money3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputFinalValue">R$ Final
                                    {{ transaction.transaction_type == 2 ? 'da Parcela' : '' }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.final_value" v-bind="config"
                                        id="inputFinalValue" name="final_value" disabled></money3>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row" v-if="transaction.contract_status == 3 || transaction.contract_status == 4">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputKeysReturn">Data de Encerramento de Contrato</label>
                                <input type="date" class="form-control" id="inputKeysReturn"
                                    name="keys_return" v-model="transaction.keys_return">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputTerminationContract">Entrega das Chaves</label>
                                <input type="date" class="form-control" id="inputTerminationContract"
                                    name="termination_contract" v-model="transaction.termination_contract">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputPenaltyValue">Multa</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.penalty_value" v-bind="config"
                                        :disabled="edit" @blur="treatValues()" id="inputPenaltyValue"
                                        name="penalty_value"></money3>
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputInterestMonthValue">Juros Mensal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="transaction.interest_month_value"
                                        :disabled="edit" @blur="treatValues()" v-bind="config"
                                        id="inputInterestMonthValue" name="interest_month_value">
                                    </money3>
                                </div>
                            </div>
                        </div> -->


                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="!transaction.id" type="submit" class="btn btn-primary"
                        @click="saveTransaction()">Salvar</button>
                    <button v-else-if="transaction.contract_status == 3" type="submit" class="btn btn-primary"
                        @click="finishOrCancelTransaction(3)">Cancelar Transação</button>
                    <button v-else-if="transaction.contract_status == 4" type="submit" class="btn btn-primary"
                        @click="finishOrCancelTransaction(4)">Finalizar Transação</button>
                    <button v-else-if="transaction.contract_status == 5" type="submit" class="btn btn-primary"
                        @click="renewTransaction()">Renovar Transação</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import {
    due_day,
    transaction_type,
    status_transact,
    contract_status,
    modality,
    responsible_insurance,
    responsible_iptu,
    type_of_charge,
    onError,
    action_contract_status,
} from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {

    data: function () {
        return {
            data: {},
            transaction: {
                id: '',
                contract_start_date: '',
                contract_end_date: '',
                contract_status: 1,
                due_day: '',
                first_due_date: '',
                generation_date: '',
                transaction_type: '',
                modality: '',
                responsible_insurance: '',
                responsible_iptu: '',
                type_of_charge: 1,
                observations: '',
                witness: '',
                insurance_number: '',
                status_transact: '',
                security_deposit: '',
                penalty_value: 0,
                interest_month_value: 0,
                administrative_tax: 0,
                other_transfers: 0,
                property_value: 0,
                insurance_value: 0,
                condo_value: '',
                iptu_value: 0,
                final_value: '',
                number_installments: 1,
                id_property: '',
                id_locator: '',
                id_renter: '',
                id_first_guarantor: '',
                id_second_guarantor: '',
                id_keys: '',
                id_broker: '',
                id_condo: '',
                keys_return: '',
                termination_contract: '',
            },
            total_remaining_installments: 0,
            properties: {
                condo: {},
            },
            renters: {},
            renters_filtered: {},
            guarantors: {},
            brokers: {},
            locators: {},
            config: {
                decimal: '.',
                thousands: '',
                precision: 2,
                masked: true
            },
            due_day: due_day,
            transaction_type: transaction_type,
            status_transact: status_transact,
            contract_status: contract_status,
            modality: modality,
            responsible_insurance: responsible_insurance,
            responsible_iptu: responsible_iptu,
            type_of_charge: type_of_charge,
            action_contract_status: action_contract_status,
            property: {},
            setting: {},
            edit: false,
            onError: onError,
        }
    },
    computed: {
        filteredGuarantors() {
            return this.guarantors.filter(guarantor => guarantor.id !== this.transaction.id_first_guarantor) ?? {};
        }
    },
    methods: {
        getTransactionById(id) {
            this.edit = true;
            axios.get('/transactions/' + id)
                .then(response => {
                    this.transaction = response.data.transaction;
                    const installments = this.transaction.installments.filter(installment => installment.date_received == null) ?? 0;
                    this.total_remaining_installments = installments.length ?? 0;

                })
                .catch(error => {
                    console.log(error);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                });
        },
        getPropertiesByIdLocator(id_locator) {
            this.resetValues();
            if (id_locator) {
                axios.get('/property-by-locator/' + id_locator)
                    .then(response => {
                        this.properties = response.data.properties;
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
            } else {
                this.property = {};
            }
        },
        resetValues() {
            this.properties = {};
            this.transaction.id_property = '';
            this.transaction.penalty_value = 0;
            this.transaction.interest_month_value = 0;
            this.transaction.other_transfers = 0;
            this.transaction.iptu_value = 0;
            this.transaction.insurance_value = 0;
            this.transaction.property_value = 0;
            this.transaction.number_installments = 0;
            this.transaction.administrative_tax = 0;
            this.transaction.final_value = 0;
            this.transaction.responsible_insurance = '';
            this.transaction.transaction_type = '';
        },
        getProperty(id) {
            axios.get('/properties/' + id)
                .then(response => {
                    this.property = response.data.property;
                    if (this.property) {
                        this.transaction.transaction_type = this.property.status;
                        this.transaction.administrative_tax = this.property.administrative_tax_percentual;
                    }
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getLocators() {
            axios.get('/locators')
                .then(response => {
                    this.locators = response.data.locators.data;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getRenters() {
            axios.get('/renters')
                .then(response => {
                    const renters = response.data.renters.data;
                    this.renters = renters;
                    console.log(renters);
                    this.renters_filtered = renters.filter(renter =>
                        !renter.transaction ||
                        !Array.isArray(renter.transaction) ||
                        renter.transaction.length === 0 ||
                        renter.transaction.some(transaction => transaction.contract_status !== 1)
                    );
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getGuarantors() {
            axios.get('/guarantors', {

            })
                .then(response => {
                    this.guarantors = response.data.guarantors.data;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getBrokers() {
            axios.get('/users')
                .then(response => {
                    this.brokers = response.data.users.data;

                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        treatProperty(id) {
            if (id) {
                this.property = this.properties.filter((value, index) =>
                    value.id == id
                )[0];
                if (this.property.id_condo != '' && this.property.condo) {
                    this.transaction.id_condo = this.property.id_condo;
                    this.transaction.property_value = this.property.rental_value;
                    this.transaction.transaction_type = this.property.purpose;
                    this.transaction.condo_value = this.property.condo_value;
                    if (this.transaction.transaction_type == 2) {
                        this.transaction.number_installments = 12;
                    } else {
                        this.transaction.number_installments = 0;
                    }
                }
                if (this.property.iptu_value != '') {
                    this.transaction.iptu_value = this.property.iptu_value;
                    this.transaction.responsible_iptu = 2;
                }
                this.treatTaxValue();
                this.treatValues();
            } else {
                this.property = {};
            }
        },
        treatTaxValue() {
            if (this.property && this.setting) {
                this.transaction.administrative_tax = this.property.rental_value * (this.setting.administrative_tax / 100).toFixed(2);
            }
        },
        treatDate(date) {
            let new_date = new Date(date);
            new_date.setMonth(new_date.getMonth() + 12);
            this.transaction.contract_end_date = new_date.toISOString().slice(0, 10);
        },
        saveTransaction() {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, a transação será salva, as parcelas serão geradas e o status do imóvel será alterado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f89d52",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.save()
                }
            });
        },
        renewTransaction() {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao clicar em SIM, a transação atual será finalizada e gerada uma nova transação de renovação",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f89d52",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                denyButtonText: `Don't save`,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.renew()
                }
            });
        },
        finishOrCancelTransaction(status) {
            let action = '';
            let post_action = '';
            let message = '';

            if (status == 3) {
                action = "Cancelar";
                post_action = "cancelada";
            } else if (status == 4) {
                action = "Finalizar";
                post_action = "finalizada";
            }

            if (this.total_remaining_installments > 0) {
                message = 'O locatário ainda possui ' + this.total_remaining_installments + ' parcelas à vencer. Você pode optar por apenas ' + action.toLowerCase() + ' o contrato, ou ' + action.toLowerCase() + ' a multa rescisória.'
            }

            Swal.fire({
                title: "Você tem certeza?",
                text: "Ao avançar, a transação atual será " + post_action + '. ' + message,
                showDenyButton: (this.total_remaining_installments > 0),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f89d52",
                denyButtonColor: "#f89d52",
                cancelButtonColor: "#d33",
                confirmButtonText: action + " e gerar multa",
                denyButtonText: action + " a transação",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.updateTransaction(status, true)
                } else if (result.isDenied) {
                    this.updateTransaction(status, false)
                }
            });
        },
        save() {
            axios.post('/transactions', this.transaction)
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
                    error = this.onError(error);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.message,
                        showConfirmButton: false,
                        timer: 2500
                    });

                });
        },
        renew() {
            axios.post('/transactions', this.transaction)
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
                    error = this.onError(error);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: error.message,
                        showConfirmButton: false,
                        timer: 2500
                    });

                });
        },
        updateTransaction(status, generate_penalty) {
            axios.post('/transaction/' + this.$route.params.id + '/cancel-finish-transaction', {
                contract_status: status,
                generate_penalty: generate_penalty,
                total_remaining_installments: this.total_remaining_installments,
                id_property: this.transaction.property.id,
                id_renter: this.transaction.id_renter,
                keys_return: this.transaction.keys_return,
                termination_contract: this.transaction.termination_contract
            })
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
        getSettings() {
            axios.get('/settings/1')
                .then(response => {
                    this.setting = response.data.setting;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        treatValues() {
            if (this.transaction.property_value != '' && this.setting.administrative_tax != '') {
                this.transaction.administrative_tax = (parseFloat(this.transaction.property_value ? this.transaction.property_value : 0)
                    + parseFloat(this.transaction.iptu_value ? this.transaction.iptu_value : 0)) * (this.setting.administrative_tax / 100).toFixed(2);
                let final_value = parseFloat(this.transaction.property_value) +
                    parseFloat(this.transaction.penalty_value ? this.transaction.penalty_value : 0) +
                    parseFloat(this.transaction.interest_month_value ? this.transaction.interest_month_value : 0) +
                    parseFloat(this.transaction.other_transfers ? this.transaction.other_transfers : 0) +
                    parseFloat(this.transaction.iptu_value ? this.transaction.iptu_value : 0) +
                    parseFloat(this.transaction.condo_value ? this.transaction.condo_value : 0) +
                    parseFloat(this.transaction.insurance_value ? this.transaction.insurance_value : 0);
                this.transaction.final_value = final_value;
            }
        },
        treatIptu(responsible_iptu) {
            if (responsible_iptu != 2) {
                this.transaction.final_value = parseFloat(this.transaction.final_value) - parseFloat(this.transaction.iptu_value);
                this.transaction.iptu_value = 0;
            } else {
                this.transaction.iptu_value = this.property.iptu_value;
                this.treatValues();
            }
        },
        treatInsurance(responsible_insurance) {
            if (responsible_insurance != 1) {
                this.transaction.insurance_value = 0
            }
            this.treatValues();
        },
        treatGuarantor(id_first_guarantor) {
            if (id_first_guarantor == '') {
                this.transaction.id_second_guarantor = 0
            }
        },
        treatModality() {
            this.transaction.security_deposit = '';
            this.transaction.id_first_guarantor = '';
            this.transaction.id_second_guarantor = '';
            this.transaction.insurance_value = '';
            this.transaction.responsible_insurance = '';
            this.transaction.insurance_number = '';
        },
        validateContractEndDate(date_contract) {
            const contract_date = new Date(date_contract);
            const today = new Date();
            return contract_date > today
        },

        validateContractExpirationDate(date_contract) {
            const contract_date = new Date(date_contract);
            const today = new Date();
            return contract_date <= today
        }

    },
    created() {
        this.getRenters();
        this.getLocators();
        this.getBrokers();
        this.getGuarantors();
        this.getSettings();
        if (this.$route.params.id) {
            this.getTransactionById(this.$route.params.id)
        }
    },
};
</script>
