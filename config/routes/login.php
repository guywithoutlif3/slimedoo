<?php

use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

//$this->get("session")["user"] = ;

return function (App $app) {


    $app->post('/login', function (ServerRequestInterface $request, ResponseInterface $response) {
        $session =  new \SlimSession\Helper();
        //curl -X POST -F 'username=cptrio' -F 'password=verysecure' 'http://10.80.4.43/login'
        $data = $request->getParsedBody();
        if (isset($data['username']) && isset($data['password'])) {
            $check = $this->get('database')->select(
                'user',
                [
                    'userID',
                    'username',
                    'password'
                ],
                [
                    'username' => $data['username'],
                    'password' => hash('ripemd160', $data['password'])
                ]

            );
            if (!empty($check)) {
                //var_dump($_SESSION);
                //var_dump($session->get("user"));
                
                $session->set('user', $check[0]["userID"]);
                $response->getBody()->write("Test");
                $response->getBody()->write($session->get("user"));
                $exists = $session->exists('user');
                if ($exists = true) {
                    $response->getBody()->write("\n Exists but empty af\n");
                }
                $response->getBody()->write(json_encode(var_dump($_SESSION)));
            } else {
                $response->getBody()->write("no succes");
            }
        } else {
            var_dump($data);
            $response->getBody()->write("im missing smt");
        }
        return $response;
    });
};
