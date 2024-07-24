<template>
    <menu-site>
    </menu-site>
    <search-site @getProperties="getProperties"></search-site>
    <main id="main">

        <section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center" style="margin-top: -2em;">
            <section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center">
                <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out" style="margin-top: -5em;">
                    <h2 style="text-align: center;">Bem vindo à nossa <span>imobiliária</span></h2>
                    <p style="text-align: center;">Aqui você vai encontrar o imóvel que você sempre sonhou!</p>
                    <div class="d-flex">
                        <router-link :to="'/all_properties'" class="btn-get-started scrollto">
                            Ver imóveis
                        </router-link>
                        <!-- <a href="/imoveis#imoveis" class="btn-get-started scrollto">Ver imóveis</a> -->
                    </div>
                </div>
            </section>
        </section>


        <!-- ======= Serviços Oferecidos ======= -->
        <section id="featured-services" class="featured-services">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-xl-3 col-md-6" data-aos="zoom-out">
                        <div class="service-item position-relative align-items-center info-item text-lg-center"
                            style="text-align: center;">
                            <div class="icon"><i class="bi bi-activity icon"></i></div>
                            <h4>ALUGUEL</h4>
                            <p>Os mais variados imóveis para alugar</p>
                        </div>
                    </div>
                    <!-- Fim de item de Serviço -->
                    <div class="col-xl-3 col-md-6" data-aos="zoom-out" data-aos-delay="200">
                        <div class="service-item position-relative" style="text-align: center;">
                            <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                            <h4>VENDA</h4>
                            <p>Realize o sonho da sua casa própria</p>
                        </div>
                    </div>
                    <!-- Fim de item de Serviço -->
                    <div class="col-xl-3 col-md-6" data-aos="zoom-out" data-aos-delay="400">
                        <div class="service-item position-relative" style="text-align: center;">
                            <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                            <h4>FINANCIAMENTO</h4>
                            <p>Escolha seu imóvel, nós financiamos</p>
                        </div>
                    </div>
                    <!-- Fim de item de Serviço -->
                    <div class="col-xl-3 col-md-6" data-aos="zoom-out" data-aos-delay="600">
                        <div class="service-item position-relative" style="text-align: center;">
                            <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                            <h4>CONSULTORIA</h4>
                            <p>Encontraremos o melhor imóvel para você</p>
                        </div>
                    </div>
                    <!-- Fim de item de Serviço -->
                </div>
            </div>
        </section>
        <!-- Fim dos serviços oferecidos -->


        <section v-if="Object.keys(properties_rent).length > 0 > 0" id="services" class="services">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>Imóveis para Locação</h2>
                </div>
                <div class="row gy-5">
                    <div v-for="property in properties_rent" :key="property.id" class="col-xl-4 col-md-6"
                        data-aos="zoom-in" data-aos-delay="500">
                        <router-link :to="'/property_details/' + property.id" class="small-box-footer">
                            <div class="service-item">
                                <div class="row text-center">
                                    <div class="col">
                                        <div class="img">
                                            <img :src="property.main_picture.folder + '/' + property.main_picture.description"
                                                class="img-detalhe" />
                                        </div>
                                    </div>
                                </div>
                                <div class="details position-relative">
                                    <router-link :to="'/properties_details/' + property.id" class="small-box-footer">
                                        <h3 style="margin-top: -1.2em; margin-bottom: -0.075em;">
                                            <b>
                                                {{ properties_type[property.type -1].description }}
                                            </b>
                                        </h3>
                                        <p class="normal-description">{{ property.description.length > 15 ?
                                            property.description.substring(0, 16) + ' ...': property.description }}</p>
                                        <p class="responsive-description">{{ property.description.length > 11 ?
                                            property.description.substring(0, 12) + ' ...': property.description }}</p>

                                        <h5 style="color:black;">
                                            <b>{{ property.rental_value != '0.00' ? 'R$ ' + property.rental_value :
                                                'Consulte-nos!' }}
                                            </b>
                                        </h5>
                                        <p style="color: #f97233;">{{ purpose[property.purpose] }}</p>
                                    </router-link>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>

        <!-- End About Section -->


        <section v-if="Object.keys(properties_sale).length > 0" id="services" class="services">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>Imóveis para Venda</h2>
                </div>
                <div class="row gy-5">
                    <div v-for="property in properties_sale" :key="property.id" class="col-xl-4 col-md-6"
                        data-aos="zoom-in" data-aos-delay="500">
                        <!-- <a href="" class="stretched-link"> -->
                        <router-link :to="'/property_details/' + property.id" class="small-box-footer">
                            <div class="service-item">
                                <div class="row text-center">
                                    <div class="col">
                                        <div class="img">
                                            <img :src="property.main_picture.folder + '/' + property.main_picture.description"
                                                class="img-detalhe" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col">
                                        <div class="details position-relative">
                                            <!-- <a href="" class="stretched-link"> -->
                                            <h3 style="margin-top: -1.2em; margin-bottom: -0.075em;">
                                                <b>
                                                    {{ properties_type[property.type].description }}
                                                </b>
                                            </h3>
                                            <!-- </a> -->
                                            <p>{{ property.description }}</p>

                                            <h5 style="color: black;">
                                                <b>{{ property.sale_value != '0.00' ? 'R$ ' + property.sale_value :
                                                    'Consulte-nos!' }}
                                                </b>
                                            </h5>
                                            <p style="color: #f97233;">{{ purpose[property.purpose] }}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                        <!-- </a> -->
                    </div>
                    <!-- Fim de item de Destaque -->
                </div>
            </div>
        </section>

        <section v-if="Object.keys(properties_sale).length == 0 && Object.keys(properties_rent).length == 0"
            id="hero-static" class="hero-static d-flex align-items-center"
            style="margin-top: -2em; margin-bottom: 2em;">
            <hr>
            <div class="container d-flex flex-column justify-content-center align-items-center text-center position-relative aos-init aos-animate"
                data-aos="zoom-out">
                <h2>Até o momento, <span>nenhum</span> imóvel foi cadastrado!</h2>
                <p>Enquanto isso, navegue pelo nosso site e conheça nossa imobiliária!</p>
            </div>
        </section>

        <!-- End Clients Section -->

        <!-- ======= Call To Action Section ======= -->
        <section id="contato" class="contact">
            <div class="container">
                <div class="section-header">
                    <h2>Contato</h2>
                    <p>Venha nos fazer uma visita!</p>
                </div>
            </div>
            <!-- Início do mapa -->

            <div class="map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3741.1546025019297!2d-47.79220858507884!3d-20.335230886378202!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ba5d33a9ea8f7f%3A0x772691ed05c18636!2sRenata%20Flor%C3%AAncio%20Corretora%20de%20Im%C3%B3veis!5e0!3m2!1spt-BR!2sbr!4v1607993718924!5m2!1spt-BR!2sbr"
                    frameborder="0" allowfullscreen></iframe>
            </div>

            <!-- Fim do mapa -->
            <div class="container info text-center">
                <div class="row">
                    <h3>Horário de Funcionamento</h3>
                    <p><b>Segunda à Sexta</b>: das 09h às 18h</p>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item text-center" style="padding: 1em;">
                            <i class="bi bi-geo-alt flex-shrink-0" style="margin-left: 1em;"></i>
                            <h4>Endereço: </h4>
                            <p>Avenida Dr.Soares de Oliveira, Nº 995 | Centro | Ituverava/SP</p>


                        </div>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item text-center" style="padding: 1em;">
                            <i class="bi bi-envelope flex-shrink-0" style="margin-left: 1em;"></i>
                            <div>
                                <h4>Email:</h4>
                                <p>imobilrenata@hotmail.com</p>

                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item text-center" style="padding: 1em;">
                            <i class="bi bi-phone flex-shrink-0" style="margin-left: 1em;"></i>
                            <div>
                                <h4>Telefone</h4>
                                <p>(16) 3729-6822 | (16) 3839-0000
                                </p>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item text-center" style="padding: 1em;">
                            <i class="bi bi-phone flex-shrink-0" style="margin-left: 1em;"></i>
                            <div>
                                <h4>WhatsApp</h4>
                                <p><a href="https://api.whatsapp.com/send?phone=5516992358101&text=Ol%C3%A1!%20Vim%20pelo%20site%20da%20imobili%C3%A1ria.%20Pode%20me%20ajudar%3F"
                                        target="_blank">(16) 99235-8101</a>
                                </p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <footer-site></footer-site>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

import Menu from './Menu.vue';
import Search from './Search.vue';
import Footer from './Footer.vue';

import { transaction_type, properties_type, purpose } from '../../utils'

export default {
    data: function () {
        return {
            cities: {},
            properties: {},
            properties_sale: {},
            properties_rent: {},
            transaction_type: transaction_type,
            properties_type: properties_type,
            purpose: purpose,

        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.totalItems / this.itemsPerPage);
        }
    },
    components: {
        'search-site': Search,
        'menu-site': Menu,
        'footer-site': Footer
    },
    methods: {
        getProperties(search) {
            if (search) {
                this.currentPage = 1;
            }

            axios.get('/properties-site', {
                params: {
                    ...search,
                    status: 1
                }
            })
                .then(response => {
                    this.properties = response.data.properties.data;
                    this.properties.forEach(property => {
                        const mainPicture = property.pictures.find(picture => picture.main === 1);
                        property.main_picture = mainPicture;
                    });
                    this.properties_sale = this.properties.filter(property => property.purpose === 1);
                    this.properties_rent = this.properties.filter(property => property.purpose === 2);

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

    },
    beforeMount() {
        this.getProperties();
    },
};
</script>

