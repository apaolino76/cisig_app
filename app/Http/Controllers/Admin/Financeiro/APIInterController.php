<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Helpers\Financeiro\APIInter;
use App\Helpers\Financeiro\PagamentosDAO;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isNull;

class APIInterController extends Controller
{
    private $appInter;
    private $pagamentosDAO;

    public function __construct(APIInter $apiService, PagamentosDAO $pagamentosDAO)
    {
        $this->appInter      = $apiService;
        $this->pagamentosDAO = $pagamentosDAO;
    }

    public function index(?string $reference = null): View | Response
    {
        try {
            $competencia    = !isset($reference) ? date("Ym") : $reference;
            $competenciaFrt = substr($competencia, 4, 2) . "/" . substr($competencia, 0, 4);
            $parcelas       = $this->pagamentosDAO->buscarParcelaPorCompetencia(intval($competencia));
            $pagNegocio     = $this->appInter->totalizarBoletosPorNegocio(intval($competencia), $parcelas);
            return view('admin.financeiro.bancoInter.index', [
                'competencia'    => $competencia,
                'competenciaAnt' => Util::montaCompetencia($competencia, "-"),
                'competenciaFrt' => "Competência : {$competenciaFrt}",
                'competenciaPos' => Util::montaCompetencia($competencia, "+"),
                'pagamentos'     => $pagNegocio,
            ]);        
        } catch (Exception $e) {
            return redirect()
                ->route('admin.home')
                ->with(['pErro' => $e->getMessage()]);
        }
    }

    public function baixar(int $reference): Response
    {
        try {
            $parcelas = $this->pagamentosDAO->buscarParcelaPorCompetencia($reference);
            $result   = $this->appInter->pegarBoletosPagosNoAppInter($reference, $parcelas);
            var_dump($result);
/*            return redirect()
                ->route('admin.financeiro.bancoInter.baixar', ['reference' => $reference])
                ->with(['pSucesso' => "O token foi atribuído para a competência {$reference}!"]);
*/                
//            return response()->json(['success' => true, 'message' => "O token {$token->access_token} foi atribuído para a competência {$reference}!"]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.financeiro.bancoInter.baixar', ['reference' => $reference])
                ->with(['pErro' => $e->getMessage()]);                    
//            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
