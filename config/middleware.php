<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Middleware\SessionMiddleware;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(SessionMiddleware::class); // <-- here

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    $app->add(BasePathMiddleware::class); // <--- here

    // Catch exceptions and errors
    $app->add(ErrorMiddleware::class);
  
};
