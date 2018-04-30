<?php 
/**
 * S3 Bucket Helper
 */

defined('BASEPATH') OR exit('No direct script access allowed');

use Aws\CloudFront\CloudFrontClient;
use Aws\S3\S3Client;

/**
 * This function is used to upload files into s3 bucket
 */
function uploadFilesS3($filename, $file_details){
	$BUCKET_NAME = 'daycareindia1';

	$s3_path = '';
	if(!defined('AWS_URL')){
		define('AWS_URL','https://'.$BUCKET_NAME.'.s3.amazonaws.com/');
	}
	require_once(FCPATH.'vendor/awssdk/sdk.class.php');
	//init var
	$s3 = new AmazonS3();
	//show($s3);
	$try = 0;
	$sleep = 1;
	
	$opt = array(
		'fileUpload' => $file_details['tmp_name'],
		'contentType'=> $file_details['type']
		
	);

	do {
		$r = $s3->create_object( $BUCKET_NAME, $s3_path . $filename, $opt );
		show($r);
		if ($r->isOK()) {
			return $filename;
		}
		sleep($sleep);
		$sleep *= 2;
	} while (++$try < 2);
	
	return false;
}

