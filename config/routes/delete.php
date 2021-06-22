<?php
//includes Medoo + Slim Framework, and added PHP standard reccomended http Responde and Request Interfaces 
use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


//functions for deleting stuff in the DB are Here
return function (App $app) {

    //routing which is responsible for the deleting of users either with ID or username (foreign key is on cascading so it deletes also all coresponding messages) 
    $app->get('/users/delete', function (ServerRequestInterface $request, ResponseInterface $response, array $args) { //takes a parameter for deleting with {}
        $session =  new \SlimSession\Helper();
        $userid = $session->get("user");

        $this->get('database')->delete("user",  //medoo Syntax with paramter as values
             [
                'userID' => $userid,
             ]);
    $response->getBody()->write("user has been deleted"); //for testing
        return $response;
    });
    //routing which is responsible for the deleting of messages with id of message used as parameter (All messages)
    $app->get('/messages/delete/all', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $session =  new \SlimSession\Helper(); //Slim Session to save User, i dont know if this is needed actually ;-;
        $user = $session->get("user");
        if (isset($user)) {
            $this->get('database')->delete(
                "message",
                [
                    'userIDfs' => $user
                ]
            );
            $response->getBody()->write("messages from userid:", $this->get("session")["user"], " has been deleted");
        } else {
             $response->getBody()->write("your not logged in");
        }


        return $response;
    });
    
    /*  //routing which is responsible for the deleting of messages with id of message used as parameter
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
    */
    //routing which is responsible for the deleting of messages with id of message used as parameter
    /*
    $app->get('/messages/delete/{messageid}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $session =  new \SlimSession\Helper();
        $user = $session->get("user");
        $messageid = $args['messageid'];

        $this->get('database')->delete(
            "message",
            [
                'userIDfs' => $user,
                'messageID' => $messageid
            ]
        );
        $response->getBody()->write("message with id $messageid and from userid:", $this->get("session")["user"], " has been deleted");
        return $response;
    });
    */
};
