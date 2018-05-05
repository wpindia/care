<?php 

defined('BASEPATH') OR exit('No direct script access allowed'); 

if( !function_exists('loadJS') ) {
	function loadJS( $pageName = 'home' ) {
		$jsFileArr = array(
			0 => 'home.js',
			1 => 'signup.js',
			2 => 'branch.js',
			3 => 'user_daycare_view.js',
			4 => 'materialize.min.js',
			//101=>'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js',
			//101=>'materialize.min.js',
			102=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js',
			103=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/owl.carousel.min.js',
			104=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.min.js',
			105=>'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js', 
			106=>'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.11/jquery.tinymce.min.js',
			107=>'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js',
			108=>"https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"		
			
		);
		$jsText = '';
		$jsArr = array(4);
		switch ($pageName) {
			case 'home':
				array_push($jsArr, 0,103,108);
			break;

			case 'search-results':
				array_push($jsArr, 108);
			break;				

			case 'signup':
				array_push($jsArr, 1,102,104);
			break;			

			case 'create-branch':
			case 'edit-branch':
				array_push($jsArr, 2,102,104,105,106,107);
			break;				

			case 'user-daycare-view':
				array_push($jsArr, 3,103);
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
			3  => 'user_daycare_view.css',

			101=>'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css',
			102=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.carousel.min.css',
			103=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.theme.default.min.css',
			104=>'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css',
			105=>'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css',
			106=>'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.11/skins/lightgray/skin.min.css'
		);
		
		$cssText = '';
		$cssArr = array(0,101,104);
		switch ($pageName) {
			case 'home':
				array_push($cssArr, 102,103);
			break;

			case 'search-results':
				//array_push($cssArr);
			break;
					
			case 'signup':
				array_push($cssArr,1);
			break;

			case 'signin':
				array_push($cssArr,2);
			break;				

			case 'create-branch':
			case 'edit-branch':
				array_push($cssArr, 1,105,106);
			break;

			case 'user-daycare-view':
				array_push($cssArr, 3,102,103);
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

if ( ! function_exists('partner_base_url')){
	function partner_base_url($uri = ''){
		$uri = 'partner/'.$uri;
		return get_instance()->config->base_url($uri);
	}
}

function getRandomString(){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $strRandom = '';
    for ($i = 0; $i < 5; $i++) {
        $strRandom .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $strRandom;
}

function generateImageUrl($fileName){
	$strUrl = ( ENVIRONMENT !== 'production' ) ? base_url($fileName) : FCPATH . $fileName; 
	return $strUrl;
}

function uploadfile($uploadedFilename, $vendorId){
        //$filename 			= strtolower($_FILES[$uploadedFilename]["name"]);
        $randomString 		= getRandomString();
        $destinationPath 	= FCPATH . 'uploads/admin/' . $vendorId . '/';
        
        if(false == file_exists($destinationPath)){
            $status = mkdir($destinationPath);
        	if(false == $status) return false;
        }

        $info 			= new SplFileInfo($_FILES[$uploadedFilename]["name"]);
		$fileExtension 	= $info->getExtension();

		if($_FILES[$uploadedFilename]['error'] != 0 || $_FILES[$uploadedFilename]['name'] == '') return false;

		$filename 	= $uploadedFilename . '_' . $randomString . '_'.time(). '.' . $fileExtension;
        
        $config['upload_path'] 		= $destinationPath;
        $config['allowed_types'] 	= 'gif|jpg|png|jpeg';
        $config['file_name']		= $filename;
        $CI =& get_instance();
     	$CI->load->library('upload', $config);

        if( false == $CI->upload->do_upload($uploadedFilename) ) {
            $error = array('error' => $CI->upload->display_errors());
            show($error);
        }else {
            $uploadData = $CI->upload->data();
	        
	        return $filename;
        }
        
        
        return false;
    }

    function getCityNameById($cityId){
    	global $daycareCities;
		return ( true == array_key_exists( $cityId, $daycareCities ) ) ? $daycareCities[$cityId] : false;
	}

	function getCityIdByName($cityName){
		global $daycareCities;
		return array_search(strtolower($cityName), array_map('strtolower', $daycareCities ) );
	}

	function getAreaNameById($areaId){
    	global $daycareAreas;
		return ( true == array_key_exists( $areaId, $daycareAreas ) ) ? $daycareAreas[$areaId] : false;
	}

	function getAreaIdByName($areaName){
		global $daycareAreas;
		return array_search(strtolower($areaName), array_map('strtolower', $daycareAreas ) );
	}

	function getFormattedTime($time){
		return date('h:i a', strtotime($time));
	}