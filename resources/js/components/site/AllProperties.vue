<template>
    <menu-site></menu-site>
    <search-site @getProperties="getProperties"></search-site>
    <main id="main">
        <section v-if="properties.length > 0" id="imoveis" class="services" style="margin-top: 5em;">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>Imóveis</h2>
                </div>
                <div class="row text-center">
                    <div v-for="property in properties" :key="property.id" class="col-xl-4 col-md-6" data-aos="zoom-in"
                        data-aos-delay="500">
                        <a :href="'property_details/' + property.id" class="stretched-link">
                            <div class="service-item">
                                <div class="img">
                                    <img :src="property.main_picture.folder + '/' + property.main_picture.description"
                                        class="img-detalhe" alt="" />
                                </div>
                                <div class="details position-relative">
                                    <a :href="'property_details/' + property.id" class="stretched-link">
                                        <h3 style="margin-top: -1.2em; margin-bottom: -0.075em;">
                                            <b>
                                                {{ properties_type[property.type].description }}
                                            </b>
                                        </h3>
                                    </a>
                                    <p class="normal-description">{{ property.description.length > 15 ?
                                        property.description.substring(0, 16) + ' ...' : property.description }}</p>
                                    <p class="responsive-description">{{ property.description.length > 11 ?
                                        property.description.substring(0, 12) + ' ...' : property.description }}</p>

                                    <h5 style="color:black;">
                                        <b>{{ property.rental_value != '0.00' ? 'R$ ' + property.rental_value :
                                            'Consulte-nos!' }}
                                        </b>
                                    </h5>
                                    <p style="color: #f97233;">{{ purpose[property.purpose] }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- <div v-if="totalItems > currentPage" style="margin-top: 5em;">
                    <pagination v-if="this.properties.length > 1" :current-page="currentPage" :total-pages="totalPages"
                        @update-page="updatePage" />
                </div> -->
            </div>
        </section>
        <section v-else id="hero-static" class="hero-static d-flex align-items-center"
            style="margin-top: 6em; margin-bottom: 2em;">
            <div class="container d-flex flex-column justify-content-center align-items-center text-center position-relative aos-init aos-animate"
                data-aos="zoom-out">
                <h2>Até o momento, <span>nenhum</span> imóvel foi cadastrado!</h2>
                <p>Enquanto isso, navegue pelo nosso site e conheça nossa imobiliária!</p>
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
            search: {},
            properties: {},
            transaction_type: transaction_type,
            properties_type: properties_type,
            purpose: purpose,
            currentPage: 1,
            itemsPerPage: 30,
            totalItems: 0,
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
        updatePage(page) {
            this.currentPage = page;
            this.getProperties();
        },
    },
    beforeMount() {
        this.getProperties();
    },
};
</script>
