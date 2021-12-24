<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'], '/v1/mocks', function (Request $request, Response $response, $args) {
    $formData = $request->getQueryParams();

    $statusCode = isset($formData['status']) ? (int)$formData['status'] : 200;

    $payLoadData = 'no-data';
    if (isset($formData['size']) && $formData['size'] > 0) {
        $random = '9';
        for ($i = 1; $i < $formData['size']; $i++) {
            $random .= '9';
        }
        $payLoadData = $random;
    }

    if (isset($formData['delay']) && (int)$formData['delay'] > 0) {
        usleep((int)$formData['delay']);
    }

    $format = 'application/json';
    if (isset($formData['format']) && $formData['format'] == 'text') {
        $format = 'text/html';
        $response->getBody()->write($payLoadData);
    } else {
        $response->getBody()->write(json_encode(['payload' => $payLoadData]));
    }

    return $response
        ->withHeader('Content-Type', $format)
        ->withStatus((int)$statusCode);
});


$app->run();
