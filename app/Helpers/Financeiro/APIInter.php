<?php // Code within app\Helpers\Helper.php

namespace App\Helpers\Financeiro;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use PhpParser\JsonDecoder;
use stdClass;

class APIInter
{
    private $paramCC = 'x-conta-corrente: 350416990';

    private $pagamentosDAO;

    public function __construct(PagamentosDAO $pagamentos)
    {
        $this->pagamentosDAO = $pagamentos;
    }

    private function consumirServicosInter($url, $header, $method, $postFields = null): stdClass | array | Exception
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_SSLCERT, storage_path(env('INTER_BANK_SSL_CERT')));
            curl_setopt($ch, CURLOPT_SSLKEY, storage_path(env('INTER_BANK_SSL_KEY')));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if ($method === 'POST') {
                //curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            }
            $result  = curl_exec($ch);
//                var_dump($result);
            $error   = curl_error($ch);
//                var_dump($error);
            $errorno = curl_errno($ch);
//                var_dump($errorno);
            curl_close ($ch);
            if ($errorno > 0) {
                throw new Exception($error);
            }                    
            $obj = json_decode($result);
            return $obj;                
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function pegarTokenDeAcesso(): stdClass | Exception
    {
        try {
            $postFields = http_build_query(array(
                'client_id'     => env('INTER_BANK_CLIENT_ID'), 
                'client_secret' => env('INTER_BANK_CLIENT_SECRET'), 
                'scope'         => 'boleto-cobranca.write boleto-cobranca.read',
                'grant_type'    => 'client_credentials'
                ));
            $url    = "https://cdpj.partners.bancointer.com.br/oauth/v2/token";
            $header = array('Content-Type: application/x-www-form-urlencoded');
            return $this->consumirServicosInter($url, $header, "POST", $postFields);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
/*        
        try {
            return Http::withOptions([
                    'ssl_key' => [
                        storage_path(env('INTER_BANK_SSL_CERT')),
                        storage_path(env('INTER_BANK_SSL_KEY')),
                    ]
                ])
                ->asForm()
                ->post('https://cdpj.partners.bancointer.com.br/oauth/v2/token', [
                    'client_id'     => env('INTER_BANK_CLIENT_ID'), 
                    'client_secret' => env('INTER_BANK_CLIENT_SECRET'), 
                    'grant_type'    => 'client_credentials',
                    'scope'         => 'boleto-cobranca.write boleto-cobranca.read'
                ])
                ->throw()
                ->json();
        } catch (Exception $e) {
            return [
                'error' => "Erro ao acessar a API: {$e->getMessage()}."
            ];
        }
*/
    }

    public function pegarSumarioDePagamentosNoAppInter($bearerToken, $parametros)
    {
        try {
            $bearer      = "Authorization: Bearer " . $bearerToken;
            $queryString = http_build_query($parametros);
            $url         = "https://cdpj.partners.bancointer.com.br/cobranca/v3/cobrancas/sumario?". $queryString;
            $header      =  array($bearer, $this->paramCC, "Content-Type: application/json");
            return $this->consumirServicosInter($url, $header, "GET");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function totalizarBoletosPorNegocio(string $token, int $competencia, array $pagamentos): array
    {
        $array = [];
//        var_dump($pagamentos);
        foreach ($pagamentos as $pagamento) {
            $parametros = [
                "dataInicial"   => date('Y-m-01', strtotime(substr($competencia, 0, 4) . "-" . substr($competencia, 4, 2))),
                "dataFinal"     => date('Y-m-t', strtotime(substr($competencia, 0, 4) . "-" . substr($competencia, 4, 2))),
                "situacao"      => $pagamento->situacao,
                "tipoOrdenacao" => 'ASC',
            ];
            $result  = $this->pegarBoletosNoAppInter($token, $parametros);
            $array[] = $this->contarBoletosPorNegocio($token, $competencia, $parametros, $result);
        }
//        var_dump($array);
        return $array;
    }

    private function pegarBoletosNoAppInter($bearerToken, $parametros)
    {
        try {
            $bearer      = "Authorization: Bearer " . $bearerToken;
            $queryString = http_build_query($parametros);
            $url         = "https://cdpj.partners.bancointer.com.br/cobranca/v3/cobrancas?". $queryString;
            $header      =  array($bearer, $this->paramCC, "Content-Type: application/json");
            return $this->consumirServicosInter($url, $header, "GET");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function contarBoletosPorNegocio(string $token, int $competencia, array $parametros, stdClass $result): array
    {
//        var_dump($parametros["situacao"], $result->totalPaginas);
        $quant = 0;
        $valor = 0;
        for ($i = 0; $i <= $result->totalPaginas - 1; $i++) {
            $parametros["paginacao.paginaAtual"] = $i;
            $items = $this->pegarBoletosNoAppInter($token, $parametros);
            foreach ($items->cobrancas as $item) {
                if (floatval($item->cobranca->valorNominal) != 2.50 ) {
//                    var_dump($parametros["situacao"], $item->cobranca->pagador->nome, $item->cobranca->pagador->cpfCnpj, $item->cobranca->valorNominal);
                    $aluno = $this->pagamentosDAO->buscarParcelaPorAlunoECompetencia($competencia, $item->cobranca->pagador->nome, $item->cobranca->pagador->cpfCnpj);
                    if($aluno->count() > 0){
                        $quant++;
                        $valor += $item->cobranca->valorNominal;
                    }
                }
            }
        }
        return [
            'situacao'   => $parametros["situacao"],
            'quantidade' => $quant,
            'valor'      => $valor,
        ];
    }
}