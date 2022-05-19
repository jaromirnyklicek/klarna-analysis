<?php

use KlarnaAnalysis\GatewayFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$gatewayFactory = new GatewayFactory();
$gateway = $gatewayFactory->create();

$type = $_GET['type'] ?? false;
$success = false;

if ($type === 'return' || $type === 'notify') {
    $response = $gateway->fetchTransaction(['transactionReference' => $_GET['id']])->send();

    $amount = $response->getData()['management']['remaining_authorized_amount'];
    if ($amount > 0) {
        $success = $gateway->capture([
            'transactionReference' => $_GET['id'],
            'amount' => $amount / 100,
        ])->send()->isSuccessful();
    } else {
        $success = true;
    }

}

?>

<html>
<head>
    <title>Klarna Analysis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<p class="text-center p-5">
    <?php echo $success ? 'Order is fully captured, thank you.' : 'Order is not captured, sorry.' ?>
</p>
</body>
</html>

