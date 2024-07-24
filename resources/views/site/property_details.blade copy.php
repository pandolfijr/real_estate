<!DOCTYPE html>
<html lang="pt-br">

<head>
    @include('site.assets');
</head>

<body>
    @include('site.cabecalho');
    @include('site.search')


    <main id="main">
        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio" data-aos="fade-up" style="margin-top: 5em">

            <div class="container">
                <div class="section-header">
                    <h2>{{ $imovel->descricao }}</h2>
                    <hr>
                </div>
            </div>

            <div class="container-fluid" data-aos="fade-up" data-aos-delay="200">
                <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry"
                    data-portfolio-sort="original-order">
                    <div class="row g-0 portfolio-container">
                        @if ($imagens)
                            @foreach ($imagens as $imagem)
                                <a href="/{{ $imagem->local }}/{{ $imagem->descricao }}"
                                    data-gallery="portfolio-gallery" class="glightbox preview-link">
                                    <div class="col-xl-3 col-lg-4 col-md-6 col align-self-center portfolio-item">
                                        <img id="myImg_{{ $imagem->id }}"
                                            src="/{{ $imagem->local }}/{{ $imagem->descricao }}" class="img-detalhe">
                                        <div class="portfolio-info">
                                            <h4>{{ $imovel->descricao }}</h4>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            <!-- End Portfolio Item -->
                        @endif
                    </div><!-- End Portfolio Container -->
                </div>
            </div>
        </section><!-- End Portfolio Section -->

        <!-- ======= Features Section ======= -->
        <section id="features" class="features">
            <div class="container" data-aos="fade-up">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab-1">
                        <section id="blog" class="blog">
                            <div class="container aos-init aos-animate" data-aos="fade-up">
                                <div class="row g-5">
                                    <div class="col-lg-8">
                                        <article class="blog-details">
                                            <h3>Código do imóvel: {{ $imovel->referencia }}</h3>
                                            <hr>
                                            <p class="fst-italic">
                                                <!-- descrição da casa -->
                                                {{ $imovel->tipo }} para {{ $imovel->finalidade }} no bairro
                                                {{ $imovel->bairro }},
                                                na cidade de {{ $imovel->cidade }}/{{ $imovel->estado }}.
                                            </p><br>
                                            @if ($imovel->exibir_endereco == 2)
                                                <h3>Endereço</h3>
                                                <hr>
                                                <p class="fst-italic">
                                                    Rua {{ $imovel->endereco }}, <b>número</b>
                                                    {{ $imovel->numero }}.
                                                </p>
                                                <br>
                                            @endif
                                            <h3>Características do imóvel</h3>
                                            <hr>
                                            <ul>
                                                @if ($imovel->dormitorios != 0 && $imovel->dormitorios != null)
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Dormitórios: </b> {{ $imovel->dormitorios ?? 0 }}
                                                    </li>
                                                @endif

                                                @if ($imovel->suites != 0 && $imovel->suites != null)
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Suítes: </b> {{ $imovel->suites ?? 0 }}
                                                    </li>
                                                @endif

                                                @if ($imovel->vagas != 0 && $imovel->vagas != null)
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Vagas na Garagem: </b> {{ $imovel->vagas ?? 0 }}
                                                    </li>
                                                @endif

                                                @if ($imovel->area != 0 && $imovel->area != null)
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Área em M²: </b> {{ $imovel->area ?? 0 }}
                                                    </li>
                                                @endif

                                                @if ($imovel->banheiros != 0 && $imovel->banheiros != null)
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Banheiros: </b> {{ $imovel->banheiros ?? 0 }}
                                                    </li>
                                                @endif

                                                @if ($imovel->valor_venda != '0.00' && $imovel->id_finalidade == 1)
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Valor de Venda: </b>R$
                                                        {{ App\Models\Utils::mascaraValor($imovel->valor_venda) }}
                                                    </li>
                                                @endif

                                                @if ($imovel->valor_locacao != '0.00' && ($imovel->id_finalidade == 2 || $imovel->id_finalidade == 4))
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Valor de Locação: </b>R$
                                                        {{ App\Models\Utils::mascaraValor($imovel->valor_locacao) }}
                                                    </li>
                                                @endif

                                                @if ($imovel->valor_locacao != '0.00' && $imovel->id_finalidade == 3)
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Valor de Venda: </b>R$
                                                        {{ App\Models\Utils::mascaraValor($imovel->valor_venda) }}
                                                    </li>
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Valor de Locação: </b>R$
                                                        {{ App\Models\Utils::mascaraValor($imovel->valor_locacao) }}
                                                    </li>
                                                @endif

                                                @if ($imovel->valor_iptu != '0.00')
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Valor de IPTU: </b>R$
                                                        {{ App\Models\Utils::mascaraValor($imovel->valor_iptu) }}
                                                    </li>
                                                @endif

                                                @if ($imovel->valor_condominio != '0.00')
                                                    <li>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <b>Valor de Condomínio: </b>R$
                                                        {{ App\Models\Utils::mascaraValor($imovel->valor_condominio) }}
                                                    </li>
                                                @endif

                                                <br>
                                                <hr>
                                                <p class="fst-italic">
                                                    <a href="https://api.whatsapp.com/send?phone=5516992358101&text=Ol%C3%A1!%20Vi%20este%20im%C3%B3vel%20no%20site%20e%20me%20interessei%20por%20ele!%20C%C3%B3digo%3A%20{{ $imovel->referencia }}"
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
                                            {{-- <div class="col-lg-4> --}}
                                            {{-- <div class="border">
                                                <h4>Contato</h4>
                                                <h5>Renata - Corretora da Propriedade</h5>
                                                <h5>contato@renatacorretoradeimoveis.com.br</h5>
                                                <h5>(16) 3729-6822</h5>
                                                <h5>(16) 99235-8101</h5>
                                            </div><br>
                                            <h3>Veja mais:</h3>
                                            @foreach ($imoveis as $imovel_lateral)
                                                <div class="container-fluid" data-aos="fade-up" data-aos-delay="200">
                                                    <div class="portfolio-isotope" data-portfolio-filter="*"
                                                        data-portfolio-layout="masonry"
                                                        data-portfolio-sort="original-order">
                                                        <div class="row g-0 portfolio-container">
                                                            <img id="myImg_{{ $imovel_lateral->id }}"
                                                                src="/{{ $imovel_lateral->local_imagem }}/{{ $imovel_lateral->nome_imagem }}"
                                                                class="img-detalhe">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach --}}
                                            {{-- </div> --}}
                                            @if (count($imoveis) > 0)
                                                <div class="sidebar-item search-form">
                                                    <h3 class="sidebar-title">Outros imóveis...</h3>
                                                </div>
                                                <div class="sidebar-item recent-posts">
                                                    <div class="mt-3">
                                                        @foreach ($imoveis as $imovel_lateral)
                                                            <div class="container-fluid" data-aos="fade-up"
                                                                data-aos-delay="200" style="margin-bottom: 3em;">
                                                                <div class="post-item"> <img
                                                                        src="/{{ $imovel_lateral->local_imagem }}/{{ $imovel_lateral->nome_imagem }}"
                                                                        alt="" class="flex-shrink-0"
                                                                        height="70em">
                                                                    <div>
                                                                        <h4><a href="{{ $imovel_lateral->id }}">
                                                                                {{ substr($imovel_lateral->descricao, 0, 40) }}...
                                                                            </a>
                                                                        </h4> <time>{{ $imovel_lateral->tipo }} para
                                                                            {{ $imovel_lateral->finalidade }}</time>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <h4 style="text-align: center;">Contato</h4>
                                                <hr>
                                                <h5 style="text-align: center;">
                                                    <b>{{ $configuracao->nome_fantasia }}</b>
                                                </h5>
                                                <h5 style="text-align: center;">{{ $configuracao->email_1 }}</h5>
                                                <h5 style="text-align: center;">
                                                    {{ App\Models\Utils::mascaraCelular($configuracao->telefone_1) }}
                                                </h5>
                                                <h5 style="text-align: center;">
                                                    <b><a href="https://api.whatsapp.com/send?phone=55{{ $configuracao->whatsapp_1 }}&text=Ol%C3%A1!%20Vim%20pelo%20site%20da%20imobili%C3%A1ria.%20Pode%20me%20ajudar%3F"
                                                            target="_blank">{{ App\Models\Utils::mascaraCelular($configuracao->whatsapp_1) }}</a></b>
                                                </h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Rodapé ======= -->
    <footer id="footer" class="footer">
        @include('site.rodape')
    </footer><!-- Fim rodapé -->
    {{--
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a> --}}

    <div id="preloader"></div>
    @include('site.scripts')



</body>

</html>
