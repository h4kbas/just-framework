<?php namespace Just\Util;
class Lang {
	static $_currlang;
	static $_langdata;
	
	static function set($lang){
		self::$_currlang = $lang;
		Session::set("lang",$lang);
	}
	
	static function get($f, $t){
		$gen = 'lang'.DS.Session::get("lang").".$f";
		$langdata = null;
		if(!self::$_langdata[$gen])
			$langdata = include APP.DS."$gen.php";
		else
			$langdata = $_langdata[$gen];
		return $langdata[$t];
	}
	
	static function current(){
		return self::$_currlang;
	}
	
}
