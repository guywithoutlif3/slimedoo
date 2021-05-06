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
//Session

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
$app->add(
    new \Slim\Middleware\Session([
      'name' => 'session',
      'autorefresh' => true,
      'lifetime' => '1 hour',
    ])
  );

// Register globally to app
$container->set('session', function () {
  return new \SlimSession\Helper();
});


// Register routes
(require __DIR__ . '/routes/routes.php')($app); 
(require __DIR__ . '/routes/create.php')($app);
(require __DIR__ . '/routes/delete.php')($app);
(require __DIR__ . '/routes/select.php')($app);
(require __DIR__ . '/routes/login.php')($app);
// Register middleware
(require __DIR__ . '/middleware.php')($app);

return $app;
