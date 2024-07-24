@include('site.components.header')
@include('site.components.search')

<body>
    <main id="main">
        @if (!empty($imoveis))
        <section id="services" class="services">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>Imóveis para Locação</h2>
                </div>
                <div class="row gy-5">
                    @foreach ($imoveis as $imovel)
                    <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="500">
                        <a href="{{ URL::to('propriedade_detalhe/' . $imovel->id) }}" class="stretched-link">
                            <div class="service-item">
                                <div class="img">
                                    <img src="/{{ $imovel->local }}/{{ $imovel->nome_imagem }}" class="img-detalhe" alt="" />
                                </div>
                                <div class="details position-relative">
                                    <a href="{{ URL::to('propriedade_detalhe/' . $imovel->id) }}" class="stretched-link">
                                        <h3 style="margin-top: -1.2em; margin-bottom: -0.075em;">
                                            {{ $imovel->tipo }}
                                        </h3>
                                    </a>
                                    <p>{{ substr($imovel->descricao_imovel, 0, 29) }}...</p>
                                    <p><b>
                                            @if ($imovel->id_finalidade == 2 || $imovel->id_finalidade == 4)
                                            @if ($imovel->valor_locacao == '0.00')
                                            <h5>CONSULTE-NOS!</H5>
                                            @else
                                            <h5>R$
                                                {{ App\Models\Utils::mascaraValor($imovel->valor_locacao) }}
                                            </h5>
                                            @endif
                                            @elseif($imovel->id_finalidade == 1)
                                            {{-- venda --}}
                                            @if ($imovel->valor_venda == '0.00')
                                            <h5>CONSULTE-NOS!</H5>
                                            @else
                                            <h5>R$
                                                {{ App\Models\Utils::mascaraValor($imovel->valor_venda) }}
                                            </h5>
                                            @endif
                                            @elseif($imovel->id_finalidade == 3)
                                            {{-- venda e locacao --}}
                                            @if ($imovel->valor_venda == '0.00' || $imovel->valor_locacao == '0.00')
                                            <h5>CONSULTE-NOS!</H5>
                                            @else
                                            @endif
                                            <h5>R$
                                                {{ App\Models\Utils::mascaraValor($imovel->valor_venda) }}
                                                |
                                                R$
                                                {{ App\Models\Utils::mascaraValor($imovel->valor_locacao) }}
                                            </h5>
                                            @endif
                                            <p style="color: #f97233;">{{ $imovel->finalidade }}</p>
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

    </main>
</body>

@include('site.components.footer')

</html>
