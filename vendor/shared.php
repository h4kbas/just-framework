<?php 
use Just\Core\Session, 
	Just\Core\Template,
	Just\Core\Route,
	RedBeanPHP\R as DB;

if(DB_ACTIVE)
	DB::setup( 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD );
function setReporting(){
	if (DEVELOPMENT_ENVIRONMENT) {
		error_reporting(E_ALL);
		ini_set('display_errors','On');
	} else {
		error_reporting(E_ALL);
		ini_set('display_errors','Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
	}
}
Session::set("lang", LANG);
$template = new Template();

function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

function removeMagicQuotes() {
if ( get_magic_quotes_gpc() ) {
	$_GET    = stripSlashesDeep($_GET   );
	$_POST   = stripSlashesDeep($_POST  );
	$_COOKIE = stripSlashesDeep($_COOKIE);
}
}

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

function callHook() {
	global $url;
	$urlArray = array();
	global $template;
	
	$urlArray = explode("/",$url);
	$controller = "";
	$action = "";
	$queryString = array();
	$pre = "";
	$routeMaps = [];
	switch($_SERVER['REQUEST_METHOD'])
	{
		case 'GET': $pre = "get"; break;
		case 'POST': $pre = "post";break;
	}
	if (file_exists(APP.DS."routes.php")) {
		$routeMaps = include_once APP.DS."routes.php";
		if($url == '/'){
			if(isset($routeMaps['/']))
				$controller = $routeMaps['/'];
			else{ Route::abort(404);exit; }
			$action = $pre."Index";
		}
		else if(count($urlArray) == 1){
			if(isset($routeMaps[$urlArray[0]]))
				$controller = $routeMaps[$urlArray[0]];
			else{ Route::abort(404);exit; }
			array_shift($urlArray);
			$action = $pre."Index";
			array_shift($urlArray);
			$queryString = $urlArray;
		}
		else{
			if(isset($routeMaps[$urlArray[0]]))
				$controller = $routeMaps[$urlArray[0]];
			else{ Route::abort(404);exit; }
			array_shift($urlArray);
			$action = $pre.ucwords($urlArray[0]);
			array_shift($urlArray);
		}
	}
	/* auto routing */
	else{
		if($url == '/'){
			$controller = "HomeController";
			$action = $pre."Index";
		}
		else if(count($urlArray) == 1){
			$controller = ucwords($urlArray[0]).'Controller';
			array_shift($urlArray);
			$action = $pre."Index";
			array_shift($urlArray);
			$queryString = $urlArray;
		}
		else{
			$controller = ucwords($urlArray[0]).'Controller';
			array_shift($urlArray);
			$action = $pre.ucwords($urlArray[0]);
			array_shift($urlArray);
		}
	}
	// Common
	if (file_exists(CONTROLLERS.DS."$controller.php")) {
		require_once CONTROLLERS.DS."$controller.php";
		if ( is_callable(array($controller, $action)) ) {		
			$obj = new $controller();
			$obj->template = &$template;
			$obj->controller = $controller;
			$obj->action = $action;
			$obj->beforeAction();
			$filt = true;
			foreach($obj->_filter as $f){
				if(__check($f->action, $f->actions)){
					$filt = $filt && $f->handle();		
					if(!$filt){
						$f->fallback();
						break;
					}
				}
				else{
					call_user_func_array(array($obj,$action), $urlArray);
				}
			}
			if($filt || is_null($filt))
				call_user_func_array(array($obj,$action), $urlArray);
			$obj->afterAction();
		}else{
			Route::abort(404);
		}
	}
	else{
		Route::abort(404);
	}  
}


require_once("helpers.php");
require_once(APP.DS.'global.php');
setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();
