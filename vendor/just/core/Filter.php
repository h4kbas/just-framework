<?php namespace Just\Core;
class Filter{
	public $action;
	public $actions;
	function __construct($action, $actions){
		$this->action = $action;
		$this->actions = $actions;
	}
}
