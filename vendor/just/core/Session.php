<?php namespace Just\Core;
class Session{
	public static function has($t){
		if(isset( $_SESSION[$t]))
			return true;
		else return false;
	}
	public static function get($t) {
		return $_SESSION[$t];
	}

	public static function all() {
		return $_SESSION;
	}

	public static function set($k, $v) {
		$_SESSION[$k] = $v;
	}

	public static function remove($k) {
		unset($_SESSION[$k]);
	}

	public static function only($k){
		return array_intersect($k, $_SESSION);
	}
	public static function except($k){
		return array_diff($_SESSION, $k);
	}

	public static function destroy() {
		session_destroy();
	}

	public static function  flash( $name = '', $message = '' )
	{
		if( !empty( $name ) )
		{
			if( !empty( $message ) && empty( $_SESSION[$name] ) )
			{
				if( !empty( $_SESSION[$name] ) )
					unset( $_SESSION[$name] );

				$_SESSION[$name] = $message;
			}
			elseif( !empty( $_SESSION[$name] ) && empty( $message ) ){
				$r =  $_SESSION[$name];
				unset($_SESSION[$name]);
				return $r;
			}
		}
	}
}
