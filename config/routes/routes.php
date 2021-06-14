<?php

use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


return function (App $app) {

   //my first random route for testing and playing around with API
   //Yes its an Hello World :D
    $app->get('/', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write('Hello, World!');

        return $response;
    });

    $app->get("/foo", function ($request, $response) {
        //$this->get('session')->set('userid', 'slimedoo');
        //$this->get('session')->save();
        //$response->getBody()->write(json_encode($this->get('session')->all()));
        return $response;
    });  
  
};
