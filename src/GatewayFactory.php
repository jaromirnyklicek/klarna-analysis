<?php
declare(strict_types=1);

namespace KlarnaAnalysis;

use MyOnlineStore\Omnipay\KlarnaCheckout\Gateway;
use Omnipay\Omnipay;

class GatewayFactory
{
    public function create(): Gateway
    {
        $gateway = Omnipay::create(Gateway::class);
        $gateway->initialize([
            'username' => 'PK57421_1b5a2760d1f5',
            'secret' => 'b99JkHawiZ11aQIJ',
            'api_region' => Gateway::API_VERSION_EUROPE,
            'testMode' => true
        ]);

        return $gateway;
    }
}
