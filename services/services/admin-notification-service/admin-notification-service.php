<?php
/**
 * @var Goridge\RelayInterface $relay
 */

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;
use Spiral\Goridge;
use Spiral\RoadRunner;

ini_set('display_errors', 'stderr');
require '../../vendor/autoload.php';

$app = AppFactory::create();

$app->post('/userCreated', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('admin!!!');
    return $response;
});

$app->get('/dapr/config', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    return $response;
});

$app->get('/dapr/subscribe', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write(json_encode(['userCreated'], JSON_THROW_ON_ERROR, 512));
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