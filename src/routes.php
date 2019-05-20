<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

   $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
      $container->get('logger')->info("Slim-app-01 '/' route");
      return $container->get('home')->index($request, $response, $args);
   });

   $app->get('/home', function (Request $request, Response $response, array $args) use ($container) {
      $container->get('logger')->info("Slim-app-01 '/home' route");
      return $container->get('home')->index($request, $response, $args);
   });

   $app->get('/home/create', function (Request $request, Response $response, array $args) use ($container) {
      $container->get('logger')->info("Slim-app-01 '/home/create' route");
      return $container->get('home')->create($request, $response, $args);
   });

   $app->post('/home', function (Request $request, Response $response, array $args) use ($container) {
      $container->get('logger')->info("Slim-app-01 '/home/store' route");
      return $container->get('home')->store($request, $response, $args);
   });

   $app->get('/home/{id}', function (Request $request, Response $response, array $args) use ($container) {
      $container->get('logger')->info("Slim-app-01 '/home/show' route");
      return $container->get('home')->show($request, $response, $args);
   });

   $app->get('/home/edit/{id}', function (Request $request, Response $response, array $args) use ($container) {
      $container->get('logger')->info("Slim-app-01 '/edit' route");
      return $container->get('home')->edit($request, $response, $args);
   });

   $app->patch('/home/{id}', function (Request $request, Response $response, array $args) use ($container) {
      $container->get('logger')->info("Slim-app-01 '/update' route");
      return $container->get('home')->update($request, $response, $args);
   });

   $app->delete('/home/{id}', function (Request $request, Response $response, array $args) use ($container) {
      $container->get('logger')->info("Slim-app-01 '/destroy' route");
      return $container->get('home')->destroy($request, $response, $args);
   });
};
