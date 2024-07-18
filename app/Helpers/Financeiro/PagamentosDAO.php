<?php

namespace App\Helpers\Financeiro;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PagamentosDAO
{

    public function buscarParcelaPorAlunoECompetencia(int $competencia, string $nome, string $cfpRespFinan)
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
                ->where('a.nome', '=', $nome)
                ->where('a.cpf_resp_finan', '=', $cfpRespFinan)
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
                ->get();
//                ->toSql();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }        
    }
}