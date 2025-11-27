<?php 

namespace Omnipay\Momo\Traits;

trait RequestHash
{
    protected $code_hash = 'sha256';

    protected function generateHash($params)
    {
        ksort($params);
        $rawHash = "accessKey=" . config('momo.access_key');
        if (!empty($params)) {
            unset($params['signature']);
            foreach($params as $key => $value) {
                $rawHash = $rawHash . '&' . $key . '=' . $value;
            }
        }

        return hash_hmac($this->code_hash, $rawHash, config('momo.secret_key'));
    }
}