<?php namespace Just\Core;

use Twig;
use Just\Component, Just\Component\Twig_TokenParser_Component;
class Template{
	public  $twig;
	function __construct(){
		$urlfunc = new \Twig_SimpleFunction('url', function ($url) {
			return URL."/$url";
		});
    
		$initcompfunc  = new \Twig_SimpleFunction('componentInit', function($className){
				return componentInit($className);
		});
		
		$sessionfunc = new \Twig_SimpleFunction('session', function ($name) {
			if(Session::has($name))
				return Session::get($name);
			else return false;
		});
		
		$sflashfunc = new \Twig_SimpleFunction('sflash', function ($name) {
			return Session::flash($name);
		});
		
		$ddfunc = new \Twig_SimpleFunction('dd', function ($name) {
			return var_dump($name);
		});
		$loader = new \Twig_Loader_Filesystem(VIEWS);
		if ($handle = opendir(VIEWS)) {

			while (false !== ($entry = readdir($handle))) {

				if ($entry != "." && $entry != "..") {

					$loader->addPath(VIEWS, $entry);
				}
			}
			closedir($handle);
		}
		$this->twig = new \Twig_Environment($loader, array(
			//'cache' => ROOT . DS . 'tmp' . DS . 'cache' . DS,
			'cache' => CACHE ? TMP . DS . 'cache' . DS : CACHE
		));
		
		$this->twig->addFunction($urlfunc);
		$this->twig->addFunction($sessionfunc);
		$this->twig->addFunction($sflashfunc);
		$this->twig->addFunction($ddfunc);
		$this->twig->addFunction($initcompfunc);
		$this->twig->addTokenParser(new Twig_TokenParser_Component());
	}
	function render($tpl, $args = array()) {
		$tpl = str_replace(".","/",$tpl).'.html';
		
		echo $this->twig->render($tpl, $args);
	}
	function share($var, $val){
		$this->twig->addGlobal($var, $val);
	}
}
