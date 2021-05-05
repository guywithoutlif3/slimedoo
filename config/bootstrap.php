<?php

use DI\ContainerBuilder;
use Slim\App;
use Medoo\Medoo;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Set up settings
$containerBuilder->addDefinitions(__DIR__ . '/container.php');

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Set database as the name of Medoo service.
$container->set('database', function () {
    return new Medoo([
        'type' => 'mysql',
        'host' => 'localhost',
        'database' => 'slimedoo',
        'username' => 'root',
        'password' => 'manager'
    ]);
});

// Create App instance
$app = $container->get(App::class);

// Register routes
(require __DIR__ . '/routes.php')($app);

// Register middleware
(require __DIR__ . '/middleware.php')($app);

return $app;
