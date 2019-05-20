<?php
namespace App\Controllers;

use APP\Models\Home;

class HomeController {

   private $container;

   public function __construct ($c) {
      $this->container = $c;
   }

   public function index ($req, $res, $arg) {
      echo 'this is index page';
   }

   public function create ($req, $res, $arg) {
      echo 'this is create page';
   }

   public function store ($req, $res, $arg) {
      echo 'this is store page';
   }

   public function show ($req, $res, $arg) {
      echo 'this is show page';
   }

   public function edit ($req, $res, $arg) {
      echo 'this is edit page';
   }

   public function update ($req, $res, $arg) {
      echo 'this is update page';
   }

   public function destroy ($req, $res, $arg) {
      echo 'this is index page';
   }
}