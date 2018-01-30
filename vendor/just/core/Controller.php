<?php namespace Just\Core;

class Controller {
	public $controller;
	public $action;
	public $template;
	public $_filter = [];
	function __construct() {
	}

	function beforeAction(){

	}

	function afterAction(){

	}

	function allActions(){
		return except(['beforeAction', 'afterAction', '__construct', 'allActions'],get_class_methods($this));
	}
	
	function filterOnly($f,$actions){
		filterInit($f);
		$this->_filter []= new $f($this->action, $actions);
	}
	
	function filterExcept($f, $actions){
		filterInit($f);
		$this->_filter []= new  $f($this->action, except($actions, $this->allActions()));
	}

	function filter($f){
		filterInit($f);
		$this->_filter []= new  $f($this->action, $this->allActions());
	}
}
