<?php namespace Just\Core;
class Route{

	static function redirect($url) {
		return header("Location: $url");
	}

	static function back() {
		header("Location: {$_SERVER['HTTP_REFERER']}");
		exit;
	}

	static function abort($what){
		$tpl = new Template();
		switch ($what) {
			case 404:
				http_response_code(404);
				if(file_exists(VIEWS.DS.'errors'.DS.'_404.html'))
					$tpl->render('errors._404');
				break;
			case 500:
				http_response_code(500);
				if(file_exists(VIEWS.DS.'errors'.DS.'_500.html'))
					$tpl->render('errors._500');
				break;
			default:
				http_response_code(500);
				if(file_exists(VIEWS.DS.'errors'.DS.'_500.html'))
					$tpl->render('errors._500');
		}
	}

}
