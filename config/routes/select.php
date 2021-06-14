<?php
//includes Medoo + Slim Framework, and added PHP standard reccomended http Responde and Request Interfaces 
use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


//all the Select routes are here
//TODO: might have to add some :(
return function (App $app) {
    //routing to get all messages sent to clicked user from Logged in User
    $app->get('/messages/reciever/{recieverID}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $session =  new \SlimSession\Helper();
        $userid = $session->get("user");
        $recieverID = $args['recieverID'];
        $data = $this->get('database')->select( //medoo syntax to get all messages with value
            'message',
            [
                'messageID',
                'message',
                'created',
                'userIDfs',
                'recieverID'
            ],
            [
                'userIDfs' => $userid, //get session ID from Logged in User (Hopefully owo)
                'recieverID' => $recieverID
            ]
        );
        $response->getBody()->write(json_encode($data));
        return $response;
    });
//routig to get all messages sent from recievier to loggedin (logged in = reciver in our context)
$app->get('/messages/LoggedIn/{recieverID}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
   
    $session =  new \SlimSession\Helper();
    $userid = $session->get("user");
    $recieverID = $args['recieverID'];
    $data = $this->get('database')->select( //medoo syntax to get all messages with value
        'message',
        [
            'messageID',
            'message',
            'created',
            'userIDfs',
            'recieverID'
        ],
        [
            'userIDfs' => $recieverID , //get session ID from Logged in User (Hopefully owo)
            'recieverID' => $userid
        ]
    );
    $response->getBody()->write(json_encode($data));
    return $response;

});


    /*
    // outdated routing because new approach
    //routing to get all messages sent from a user with the userIDfs
    $app->get('/messages/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {

        $userid = $args['id'];
        $data = $this->get('database')->select( //medoo sytnax to get all the messages with the parameter value
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
    });*/
    //routing to get all users
    $app->get('/users', function (ServerRequestInterface $request, ResponseInterface $response) {
        $data = $this->get('database')->select('user', ['username', 'prename', 'lastname', 'password']);
        $response->getBody()->write(json_encode($data));
        return $response;
    });
    //Route responsible for listing all Friends of Friendlist of logged in User
    $app->get('/friends/all', function (ServerRequestInterface $request, ResponseInterface $response) {
        $session =  new \SlimSession\Helper();
        $userid = $session->get("user");
        $data = $this->get('database')->query("SELECT FriendID, user.username
        FROM friendlist
        LEFT JOIN user ON friendlist.FriendID=user.userID WHERE UserID_fs = $userid;")->fetchAll();
         $response->getBody()->write(json_encode($data));
         return $response;
        // Using WHERE in JOIn clause is not suported by medoo yet
        //https://github.com/catfan/Medoo/issues/167
        //https://stackoverflow.com/questions/26135002/medoo-php-framework-select-left-join-using-and-to-test-against-a-conditi
        /*$this->get('database')->select(
            'friendlist',
            [ //medoo syntax to get all messages with value
                '[>]user' => ["friendlist.FriendID" => "user.userID"]
            ],
            [
                'FriendID',
                'user.username'
            ],
            
            [
                'UserID_fs' => $userid //get session ID from Logged in User (Hopefully owo)
            ]
        );*/
       
    });

//routing for resolving username with 
 
$app->get('/friends/{username}', function (ServerRequestInterface $request, ResponseInterface $response , array $args) {


    $username = $args['username'];
    $data = $this->get('database')->select( //medoo sytnax to get all the messages with the parameter value
        'user',
        [
            'username',
            'userID'
        ],
        [
            'username' => $username
        ]
    );
    $response->getBody()->write(json_encode($data));
    return $response;   
});
//

};
