<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo | Renata Corretora de Imóveis</title>
    <link rel="icon" href="{{ asset('images_setting/1/logo_icone1_20230211.png') }}" type="image/x-icon">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
            margin-top:1em;
        }

        .header img {
            width: 100px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .header p {
            margin: 0;
            font-size: 1rem;
        }

        .info-section,
        .values-section {
            margin-top: 20px;
        }

        .border-title {
            border: 1px solid #000;
        }

        .info-section .row,
        .values-section .row {
            border-bottom: 1px solid #ccc;
        }

        .info-section .row:last-child,
        .values-section .row:last-child {
            border-bottom: none;
        }

        .info-section .col,
        .values-section .col {
            padding: 0px;
        }

        .info-section .col-3 {
            background-color: #f2f2f2;
        }

        .values-section .col-3,
        .values-section .col-6 {
            background-color: #f2f2f2;
        }

        .values-section .col-9 {
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 6em;
        }

        .footer p {
            margin: 0;
        }

        @media print {
            .print-button {
                display: none;
            }

            body {
                -webkit-print-color-adjust: exact;
                margin: 0;
                padding: 0;
            }

            .info-section .col-3,
            .values-section .col-3,
            .values-section .col-6 {
                background-color: #f2f2f2 !important;
                -webkit-print-color-adjust: exact;
            }
        }

        @page {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 3em;">
        <div class="row">
            <div class="col-3 font-weight-bold">
                <img src="{{ asset('images_setting/1/logo_menu_1_20230211.png') }}" class="img-fluid" alt="">
            </div>
            <div class="col-9">
                <div class="header">
                    <h1>TERMO DE DEVOLUÇÃO DE CHAVES</h1>
                    <p>Renata Florêncio Corretora de Imóveis</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="row" style="margin-top:5em;">
            <div class="col-12">
                <p class="text-justify">Recebemos de
                    <b>{{ $transaction->renter->people->name . ' ' . $transaction->renter->people->surname }}</b>, locatário(a)
                    do imóvel <b>{{ $transaction->property->reference }}</b> sito à
                    {{ $transaction->property->address }}, {{ $transaction->property->number ?? 's/ nº' }} -
                    {{ $transaction->property->city->name }} ({{ $transaction->property->city->state->name }})
                    as chaves do referido imóvel para fins de vistoria.</p>

                <p class="text-justify" style="margin-top:5em;"> O presente documento não encerra o contrato de Locação
                    devendo o locatário aguardar o término
                    da vistoria de entrega do imóvel e SE DESEJAR, SOLICITANDO ESTAR PRESENTE A VISTORIA em data a
                    ser acertada com o locador. O locatário pode optar por fazer as reformas necessárias devendo durante
                    o
                    prazo de reforma pagar o aluguel “pro-rata”. Se reformado pelo locador o locatário fica dispensado
                    do
                    pagamento de aluguel durante o prazo que durar as reformas. O contrato de locação somente se encerra
                    após a reforma e a quitação de todos os débitos presentes e
                    assinatura do termo de encerramento.</p>
            </div>
        </div>
        <div class="footer">
            <div class="row">
                <div class="col-6">
                    <p>_________________________________________________</p>
                    <p>Locador(a):
                        {{ $transaction->locator->people->name . ' ' . $transaction->locator->people->surname }}</p>
                </div>
                <div class="col-6">
                    <p>_________________________________________________</p>
                    <p>Locatário(a):
                        {{ $transaction->renter->people->name . ' ' . $transaction->renter->people->surname }}</p>
                </div>
            </div>

        </div>


        {{-- <div class="info-section">
            <div class="row">
                <div class="col-3 font-weight-bold">Locador</div>
                <div class="col-5">
                    {{ $installment->locator->people->name . ' ' . $installment->locator->people->surname }}
                </div>
                <div class="col-4 font-weight-bold">CPF:
                    {{ $installment->locator->people->cpf ? \App\Helpers\Utils::formatCpf($installment->locator->people->cpf) : '' }}
                </div>
            </div>
            <div class="row">
                <div class="col-3 font-weight-bold">Locatário</div>
                <div class="col-5">
                    {{ $installment->renter->people->name . ' ' . $installment->renter->people->surname }}
                </div>
                <div class="col-4 font-weight-bold">
                    {{ $installment->renter->people->cpf ? 'CPF: ' . \App\Helpers\Utils::formatCpf($installment->renter->people->cpf) : '' }}
                </div>
            </div>

            <div class="row">
                @if ($installment->property->id_condo)
                    <div class="col-3 font-weight-bold">Endereço do Imóvel</div>
                    <div class="col-9">
                        {{ '[' . $installment->property->reference . '] - ' . $installment->property->address }}
                        {{ $installment->property->number ? ', Nº. ' . $installment->property->number : '' }}
                    </div>
                    <div class="col-3 font-weight-bold"></div>
                    <div class="col-9">
                        <b>{{ $installment->property->condo->description . ' - ' }}</b>
                        {{ $installment->property->lot ? ' Lote: ' . $installment->property->lot : '' }}
                        {{ $installment->property->court ? ' Quadra: ' . $installment->property->court : '' }}
                        {{ $installment->property->tower ? ' Torre: ' . $installment->property->tower : '' }}
                        {{ $installment->property->floor ? ' Andar: ' . $installment->property->floor : '' }}

                    </div>
                @else
                    <div class="col-3 font-weight-bold">Endereço do Imóvel</div>
                    <div class="col-9">
                        {{ '[' . $installment->property->reference . '] ' . $installment->property->address }}
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-3 font-weight-bold">Cidade</div>
                <div class="col-5"> {{ $installment->property->city->name }}</div>
                <div class="col-4 font-weight-bold">
                    {{ $installment->property->cep ? 'CEP: ' . \App\Helpers\Utils::formatCep($installment->property->cep) : '' }}
                </div>
            </div>
            <div class="row">
                <div class="col-12">Declaramos para os devidos fins de direito e efeitos legais que recebi de
                    Imobiliaria da Renata - CRECI 136.300, a importância(s) abaixo, referente ao aluguel do imóvel
                    de
                    minha propriedade, citado no cabeçalho deste recibo.</div>
            </div>
        </div> --}}

        {{-- <div class="values-section">
            <div class="header border-title">
                <p><b>Discriminação dos Valores do Recibo</b></p>
            </div>
            <div class="row">
                <div class="col-4 font-weight-bold">N.º Controle</div>
                <div class="col-2">{{ $installment->id }}</div>
                <div class="col-2 font-weight-bold">Parcela</div>
                <div class="col-1">{{ $installment->current_installment }}</div>
                <div class="col-2 font-weight-bold">De</div>
                <div class="col-1">{{ $installment->total_installments }}</div>
            </div>
            <div class="row">
                <div class="col-3 font-weight-bold">Data de Vencimento</div>
                <div class="col-3 text-center">
                    {{ $installment->due_date ? \App\Helpers\Utils::formatDate($installment->due_date) : '' }}</div>
                <div class="col-3 font-weight-bold">Data de Recebimento</div>
                <div class="col-3 text-right">
                    {{ $installment->date_received ? \App\Helpers\Utils::formatDate($installment->date_received) : '' }}
                </div>
            </div>
            <div class="row">
                <div class="col-6 font-weight-bold">(+) Valor do Aluguel</div>
                <div class="col-6 text-right">R$ {{ $installment->installment_value }}</div>
            </div>
            <div class="row">
                <div class="col-6 font-weight-bold">(+) Valor Outros Repasses</div>
                <div class="col-6 text-right">R$ {{ $installment->other_transfers ?? '0.00' }}</div>
            </div>
            <div class="row">
                <div class="col-6 font-weight-bold">(+) Valor da Multa</div>
                <div class="col-6 text-right">R$ {{ number_format($installment->penalty_value ?? '0.00', 2, '.', '') }}
                </div>
            </div>
            <div class="row">
                <div class="col-6 font-weight-bold">(+) Valor de Juros</div>
                <div class="col-6 text-right">R$
                    {{ number_format($installment->interest_month_value ?? '0.00', 2, '.', '') }}</div>
            </div>
            <div class="row">
                <div class="col-6 font-weight-bold">(-) Valor de Desconto</div>
                <div class="col-6 text-right">R$
                    {{ number_format($installment->discount_value ?? '0.00', 2, '.', '') }}</div>
            </div>

            <div class="row">
                <div class="col-6 font-weight-bold">Valor Total Parcela</div>
                <div class="col-6 text-right"><b>R$
                        {{ number_format($installment->installment_total_value ?? '0.00', 2, '.', '') }}</b></div>
            </div>
            <div class="row">
                <div class="col-6 font-weight-bold">(-) Valor de Administração</div>
                <div class="col-6 text-right">R$
                    {{ number_format($installment->installment_total_value - $installment->casher->account_value ?? '0.00', 2, '.', '') }}
                </div>
            </div>
            <div class="row">
                <div class="col-6 font-weight-bold">Valor Total Repasse</div>
                <div class="col-6 text-right"><b>R$
                        {{ number_format($installment->casher->account_value ?? '0.00', 2, '.', '') }}</b></div>
            </div>
            <div class="row">
                <div class="col-6 font-weight-bold" style="background-color: #fff;">Data de Pagamento do Repasse</div>
                <div class="col-6 text-right" style="background-color: #fff;">
                    {{ $installment->casher->date_current_action ? \App\Helpers\Utils::formatDate($installment->casher->date_current_action) : '' }}
                </div>
            </div>
        </div>

        <div class="footer">
            <p>_________________________________________________</p>
            <p>Recebido por:
                {{ $installment->locator->people->name . ' ' . $installment->locator->people->surname }}</p>
        </div> --}}

        <div class="row mt-4">
            <div class="col-12 text-center">
                <button onclick="window.print()" class="btn btn-primary print-button"
                    style="background-color: #f89d52; border: 1px solid #f89d52">Imprimir Recibo</button>
            </div>
        </div>

    </div>

    <div class="container text-center" style="margin-top: 5em;margin-bottom: 5em;">
        <b>___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___
            ___ ___ ___ ___
        </b>
    </div>

    <div class="container" style="margin-top: 3em;">
        <div class="row">
            <div class="col-3 font-weight-bold">
                <img src="{{ asset('images_setting/1/logo_menu_1_20230211.png') }}" class="img-fluid" alt="">
            </div>
            <div class="col-9">
                <div class="header">
                    <h1>TERMO DE DEVOLUÇÃO DE CHAVES</h1>
                    <p>Renata Florêncio Corretora de Imóveis</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="row" style="margin-top:5em;">
            <div class="col-12">
                <p class="text-justify">Recebemos de
                    <b>{{ $transaction->renter->people->name . ' ' . $transaction->renter->people->surname }}</b>, locatário(a)
                    do imóvel <b>{{ $transaction->property->reference }}</b> sito à
                    {{ $transaction->property->address }}, {{ $transaction->property->number ?? 's/ nº' }} -
                    {{ $transaction->property->city->name }} ({{ $transaction->property->city->state->name }})
                    as chaves do referido imóvel para fins de vistoria.</p>

                <p class="text-justify" style="margin-top:5em;"> O presente documento não encerra o contrato de Locação
                    devendo o locatário aguardar o término
                    da vistoria de entrega do imóvel e SE DESEJAR, SOLICITANDO ESTAR PRESENTE A VISTORIA em data a
                    ser acertada com o locador. O locatário pode optar por fazer as reformas necessárias devendo durante
                    o
                    prazo de reforma pagar o aluguel “pro-rata”. Se reformado pelo locador o locatário fica dispensado
                    do
                    pagamento de aluguel durante o prazo que durar as reformas. O contrato de locação somente se encerra
                    após a reforma e a quitação de todos os débitos presentes e
                    assinatura do termo de encerramento.</p>
            </div>
        </div>
        <div class="footer">
            <div class="row">
                <div class="col-6">
                    <p>_________________________________________________</p>
                    <p>Locador(a):
                        {{ $transaction->locator->people->name . ' ' . $transaction->locator->people->surname }}</p>
                </div>
                <div class="col-6">
                    <p>_________________________________________________</p>
                    <p>Locatário(a):
                        {{ $transaction->renter->people->name . ' ' . $transaction->renter->people->surname }}</p>
                </div>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <button onclick="window.print()" class="btn btn-primary print-button"
                    style="background-color: #f89d52; border: 1px solid #f89d52">Imprimir Recibo</button>
            </div>
        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>



<script>
    window.addEventListener('beforeprint', function() {
        var colsToHighlight = document.querySelectorAll(
            '.info-section .col-3, .values-section .col-3, .values-section .col-6');
        colsToHighlight.forEach(function(col) {
            col.classList.add('print-background');
        });
    });

    window.addEventListener('afterprint', function() {
        var colsToHighlight = document.querySelectorAll(
            '.info-section .col-3, .values-section .col-3, .values-section .col-6');
        colsToHighlight.forEach(function(col) {
            col.classList.remove('print-background');
        });
    });
</script>
