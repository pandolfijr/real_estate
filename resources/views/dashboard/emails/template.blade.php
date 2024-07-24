<!DOCTYPE html>
<html>

<head>
    <style>
        .item1 {
            grid-area: header;
            background-color: #000000;
        }

        .item2 {
            grid-area: main2;
            background-color: #000000;
        }

        .item3 {
            grid-area: main;
            background-color: #000000;
        }

        .item4 {
            grid-area: right;
            background-color: #000000;
        }

        .item5 {
            grid-area: footer;
            background-color: #ffffff;
        }

        .item6 {
            grid-area: left;
            background-color: #000000;
        }

        .grid-container {
            padding: 0.5em;
            display: grid;
            grid-template-columns: 25% 50% 25%;
            grid-template-areas:
                'header header header'
                'left main2 right'
                'footer footer footer';
        }

        .grid-container>div {
            padding-top: 20px;
            font-size: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .grid-container .item1,
        .item2,
        .item5 {
            text-align: center;
        }

        .grid-container .item1 .logo-download {
            padding-left: 10em;
        }

        .grid-container .item1 .logo-garupa {
            padding-left: 12em;
        }

        .grid-container .item2 {
            text-align: center;
            background-color: #000000;
            line-height: 20px;
            font-size: 28px;
            color: #fff;
        }

        .grid-container .item2 {
            line-height: 1.5em;
            padding-bottom: 1em;
        }

        .grid-container .item2 .hello {
            font-size: 28px;

        }

        .grid-container .item2 .download {
            font-size: 20px;
            color: #fff;
        }

        .grid-container .item2>img {
            display: none;
        }

        .grid-container .item4>img {
            margin-top: -2em;
        }

        .grid-container .item5 {
            font-size: 24px;
            background-color: #fff;
        }

        .grid-container .item5 .principal {
            font-size: 24px;
        }

        .grid-container .item5 .alternativo {
            font-size: 16px;
        }

        .grid-container .item5 .div-item5 {
            margin-top: 1.5em;
        }

        .grid-container .item5 .botao {
            width: 200px;
            height: 48px;
            background-color: #25A58C;
            border-color: #25A58C;
            border-radius: 8px;
            color: white;
        }

        .grid-container .item5 .botao .text {
            font-size: 20px;
        }

        @media (max-width: 500px) {
            .grid-container {
                padding: 0.5em;
                display: grid;
                grid-template-columns: 100%;
                grid-template-areas:
                    'header'
                    'main2'
                    'footer';
            }

            .grid-container .item4>img {
                display: none;
            }

            .grid-container .item4,
            .item6 {
                display: none;
            }

            .grid-container .item2 {
                line-height: 1.3em;
            }

            .grid-container .item2 .download {
                padding-bottom: 5em;
            }

            .grid-container .item2 {
                line-height: 1em;
            }

            .grid-container .item5 .div-item5 {
                margin-top: 1em;
            }

            .grid-container .item5 .principal {
                font-size: 16px;
            }

            .grid-container .item5 .alternativo {
                font-size: 12px;
            }

            .grid-container .item2>img {
                margin-top: 1em;
                display: inline;
                width: 60px;
                height: 68px;
            }

            .grid-container .item1 .logo-download {
                display: none;
            }

            .grid-container .item1 .logo-garupa {
                padding-left: 0em;
            }
        }
    </style>
</head>

<body>
    <div class="grid-container">
        <div class="item1">
            <img class=""
                src="https://renatacorretoradeimoveis.com.br/images_setting/1/logo_menu_1_20230211.png">
        </div>
        <div class="item6"></div>
        <div class="item2">
            <span class="hello"> Atualização de Imóvel | Imobiliária</span><br>

        </div>
        <div class="item4"></div>
        <div class="item5">
            <div class="div-item5">
                <p>
                    <span class="principal">O status do imóvel <b>{{ $referencia }}</b> foi alterado<br>
                        por <b>{{ $usuario }}</b> (<b>{{ $usuario_email }}</b>) | {{ $hora_atual }} </span>
                    </span>
                </p>
            </div>

            <div class="div-item5">
                <p>
                    <span class="alternativo"> O imóvel <b>{{ $descricao_imovel }}</b> que estava
                        com o status <b>{{ $status_anterior }}</b>, foi alterado para <b>{{ $status_atual }}</b></span>
                </p>
                <p>
                    <span class="alternativo"><a href="{{ $link }}"> Clique aqui</a> para visualizar o imóvel. </span>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
