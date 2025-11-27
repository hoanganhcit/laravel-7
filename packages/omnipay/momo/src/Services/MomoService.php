<?php 

namespace Omnipay\Momo\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Omnipay\Momo\Traits\RequestEndPoint;
use Omnipay\Momo\Traits\RequestHash;
use Exception;

class MomoService
{
    use RequestEndPoint;
    use RequestHash;

    protected $requestQrcode = 'captureWallet';

    /**
     * @param array $params
     * @return array 
     * @throws GuzzleException
     */
    public function payConfirm($params)
    {
        Log::debug("------------------ SHOW QRCODE MOMO -----------------");
        $requestId = time() . "";
        $dataPost = $params;
        $params['requestId'] = $requestId;
        $signature = $this->generateHash($params);

        $dataPost['lang'] = 'vi';
        $dataPost['requestId'] = $requestId;
        $dataPost['signature'] = $signature;
        
        return $this->executePayConfrim($dataPost);

        Log::debug("------------------ DONE QRCODE MOMO -----------------");
    }

    /**
     * @param array $params
     * @return array 
     * @throws GuzzleException
     */
    public function queryTransaction($params)
    {
        Log::debug("------------------ SHOW QUERY TRANSACTION MOMO -----------------");
        $requestId = time() . "";
        $dataPost = $params;
        $params['requestId'] = $requestId;

        $signature = $this->generateHash($params);

        $dataPost['lang'] = 'vi';
        $dataPost['requestType'] = $this->requestQrcode;
        $dataPost['requestId'] = $requestId;
        $dataPost['signature'] = $signature;

        return $this->executePayQueryStatus($dataPost);


        Log::debug("------------------ DONE QUERY TRANSACTION MOMO -----------------");
    }
    
    /**
     * @param array $dataPost
     * @return array
     */
    private function executePayConfrim($dataPost)
    {
        try {
            $client = new Client();
            $result = $client->request('POST', $this->getEndPoint() . '/v2/gateway/api/create', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen(json_encode($dataPost)),
                ],
                'json' => $dataPost,
                'timeout' => 300,
            ]);
    
            return json_decode($result->getBody()) ?? [];

        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    /**
     * @param $url
     * @param array $dataPost
     * @return array
     */
    private function executePayQueryStatus($dataPost)
    {
        try {
            $client = new Client();
            $result = $client->request('POST', $this->getEndPoint() . '/v2/gateway/api/query', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen(json_encode($dataPost)),
                ],
                'json' => $dataPost,
                'timeout' => 300,
            ]);
    
            return json_decode($result->getBody()) ?? [];
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    /**
     * @param array $params
     * @return boolean
     */
    public function ipnCheckSignature($params)
    {
        try {
            $signatureUrl = $params['signature'] ?? null;
            $signatureHash = $this->generateHash($params);
    
            if ($signatureUrl == $signatureHash) {
                if ($params['resultCode'] == '0') {
                   return true;
                }
            }

            return false;
        } catch (Exception $e) {
            Log::debug($e);
        }
    }
}