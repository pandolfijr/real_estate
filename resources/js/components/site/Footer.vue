<template>
    <div>
        <footer id="footer" class="footer">
            <div class="footer-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6" style="text-align: center;">
                            <div class="footer-info">
                                <h3>A IMOBILIÁRIA</h3>
                                <p><b>Avenida Dr.Soares de Oliveira</b>, número <b>995</b> <br>
                                    Bairro: <b>Centro</b><br>
                                    <b>Ituverava/SP</b> - Brasil<br><br>

                                </p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 footer-links" style="text-align: center;">
                            <div class="footer-info">
                                <h3>CONTATO</h3>
                                <strong>Telefone:</strong> (16) 3729-6822 <br>
                                <strong>WhatsApp:</strong> (16) 9 9235-8101 <br>
                                <strong>Email:</strong> imobilrenata@hotmail.com <br>
                            </div>

                        </div>

                        <div class="col-lg-4 col-md-6" style="text-align: center;">
                            <div class="footer-info">

                                <h3>MENUS</h3>
                                <router-link :to="'/all_properties'" class="nav-link scrollto">
                                    Imóveis
                                </router-link>
                                <router-link :to="'/about'" class="nav-link scrollto">
                                    Sobre nós
                                </router-link>
                                <router-link :to="{ path: '/about', hash: '#onfocus' }" class="nav-link scrollto">
                                    Financiamentos
                                </router-link>
                                <router-link :to="{ path: '/', hash: '#contato' }" class="nav-link scrollto">
                                    Contato
                                </router-link>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="footer-legal text-center">
                <div
                    class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
                    <div class="d-flex flex-column align-items-center align-items-lg-start">
                        <div class="copyright">
                            &copy; Copyright <strong><span>Renata Florêncio Imobiliária.</span></strong> Todos os
                            Direitos
                            Reservados
                        </div>
                        <div class="credits">
                            Desenvolvido por <a href="https://www.linkedin.com/in/jean-pandolfi/" target="_blank">Jean
                                Pandolfi Jr.</a>
                        </div>
                    </div>
                    <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                        <a href="https://www.facebook.com/renataflorenciocorretoradeimoveis/" class="facebook"
                            target="_blank"><i class="bi bi-facebook"></i></a>

                        <a href="https://www.instagram.com/renataflorencioimoveis/" class="instagram" target="_blank"><i
                                class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>

        </footer>

        <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

    </div>
</template>

<script>
export default {
    data: function () {
        return {

        };
    },
    computed: {

    },
    methods: {

    },
    beforeMount() {

    },
};
</script>
