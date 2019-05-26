<?php
namespace App\Controllers;

use slim\Router;
use Slim\Views\Twig;
use Illuminate\Database\Query\Builder;
use APP\Models\Home;

class HomeController {

   private $view;
   private $table;
   private $router;

   public function __construct (Twig $view, Builder $table, Router $router) {
      $this->view = $view;
      $this->table = $table;
      $this->router = $router;
   }

   public function index ($req, $res, $args) {
      $movies = $this->table->get();
      return $this->view->render($res, 'home/home.twig', [ 'movies' => $movies]);
   }

   public function create ($req, $res, $args) {
      return $this->view->render($res, 'home/create.twig', $args);
   }

   public function store ($req, $res, $args) {
      $movie['title'] = $req->getParam('movie_name');
      $movie['director'] = $req->getParam('director');
      $movie['main_actor'] = $req->getParam('main_actor');
      $movie['production_company'] = $req->getParam('company');
      $movie['released_date'] = $req->getParam('released_date');

      $this->table->insert($movie);

      return $res->withRedirect($this->router->pathFor('showMovies'));
   }

   public function show ($req, $res, $args) {
      $id = $args['id'];
      $movie = $this->table->find($id);
      $movie = (array)$movie;

      return $this->view->render($res, 'home/show.twig', $movie);
   }

   public function edit ($req, $res, $args) {
      $id = $args['id'];
      $movie = $this->table->find($id);
      $movie = (array)$movie;

      return $this->view->render($res, 'home/edit.twig', $movie);
   }

   public function update ($req, $res, $arg) {
      echo 'this is update page';
   }

   public function destroy ($req, $res, $arg) {
      echo 'this is index page';
   }
}