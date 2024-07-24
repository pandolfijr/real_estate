<template>
    <div class="content-header">
        <div class="container-fluid">

            <div class="row" style="margin-bottom: 2.5em;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Preencha os Filtros e Gere o Relatório</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <input type="number" name="dormitorios" class="form-control float-right"
                                        placeholder="Dormitórios" min="0">
                                </div>
                                <div class="form-group col-sm-3">
                                    <input type="number" name="suites" class="form-control float-right"
                                        placeholder="Suítes" min="0">
                                </div>
                                <div class="form-group col-sm-3">
                                    <input type="number" name="banheiros" class="form-control float-right" min="0"
                                        placeholder="Banheiros">
                                </div>
                                <div class="form-group col-sm-3">
                                    <input type="number" name="vagas" class="form-control float-right"
                                        placeholder="Vagas de Garagem" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 form-group">
                                    <input type="text" class="form-control" name="valor_min" id="valor_min"
                                        onkeypress="$(this).mask('000.000.000.000.000,00', {reverse: true});"
                                        placeholder="Valor Mínimo">
                                </div>
                                <div class="col-md-1 form-group">
                                    <input type="text" class="form-control" name="valor_max" id="valor_max"
                                        onkeypress="$(this).mask('000.000.000.000.000,00', {reverse: true});"
                                        placeholder="Valor Máximo">
                                </div>
                                <div class="col-sm-2 form-group">
                                    <select class="custom-select" id="selectStatusImovel" name="id_status_imovel">
                                        <option value="">Status</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <select class="custom-select" id="selectStatusImovel" name="finalidade">
                                        <option value="">Finalidade</option>
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <select name="cidade" id="cidade" class="custom-select">
                                        <option value="">Cidade... </option>



                                    </select>
                                </div>

                                <div class="col-sm-4" style="text-align: left">
                                    <button type="submit" class="btn btn-primary">Gerar Relatório</button>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</template>

<script>
// import {  } from "../utils.js";
import axios from 'axios';

export default {
    data: function () {
        return {
            settings: {},
        };
    },
    computed: {

    },
    methods: {
        getData() {
            axios.get('/settings')
                .then(response => {
                    this.settings = response.data.settings;
                })
                .catch(error => {
                    console.error('Houve um problema com a requisição:', error);
                });
        }
    },
};
</script>
