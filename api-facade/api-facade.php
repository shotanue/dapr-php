<?php
/**
 * @var Goridge\RelayInterface $relay
 */

use GuzzleHttp\Client;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;
use Spiral\Goridge;
use Spiral\RoadRunner;

ini_set('display_errors', 'stderr');
require 'vendor/autoload.php';

function publishTopic(string $topic, array $message)
{
    (new Client)->post(
        "dapr-endpoint:3500/v1.0/publish/${topic}",
        [
            'form_params' => $message
        ]
    );
}

$app = AppFactory::create();

$app->post('/followers', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    // followers process
    // ...
    // ...

    publishTopic('followerAdded', []);

    $response->getBody()->write('');
    return $response;
});

$worker = new RoadRunner\Worker(new Goridge\StreamRelay(STDIN, STDOUT));
$psr7 = new RoadRunner\PSR7Client($worker);

while ($req = $psr7->acceptRequest()) {
    try {
        $resp = $app->handle($req);
        $psr7->respond($resp);

    } catch (Throwable $e) {
        $psr7->getWorker()->error((string)$e);
    }
}