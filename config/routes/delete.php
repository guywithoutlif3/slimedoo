<?php

use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


return function (App $app) {
    //routing which is responsible for the deleting of users either with ID or username (foreign key is on cascading so it deletes also all coresponding messages) 
    $app->get('/users/delete/{parameter}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $parameter = $args['parameter'];

        $this->get('database')->delete("user", [
            'OR' => [
                'userID' => $parameter,
                'username' => $parameter
            ]
        ]);
        $response->getBody()->write("user: $parameter has been deleted");
        return $response;
    });

    //routing which is responsible for the deleting of messages with id of message used as parameter
    $app->get('/messages/delete/{parameter}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $parameter = $args['parameter'];

        $this->get('database')->delete("message", [
            "AND" => [
                'messageID' => $parameter,
            ]
        ]);
        $response->getBody()->write("message with id $parameter has been deleted");
        return $response;
    });
    // TODO: take userid from session : '/messages/delete/all'
    //$user = $_SESSION[ûser^]
    //routing which is responsible for the deleting of messages with id of message used as parameter
    $app->get('/messages/delete/{user}/all', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $user = $args['user'];
        $this->get('database')->delete(
            "message",
            [
                'userIDfs' => $user
            ]
        );
        $response->getBody()->write("messages from userid: $user has been deleted");
        return $response;
    });
    //routing which is responsible for the deleting of messages with id of message used as parameter
    $app->get('/messages/delete/{user}/{messageid}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $user = $args['user'];
        $user = $_SESSION['userid'];
        $messageid = $args['messageid'];

        $this->get('database')->delete(
            "message",
            [
                'userIDfs' => $user,
                'messageID' => $messageid
            ]
        );
        $response->getBody()->write("message with id $messageid and from userid: $user has been deleted");
        return $response;
    });
};
