<?php 

defined('BASEPATH') OR exit('No direct script access allowed'); 

if( !function_exists('loadJS') ) {
	function loadJS( $pageName = 'home' ) {
		$jsFileArr = array(
			0 => 'home.js',
			1 => 'user_daycare_view.js',
			2 => 'materialize.min.js',
			3 => 'common.js',
			4 => 'additionalMethods.js',
			//101=>'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js',
			//101=>'materialize.min.js',
			102=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js',
			103=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/owl.carousel.min.js',
			//104=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.min.js',
			105=>'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js', 
			106=>'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.11/jquery.tinymce.min.js',
			107=>'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js',
			108=>"https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js",		
			109 =>"//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-531f2b095f14dea7"
		);
		$jsText = '';
		$jsArr = array(2,3);
		switch ($pageName) {
			case 'home':
				array_push($jsArr, 0,103,108,109);
			break;

			case 'search-results':
				array_push($jsArr, 108,109);
			break;				

			case 'user-daycare-view':
				array_push($jsArr, 1,4,102,103,109);
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
			1  => 'user_daycare_view.css',
			
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
				//array_push($cssArr,);
			break;

			case 'search-results':
				//array_push($cssArr);
			break;
					
			case 'user-daycare-view':
				array_push($cssArr, 1,102,103);
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


if( !function_exists('loadPartnerJS') ) {
	function loadPartnerJS( $pageName = '' ) {
		$jsFileArr = array(
			1 => 'partner/signup.js',
			2 => 'partner/branch.js',
			3 => 'materialize.min.js',
			4 => 'partner/common.js',
			5 => 'partner/multipleUploadFile.min.js',
			6 => 'partner/gallery.js',
			7 => 'additionalMethods.js',  
			8 => 'partner/signin.js',
			9 => 'partner/testimonial.js',
			//101=>'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js',
			//101=>'materialize.min.js',
			102=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js',
			103=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/owl.carousel.min.js',
			104=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.min.js',
			105=>'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js', 
			106=>'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.11/jquery.tinymce.min.js',
			107=>'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js',
			108=>"https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js",		
			
		);
		$jsText = '';
		$jsArr = array(3,4);
		switch ($pageName) {
			case 'signup':
				array_push($jsArr, 1,7,102);
			break;			

			case 'signin':
				array_push($jsArr, 8,7,102);
			break;

			case 'create-branch':
			case 'edit-branch':
				array_push($jsArr, 2,5,6,102,104,105,106,107,108);
			break;

			case 'create-testimonial':
			case 'edit-testimonial':
				array_push($jsArr, 7, 9, 102, 107);
			break;

			case 'manage-gallery':
				array_push($jsArr, 5,6);
			break;				

			default:
				//array_push($jsArr, 3,103);
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

if( !function_exists('loadPartnerCSS') ) {
	function loadPartnerCSS( $pageName = 'home' ) {
		$cssFileArr = array(
			0  => 'partner/style.css',
			1  => 'partner/signup.css',
			2  => 'partner/signin.css',
			3  => 'partner/user_daycare_view.css',
			4  => 'partner/dashboard.css',
			5  => 'partner/fileUpload.css',
			6  => 'partner/gallery.css',

			101=>'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css',
			102=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.carousel.min.css',
			103=>'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.theme.default.min.css',
			104=>'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css',
			105=>'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css',
			106=>'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.11/skins/lightgray/skin.min.css'
		);
		
		$cssText = '';
		$cssArr = array(0,101);
		switch ($pageName) {
			case 'signup':
				array_push($cssArr,1);
			break;

			case 'signin':
				array_push($cssArr,2);
			break;				

			case 'create-branch':
			case 'edit-branch':
				array_push($cssArr, 1,104,105,106);
			break;

			case 'manage-gallery':
				array_push($cssArr, 5,6);
			break;			

			case 'dashboard':
				array_push($cssArr, 4);
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

function uploadfile($uploadedFilename, $vendorId, $destinationPath = ''){
        //$filename 			= strtolower($_FILES[$uploadedFilename]["name"]);
        $randomString 		= getRandomString();
        if(true == empty($destinationPath)){
        	$destinationPath = FCPATH . 'uploads/admin/' . $vendorId . '/';
    	} 
    	
    	if(false == file_exists($destinationPath)){
            $status = mkdir($destinationPath , 0777 , true);
        	if(false == $status) return false;
        }

        $info 			= new SplFileInfo($_FILES[$uploadedFilename]["name"]);
		$fileExtension 	= $info->getExtension();

		if($_FILES[$uploadedFilename]['error'] != 0 || $_FILES[$uploadedFilename]['name'] == '') return false;

		$filename 	= $uploadedFilename . '_' . $randomString . '_'.time(). '.' . $fileExtension;
		/*$config['upload_path'] 		= $destinationPath;
        $config['allowed_types'] 	= '*';
        $config['file_name']		= $filename;*/
        $config = array(
		    'logo' => array(
		        'upload_path'   => $destinationPath,
		        'allowed_types' => '*',
		        'file_name'		=> $filename
		    ),
		    'featured_image' => array(
		        'upload_path'   => $destinationPath,
		        'allowed_types' => '*',
		        'file_name'		=> $filename
		    ),
		    'gallery-image' => array(
		        'upload_path'   => $destinationPath,
		        'allowed_types' => '*',
		        'file_name'		=> $filename
		    ),
		);
        $CI = '';
        $CI =& get_instance();
     	$CI->load->library('upload');
     	$CI->upload->initialize($config[$uploadedFilename]);
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