<?php namespace Just\Core;
class Request{

	static function get($t) {
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return $_GET[$t]; break;
			case 'POST': return $_POST[$t]; break;
		}
	}

	static function has($t){
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return array_key_exists($t, $_GET); break;
			case 'POST': return  array_key_exists($t, $_POST); break;
		}
	}

	static function raw(){
		return file_get_contents("php://input");
	}

	static function file($t) {
		return $_FILES[$t];
	}

	static function all() {
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return $_GET; break;
			case 'POST': return $_POST; break;
		}
	}

	static function only($k){
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return array_intersect($k, $_GET); break;
			case 'POST': return array_intersect($k, $_POST); break;
		}
	}
	static function except($k){
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return array_diff($_GET, $k); break;
			case 'POST': return array_diff($_POST, $k); break;
		}
	}

}
