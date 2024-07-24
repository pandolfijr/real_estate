<template>
    <menu-site></menu-site>
    <search-site @getProperties="getProperties"></search-site>
    <main id="main">
        <section id="portfolio" class="portfolio" data-aos="fade-up" style="margin-top: 5em">

            <div class="container">
                <div class="section-header">
                    <h2>{{ property.description }}</h2>

                    <hr>
                </div>
            </div>

            <div class="container-fluid" data-aos="fade-up" data-aos-delay="200">
                <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry"
                    data-portfolio-sort="original-order">
                    <div class="row g-0 portfolio-container">
                        <div v-for="picture in property.pictures" class="align-self-center portfolio-item " :key="picture.id"
                            @click="openFullScreenImage(picture)" :class="property.pictures.length == 2 ? 'col-md-6': 'col-md-4'" >
                            <a data-gallery="portfolio-gallery" class="glightbox preview-link">
                                <img :src="'/' + picture.folder + '/' + picture.description" class="img-detalhe"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="showFullScreenImage" class="fullscreen-image" @click="closeFullScreenImage">
                <span class="close-btn">&times;</span>
                <img :src="'/' + selectedPicture.folder + '/' + selectedPicture.description" class="img-fullscreen"
                    alt="" />
            </div>
        </section>

        <section id="features" class="features" style="margin-top: -7em">
            <div class="container" data-aos="fade-up">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab-1">
                        <section id="blog" class="blog">
                            <div class="container aos-init aos-animate" data-aos="fade-up">
                                <div class="row g-5">
                                    <div class="col-lg-8">
                                        <article class="blog-details">
                                            <h3>Código do imóvel: {{ property.reference }}</h3>
                                            <hr>
                                            <p class="fst-italic">
                                                {{ property.description }}
                                            </p><br>
                                            <div v-if="property.display_address">
                                                <h3>Endereço</h3>
                                                <hr>
                                                <p class="fst-italic">
                                                    {{ property.address }}, nº. {{ property.number }} <br>
                                                    Bairro: {{ property.district }}
                                                </p>
                                            </div>
                                            <br>
                                            <h3>Características do imóvel</h3>
                                            <hr>
                                            <ul>
                                                <li v-if="property.bedrooms">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <b>Dormitórios: </b> {{ property.bedrooms ?? 0 }}
                                                </li>

                                                <li v-if="property.suites">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <b>Suítes: </b> {{ property.suites ?? 0 }}
                                                </li>

                                                <li v-if="property.parking_space">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <b>Vagas na Garagem: </b> {{ property.parking_space ?? 0 }}
                                                </li>

                                                <li v-if="property.parking_space">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <b>Área em M²: </b> {{ property.parking_space ?? 0 }}
                                                </li>
                                                <li v-if="property.bathrooms">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <b>Banheiros: </b> {{ property.bathrooms ?? 0 }}
                                                </li>
                                                <li v-if="property.sale_value != '0.00'">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <b>Valor de Venda: </b>R$ {{ property.sale_value }}
                                                </li>
                                                <li v-if="property.rental_value != '0.00'">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <b>Valor de Locação: </b>R$ {{ property.rental_value }}
                                                </li>
                                                <li v-if="property.iptu_value != '0.00'">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <b>Valor de IPTU: </b>R$ {{ property.iptu_value }}
                                                </li>
                                                <li v-if="property.condo_value != '0.00'">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <b>Valor de Condomínio: </b>R$ {{ property.condo_value }}
                                                </li>
                                                <br>
                                                <hr>
                                                <p class="fst-italic">
                                                    <a :href="'https://api.whatsapp.com/send?phone=5516992358101&text=Ol%C3%A1!%20Vi%20este%20im%C3%B3vel%20no%20site%20e%20me%20interessei%20por%20ele!%20C%C3%B3digo%3A%20' + property.reference"
                                                        target="_blank">
                                                        <b style="color: #000">Clique aqui para detalhes deste
                                                            imóvel via <span style="color: #4AC959">WhatsApp</span></b>
                                                    </a>
                                                </p>
                                            </ul>
                                        </article>

                                    </div>
                                    <div class="col-lg-4  order-1 order-lg-2" data-aos="fade-up" data-aos-delay="200">
                                        <div class="sidebar">
                                            <div class="col-lg-4">
                                            </div>
                                            <div v-if="Object.values(others_properties).length > 0">
                                                <div class="sidebar-item search-form">
                                                    <h3 class="sidebar-title">Outros imóveis...</h3>
                                                </div>
                                                <div class="sidebar-item recent-posts">
                                                    <div class="mt-3">

                                                        <div class="container-fluid" data-aos="fade-up"
                                                            data-aos-delay="200" style="margin-bottom: 3em;">
                                                            <div v-for="property in others_properties"
                                                                :key="property.id" class="post-item">
                                                                <img :src="'/' + property.main_picture.folder + '/' + property.main_picture.description"
                                                                    class="flex-shrink-0" alt="" height="70em" />
                                                                <div>
                                                                    <h4>
                                                                        <a :href="'/property_details/' + property.id"
                                                                            class="">
                                                                            <p class="normal-description">{{
                                                                                property.description.length > 43 ?
                                                                                    property.description.substring(0, 44) +
                                                                                    ' ...' : property.description }}</p>
                                                                            <p class="responsive-description">{{
                                                                                property.description.length > 11 ?
                                                                                    property.description.substring(0, 18) +
                                                                                    ' ...' : property.description }}</p>
                                                                        </a>
                                                                        <time style="margin-top: 1em">{{
                                                                            properties_type[property.type].description
                                                                            }}</time>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div class="sidebar-item search-form">
                                                    <h3 class="sidebar-title">Nenhum imóvel associado...</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>

import axios from 'axios';
import Menu from './Menu.vue';
import Search from './Search.vue';
import Footer from './Footer.vue';
import { transaction_type, properties_type, purpose } from '../../utils'

export default {

    data: function () {
        return {
            cities: {},
            search: {},
            property: {},
            others_properties: {},
            transaction_type: transaction_type,
            properties_type: properties_type,
            purpose: purpose,
            showFullScreenImage: false,
            selectedPicture: null
        };
    },
    components: {
        'search-site': Search,
        'menu-site': Menu,
        'footer-site': Footer
    },
    methods: {
        getProperty() {
            axios.get('/properties-detail-site/' + this.$route.params.id)
                .then(response => {
                    this.property = response.data.property;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        },
        redirectToDestination(search) {
            this.$router.push({
                name: 'AllPropertiesSearch',
                params: {
                    ...search,
                    status: 1
                }
            });
        },
        getOthersProperties() {
            this.search.exception = this.$route.params.id;
            this.search.limit_properties = 5;
            this.search.status = 1;
            axios.get('/properties-site', { params: this.search })
                .then(response => {
                    this.others_properties = response.data.properties.data;
                    this.others_properties.forEach(property => {
                        const mainPicture = property.pictures.find(picture => picture.main === 1);
                        property.main_picture = mainPicture;
                    });
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
        openFullScreenImage(picture) {
            this.selectedPicture = picture;
            this.showFullScreenImage = true;
        },
        closeFullScreenImage() {
            this.showFullScreenImage = false;
        }
    },
    beforeMount() {
        this.getProperty();
        this.getOthersProperties();
    },
};
</script>
<style></style>
