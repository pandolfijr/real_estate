<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Utils extends Model
{
    public static function limpaCpfCnpjCep($valor)
    {
        $valor = preg_replace('/[^0-9]/', '', $valor);
        return $valor;
    }

    public static function mascaraCelular($numero)
    {
        $numero = "(" . substr($numero, 0, 2) . ") " . substr($numero, 2, -4) . "-" . substr($numero, -4);
        // primeiro substr pega apenas o DDD e coloca dentro do ()
        // segundo subtr pega os números do 3º até faltar 4, insere o hífen
        // ultimo pega apenas o 4 ultimos digitos
        return $numero;
    }

    public static function mascaraValor($valor)
    {
        // $valor_formatado = number_format($valor, 2);
        $valor_formatado = number_format($valor, 2, ',', '.');
        return $valor_formatado;
    }
    public static function trataValor($valor)
    {
        $valor_tratado = str_replace(".", "", $valor);
        $valor_tratado = str_replace(",", ".", $valor_tratado);
        return $valor_tratado;
    }

    public static function validateValue($number)
    {
        return filter_var($number, FILTER_VALIDATE_INT) !== false;
    }

    public static function quantidade()
    {
        return [
            "1" => "1",
            "2" => "2",
            "3" => "3",
            "4" => "4",
            "5" => "5",
            "6" => "6",
            "7" => "7",
            "8" => "8",
            "9" => "9",
            "10" => "10"
        ];
    }

    public static function statusImovel($input): string
    {
        $status = [
            "1" => "Disponível",
            "2" => "Vendido",
            "3" => "Alugado",
            "4" => "Indisponível"
        ];
        return $status[$input];
    }

    public static function situacaoRegistro(): array
    {
        return [
            "1" => "Ativos",
            "2" => "Inativos",
            "3" => "Todos"
        ];

    }

    public static function getAcronymByPropertyType($type_id)
    {
        $properties_type = collect([
            ['id' => 1, 'descricao' => "Apartamento", 'sigla' => "APA"],
            ['id' => 2, 'descricao' => "Área", 'sigla' => "ARE"],
            ['id' => 3, 'descricao' => "Breve Lançamento", 'sigla' => "BRL"],
            ['id' => 4, 'descricao' => "Casa", 'sigla' => "CAS"],
            ['id' => 5, 'descricao' => "Casa em Condomínio", 'sigla' => "CAC"],
            ['id' => 6, 'descricao' => "Casa e Comércio", 'sigla' => "CCO"],
            ['id' => 7, 'descricao' => "Chácara", 'sigla' => "CHA"],
            ['id' => 8, 'descricao' => "Comercial", 'sigla' => "COM"],
            ['id' => 9, 'descricao' => "Fazenda", 'sigla' => "FAZ"],
            ['id' => 10, 'descricao' => "Flat", 'sigla' => "FLA"],
            ['id' => 11, 'descricao' => "Galpão", 'sigla' => "GAL"],
            ['id' => 12, 'descricao' => "Hotel", 'sigla' => "HOT"],
            ['id' => 13, 'descricao' => "Ilha", 'sigla' => "ILH"],
            ['id' => 14, 'descricao' => "Indústria", 'sigla' => "IND"],
            ['id' => 15, 'descricao' => "Lançamento", 'sigla' => "LAN"],
            ['id' => 16, 'descricao' => "Loja", 'sigla' => "LOJ"],
            ['id' => 17, 'descricao' => "Lote", 'sigla' => "LOT"],
            ['id' => 18, 'descricao' => "Prédio", 'sigla' => "PRE"],
            ['id' => 19, 'descricao' => "Pronto para Morar", 'sigla' => "PPM"],
            ['id' => 20, 'descricao' => "Rancho", 'sigla' => "RAN"],
            ['id' => 21, 'descricao' => "Sala Comercial", 'sigla' => "SAC"],
            ['id' => 22, 'descricao' => "Sítio", 'sigla' => "SIT"],
            ['id' => 23, 'descricao' => "Sobrado", 'sigla' => "SOB"],
            ['id' => 24, 'descricao' => "Terreno", 'sigla' => "TER"],
        ]);

        $property = $properties_type->firstWhere('id', $type_id);

        return $property['sigla'] ?? null;
    }

    /**
     *
     * @param string $input
     * @return string
     */
    public static function formatDate(string $input): string
    {
        if ($input) {
            $date = Carbon::createFromFormat('Y-m-d', $input);
            return $date->format('d/m/Y') ?? null;
        }
        return null;
    }

    /**
     *
     * @param string $cpf
     * @return string
     */
    public static function formatCpf(string $cpf): string
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        if (strlen($cpf) !== 11) {
            return 'CPF inválido';
        }
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    /**
     *
     * @param string $cep
     * @return string
     */
    public static function formatCep(string $cep): string
    {
        $cep = preg_replace('/\D/', '', $cep);
        if (strlen($cep) !== 8) {
            return 'CEP inválido';
        }
        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $cep);
    }
}
