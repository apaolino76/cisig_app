<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Helpers\Financeiro\APIInter;
use App\Helpers\Financeiro\PagamentosDAO;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function PHPUnit\Framework\isNull;

class APIInterController extends Controller
{
    private $appInter;

    public function __construct(APIInter $apiService)
    {
        $this->appInter = $apiService;
    }

    public function index(?string $reference = null): View
    {
        $competencia    = !isset($reference) ? date("Ym") : $reference;
        $competenciaFrt = substr($competencia, 4, 2) . "/" . substr($competencia, 0, 4);
        
        $parameters = [
            "dataInicial"   => date('Y-m-01', strtotime(substr($competencia, 0, 4) . "-" . substr($competencia, 4, 2))),
            "dataFinal"     => date('Y-m-t', strtotime(substr($competencia, 0, 4) . "-" . substr($competencia, 4, 2))),
            "tipoOrdenacao" => 'ASC',
        ];
        
        $response   = $this->appInter->pegarTokenDeAcesso();
        $token      = $response->access_token;    
        $pagamentos = $this->appInter->pegarSumarioDePagamentosNoAppInter($token, $parameters);
        $pagNegocio = $this->appInter->totalizarBoletosPorNegocio($token, intval($competencia), $pagamentos);
                
        return view('admin.financeiro.bancoInter.index', [
            'competencia'    => $competencia,
            'competenciaAnt' => Util::montaCompetencia($competencia, "-"),
            'competenciaFrt' => "Competência : {$competenciaFrt}",
            'competenciaPos' => Util::montaCompetencia($competencia, "+"),
            'pagamentos'     => $pagNegocio,
        ]);
    }
}
