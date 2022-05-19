<?php
declare(strict_types=1);

use KlarnaAnalysis\GatewayFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$gatewayFactory = new GatewayFactory();
$gateway = $gatewayFactory->create();

if ($_GET['pay'] ?? false) {
    $data = [
        'amount' => 100,
        'tax_amount' => 20,
        'currency' => 'EUR',
        'locale' => 'de-AT',
        'purchase_country' => 'AT',
        'merchant_reference1' => rand(1000, 10000), //ourTxId

        'notify_url' => 'http://localhost:10001/hook.php?type=notify&id={checkout.order.id}',
        'return_url' => 'http://localhost:10001/hook.php?type=return&id={checkout.order.id}',
        'terms_url' => 'http://localhost:10001/hook.php?type=terms', // obchodni podminky
        'validation_url' => 'https://localhost:10001/hook.php?type=validate',

        'items' => [
            [
                'type' => 'physical',
                'name' => 'Shirt',
                'quantity' => 1,
                'tax_rate' => 25,
                'price' => 100,
                'unit_price' => 100,
                'total_tax_amount' => 20,
            ],
        ],
    ];

    $response = $gateway->authorize($data)
        ->send()
        ->getData();
    header('location: /confirm.php?id=' . $response['order_id']);
}

?>

<html>
    <head>
        <title>Klarna Analysis</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
    <p class="text-center p-5">
        <a href="/index.php?pay=1" class="btn btn-primary">Pay 100 €</a>
    </p>
    </body>
</html>
