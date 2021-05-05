<?php

use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

//$this->get("session")["user"] = ;

return function (App $app) {
    
        
    $app->post('/login', function (ServerRequestInterface $request, ResponseInterface $response) {
        //curl -X POST -F 'username=cptrio' -F 'password=verysecure' 'http://10.80.4.43/login'
        $data = $request->getParsedBody();
        if (isset($data['username']) && isset($data['password'])) {
            $check = $this->get('database')->select(
                'user',
                [
                   'userID',
                   'username',
                   'password'
                ],[
                    'username' => $data['username'],
                    'password' => $data['password']
                ]

            );
            if(json_encode($check) != "[]"){
                $encoded =json_encode($check);
                //$dataarray = explode('"',$encoded);
                $response->getBody()->write($encoded);
                //$response->getBody()->write("Dataarray 3: ",$dataarray[3]);
                var_dump($check[0]['userID']);
                $this->get("session")->set ('user', $check[0]['userID']);
                $response->getBody()->write("succes\n UserID for Session: ",  $this->get("session")->user);

            }else{
                $response->getBody()->write("no succes");
            }
            
        } else {
            $response->getBody()->write("im missing smt");
        }
        return $response;
    });
};
