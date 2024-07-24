@include('site.components.header')
@include('site.components.search')

<body>
    <main id="main">
        <section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center" style="margin-top: -2em;">
            <section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center">
                <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
                    <h2 style="text-align: center;">Bem vindo à nossa <span>imobiliária</span></h2>
                    <p style="text-align: center;">Aqui você vai encontrar o imóvel que você sempre sonhou!</p>
                    <div class="d-flex">
                        <a href="/imoveis#imoveis" class="btn-get-started scrollto">Ver imóveis</a>
                    </div>
                </div>
            </section>
        </section>


        <!-- ======= Serviços Oferecidos ======= -->
        <section id="featured-services" class="featured-services">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-xl-3 col-md-6" data-aos="zoom-out">
                        <div
                            class="service-item position-relative align-items-center info-item text-lg-center"style="text-align: center;">
                            <div class="icon"><i class="bi bi-activity icon"></i></div>
                            <h4>ALUGUEL</h4>
                            <p>Os mais variados imóveis para alugar</p>
                        </div>
                    </div><!-- Fim de item de Serviço -->
                    <div class="col-xl-3 col-md-6" data-aos="zoom-out" data-aos-delay="200">
                        <div class="service-item position-relative" style="text-align: center;">
                            <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                            <h4>VENDA</h4>
                            <p>Realize o sonho da sua casa própria</p>
                        </div>
                    </div><!-- Fim de item de Serviço -->
                    <div class="col-xl-3 col-md-6" data-aos="zoom-out" data-aos-delay="400">
                        <div class="service-item position-relative" style="text-align: center;">
                            <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                            <h4>FINANCIAMENTO</h4>
                            <p>Escolha seu imóvel, nós financiamos</p>
                        </div>
                    </div><!-- Fim de item de Serviço -->
                    <div class="col-xl-3 col-md-6" data-aos="zoom-out" data-aos-delay="600">
                        <div class="service-item position-relative" style="text-align: center;">
                            <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                            <h4>CONSULTORIA</h4>
                            <p>Encontraremos o melhor imóvel para você</p>
                        </div>
                    </div><!-- Fim de item de Serviço -->
                </div>
            </div>
        </section>
        <!-- Fim dos serviços oferecidos -->

        @if (!empty($imoveis_locacao))
            <section id="services" class="services">
                <div class="container" data-aos="fade-up">
                    <div class="section-header">
                        <h2>Imóveis para Locação</h2>
                    </div>
                    <div class="row gy-5">
                        @foreach ($imoveis_locacao as $imovel_locacao)
                            <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="500">
                                <a href="{{ URL::to('propriedade_detalhe/' . $imovel_locacao->id) }}"
                                    class="stretched-link">
                                    <div class="service-item">
                                        <div class="img">
                                            <img src="/{{ $imovel_locacao->local }}/{{ $imovel_locacao->nome_imagem }}"
                                                class="img-detalhe" alt="" />
                                        </div>
                                        <div class="details position-relative">
                                            <a href="{{ URL::to('propriedade_detalhe/' . $imovel_locacao->id) }}"
                                                class="stretched-link">
                                                <h3 style="margin-top: -1.2em; margin-bottom: -0.075em;">
                                                    {{ $imovel_locacao->tipo }}</h3>
                                            </a>
                                            <p>{{ substr($imovel_locacao->descricao_imovel, 0, 29) }}...</p>
                                            <p><b>
                                                    @if ($imovel_locacao->id_finalidade == 2 || $imovel_locacao->id_finalidade == 4)
                                                        @if ($imovel_locacao->valor_locacao == '0.00')
                                                            <h5>CONSULTE-NOS!</H5>
                                                        @else
                                                            <h5>R$
                                                                {{ App\Models\Utils::mascaraValor($imovel_locacao->valor_locacao) }}
                                                            </h5>
                                                        @endif
                                                    @elseif($imovel_locacao->id_finalidade == 1)
                                                        {{-- venda --}}
                                                        @if ($imovel_locacao->valor_venda == '0.00')
                                                            <h5>CONSULTE-NOS!</H5>
                                                        @else
                                                            <h5>R$
                                                                {{ App\Models\Utils::mascaraValor($imovel_locacao->valor_venda) }}
                                                            </h5>
                                                        @endif
                                                    @elseif($imovel_locacao->id_finalidade == 3)
                                                        {{-- venda e locacao --}}
                                                        @if ($imovel_locacao->valor_venda == '0.00' || $imovel_locacao->valor_locacao == '0.00')
                                                            <h5>CONSULTE-NOS!</H5>
                                                        @else
                                                        @endif
                                                        <h5>R$
                                                            {{ App\Models\Utils::mascaraValor($imovel_locacao->valor_venda) }}
                                                            |
                                                            R$
                                                            {{ App\Models\Utils::mascaraValor($imovel_locacao->valor_locacao) }}
                                                        </h5>
                                                    @endif
                                                    <p style="color: #f97233;">{{ $imovel_locacao->finalidade }}</p>
                                                </b></p>
                                        </div>
                                    </div>
                                </a>
                            </div><!-- Fim de item de Destaque -->
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        End About Section

        

        

    </main>
</body>

@include('site.components.footer')

</html>
