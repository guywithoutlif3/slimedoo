<?php

use Medoo\Medoo;
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
    //routing to get all messages
    $app->get('/messages', function (ServerRequestInterface $request, ResponseInterface $response) {
        $data = $this->get('database')->select('message', ['message', 'created', 'userIDfs']);
        $response->getBody()->write(json_encode($data));
        return $response;
    });
    //routing to get all users
    $app->get('/users', function (ServerRequestInterface $request, ResponseInterface $response) {
        $data = $this->get('database')->select('user', ['username', 'prename', 'lastname', 'password']);
        $response->getBody()->write(json_encode($data));
        return $response;
    });
    //adds a message to the table and adds the corresponding User whom sent the message
    $app->get('/messages/add/{msg}/{userid}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $msg = $args['msg'];
        $userid = $args['userid'];
        $this->get('database')->insert(
            'message',
            [
                'message' => $msg,
                'created' => Medoo::raw("NOW()"),
                'userIDfs' => $userid
            ]
        );
        $response->getBody()->write("message has been inserted");
        return $response;
    });
    //routing which is responsible for the adding of users
    $app->get('/users/add/{username}/{prename}/{lastname}/{password}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $username = $args['username'];
        $prename = $args['prename'];
        $lastname = $args['lastname'];
        $password = $args['password'];
        $this->get('database')->insert(
            'user',
            [
                'username' => $username,
                'prename' => $prename,
                'lastname' => $lastname,
                'password' => $password
            ]
        );
        $response->getBody()->write("user has been inserted");
        return $response;
    });
};
