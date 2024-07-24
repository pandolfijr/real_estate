<form id="quickForm" method="get" action="{{ route('imovel.index') }}">
    <div class="row" style="margin-bottom: 2.5em;">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filtrar</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3 filtro-div">
                            <div class="form-group">
                                <input type="text" name="filtro" class="form-control float-right"
                                    placeholder="Pesquise nome, descricao ou referência"
                                    value="{{ isset($_GET['filtro']) && !empty($_GET['filtro']) ? $_GET['filtro'] : '' }}">
                            </div>
                        </div>
                        <div class="col-sm-1 filtro-div">
                            <select class="custom-select" id="selectStatusImovel" name="id_status_imovel">
                                <option value="">Status</option>
                                @foreach ([1 => 'Disponível', 2 => 'Vendido', 3 => 'Alugado', 4 => 'Indisponível'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ isset($_GET['id_status_imovel']) && $_GET['id_status_imovel'] == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2 filtro-div">
                            <select class="custom-select" id="selectStatusImovel" name="finalidade">
                                <option value="">Finalidade</option>
                                @foreach ([1 => 'Venda', 2 => 'Locação', 3 => 'Venda e Locação', 4 => 'Temporada'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ isset($_GET['finalidade']) && $_GET['finalidade'] == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4" style="text-align: left">
                            <button type="submit" class="btn btn-primary">Pesquisar</button>
                            <a href="{{ route(Request::segment(1) . '.index') }}">
                                <button type="button" class="btn btn-warning">Limpar Filtros</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
