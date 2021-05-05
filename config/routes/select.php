<?php

use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


return function (App $app) {
    //routing to get all messages
    $app->get('/messages', function (ServerRequestInterface $request, ResponseInterface $response) {
        $data = $this->get('database')->select('message', ['message', 'created', 'userIDfs']);
        $response->getBody()->write(json_encode($data));
        return $response;
    });
    //routing to get all messages sent from a user with the userIDfs
    $app->get('/messages/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $userid = $args['id'];
        $data = $this->get('database')->select(
            'message',
            [
                'message',
                'created',
                'userIDfs'
            ],
            [
                'userIDfs' => $userid
            ]
        );
        $response->getBody()->write(json_encode($data));
        return $response;
    });
    //routing to get all users
    $app->get('/users', function (ServerRequestInterface $request, ResponseInterface $response) {
        $data = $this->get('database')->select('user', ['username', 'prename', 'lastname', 'password']);
        $response->getBody()->write(json_encode($data));
        return $response;
    });

};
