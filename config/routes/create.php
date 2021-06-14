<?php
//includes Medoo + Slim Framework, and added PHP standard reccomended http Responde and Request Interfaces 
use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

//functions for creating stuff in the DB are Here
return function (App $app) {
    //TODO: maybe this needs to be adjusted but i dont think so, have to Test
    //adds a message to the table and adds the corresponding User whom sent the message
    $app->post('/messages/add', function (ServerRequestInterface $request, ResponseInterface $response) {
        // Testing with curl:   curl -X POST -F 'userid=1' -F 'message=Hallo Welt' 'http://10.80.4.43/messages/add'
        $data = $request->getParsedBody(); //gets an Array of all the Values like: userid message and so on
        if (isset($data['userIDfs']) && isset($data['message']) && isset($data['userIDfs'])&& isset($data['recieverID'])) { //checks if all the important values are set
            $this->get('database')->insert( //Medoo Syntax for the insert of SQL with the two values we tested and the time at the Moment
                'message',
                [
                    'message' => $data['message'],
                    'created' => Medoo::raw("NOW()"),
                    'userIDfs' => $data['userIDfs'],
                    'recieverID' =>$data['recieverID']
                ]

            );
            $response->getBody()->write("succes"); //for Testing purposes if the insert was succeful
        } else {
            $response->getBody()->write("im missing smt"); //for Testing purposes if the insert was succeful
        }
        return $response;
    });


    //routing which is responsible for the adding of users
    // Testing with curl :      curl -X POST -F 'username=cptrio' -F 'prename=Yves' -F 'lastname=huber' -F 'password=imdumblmao' 'http://10.80.4.43/users/add'
    $app->post('/users/add', function (ServerRequestInterface $request, ResponseInterface $response) {
        $data = $request->getParsedBody(); //gets array with values
        if (isset($data['username']) && $data['username']!= "" && isset($data['prename']) && $data['prename']!= "" && isset($data['lastname'])&&isset($data['lastname']) && $data['lastname']!= "" && isset($data['password'])&&$data['lastname']!= "") { //checks for all values needed
            $this->get('database')->insert( //Syntax for Medoo insert with values & hashed password
                'user',
                [
                    'username' => $data['username'],
                    'prename' => $data['prename'],
                    'lastname' => $data['lastname'],
                    'password' => hash('ripemd160', $data['password']) //hashed passwort from register with ripmd160
                ]
            );
            $response->getBody()->write("user has been inserted"); //for Testing
        } else {
            $response->getBody()->write("im missing smt"); // for Testing 
        }
        return $response;
    });
    //Route respondible for adding Friend to Friendlist therefor creating a new Friendlist where UserID_fs = logged in and FriendID = input from vue4
    $app->post('/friendlist/add', function (ServerRequestInterface $request, ResponseInterface $response) {
        $data = $request->getParsedBody(); //gets array with values
        if (isset($data['UserID_fs']) && isset($data['FriendID'])) { //checks for all values needed
            $this->get('database')->insert( //Syntax for Medoo insert with values & hashed password
                'friendlist',
                [
                    'UserID_fs' => $data['UserID_fs'],
                    'FriendID' => $data['FriendID']
                ]
            );
            $response->getBody()->write("friend has been inserted"); //for Testing
        } else {
            $response->getBody()->write("im missing smt"); // for Testing 
        }
        return $response;
    });
};
