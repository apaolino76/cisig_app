<?php

namespace App\Imports;

use App\Models\Velho\Pagamento4IesArquivo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Pagamento4IesArquivoImport implements ToModel, WithHeadingRow
{
    use Importable;
    
    public function model(array $row)
    {
        return new Pagamento4IesArquivo([
            'codigo' => $row['id_parcela'],
            'cpf' => $row['cpf'],
            'nome' => $row['aluno'],
            'fourIes_id' => $row['id_principia'],
            'data_vencimento'=> $row['data_baixa'],
            'valor_original' => $row['principal'],
            'data_pagamento' => $row['data_baixa'],
            'valor_pago' => $row['recebido'],
        ]);
    }
}
