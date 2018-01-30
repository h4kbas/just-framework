<?php

use Just\Core\Controller;
class HomeController extends Controller{
	
  public function getIndex(){
	  $this->template->render('home', [ 'world' => "World" ]);
  }
 
}
