<?php

use Just\Core\Filter;
class AuthFilter extends Filter{

  public function handle(){
    //TODO: Check the Auth If false it won't pass and call fallback.
    return true;
  }
  
  public function fallback(){
	  redirect('/');
  }
}