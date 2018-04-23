<?php 

defined('BASEPATH') OR exit('No direct script access allowed'); 

if( !function_exists('loadJS') ) {
	function loadJS( $pageName = 'home' ) {
		$jsFileArr = array(
			0 => 'home.js',
			1 => 'signup.js',

			101=>'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js',
			102=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js',
			103=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/owl.carousel.min.js',
			104=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.min.js',
			 
			
		);
		$jsText = '';
		$jsArr = array(101,103);
		switch ($pageName) {
			case 'home':
				array_push($jsArr, 0);
			break;	

			case 'signup':
				array_push($jsArr, 1,102,104);
			break;			

			case 'create-branch':
				array_push($jsArr, 1,102,104);
			break;				
		}

		if(!empty($jsArr)){
			foreach ($jsArr as $key => $value) {
				if(isset($jsFileArr[$value]) && $jsFileArr[$value] != ''){
					$path = THEME_JS_PATH.$jsFileArr[$value];
					$additional = "defer";
					if($value>=100){
						$path = $jsFileArr[$value];
						$additional = "defer";
					}
					$jsText .= "\r\n".'<script type="text/javascript" src="'.$path.'" '.$additional.'></script>';
				}
			}
		}
		return $jsText;
	}	
}

if( !function_exists('loadCSS') ) {
	function loadCSS( $pageName = 'home' ) {
		$cssFileArr = array(
			0  => 'style.css',
			1  => 'signup.css',
			2  => 'signin.css',

			101=>'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css',
			102=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.carousel.min.css',
			103=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.theme.default.min.css',
			104=>'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css'
		);
		
		$cssText = '';
		$cssArr = array(0,101,102,103,104);
		switch ($pageName) {
			case 'signup':
				array_push($cssArr,1);
			break;

			case 'signin':
				array_push($cssArr,2);
			break;				

			case 'create-branch':
				//array_push($jsArr, 1,102,104);
			break;
		}

		if(!empty($cssArr)){
			foreach ($cssArr as $key => $value) {
				if(isset($cssFileArr[$value]) && $cssFileArr[$value] != ''){
					$path = THEME_CSS_PATH.$cssFileArr[$value];
					if($value>=100){
						$path = $cssFileArr[$value];
					}
					$cssText .= '<link type="text/css" rel="stylesheet" href="'.$path.'">'."\r\n";
				}
			}
		}
		return $cssText;
	}	
}	

function generateSlug($text){
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);
	// trim
	$text = trim($text, '-');
	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);
	// lowercase
	$text = strtolower($text);
	if (empty($text)) {
		return 'n-a';
	}
	return $text;
}

function show($data){
	echo '<pre>';
	var_dump($data);
	exit; 
}