<?php
use Just\Component\ConditionComponent;
//Some custom Auth class (not important)
use App\Ext\Auth;

class Info extends ConditionComponent{
	public function __construct(){
      //The stuff that checks whether user is logged in
      //$this->condition = Auth::check();
	}
}