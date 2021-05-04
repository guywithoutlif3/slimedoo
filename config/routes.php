<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $app->get('/', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write('Hello, World!');

        return $response;
    });
    $app->get('/messages', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {

        $data = $this->get('database')->select('message', ['message', 'created']);
        $response->getBody()->write(json_encode($data));
        return $response;
    });    
};
