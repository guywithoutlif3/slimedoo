<?php
 // uses Slim App and Medoo for the bootstrap
use DI\ContainerBuilder;
use Slim\App;
use Medoo\Medoo;

//This Bootstrap file is making sure every route is known and puts all setting together
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

// Create App instance and tell it its name and how long it lasts
$app = $container->get(App::class);
$app->add(
    new \Slim\Middleware\Session([
      'name' => 'worked',
      'autorefresh' => true,
      'lifetime' => '1 hour',
    ])
  );

// Register globally to app
$container->set('session', function () {
  return new \SlimSession\Helper();
});


// Registe all route files
(require __DIR__ . '/routes/routes.php')($app); 
(require __DIR__ . '/routes/create.php')($app);
(require __DIR__ . '/routes/delete.php')($app);
(require __DIR__ . '/routes/select.php')($app);
(require __DIR__ . '/routes/login.php')($app);
(require __DIR__ . '/routes/update.php')($app);

// Register middleware file
(require __DIR__ . '/middleware.php')($app);

return $app; //returns the slim AP
