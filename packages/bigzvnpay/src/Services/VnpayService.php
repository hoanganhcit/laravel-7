<?php

namespace Bigzvnpay\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Bigzvnpay\Traits\RequestHash;
use Exception;

class VnpayService
{
    use RequestHash;

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function getVnpUrlConfirm($params)
    {
        Log::debug("------------------ SHOW Url VNPay -----------------");
        $vnpUrl = $this->generateHash($params);
        return $vnpUrl;

        Log::debug("------------------ DONE Url VNPay -----------------");
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
