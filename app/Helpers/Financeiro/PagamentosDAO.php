<?php

namespace App\Helpers\Financeiro;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PagamentosDAO
{

    public function buscarParcelaPorCompetencia(int $competencia)
    {
        try {            
            return DB::connection('mysql2')
                ->table('aluno AS a')
                ->join('inscricao_curso AS ic', 'a.codigo', '=', 'ic.cod_aluno')
                ->join('inscricao_periodo_letivo AS ip', function ($join) {
                    $join->on('ic.matricula', '=', 'ip.matricula')
                         ->on('ic.cod_periodo_letivo_ing', '=', 'ip.cod_periodo_letivo');
                })
                ->join('situacao_aluno AS sa', 'ic.matricula', '=', 'sa.matricula')
                ->join('parcelas_pgto AS p', 'ip.codigo', '=', 'p.cod_inscricao_periodo_letivo')
                ->select([
                    'p.codigo AS cod_parcela',
                    DB::raw("truncate(p.valor_pagar, 2) AS valor_pagar"),
                    'a.cpf_resp_finan',
                    'a.nome',
                ])
//                ->where('a.nome', '=', $nome)
//                ->where('a.cpf_resp_finan', '=', $cfpRespFinan)
                ->whereNotIn('sa.cod_situacao_atual', [2, 3, 4, 5, 6, 7, 17])
                ->where('p.tipo', '=', 1)
                ->whereRaw('EXTRACT(YEAR_MONTH FROM p.data_vencimento) = ?', [$competencia])
                ->whereNull('p.cod_renegociacao')
                ->where('sa.codigo', '=', function (Builder $query) {
                    $query->selectRaw("max(sa1.codigo)")
                          ->from('situacao_aluno AS sa1')
                          ->whereColumn('sa1.matricula', 'ic.matricula');                    
                })
                ->orderBy('a.nome')
                ->get()
                ->toArray();
//                ->toSql();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }        
    }

    public function baixarParcelasNoPrisma($item)
    {
        try {
            $sql = "UPDATE aluno AS a INNER JOIN inscricao_curso AS ic ON a.codigo = ic.cod_aluno
                                      INNER JOIN inscricao_periodo_letivo AS ip ON ic.matricula = ip.matricula
                                                                                   AND ic.cod_periodo_letivo_ing = ip.cod_periodo_letivo
                                      INNER JOIN parcelas_pgto AS pp ON ip.codigo = pp.cod_inscricao_periodo_letivo
                    SET pp.data_pagamento = :param1,
                        pp.cod_forma_pagamento = :param2,
                        pp.valor_pago = :param3,
                        pp.data_credito = :param4
                    WHERE pp.codigo = :param5
                          and a.nome = :param6
                          and a.cpf_resp_finan = :param7";
            return DB::update($sql, [
                'param1' => $item->cobranca->dataSituacao,
                'param2' => 43,
                'param3' => floatval($item->cobranca->valorTotalRecebido),
                'param4' => $item->cobranca->dataSituacao,
                'param5' => intval($item->cobranca->seuNumero),
                'param6' => $item->cobranca->pagador->nome,
                'param7' => $item->cobranca->pagador->cpfCnpj,
            ]);
        } catch (Exception $e) {
          throw new Exception($e->getMessage());
        }
      }
}