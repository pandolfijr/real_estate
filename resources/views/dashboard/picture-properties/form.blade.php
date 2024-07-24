@extends('adminlte::page')

@section('title', 'Imóveis | Imobiliária')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Imagens do Imóvel</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Editar Imagens</small></h3>
                </div>
                <br>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($images_property as $imagem_imovel)
                                            <div class="col-sm-2" style="margin-bottom: 1em;">
                                                <img id="myImg_{{ $imagem_imovel->id }}"
                                                    src="/{{ $imagem_imovel->local }}/{{ $imagem_imovel->descricao }}"
                                                    class="mb-2 img-detalhe" alt="white sample"> <br>

                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="float-right"
                                                            data-target="#exampleModal_{{ $imagem_imovel->id }}">
                                                            @if ($imagem_imovel->principal == true)
                                                                <button type="button" class="btn btn-secondary"
                                                                    title="Esta é a imagem principal" disabled>
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-outline-primary"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModalPrincipal_{{ $imagem_imovel->id }}"
                                                                    style="" title="Definir Imagem como Principal">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="float-right"
                                                            data-target="#exampleModal_{{ $imagem_imovel->id }}">
                                                            @if ($imagem_imovel->principal == true)
                                                            <button type="button" class="btn btn-danger"
                                                                    style=""
                                                                    title="Você não pode excluir a imagem principal"
                                                                    disabled>
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModal_{{ $imagem_imovel->id }}"
                                                                    style="" title="Excluir Imagem">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModal_{{ $imagem_imovel->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    <b>Atenção</b>
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Você tem certeza que quer excluir a imagem?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Voltar</button>

                                                                <form id="form_{{ $imagem_imovel->id }}" method="post"
                                                                    action="{{ route('imagem_imovel.destroy', ['imagem_imovel' => $imagem_imovel->id]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <a href="#"
                                                                        onclick="document.getElementById('form_{{ $imagem_imovel->id }}').submit()">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Excluir</button>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalPrincipal_{{ $imagem_imovel->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    <b>Atenção</b>
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Você tem certeza que quer definir esta imagem como
                                                                principal?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Voltar</button>
                                                                <form id="quickForm" method="post"
                                                                    action="{{ URL::to('imagem_imovel/' . $id_property) }}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="id_imagem_imovel"
                                                                        value="{{ $imagem_imovel->id }}">
                                                                    <input type="hidden" name="id_property"
                                                                        value="{{ $id_property }}">
                                                                    <a href="#"
                                                                        onclick="document.getElementById('form_{{ $imagem_imovel->id }}').submit()">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Definir</button>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <a href="{{ URL::to('imovel/' . $id_property . '/edit') }}"><button type="button" title="Fechar"
                                            class="btn btn-danger" data-dismiss="modal">Voltar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Versão</b> 1.0.0
    </div>
    <strong>Copyright © 2023 <a href="mailto:jeancarlojr@live.com" target="_blank">Jean Pandolfi Jr. Software</a></strong> | Todos os direitos reservados.
@stop

@section('css')
    <link rel="stylesheet" src="{{ asset('assets/css/main.css') }}">
    <style>
        .img-detalhe {
            max-width: 100%;
            height: 300px;
            width: 300px;
            border: 5px solid var(--bs-border-color);
            border-radius: .875rem;
        }
    </style>
@stop

@section('js')
    <script>
        function editar(variavel) {
            alert(variavel);
        }
    </script>
@stop
