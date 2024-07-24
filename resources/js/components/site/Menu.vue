<template>
    <main id="main">
        <header id="header" class="header fixed-top" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <router-link :to="'/'" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
            <img :src="'/images_setting/1/logo_menu_1_20230211.png'" class="img-fluid" alt="" />
        </router-link>
        <nav id="navbar" class="navbar" style="margin-left: -3em">
            <ul class="d-flex justify-content-center"> <!-- Centraliza os itens do menu -->
                <li>
                    <router-link :to="'/'" class="small-box-footer">
                        Início
                    </router-link>
                </li>
                <li>
                    <router-link :to="'/all_properties'" class="small-box-footer">
                        Imóveis
                    </router-link>
                </li>
                <li>
                    <router-link :to="'/about'" class="small-box-footer">
                        Sobre nós
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ path: '/about', hash: '#onfocus' }" class="small-box-footer">
                        Financiamentos
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ path: '/', hash: '#contato' }" class="small-box-footer">
                        Contato
                    </router-link>
                </li>
            </ul>
        </nav>
        <div class="col-md-1" style="margin-right: 1em; margin-top: 1em;">
            <button v-if="!pathSegment.includes('property_details') && currentUrl != 'about'" type="button" class="btn button-search" data-bs-toggle="collapse"
                data-bs-target="#faq-content-1" aria-expanded="false"><i class="bi bi-search"></i></button>
        </div>
    </div>
</header>

    </main>
</template>
<script>

export default {
    data: function () {
        return {
            currentUrl : window.location.pathname.split('/').pop(),
            pathSegment : window.location.pathname.split('/').slice(1).join('/'),

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
