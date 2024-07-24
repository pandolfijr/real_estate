<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Imóveis</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 v-if="property.id_transaction" class="card-title">Visualizar Imóvel</h3>
                    <h3 v-else-if="property.id" class="card-title">Editar</h3>
                    <h3 v-else class="card-title">Cadastrar</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputReference">Ref.</label>
                                <div type="text" class="form-control" id="inputReference"
                                    title="Gerado Automáticamente após salvar" readonly name="reference"> {{
                                        property.reference }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="InputDescription">Descrição do Imóvel</label>
                                <input type="text" class="form-control" id="InputDescription"
                                    placeholder="Descreva o Imóvel" name="description" maxlength="100"
                                    v-model="property.description">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputLocator">Proprietário do Imóvel</label>
                                <select class="custom-select" id="inputLocator" name="id_locator" required
                                    v-model="property.id_locator">
                                    <option value="">Selecione... </option>
                                    <option v-for="(value) in locators" :key="value.id" :id="value.id"
                                        :value="value.id">
                                        {{ value.people.name + ' ' + value.people.surname }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputPurpose">Finalidade</label>
                                <select class="custom-select" id="inputPurpose" name="purpose" required
                                    v-model="property.purpose">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in purpose" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select class="custom-select" id="inputStatus" name="status" disabled
                                    v-model="property.status">
                                    <option value="">Selecione...</option>
                                    <option v-for="(value, key) in status_properties" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputType">Tipo de Imóvel</label>
                                <select id="inputType" class="form-control" name="type" required
                                    @change="treatPropertyType($event.target.value)" v-model="property.type">
                                    <option value="">Selecione...</option>
                                    <option v-for="value in properties_type" :key="value.id" :id="value.id"
                                        :value="value.id">
                                        {{ value.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputDisplayAddress">Exibir Endereço</label>
                                <select class="custom-select" id="inputDisplayAddress" name="display_address"
                                    v-model="property.display_address">
                                    <option value>Selecione...</option>
                                    <option v-for="(value, key) in options" :key="key" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div v-if="validateCondo(property.type)" class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCondo">Cond./Prédio</label>
                                <select class="custom-select" id="inputCondo" name="condo" required
                                    @change="treatCondo($event.target.value)" v-model="property.id_condo">
                                    <option value>Selecione...</option>
                                    <option v-for="(value) in condos" :key="value.id" :id="value.id" :value="value.id">
                                        {{ value.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div :class="validateCondo(property.type) ? 'col-sm-3' : 'col-sm-5'">
                            <div class="form-group">
                                <label for="inputAddress">Endereço</label>
                                <input type="text" class="form-control" id="inputAddress" maxlength="100"
                                    placeholder="Digite o Endereço" name="address" v-model="property.address"
                                    :disabled="validateCondo(property.type)">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="inputNumber">Número</label>
                                <input type="text" class="form-control" id="inputNumber" placeholder="No."
                                    @keypress="isNumber($event)" name="number" maxlength="5" v-model="property.number"
                                    :disabled="validateCondo(property.type)">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputDistrict">Bairro</label>
                                <input type="text" class="form-control" id="inputDistrict" placeholder="Digite o Bairro"
                                    maxlength="20" name="district" v-model="property.district"
                                    :disabled="validateCondo(property.type)">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCep">CEP</label>
                                <input type="text" class="form-control cep" id="cep" placeholder="Digite o CEP"
                                    v-mask="'#####-###'" masked="false" name="cep" v-model="property.cep"
                                    :disabled="validateCondo(property.type)">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCity">Cidade</label>
                                <select class="custom-select" id="inputCity" name="city" required
                                    v-model="property.id_city" :disabled="validateCondo(property.type)">
                                    <option value>Selecione...</option>
                                    <option v-for="(value, key) in cities" :key="key" :id="key" :value="value.id">
                                        {{ value.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div v-if="validateCondo(property.type)" class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputApartmentNumber">Nº Apto.</label>
                                <input type="text" class="form-control" id="apartment_number"
                                    placeholder="Digite o Número do Apartamento" @keypress="isNumber($event)"
                                    name="apartment_number" v-model="property.apartment_number">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputFloor">Andar</label>
                                <input type="text" class="form-control" id="floor"
                                    placeholder="Digite o Andar do Apartamento" @keypress="isNumber($event)"
                                    name="floor" v-model="property.floor">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputCourt">Quadra</label>
                                <input type="text" class="form-control" id="court"
                                    placeholder="Digite a Quadra do Apartamento" name="court" v-model="property.court">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputTower">Torre</label>
                                <input type="text" class="form-control" id="tower"
                                    placeholder="Digite a Torre do Apartamento" name="tower" v-model="property.tower">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputLot">Lote</label>
                                <input type="text" class="form-control" id="lot"
                                    placeholder="Digite o Lote do Apartamento" name="lot" v-model="property.lot">
                            </div>
                        </div>
                    </div>

                    <div class="row"></div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputArea">Área (m²)</label>
                                <input type="text" class="form-control" id="inputArea" placeholder="Área m²"
                                    @keypress="isNumber($event)" maxlength="5" name="area" v-model="property.area">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputBedrooms">Dormitórios</label>
                                <input type="text" class="form-control" id="inputBedrooms" maxlength="2"
                                    @keypress="isNumber($event)" placeholder="Dormitórios" name="bedrooms"
                                    v-model="property.bedrooms">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputSuites">Suítes</label>
                                <input type="text" class="form-control" id="inputSuites" placeholder="Suítes"
                                    @keypress="isNumber($event)" v-model="property.suites" maxlength="2" name="suites">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputBathrooms">Banheiros</label>
                                <input type="text" class="form-control" id="inputBathrooms" @keypress="isNumber($event)"
                                    v-model="property.bathrooms" placeholder="Banheiros" maxlength="2" name="bathrooms">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputParkingSpace">Vagas na Garagem</label>
                                <input type="text" class="form-control" id="inputParkingSpace" placeholder="Vagas"
                                    @keypress="isNumber($event)" v-model="property.parking_space" maxlength="2"
                                    name="parking_space">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div v-if="property.purpose == 1 || property.purpose == 3" class="col-sm-3">
                            <div class="form-group">
                                <label for="inputSaleValue">Valor Venda</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="property.sale_value" v-bind="config"
                                        id="inputSaleValue" placeholder="Venda" name="sale_value" @blur="treatValues()">
                                    </money3>
                                </div>

                            </div>
                        </div>
                        <div v-if="property.purpose == 2 || property.purpose == 3 || property.purpose == 4"
                            class="col-sm-3">
                            <div class="form-group">
                                <label for="inputRentalValue">Valor Locação</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="property.rental_value" v-bind="config"
                                        id="inputRentalValue" placeholder="Locacao" name="rental_value"
                                        @blur="treatValues()"></money3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputIptuValue">Valor IPTU</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="property.iptu_value" v-bind="config"
                                        id="inputIptuValue" placeholder="Iptu" name="iptu_value" @blur="treatValues()">
                                    </money3>
                                </div>
                            </div>
                        </div>
                        <div v-if="validateCondo(property.type)" class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCondoValue">Valor Condomínio</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="property.condo_value" v-bind="config"
                                        id="inputCondoValue" placeholder="Valor do Condomínio" name="condo_value"
                                        @blur="treatValues()">
                                    </money3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputSaleValue">Valor Percentual Taxa Adm.</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-percentage"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="property.administrative_tax_percentual"
                                        v-bind="config" id="inputAdministrativeTaxPercentual" max="100"
                                        name="administrative_tax_percentual" @blur="treatValues()"></money3>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputRentalValue">Comissão Imobiliária R$</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="property.administrative_tax_value"
                                        v-bind="config" id="inputAdministrativeTaxValue" name="administrative_tax_value"
                                        readonly></money3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputChronicProblem">Problemas Crônicos</label>
                                <div class="input-group">
                                    <input type="text" class="form-control numero" id="inputChronicProblem"
                                        placeholder="Descreva os problemas crônicos do imóvel"
                                        v-model="property.chronic_problem" maxlength="255" name="chronic_problem">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div><br>

                    <div v-if="!property.id_transaction" class="col-sm-12">
                        <input type="file" @change="handleFileUpload" multiple />

                        <div class="row" style="text-align: center; margin-top: 2em;">
                            <div v-for="(image, index) in images" :key="index" class="col-sm-2">
                                <img :src="image" alt="Imagem" style="max-width: 100px; max-height: 100px;" />
                            </div>
                        </div>
                    </div>
                    <div v-if="!property.id_transaction" class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div v-if="!property.id_transaction">
                        <button v-if="property.id" type="submit" class="btn btn-primary"
                            @click="updateProperty()">Atualizar</button>
                        <button v-else type="submit" class="btn btn-primary" @click="saveProperty()">Salvar</button>
                    </div>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>
            </div>
        </div>
        <div v-if="property.pictures && property.pictures.length > 0" class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Imagens do Imóvel</h3>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row" style="text-align: center;">
                            <div v-for="image in property.pictures" :key="image.id" class="col-4 col-lg-2"
                                style="margin-top: 1em;">
                                <img :src="'/' + image.folder + '/' + image.description" width="100" height="100"
                                    style="margin-bottom: 1em;">
                                <br>
                                <div v-if="!property.id_transaction">
                                    <div style="color:#f89d52">
                                        <b>Principal: </b>
                                        <input type="radio" :id="image.id" :value="image.id" v-model="main"
                                            style="margin-left: 0.1em;" :checked="image.main"
                                            @click="treatExcludes(image.id)"> <br>
                                    </div>
                                    <div style="color: #c82333;" v-if="!(main == image.id)">
                                        <b>Excluir:</b>
                                        <input type="checkbox" :id="image.id" :value="image.id" v-model="exclude"
                                            style="margin-left: 1em;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="property.renter" class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Imóvel {{ status_properties[property.status] }} para {{ property.renter.people.name }}</h3>
                </div>
                <div class="card-body">
                    <div class="scrollable text-left">
                        <table class="table table-head-fixed text-nowrap text-left">
                            <thead>
                                <tr>
                                    <th class="md='auto'">ID</th>
                                    <th class="md='auto'">Nome Completo do locador/comprador</th>
                                    <th class="md='auto'">Contato</th>
                                    <th class="md='auto'">E-mail</th>
                                    <th class="md='auto'">Ver Proprietário</th>
                                    <th class="md='auto'">Ver Transação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ property.renter.id }}</td>
                                    <td>
                                        {{ property.renter.people.name + ' ' +  property.renter.people.surname }}
                                    </td>
                                    <td>{{ phoneMask(property.renter.people.cellphone)}}</td>
                                    <td>{{ property.renter.people.email }}</td>
                                    <td>
                                        <router-link :to="'/renter/' + property.id_renter + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary"
                                                style="margin-top: -0.5em;">
                                                <i class="fas fa-solid fa-eye"></i>
                                            </button>
                                        </router-link>
                                    </td>
                                    <td class="col-sm-1">
                                        <router-link :to="'/transaction/' + property.id_transaction + '/edit'"
                                            class="small-box-footer">
                                            <button type="button" class="btn btn-outline-primary"
                                                style="margin-top: -0.5em;">
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
    </div>
</template>

<script>
import { status_properties, purpose, options, properties_type, isNumber,phoneMask,onError } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {

    data: function () {
        return {
            data: {},
            property: {
                reference: '',
                description: '',
                address: '',
                number: '',
                district: '',
                display_address: '',
                status: 1,
                purpose: '',
                type: '',
                cep: '',
                area: '',
                bedrooms: '',
                suites: '',
                bathrooms: '',
                parking_space: '',
                emphasis: '',
                sale_value: '',
                rental_value: '',
                iptu_value: '',
                condo_value: '',
                chronic_problem: '',
                apartment_number: '',
                court: '',
                tower: '',
                floor: '',
                lot: '',
                id_city: '',
                id_locator: '',
                id_condo: '',
                administrative_tax_percentual: '',
                administrative_tax_value: '',

            },
            config: {
                decimal: '.',
                thousands: '',
                // prefix: 'R$ ',
                precision: 2,
                masked: true
            },
            main: '',
            cities: {},
            locators: {},
            images: [],
            exclude: [],
            condos: {},
            setting: {},
            disable_address: false,
            properties_type: properties_type,
            status_properties: status_properties,
            purpose: purpose,
            options: options,
            isNumber: isNumber,
            phoneMask:phoneMask,
            onError:onError,
        }
    },

    methods: {
        getProperty() {
            axios.get('/properties/' + this.$route.params.id)
                .then(response => {

                    this.property = response.data.property;
                    if (this.property.pictures && this.property.pictures.length > 0) {
                        this.main = this.property.pictures.find(image => image.main === 1)?.id;
                    }
                    if (this.property.id_condo) {
                        this.disable_address = true;
                    }
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveProperty() {
            this.handlesSpecialCharacters();
            if (this.images.length > 0) {
                this.property.images = this.images;
            }

            this.property.main = this.main ?? '';
            this.property.exclude = this.exclude ?? [];
            this.property.main = this.main ?? '';
            axios.post('/properties', this.property)
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
                        timer: 2500
                    });

                });
        },
        updateProperty() {
            this.handlesSpecialCharacters();
            if (this.images.length > 0) {
                this.property.images = this.images;
            }
            this.property.main = this.main ?? '';
            this.property.exclude = this.exclude ?? [];
            this.property.main = this.main ?? '';
            axios.put('/properties/' + this.$route.params.id, this.property)
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
        handleFileChange(event) {
            this.images = [];
            const fileList = event.target.files;
            if (fileList.length > 0) {
                for (let i = 0; i < fileList.length; i++) {
                    const file = fileList[i];
                    this.convertToBase64(file);
                }
            }
        },

        handleFileUpload(event) {
            const files = event.target.files;
            const maxSize = 1024;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        let width = img.width;
                        let height = img.height;
                        if (width > height) {
                            if (width > maxSize) {
                                height *= maxSize / width;
                                width = maxSize;
                            }
                        } else {
                            if (height > maxSize) {
                                width *= maxSize / height;
                                height = maxSize;
                            }
                        }
                        canvas.width = width;
                        canvas.height = height;
                        ctx.drawImage(img, 0, 0, width, height);
                        const resizedDataUrl = canvas.toDataURL('image/jpeg');
                        this.images.push(resizedDataUrl);
                    };
                };
                reader.readAsDataURL(file);
            }
        },

        convertToBase64(file) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                this.images.push(reader.result);
            };
        },
        back() {
            this.$router.go(-1);
        },
        getCities() {
            axios.get('/cities', {})
                .then(response => {
                    this.cities = response.data.cities;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        getLocators() {
            axios.get('/locators', {})
                .then(response => {
                    this.locators = response.data.locators.data;

                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        handlesSpecialCharacters() {
            this.property.cep = this.property.cep != null ? this.property.cep.replace(/[.\-\s()/]/g, '') : '';
        },
        treatExcludes(main) {
            if (this.exclude.includes(main)) {
                const index = this.exclude.indexOf(main);
                this.exclude.splice(index, 1);
            }
        },
        getCondos() {
            axios.get('/condos')
                .then(response => {
                    this.condos = response.data.condos.data;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        treatCondo(id_condo) {
            if (id_condo != '') {
                this.select_condo = this.condos.find(condo => condo.id == id_condo);
                this.property.id_city = this.select_condo.city.id;
                this.property.cep = this.select_condo.cep;
                this.property.number = this.select_condo.number;
                this.property.address = this.select_condo.address;
                this.property.district = this.select_condo.district;
                this.disable_address = true;
            } else {
                this.property.id_city = '';
                this.property.cep = '';
                this.property.address = '';
                this.property.number = '';
                this.disable_address = false;
                this.property.district = '';
            }
        },
        treatPropertyType(type) {
            if (this.validateCondo(type)) {
                this.disable_address = true;
            } else {
                this.property.id_condo = '';
                this.treatCondo('');
            }
        },
        treatValues() {
            let property_value = 0;
            const iptu_value = this.property.iptu_value ? parseFloat(this.property.iptu_value) : 0;
            const condo_value = this.property.condo_value ? parseFloat(this.property.condo_value) : 0;

            if (this.property.purpose == 1) { // venda
                property_value = this.property.sale_value ? parseFloat(this.property.sale_value) : 0;
            } else if (this.property.purpose == 2) { //aluguel
                property_value = this.property.rental_value ? parseFloat(this.property.rental_value) : 0;
            }
            this.property.administrative_tax_value = (property_value + iptu_value + condo_value) * (this.property.administrative_tax_percentual / 100);
        },
        validateCondo(value) {
            if (value) {
                return ([1, 5, 10, 12, 18, 21].includes(parseInt(value)))
            }
        },
        getSettings() {
            axios.get('/settings/1')
                .then(response => {
                    this.setting = response.data.setting;
                    if (this.property.administrative_tax_percentual == '0.00' || !this.property.administrative_tax_percentual) {
                        this.property.administrative_tax_percentual = this.setting.administrative_tax;
                    }
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },

    },
    created() {
        this.getCities();
        this.getLocators();
        this.getCondos();
        if (this.$route.params.id) {
            this.getProperty();
        }
        this.getSettings();
    },
};
</script>
