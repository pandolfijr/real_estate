<section class="content">
    <div class="container-fluid">
        <form id="quickForm" method="get" action="{{ route(Request::segment(1) . '.index') }}">
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
                                    <select class="custom-select" id="selectStatus" name="status">
                                        <option value="">Status</option>
                                        <option value=1
                                            {{ isset($_GET['status']) && $_GET['status'] == 1 ? 'selected' : '' }}>
                                            Ativos
                                        </option>
                                        <option value=2
                                            {{ isset($_GET['status']) && $_GET['status'] == 2 ? 'selected' : '' }}>
                                            Inativos
                                        </option>
                                        <option value=3
                                            {{ isset($_GET['status']) && $_GET['status'] == 3 ? 'selected' : '' }}>
                                            Todos
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-4 filtro-div" style="text-align: left">
                                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                                    <a href="{{ route(Request::segment(1) . '.index') }}">
                                        <button type="button" class="btn btn-warning">Limpar Filtros</button> </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<style>
    .filtro-div {
        margin: 0.5em;
    }
</style>
