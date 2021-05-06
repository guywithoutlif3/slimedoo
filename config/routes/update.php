<?php

use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


return function (App $app) {
    //route with the usage of editing a username of the currently logged in user
    $app->post('/users/update/username', function (ServerRequestInterface $request, ResponseInterface $response) {

        $session =  new \SlimSession\Helper();
        $user = $session->get("user");
        $data = $request->getParsedBody();


        if (isset($data['username']) && strlen($data['username']) > 0) {
            $this->get('database')->update(
                'user',
                [
                    'username' => $data['username']

                ],
                [
                    'userID' => $user
                ]

            );
            $response->getBody()->write("succes");
        } else {
            $response->getBody()->write("im missing smt");
            var_dump($data);
        }
        return $response;
    });
    //route with the usage of editing the password of the currently logged in user
    $app->post('/users/update/password', function (ServerRequestInterface $request, ResponseInterface $response) {

        $session =  new \SlimSession\Helper();
        $user = $session->get("user");
        $data = $request->getParsedBody();


        if (isset($data['password']) && strlen($data['password']) > 0) {
            $this->get('database')->update(
                'user',
                [
                    'password' => $data['password']

                ],
                [
                    'userID' => $user
                ]

            );
            $response->getBody()->write("succes");
        } else {
            $response->getBody()->write("im missing smt");
            var_dump($data);
        }
        return $response;
    });
    //route with the usage of editing a message of the user TODO: make the Frontend in a manner so the parameter id here is the message the user wants to update
    $app->post('/messages/update/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {

        $session =  new \SlimSession\Helper();
        $user = $session->get("user");
        $data = $request->getParsedBody();
        $id = $args['id'];

        if (isset($data['message']) && strlen($data['message']) > 0) {
            $this->get('database')->update(
                'message',
                [
                    'message' => $data['message'],
                    'created' => Medoo::raw("NOW()"),
                    'userIDfs' => $user
                ],
                [
                    'userIDfs' => $user,
                    'messageID' => $id
                ]

            );
            $response->getBody()->write("succes");
        } else {
            $response->getBody()->write("im missing smt");
            var_dump($data);
        }
        return $response;
    });

};
