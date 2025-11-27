<?php

namespace Bigzvnpay\Traits;

trait RequestHash
{
    protected $code_hash = 'sha512';

    protected function generateHash($params)
    {
        ksort($params);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($params as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_url = config('vnpay.vnp_url') . "?" . $query;
        $vnp_HashSecret = config('vnpay.vnp_hash_secret');
        if (!empty($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac($this->code_hash, $hashdata, $vnp_HashSecret);
            $vnp_url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_url;
    }
}
