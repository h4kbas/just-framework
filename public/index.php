<?php	

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VENDOR', ROOT.DS.'vendor');
define('PUBLICDIR', ROOT.DS.'public');
define('CONFIG', ROOT.DS.'config');
define('LANGS', ROOT.DS.'lang');

define('APP', ROOT.DS.'app');
  define('COMPONENTS', APP.DS.'components');
  define('CONTROLLERS', APP.DS.'controllers');
  define('FILTERS', APP.DS.'filters');
  define('VIEWS', APP.DS.'views');

define('TMP', ROOT.DS.'tmp');
define('TMPFILES', ROOT.DS.'tmp'.DS.'files');
$url = (!empty($_GET['url'])) ? $_GET['url'] :'/';

require_once VENDOR . DS . 'autoload.php';
require_once VENDOR . DS . 'bootstrap.php';
