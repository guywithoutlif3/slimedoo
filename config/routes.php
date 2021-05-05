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
    //routing to get all messages sent from a user
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
        }else{
            $response->getBody()->write("im missing smt");
        }
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
    //routing which is responsible for the deleting of users either with ID or username (foreign key is on cascading so it deletes also all coresponding messages) 
    $app->get('/users/delete/{parameter}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $parameter = $args['parameter'];
        
        $this->get('database')->delete("user",[ 'OR' => [
                'userID'=> $parameter,
                'username' => $parameter
            ]
        ]);
        $response->getBody()->write("user: $parameter has been deleted");
        return $response;
    });
    //routing which is responsible for the deleting of messages with id of message used as parameter
    $app->get('/messages/delete/{parameter}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $parameter = $args['parameter'];
        
        $this->get('database')->delete("message", ["AND" =>[
                'messageID'=> $parameter,
            ]
        ]);
        $response->getBody()->write("message with id $parameter has been deleted");
        return $response;
    });
      //routing which is responsible for the deleting of messages with id of message used as parameter
      $app->get('/messages/delete/{user}/all', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $user = $args['user'];
        $this->get('database')->delete("message", [
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

        $this->get('database')->delete("message", [
                'userIDfs' => $user,
                'messageID'=> $messageid
            ]
        );
        $response->getBody()->write("message with id $messageid and from userid: $user has been deleted");
        return $response;
    });

    $app->get("/foo", function ($request, $response) {
        $response->getBody()->write(json_encode($this->get('session')));
        return $response;
    });  
  
};
