<?php
if(session_id() === ""){
    session_start();
}

require_once CONFIG.DS."config.php";

if (DEVELOPMENT_ENVIRONMENT) {
	$whoops = new \Whoops\Run;
	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
	$whoops->register();
} 
require_once (VENDOR . DS . 'shared.php');
