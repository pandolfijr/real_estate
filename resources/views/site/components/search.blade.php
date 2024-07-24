    <header id="header" class="header-search fixed-top" data-scrollto-offset="0" style="">
        <div class="container-fluid aos-init aos-animate" data-aos="fade-up">
            <div class="row gy-4">
                <div class="" id="faqlist" class="table-search">
                    <div class="accordion-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                        <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist"
                            style="">
                            <div class="accordion-body">
                                <form id="quickForm" method="post" action="{{ route('propriedades') }}">
                                    @csrf
                                    <div class="row" style="margin: 2em;">
                                        <div class="col-md-2 col-search">
                                            <input type="text" class="form-control" name="descricao"
                                                id="inputDescricao" placeholder="Código/Descrição do Imóvel"
                                                aria-label="Código ou Descrição"
                                                value="{{ $filtro['descricao'] ?? '' }}">
                                        </div>
                                        <div class="col-md-1 col-search">
                                            <input type="text" class="form-control" name="valor_min"
                                                id="inputValorMin"
                                                onkeypress="$(this).mask('000.000.000.000.000,00', {reverse: true});"
                                                placeholder="Valor Mín" value="{{ $filtro['valor_min'] ?? '' }}">
                                        </div>
                                        <div class="col-md-1 col-search ">
                                            <input type="text" class="form-control" name="valor_max"
                                                id="inputValorMax" placeholder="Valor Max."
                                                onkeypress="$(this).mask('000.000.000.000.000,00', {reverse: true});"
                                                value="{{ $filtro['valor_max'] ?? '' }}">
                                        </div>
                                        <div class="col-md-1 col-search">
                                            <select name="finalidade" id="inputFinalidade" class="form-select" required
                                                value="{{ $filtro['finalidade'] ?? '' }}">
                                                <option value="">Transação...</option>
                                                @foreach ($finalidades_imoveis as $finalidade_imoveis)
                                                    <option value="{{ $finalidade_imoveis->id }}"
                                                        {{ $finalidade_imoveis->id == ($filtro['finalidade'] ?? '') ? 'selected' : '' }}>
                                                        {{ $finalidade_imoveis->descricao }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 col-search">
                                            <select name="tipo" id="inputTipo" class="form-select"
                                                value="{{ $filtro['tipo'] ?? '' }}">>
                                                <option value="">Tipo de imóvel...</option>
                                                @foreach ($tipos_imoveis as $tipo_imoveis)
                                                    <option value="{{ $tipo_imoveis->id }}"
                                                        {{ $tipo_imoveis->id == ($filtro['tipo'] ?? '') ? 'selected' : '' }}>
                                                        {{ $tipo_imoveis->descricao }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 col-search">
                                            <select name="cidade" id="inputCidade" class="form-select"
                                                value="{{ $filtro['cidade'] ?? '' }}">>
                                                <option value="">Cidade... {{ $filtro['cidade'] ?? '' }}
                                                </option>
                                                @foreach ($cidades as $cidade)
                                                    <option value="{{ $cidade->id }}"
                                                        {{ $cidade->id == ($filtro['cidade'] ?? '') ? 'selected' : '' }}>
                                                        {{ $cidade->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 col-search">
                                            <select name="dormitorios" id="inputQuartos" class="form-select"
                                                value="{{ $filtro['dormitorios'] ?? '' }}">>
                                                <option value="" selected>Quartos</option>

                                                @foreach (App\Models\Utils::quantidade() as $quantidade)
                                                    <option value="{{ $quantidade }}"
                                                        {{ $quantidade == ($filtro['dormitorios'] ?? '') ? 'selected' : '' }}>
                                                        {{ $quantidade }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="col-md-1 col-search">
                                            <select name="banheiros" id="inputBanheiros" class="form-select">
                                                <option value="" selected>Banheiros</option>
                                                @foreach (App\Models\Utils::quantidade() as $quantidade)
                                                    <option value="{{ $quantidade }}"
                                                        {{ $quantidade == ($filtro['banheiros'] ?? '') ? 'selected' : '' }}>
                                                        {{ $quantidade }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-1 col-search">
                                            <select name="ordenar" id="inputBanheiros" class="form-select"
                                                value="{{ $filtro['ordenar'] ?? '' }}">
                                                <option value="">Ordenar Valor</option>
                                                <option value="desc"
                                                    {{ 'desc' == ($filtro['ordenar'] ?? '') ? 'selected' : '' }}>
                                                    Decrescente</option>
                                                <option value="asc"
                                                    {{ 'asc' == ($filtro['ordenar'] ?? '') ? 'selected' : '' }}>
                                                    Crescente</option>
                                            </select>
                                        </div>


                                        <div class="col-md-1 col-search" style="text-align:center;">
                                            <button type="submit" class="btn btn-primary">Pesquisar</button>
                                        </div>


                                        <div class="col-md-1 col-search" style="text-align:center;">
                                            <a href="/imoveis">
                                                <input type="button" class="btn btn-primary" value="Limpar Filtros">
                                            </a>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
