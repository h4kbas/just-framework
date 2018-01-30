<?php namespace Just\Component;

class RepeatComponent {
	public $key = "key";
	public $value = "value";
	public $sequence = [];
	public $exports = [];
	public static function is(){
		return "repeat";
	}
}