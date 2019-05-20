<?php

use Slim\App;
use \Slim\Views\PhpRenderer;
use \Monolog\Logger;
use \Monolog\Processor\UidProcessor;
use \Monolog\Handler\StreamHandler;
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
      $view = new \Slim\Views\Twig('path/to/templates', [
          'cache' => 'path/to/cache'
      ]);

      // Instantiate and add Slim specific extension
      $router = $c->get('router');
      $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
      $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

      return $view;
   };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new Logger($settings['name']);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

   // database service
   $container['db'] = function ($c) {
      $db = $c['settings']['db'];
      $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      return $pdo;
   };

   // controller service for HomeController
   $container['home'] = function ($c) {
      return new HomeController($c);
   };
};
