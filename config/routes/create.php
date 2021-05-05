<?php

use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


return function (App $app) {
    //adds a message to the table and adds the corresponding User whom sent the message
    $app->post('/messages/add', function (ServerRequestInterface $request, ResponseInterface $response) {
        //curl -X POST -F 'userid=1' -F 'message=Hallo Welt' 'http://10.80.4.43/messages/add'
        $data = $request->getParsedBody();
        if (isset($data['userid']) && isset($data['message'])) {
            $this->get('database')->insert(
                'message',
                [
                    'message' => $data['message'],
                    'created' => Medoo::raw("NOW()"),
                    'userIDfs' => $data['userid']
                ]

            );
            $response->getBody()->write("succes");
        } else {
            $response->getBody()->write("im missing smt");
        }
        return $response;
    });
    //routing which is responsible for the adding of users
    //curl -X POST -F 'username=cptrio -F 'prename=Yves' -F 'lastname=huber' -F 'password=imdumblmao' 'http://10.80.4.43/users/add'

    $app->post('/users/add', function (ServerRequestInterface $request, ResponseInterface $response) {
        $data = $request->getParsedBody();
        if (isset($data['username']) && isset($data['prename']) && isset($data['lastname']) && isset($data['password'])) {
            $this->get('database')->insert(
                'user',
                [
                    'username' => $data['username'],
                    'prename' => $data['prename'],
                    'lastname' => $data['lastname'],
                    'password' => $data['password']
                ]
            );
            $response->getBody()->write("user has been inserted");
        } else {
            $response->getBody()->write("im missing smt");
        }
        return $response;
    });
};
