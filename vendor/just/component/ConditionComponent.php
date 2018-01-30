<?php
namespace Just\Component;

class ConditionComponent {
	public $condition;
	public $exports = [];
	public static function is(){
		return "if";
	}
}