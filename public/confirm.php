<?php
use KlarnaAnalysis\GatewayFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$gatewayFactory = new GatewayFactory();
$gateway = $gatewayFactory->create();

$response = $gateway->fetchTransaction(['transactionReference' => $_GET['id']])->send();

echo $response->getData()['checkout']['html_snippet'];
