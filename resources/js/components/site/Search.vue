<template>
    <main id="main">
        <header id="header" class="header-search fixed-top" data-scrollto-offset="0" style="">
            <div class="container-fluid aos-init aos-animate" data-aos="fade-up">
                <div class="row">
                    <div id="faqlist" class="table-search">
                        <div class="accordion-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                            <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist"
                                style="">
                                <div class="accordion-body">
                                    <div class="row" style="margin: 1em;">
                                        <div class="col-md-4 col-search">
                                            <input type="text" class="form-control" name="description"
                                                id="inputDescription" placeholder="Código / Descrição / Rua / Bairro"
                                                aria-label="Código ou Descrição" v-model="input.search" value="">
                                        </div>


                                        <div class="col-md-2 col-search">
                                            <select name="id_city" id="inputCity" class="form-select" value=""
                                                v-model="input.id_city">
                                                <option value="">Cidade... </option>
                                                <option v-for="(value, key) in cities" :key="key" :id="key"
                                                    :value="value.id">
                                                    {{ value.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-search">
                                            <select name="type" id="inputType" class="form-select" v-model="input.type"
                                                value="">>
                                                <option value="">Tipo de imóvel...</option>
                                                <option v-for="(value, key) in properties_type" :key="key" :id="key"
                                                    :value="value.id">
                                                    {{ value.description }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-search">
                                            <select name="bedrooms" id="inputBedrooms" class="form-select"
                                                v-model="input.bedrooms" value="">
                                                <option value="" selected>Quartos</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 col-search">
                                            <select name="bathrooms" id="inputBathrooms" class="form-select"
                                                v-model="input.bathrooms">
                                                <option value="" selected>Banheiros</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="faqlist" class="table-search">
                        <div class="accordion-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                            <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist"
                                style="">
                                <div class="accordion-body">
                                    <div class="row" style="margin: -1em 1em 1em 1em">
                                        <div class="col-md-2 col-search">
                                            <select name="purpose" id="inputPurpose" class="form-select" value=""
                                                v-model="input.purpose">
                                                <option value="">Transação...</option>
                                                <option v-for="(value, key) in purpose" :key="key" :value="key">
                                                    {{ value }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-search">
                                            <input v-if="!search_min_value" class="form-control" placeholder="Valor Mínimo" @click="disabledMinValue()"/>
                                            <money3 v-else class="form-control" v-model="input.min_value" v-bind="config"
                                                id="inputMinValue" placeholder="Valor Mín" name="min_value"></money3>

                                        </div>
                                        <div class="col-md-2 col-search ">
                                            <input v-if="!search_max_value" class="form-control" placeholder="Valor Máximo" @click="disabledMaxValue()"/>
                                            <money3 v-else class="form-control" v-model="input.max_value" v-bind="config"
                                                id="inputMaxValue" placeholder="Valor Max" name="max_value"></money3>
                                        </div>

                                        <div class="col-md-4 col-search">
                                            <button @click="filter()" class="btn btn-primary"
                                                style="margin-right: 1em">Pesquisar</button>
                                            <button @click="clearFilter()" class="btn btn-primary">Limpar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </main>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';
import { purpose, properties_type } from '../../utils'
// import { validate } from 'vee-validate';
export default {
    watch: {

    },
    data() {
        return {
            input: {
                search: '',
                min_value: '',
                max_value: '',
                purpose: '',
                type: '',
                id_city: '',
                bedrooms: '',
                bathrooms: '',
                order: '',
            },
            config: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false,
            },
            search_min_value: false,
            search_max_value: false,
            cities: {},
            purpose: purpose,
            properties_type: properties_type,
        }
    },
    props: {
        route: '',
    },
    methods: {
        filter: function () {
            this.$emit("getProperties", this.input);
        },
        getCities() {
            axios.get('/cities-site')
                .then(response => {
                    this.cities = response.data.cities;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        clearFilter() {
            this.input.search = '';
            this.input.min_value = '';
            this.input.max_value = '';
            this.input.purpose = '';
            this.input.type = '';
            this.input.id_city = '';
            this.input.bedrooms = '';
            this.input.bathrooms = '';
            this.input.order = '';
            this.search_min_value = false;
            this.search_max_value = false;
        },
        disabledMinValue() {
            this.search_min_value = true;
        },
        disabledMaxValue() {
            this.search_max_value = true;
        }
    },
    created() {
        this.getCities();
    },

};
</script>
