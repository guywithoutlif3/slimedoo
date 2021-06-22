<?php
//includes Medoo + Slim Framework, and added PHP standard reccomended http Responde and Request Interfaces 
use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

//all routes to Update are here :D
return function (App $app) {
    //route with the usage of editing a username of the currently logged in user
    $app->post('/users/update/user', function (ServerRequestInterface $request, ResponseInterface $response) {

        $session =  new \SlimSession\Helper();
        $user = $session->get("user");
        $data = $request->getParsedBody();


        if (isset($data['username']) && strlen($data['username']) > 0 && isset($data['prename']) && strlen($data['prename']) > 0 && isset($data['lastname']) && strlen($data['lastname']) > 0) { // validate and check if values set
            $this->get('database')->update(
                'user',
                [
                    'username' => htmlspecialchars($data['username']), //Use new Username thats checked and validated to update
                    'prename' =>  htmlspecialchars($data['prename']),
                    'lastname' =>  htmlspecialchars($data['lastname'])
                            
                ],
                [
                    'userID' => $user //use Logged in User for Change Name
                ]

            );
            //for Testing: //$response->getBody()->write("succes");
        } else {
            //for testing:
            // $response->getBody()->write("im missing smt");
            //var_dump($data);
        }
        return $response;
    });
    //route with the usage of editing the password of the currently logged in user
    $app->post('/users/update/password', function (ServerRequestInterface $request, ResponseInterface $response) {

        $session =  new \SlimSession\Helper();
        $user = $session->get("user");
        $data = $request->getParsedBody();


        if (isset($data['password']) && strlen($data['password']) > 0) { //check if Values are set 
            $this->get('database')->update(
                'user',
                [
                    'password' => hash('ripemd160',$data['password']) //hashed password and updates it ( i think so )

                ],
                [
                    'userID' => $user //uses the current logged in User to change the Password 
                ]

            );
            $response->getBody()->write("succes");
        } else {
            $response->getBody()->write("im missing smt");
            var_dump($data);
        }
        return $response;
    });
    /* I took it out for the Time beeing because i dont know if i want to be able to edit messages 
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
    });*/

};
