<?php
use Just\Util\Lang, 
	Just\Util\Fields,
	Just\Core\Request,
	Just\Core\Route;

function session($get=false,$set=false){
	if($get){
		if($set){
			return Session::set($get,$set);
		}
		else{
			return Session::get($get);
		}
	}
	else return Session::all();
}

function l($f, $get){
	return Lang::get($f, $get);
}

function req($get=false){
	if($get){
		return Request::get($get);
	}
	else return Request::all();
}

function rawReq(){
	return Request::raw();
}

function reqs(array $reqs, array $ops, $def){
	foreach($reqs as $r){
		if(Request::has($r) && request($r) != ''){
			$def[$r] = request($r);
		}
		else{
			return false;
		}
	}
	foreach($ops as $o){
		if(Request::has($o)){
			$def[$o] = request($o);
		}
	}
	return $def;
}

function redirect($url){
	return Route::redirect(URL.$url);
}

function view($tpl,$args = array()){
	return Template::render($tpl,$args);
}

function dd($var){
	var_dump($var);
	exit;
}

function __check($action, array $actions){
	return in_array($action, $actions);
}

function only($k, $ks){
	return array_intersect($k, $ks);
}

function except($k, $ks){
	return array_diff($ks, $k);
}

function abort($what){
	return  Route::abort($what);
}

function closeRequest($msg = ""){
	ob_end_clean();
	header("Connection: close");
	ignore_user_abort(true); // optional
	ob_start();
	echo ($msg);
	$size = ob_get_length();
	header("Content-Length: $size");
	ob_end_flush();     // Will not work
	flush();            // Unless both are called !
}

function httpResponse($code){
	http_response_code($code);
}

function httpPost($url,$params, $header, &$response = null)
{
   $postData = '';
   //create name value pairs seperated by &
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   $postData = rtrim($postData, '&');
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
    $output=curl_exec($ch);
	
	if($response) 
		$response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    return $output;
 
}

function httpGet($url, $header, &$response = null)
{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	//  curl_setopt($ch,CURLOPT_HEADER, false); 
 
    $output=curl_exec($ch);
		
	if($response) 
		$response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
    curl_close($ch);
    return $output;
}

function componentInit($plugin, $component){
	if (file_exists(COMPONENTS . DS . $plugin.DS."$component.php")) {
		require_once(COMPONENTS . DS . $plugin.DS."$component.php");
	}  
}

function filterInit($f){
	if (file_exists(FILTERS . DS . "$f.php")) {
		require_once(FILTERS . DS . "$f.php");
	}  
}

function newDate(){
	return Time::now();
}