<!-- ======= Header ======= -->
<header id="header" class="header fixed-top" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <a href="/" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
            <img src="{{ asset('images_setting/1/logo_menu_1_20230211.png')}}" class="img-fluid" alt="">
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="/">Iniicio</a></li>
                    <li><a class="nav-link scrollto" href="/all_properties">Imóveis</a></li>
                    <li><a class="nav-link scrollto" href="/about">Sobre nós</a></li>
                    {{-- <li><a class="nav-link scrollto" href="#financiamentos">Financiamentos</a></li> --}}
                    <li><a class="nav-link scrollto" href="/contact">Contato</a></li>

            </ul>
            <i class="bi bi-list mobile-nav-toggle d-none"></i>
        </nav>
        <a class="scrollto" href="/admin"></a>
        <div class="col-md-1">
            <button type="button" class="btn button-search" data-bs-toggle="collapse" data-bs-target="#faq-content-1"
                aria-expanded="false"><i class="bi bi-search"></i></button>
        </div>
    </div>
    {{-- @include('site.whatsapp') --}}
</header>


<!-- End Header -->
