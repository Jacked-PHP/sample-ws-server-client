<?php

require_once __DIR__ . '/vendor/autoload.php';

use Kanata\ConveyorServerClient\Client;

$client = new Client([
    'port' => 8585,
    'onMessageCallback' => function ($client, $message) {
        echo $message . PHP_EOL;
        $parsedMessage = json_decode($message, true);
        if ('hello' === $parsedMessage['data']) {
            $client->send(json_encode([
                'action' => 'fanout-action',
                'data' => 'hello (from the bot)',
            ]));
        }
    },
    'channel' => 'sample-channel',
    'listen' => ['fanout-action'],
]);
$client->connect();
