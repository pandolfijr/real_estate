<template>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Configurações</h2>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ setting.id ? 'Editar Configuração' : 'Cadastrar Configuração' }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputFantasyName">Nome Fantasia</label>
                                <input type="text" class="form-control" id="inputFantasyName"
                                    placeholder="Descreva o Nome Fantasia" name="fantasy_name" maxlength="30"
                                    v-model="setting.fantasy_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputCompanyName">Nome da Empresa</label>
                                <input type="text" class="form-control" id="inputCompanyName"
                                    placeholder="Descreva o Nome da Empresa" name="company_name" maxlength="50"
                                    v-model="setting.company_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="inputOwnerName">Nome do Proprietário</label>
                                <input type="text" class="form-control" id="inputOwnerName"
                                    placeholder="Descreva o Nome do Proprietário" name="owner_name"
                                    v-model="setting.owner_name" maxlength="100">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="InputAddress">Endereço</label>
                                <input type="text" class="form-control" id="InputAddress" maxlength="100"
                                    placeholder="Digite o Endereço" name="address" v-model="setting.address">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="inputNumber">Número</label>
                                <input type="text" class="form-control numero" id="inputNumber" placeholder="No."
                                    name="number" maxlength="5" v-model="setting.number">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputDistrict">Bairro</label>
                                <input type="text" class="form-control" id="inputDistrict" placeholder="Digite o Bairro"
                                    maxlength="30" name="district" v-model="setting.district">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputIdCity">Cidade</label>
                                <select class="custom-select" id="inputIdCity" name="id_city" required
                                    v-model="setting.id_city">
                                    <option value>Selecione a Cidade</option>
                                    <option v-for="(value, key) in cities" :key="key" :id="key" :value="value.id">
                                        {{ value.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputCep">CEP</label>
                                <input type="text" class="form-control" id="cep" placeholder="Digite o CEP"
                                    maxlength="9" v-model="setting.cep" name="cep">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="form-label" for="customFile">Logo Menu</label><br>
                            <input class="form-label" type="file" id="customFile" name="menu_logo" />
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label" for="customFile">Logo Atual</label><br>
                            Arquivo: {{ setting.menu_logo }}
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label" for="customFile">Logo Ícone</label><br>
                            <input class="form-label" type="file" id="customFile" name="icon_logo" />
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label" for="customFile">Logo Ícone Atual</label><br>
                            Arquivo: {{ setting.icon_logo }}
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputMap">Mapa</label>
                                <input type="text" class="form-control" id="inputMap"
                                    placeholder="Cole aqui o Iframe do Mapa" name="map" v-model="setting.map">
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
                                <label for="inputFirstEmail">E-mail 1</label>
                                <input type="text" class="form-control" id="inputFirstEmail"
                                    placeholder="Informe o E-mail 1" name="first_email" v-model="setting.first_email">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputSecondEmail">E-mail 2</label>
                                <input type="text" class="form-control" id="inputSecondEmail"
                                    placeholder="Informe o E-mail 2" name="second_email" v-model="setting.second_email">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputThirdEmail">E-mail 3</label>
                                <input type="text" class="form-control" id="inputThirdEmail"
                                    placeholder="Informe o E-mail 3" name="third_email" v-model="setting.third_email">
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
                                <label for="inputFirstTelephone">Telefone 1</label>
                                <input type="text" class="form-control" id="inputFirstTelephone"
                                    placeholder="Informe o Telefone 1" name="first_telephone"
                                    v-mask="['(##) ####-####', '(##) #####-####']" masked="false"
                                    v-model="setting.first_telephone">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputSecondTelephone">Telefone 2</label>
                                <input type="text" class="form-control" id="inputSecondTelephone"
                                    placeholder="Informe o Telefone 2" name="second_telephone"
                                    v-mask="['(##) ####-####', '(##) #####-####']" masked="false"
                                    v-model="setting.second_telephone">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputThirdTelephone">Telefone 3</label>
                                <input type="text" class="form-control" id="inputThirdTelephone"
                                    placeholder="Informe o Telefone 3" name="third_telephone"
                                    v-mask="['(##) ####-####', '(##) #####-####']" masked="false"
                                    v-model="setting.third_telephone">

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
                                <label for="inputFirstWhatsapp">WhatsApp 1</label>
                                <input type="text" class="form-control" id="inputFirstWhatsapp"
                                    placeholder="Informe o WhatsApp 1" name="first_whatsapp"
                                    v-mask="['(##) ####-####', '(##) #####-####']" masked="false"
                                    v-model="setting.first_whatsapp">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="InputSecondWhatsapp">WhatsApp 2</label>
                                <input type="text" class="form-control" id="InputSecondWhatsapp"
                                    placeholder="Informe o WhatsApp 2" name="second_whatsapp"
                                    v-mask="['(##) ####-####', '(##) #####-####']" masked="false"
                                    v-model="setting.second_whatsapp">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputThirdWhatsapp">WhatsApp 3</label>
                                <input type="text" class="form-control" id="inputThirdWhatsapp"
                                    placeholder="Informe o WhatsApp 3" name="third_whatsapp"
                                    v-mask="['(##) ####-####', '(##) #####-####']" masked="false"
                                    v-model="setting.third_whatsapp">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputFacebook">Facebook</label>
                                <input type="text" class="form-control" id="inputFacebook"
                                    placeholder="Informe o Facebook" name="facebook" v-model="setting.facebook">

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputInstagram">Instagram</label>
                                <input type="text" class="form-control" id="inputInstagram"
                                    placeholder="Informe o Instagram" name="instagram" v-model="setting.instagram">

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputLinkedin">Linkedin</label>
                                <input type="text" class="form-control" id="inputLinkedin"
                                    placeholder="Informe o Linkedin" name="linkedin" v-model="setting.linkedin">

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputTwitter">Twitter</label>
                                <input type="text" class="form-control" id="inputTwitter"
                                    placeholder="Informe o Twitter" name="twitter" v-model="setting.twitter">

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputSkype">Skype</label>
                                <input type="text" class="form-control" id="inputSkype" placeholder="Informe o Skype"
                                    name="skype" v-model="setting.skype">

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputYoutube">Youtube</label>
                                <input type="text" class="form-control" id="inputYoutube"
                                    placeholder="Informe o Youtube" name="youtube" v-model="setting.youtube">

                            </div>
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
                                <label for="inputOpeningTime">Horário de Abertura</label>
                                <input type="text" class="form-control" id="inputOpeningTime"
                                    placeholder="Hora de Abertura" name="opening_time" v-model="setting.opening_time">

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputClosingTime">Horário de Fechamento</label>
                                <input type="text" class="form-control" id="inputClosingTime"
                                    placeholder="Hora de Fechamento" name="closing_time" v-model="setting.closing_time">

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="InputPercentualAdministrativeTax">R$ Taxa Administ.</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-solid fa-percent"></i>
                                        </span>
                                    </div>
                                    <money3 class="form-control" v-model="setting.administrative_tax" v-bind="config"
                                        id="inputValueProperty" name="property_value"></money3>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button v-if="setting.id" type="submit" class="btn btn-primary"
                        @click="updateSetting()">Atualizar</button>
                    <button v-else type="submit" class="btn btn-primary" @click="saveSetting()">Salvar</button>
                    <button class="btn btn-danger" @click="back()">Voltar</button>
                </div>

            </div>
        </div>
    </div>
</template>


<script>
import { onError, isNumber } from '../../../utils';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {

    data: function () {
        return {
            data: {},
            setting: {
                id: '',
                fantasy_name: '',
                company_name: '',
                owner_name: '',
                menu_logo: '',
                icon_logo: '',
                map: '',
                address: '',
                number: '',
                district: '',
                cep: '',
                first_email: '',
                second_email: '',
                third_email: '',
                first_telephone: '',
                second_telephone: '',
                third_telephone: '',
                first_whatsapp: '',
                second_whatsapp: '',
                third_whatsapp: '',
                twitter: '',
                facebook: '',
                instagram: '',
                skype: '',
                linkedin: '',
                youtube: '',
                opening_time: '',
                closing_time: '',
                id_city: '',
            },
            cities: {},
            config: {
                decimal: '.',
                thousands: '',
                precision: 2,
                masked: true
            },
            onError: onError,
            isNumber: isNumber,
        }
    },
    computed: {

    },
    methods: {
        getSettings() {
            axios.get('/settings/' + this.$route.params.id)
                .then(response => {
                    this.setting = response.data.setting;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        saveSetting() {
            this.handlesSpecialCharacters();
            axios.post('/settings', this.setting)
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
        updateSetting() {
            this.handlesSpecialCharacters();
            axios.put('/settings/' + this.$route.params.id, this.setting)
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
        handlesSpecialCharacters() {
            this.setting.first_telephone = this.setting.first_telephone != null ? this.setting.first_telephone.replace(/[.\-\s()/]/g, '') : '';
            this.setting.second_telephone = this.setting.second_telephone != null ? this.setting.second_telephone.replace(/[.\-\s()/]/g, '') : '';
            this.setting.third_telephone = this.setting.third_telephone != null ? this.setting.third_telephone.replace(/[.\-\s()/]/g, '') : '';
            this.setting.first_whatsapp = this.setting.first_whatsapp != null ? this.setting.first_whatsapp.replace(/[.\-\s()/]/g, '') : '';
            this.setting.second_whatsapp = this.setting.second_whatsapp != null ? this.setting.second_whatsapp.replace(/[.\-\s()/]/g, '') : '';
            this.setting.third_whatsapp = this.setting.third_whatsapp != null ? this.setting.third_whatsapp.replace(/[.\-\s()/]/g, '') : '';
            this.setting.cep = this.setting.cep != null ? this.setting.cep.replace(/[.\-\s()/]/g, '') : '';
        },
        getCities() {
            axios.get('/cities')
                .then(response => {
                    this.cities = response.data.cities;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        back() {
            this.getCities();
            this.$router.go(-1);
        },

    },
    beforeMount() {
        this.getSettings();
        this.getCities();
    },
};
</script>
