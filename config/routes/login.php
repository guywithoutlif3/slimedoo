<?php
//includes Medoo + Slim Framework, and added PHP standard reccomended http Responde and Request Interfaces 
use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

//all the login routing is in here
return function (App $app) {

    //route whom is responsible for the Login/ Login checking
    //Testing with curl:    curl -X POST -F 'username=cptrio' -F 'password=verysecure' 'http://10.80.4.43/login'
    $app->post('/login', function (ServerRequestInterface $request, ResponseInterface $response) {
        $session =  new \SlimSession\Helper();
        
        $data = $request->getParsedBody(); //getting All the Values from Post into data Array
        if (isset($data['username']) && isset($data['password'])) { //check if they set
            $check = $this->get('database')->select( //use medoo syntax to make an query: if it returns nothing then the Login is false: Used in Vue
                'user',
                [
                    'userID',
                    'username',
                    'password'
                ],
                [
                    'username' => $data['username'],
                    'password' => hash('ripemd160', $data['password']) //hashed version of user input to check with hash in DB
                ]

            );
            if (!empty($check)) {
                $session->set('user', $check[0]["userID"]); //sets session UserID

                $exists = $session->exists('user');
               $response->getBody()->write(json_encode($session->get('user')));
            } else {

            }
        } else {
              
         var_dump($data);
        $response->getBody()->write(json_encode("not succeful")); 
        }
        return $response;
    });
};
