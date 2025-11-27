<?php 

namespace Omnipay\Momo\Traits;

trait RequestEndPoint
{
    protected function getEndPoint()
    {
        return config('momo.app_env') == 'local' ? 'https://test-payment.momo.vn' : 'https://payment.momo.vn';
    }
}