<?php

use Slim\App;
use \Slim\Views\PhpRenderer;
use \Monolog\Logger;
use \Monolog\Processor\UidProcessor;
use \Slim\Views\Twig;
use \Slim\Http\Uri;
use \Slim\Http\Environment;
use \Slim\Views\TwigExtension;
use \Monolog\Handler\StreamHandler;
use \Illuminate\Database\Capsule\Manager;
use App\Controllers\HomeController;

return function (App $app) {
    $container = $app->getContainer();

    // default view renderer service
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new PhpRenderer($settings['template_path']);
    };

   // twig view renderer service
   $container['view'] = function ($c) {
      $settings = $c->get('settings')['twig'];
      $view = new Twig($settings['view_path'], [
          'cache' => $settings['cache_path']
      ]);

      // Instantiate and add Slim specific extension
      $router = $c->get('router');
      $uri = Uri::createFromEnvironment(new Environment($_SERVER));
      $view->addExtension(new TwigExtension($router, $uri));

      return $view;
   };

    // monolog service
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new Logger($settings['name']);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));

        return $logger;
    };

   // database service for PDO
   $container['db_pdo'] = function ($c) {
      $db = $c['settings']['db'];
      $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

      return $pdo;
   };

   // database service for Eloquent
   $container['db'] = function ($container) {
      $capsule = new Manager;
      $capsule->addConnection($container['settings']['db']);
      $capsule->setAsGlobal();
      $capsule->bootEloquent();

      return $capsule;
   };

   // controller service for HomeController
   $container['home'] = function ($c) {
      $view = $c->get('view');
      $table = $c->get('db')->table('movies');
      $router = $c->get('router');
      return new HomeController($view, $table, $router);
   };
};
