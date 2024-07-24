<template>
    <main>
        <menu-site></menu-site>
        <search-site></search-site>
        <section id="about" class="about">
            <div class="container" data-aos="fade-up" style="margin-top: 5em;">
                <div class="section-header">
                    <h2>Sobre Nós</h2>
                </div>
                <div class="row g-4 g-lg-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-lg-5">
                        <div class="about-img">
                            <img :src="'site/assets/img/about.jpg'" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <h3 class="pt-0 pt-lg-5">A nossa imobiliária tem a meta de ocupar um espaço diferenciado no
                            mercado de imóveis em Ituverava e região.</h3>
                        <ul class="nav nav-pills mb-3">
                            <li><a class="nav-link active" data-bs-toggle="pill" href="#tab1">Qualidade</a></li>
                            <li><a class="nav-link" data-bs-toggle="pill" href="#tab2">Serviços</a></li>
                            <li><a class="nav-link" data-bs-toggle="pill" href="#tab3">Experiência</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1">

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>Qualidade e objetividade</h4>
                                </div>
                                <br>
                                <p>
                                    Com a extrema determinação, sem abalar a solidez, nós da imobiliária garantimos aos
                                    nossos clientes a realização dos melhores negócios, prezando sempre pela modernidade
                                    e excelência no segmento imobiliário</p>
                            </div>
                            <div class="tab-pane fade show" id="tab2">
                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>Serviços Oferecidos</h4>
                                </div>
                                <br>
                                <p>Quem busca venda, compra, aluguel ou mesmo avaliar um imóvel, encontra muito além
                                    disso negociando conosco. Orientação com segurança, propostas sólidas, atendimento
                                    diferenciado e impecável que nos credenciam como uma das empresas
                                    mais confiáveis e tradicionais do ramo.</p>
                            </div>
                            <div class="tab-pane fade show" id="tab3">
                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>Experiência e Conhecimento</h4>
                                </div>
                                <br>
                                <p>Contando com o amplo conhecimento de nossos colaboradores na área de financiamento
                                    imobiliário e assessoria, procuramos sempre estar à frente com respeito aos nossos
                                    clientes.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section id="onfocus" class="onfocus">
            <div class="container-fluid p-0" data-aos="fade-up">
                <div class="row g-0">
                    <div class="col-lg-6 video-play position-relative">
                    </div>
                    <div class="col-lg-6">
                        <div class="content d-flex flex-column justify-content-center h-100">
                            <h3>Financiamentos</h3>
                            <p class="fst-italic">
                                Faça uma simulação de financiamento!
                            </p>
                            <ul>
                                <li>
                                    <i class="bi bi-check-circle"></i>
                                    <a href="http://www8.caixa.gov.br/siopiinternet/simulaOperacaoInternet.do?method=inicializarCasoUso&amp;isVoltar=true"
                                        target="_blank">CAIXA
                                    </a>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle"></i>
                                    <a href="https://www.itau.com.br/creditos-financiamentos/imoveis/"
                                        target="_blank">ITAÚ
                                    </a>
                                </li>
                                <li><i class="bi bi-check-circle"></i><a
                                        href="http://www.bradesco.com.br/html/classic/produtos-servicos/emprestimo-e-financiamento/index.shtm?par=1"
                                        target="_blank">BRADESCO</a>
                                </li>
                                <li><i class="bi bi-check-circle"></i><a
                                        href="http://www.bb.com.br/portalbb/page3,116,2057,1,1,1,1.bb?codigoMenu=172&codigoNoticia=27286&localizacaoDet=11"
                                        target="_blank">BANCO DO BRASIL</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="cta" class="cta">
            <div class="container" data-aos="zoom-out">
                <div class="row g-5">
                    <div
                        class="col-lg-8 col-md-6 content d-flex flex-column justify-content-center order-last order-md-first">
                        <h3>Entre em contato com a nossa <em>Imobiliária</em>.</h3>
                        <p>Teremos sempre uma pessoa altamente capacitada para te atender e ajudar.</p>
                        <a class="cta-btn align-self-start" href="/#contato">Quero falar!</a>
                    </div>
                    <div class="col-lg-4 col-md-6 order-first order-md-last d-flex align-items-center">
                        <div class="img">
                            <img :src="'site/assets/img/cta.jpg'" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import Menu from './Menu.vue';
import Search from './Search.vue';
import Footer from './Footer.vue';

export default {
    data: function () {
        return {

        };
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

    },
};
</script>
