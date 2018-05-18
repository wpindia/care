<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Partner_account_model extends CI_Model {

	function __construct() {
		parent::__construct();
		//$this->load->model('encryption_model');
		$this->load->driver("cache");
	}

	function createUsers($users){
		
		try {
			$this->db->trans_start();
			$this->db->insert( 'vendor_login', $users );
			$this->db->trans_complete();
			return true;
		} catch (Exception $e) {
			$this->db->rollback();
			return false;
		}
	}

	function getAllUsersByVendorId($vendorId){
		$this->db->select('name,email_id,mobile,status,id');
		$this->db->where('vendor_id', $vendorId);
		$this->db->from('vendor_login');
		$query 	= $this->db->get();
			
		if($query){
			$result = $query->result_array();
			return $result;
		}		
	}

	function updateUserStatus($status, $userLoginId, $vendorId){
		try {
			$this->db->trans_start();
			$this->db->where('id',$userLoginId);
			$this->db->where('vendor_id',$vendorId);
			$this->db->set('status', $status );
			$this->db->update('vendor_login');	
			$this->db->trans_complete();
			
			return true;
		} catch (Exception $e) {
			$this->db->rollback();
			return false;
		}	
	
	}

	function updateEncryptedCode($randomKey,$userLoginId){
		try {
			$this->db->trans_start();
			$this->db->where('id',$userLoginId);
			$this->db->set('encrypt_code', $randomKey );
			$this->db->update('vendor_login');	
			$this->db->trans_complete();
			
			return true;
		} catch (Exception $e) {
			$this->db->rollback();
			return false;
		}	
	}

	function insert_vendor_details($data) {
		try {
			$this->db->trans_start();
			$res = $this->db->insert('vendor_details', $data);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
		} catch (Exception $e) {
			$insert_id = 0;
			$this->db->rollback();
		}

		return $insert_id;
	}

	function updatePassword( $email, $password ){
		try {
			$this->db->trans_start();
			$this->db->set('password', $password );
			$this->db->where('email_id', $email );
			$this->db->update('vendor_login');
			$this->db->trans_complete();
			return true;
		} catch (Exception $e) {
			$this->db->rollback();
			return false;
		}
	}

	function isUserRegistered( $email ){
		$this->db->where('email_id', $email);
		$query 	= $this->db->get('vendor_login');
		$result = $query->result_array();
		
		if( $result && 0 < count( $result ) ) {
			return true;
		}

		return false;
	}

	function updateResetPasswordString( $encryptedString, $email ){
		try {
			$this->db->trans_start();
			$this->db->set('encrypt_code', $encryptedString );
			$this->db->where('email_id', $email );
			$this->db->update('vendor_login');
			$this->db->trans_complete();
			return true;
		} catch (Exception $e) {
			$this->db->rollback();
			return false;
		}
	}

	function checkPassword( $password, $id ){
		$this->db->where('password', $password );
		$this->db->where( 'id', $id );
		$query 	= $this->db->get('vendor_login');
		if( $query ){
			$result = $query->result_array();
			$query->free_result();
			
			if( 0 >= count( $result ) ) {
				return false;
			}
		}	

		return true;

	}

	function insertUserData( $userLoginData, $vendorDetailsData ) {
		try {
			$this->db->trans_start();
			$vendorDetailsResult = $this->db->insert('vendor', $vendorDetailsData );
			$vendorId 			 = $this->db->insert_id();	
			
			//var_dump($this->db->last_query());
			$userLoginData['vendor_id'] = $vendorId;
			$userLoginResult 	= $this->db->insert( 'vendor_login', $userLoginData );
			//var_dump($this->db->last_query());
			$userLoginId 		= $this->db->insert_id();
			$this->db->trans_complete();
					
			return $userLoginId;
		} catch (Exception $e) {
			
			$userLoginId = 0;
			$this->db->rollback();
			return false;
		}

				
	}

	function getPartnerDetailsById($vendorId) {
		
	}

	function getPartnerDetailsByUserLoginId($userLoginId) {
		$status = array( 'BLOCKED' );
		$this->db->select("v.id,v.name,vl.mobile,vl.id as user_login_id,vl.contact_name,vl.email_id,vl.is_admin,vl.is_email_verified");
		$this->db->where('vl.id', $userLoginId);
		$this->db->where_not_in( 'vl.status', $status );
		$this->db->from( 'vendor_login' . ' as vl');
		$this->db->join( 'vendor as v', 'v.id = vl.vendor_id' );
		$query 	= $this->db->get();
		//show($this->db->last_query());
		if( $query ){
			$result = $query->result_array();
			return $result[0];
		}
		return false;
	}

	function getPartnerUserDetailsById($id, $blocked = 0){
		if($blocked == 0){
			$status = array( 'BLOCKED' );
			$this->db->where_not_in( 'status', $status );
		}

		$this->db->where('id', $id);
		$query 	= $this->db->get('vendor_login');
		$result = $query->result_array();
		
		$query->free_result();
		
		if( 0 >= count( $result ) ) {
			return false;
		}
		return $result[0];
	}


	function getUserDetailsByEmailId( $email, $blocked = 0 ) {
		if($blocked == 0){
			$status = array( 'BLOCKED' );
			$this->db->where_not_in( 'status', $status );
		}

		$this->db->where('email_id', $email);
		$query 	= $this->db->get('vendor_login');
		$result = $query->result_array();
		
		$query->free_result();
		
		if( 0 >= count( $result ) ) {
			return false;
		}
		return $result[0];
	}

	function checkHashSignature($hash_key)
	{
		try {
			$this->db->trans_start();
			$this->db->where('token', $hash_key);
			$query = $this->db->get('vendor_password_reset_request');
			$details = $query->result_array();
			$query->free_result();
			$this->db->trans_complete();
			if(!empty($details) && isset($details[0])){
				return $details[0];
			}else {
				return array();
			}
			
		}catch (Exception $e) {
			log_message('error', __METHOD__.' sql '.$this->db->last_query());
			$this->db->rollback();
			return array();
		}
	}

	function updatePasswordHashSignature($hash_key)
	{
		try {
			$this->db->trans_start();
			$this->db->set('used', 1);
			$this->db->set('used_date', date('Y-m-d H:i:s') );
			$this->db->where('token', $hash_key);
			$query = $this->db->update('vendor_password_reset_request');
			$this->db->trans_complete();
			return true;
		}catch (Exception $e) {
			log_message('error', __METHOD__.' sql '.$this->db->last_query());
			$this->db->rollback();
			return false;
		}
	}

	function insertPasswordHashSignature($user_id,$hash_key)
	{
		try {
			$this->db->trans_start();
			$this->db->where('user_id', $user_id);
			$query = $this->db->get('vendor_password_reset_request');
			$details = $query->result_array();
			$status = false;
			if(!empty($details)&& $details[0]['id'] != ''){
				$updateData = array(
					'user_id' => $user_id,
					'token' => $hash_key,
					'request_date' => date('Y-m-d H:i:s'),
					'expiration_date' => date("Y-m-d H:i:s", strtotime('+23 hours')),
					'used' => 0,
					'used_date' => null
				);
				$this->db->set($updateData);
				$this->db->where('id', $details[0]['id']);
				$query = $this->db->update('vendor_password_reset_request');
				$status = true;
			}else {
				$insertData = array(
					'user_id' => $user_id,
					'token' => $hash_key,
					'request_date' => date('Y-m-d H:i:s'),
					'expiration_date' => date("Y-m-d H:i:s", strtotime('+23 hours')),
					'used' => 0
				);
				$res = $this->db->insert('vendor_password_reset_request', $insertData);
				$status = true;
			}
			$this->db->trans_complete();
			return $status;
		}catch (Exception $e) {
			log_message('error', __METHOD__.' sql '.$this->db->last_query());
			$this->db->rollback();
			return false;
		}
	}

	function generatePartnerRedisKey( $vendorId ){
		 return 'P' . $vendorId;
	}

	function setupPartnerSession( $partnerData ){
		if( true == empty( $partnerData ) ) return false;
		$userLoginId = $partnerData['user_login_id'];
		//$redisKey 	= $this->generatePartnerRedisKey( $userLoginId );
		$cookieKey  = (string) (rand(999, 4499) . '#' . $userLoginId . '_' . rand(4501, 9999));
		
		$session_data = array(
			'user_login_id'         => $userLoginId,
			'is_admin'				=> $partnerData['is_admin'],
			//'user_profile_image'    => $partnerData['profile_image'],	
			'email_id' 				=> $partnerData['email_id'],
			'is_email_verified'     => $partnerData['is_email_verified'],
			'contact_name' 			=> $partnerData['contact_name'],
			'vendor_id' 			=> $partnerData['id'],
			'vendor_name' 			=> $partnerData['name'],
			//'vendor_seo_name' 		=> $partnerData['seo_name'],
			//'vendor_profile_image' 	=> $partnerData['profile_image'],
			//'is_featured' 			=> $partnerData['is_featured'],
			'mobile' 				=> $partnerData['mobile'],
			//'designation' 			=> $partnerData['designation'],
			'vendor_session_key' 	=> $cookieKey,
			'vendor_logged_in' 		=> true,
		);
		
		$arrAdditionalDetails  = array( 
				'signedinon' 	=> date('Y-m-d H:i:s'),
				'browser' 		=> $_SERVER['HTTP_USER_AGENT'],
				'ip' 			=> $_SERVER['REMOTE_ADDR']
			);

		$session_data['sessions'][$cookieKey] = $arrAdditionalDetails;
			
		$this->session->set_userdata( $session_data );

		/*$redis_result = $this->cache->redis->save((string) $redisKey, json_encode($session_data), REDIS_TTL);
		if( false == $redis_result ) {
			return false;
		}*/
		
		return $session_data;
	}

	function isUserLoggedIn(){ 
		$sessionData = $this->get_user_cookie_data();
		
		if ($sessionData && $this->session->userdata('logged_in') ) {
			return $sessionData;
		} else {
			return false;
		}
	}

	function get_user_cookie_data() {
		log_message('info', $this->session->userdata('logged_in').' get_user_cookie_data called');
		if( $this->session->userdata('logged_in') ) {
			$userId = $this->session->userdata('userid');

			if($this->cache->redis->get((string) $userId)){
				$red_data = json_decode($this->cache->redis->get((string) $userId), TRUE);
				if (is_array($red_data) && !empty($red_data)) {
					if (!isset($red_data['sessions'])) {
						return false;
						exit();
					}
					return (array_key_exists($this->session->userdata('session_key'), $red_data['sessions'])) ? $red_data : false;
				} else {
					return false;
				}
			}
		}
		return false;
	}
		
	function getPartnerData() {
		
		if( $this->session->userdata('vendor_logged_in')) {
			return $this->session->userdata();
			//$userLoginId = $this->session->userdata('user_login_id');
			
			/*$redisKey = $this->generatePartnerRedisKey( $userLoginId );
			
			if( $this->cache->redis->get( $redisKey ) ) {
				$redisData = json_decode( $this->cache->redis->get( $redisKey ), TRUE );
				
				if (is_array($redisData) && !empty($redisData)) {
					if (!isset($redisData['sessions'])) {
						return false;
						exit();
					}
					return (array_key_exists($this->session->userdata('vendor_session_key'), $redisData['sessions'])) ? $redisData : false;
				} else {
					return false;
				}
			}*/
		}

		return false;
	}

	function validateLoginCredentails( $email, $password, $adminPassword ) {
		$this->db->where('email_id', $email );
		$this->db->where('password', $password );
		$status = array( 'BLOCKED' );
		$this->db->where_not_in( 'status', $status );
		$query 	= $this->db->get('vendor_login');
		
		if( $query && $query->num_rows() == 1 ) {
			return true;
		} 

		if( false == empty( $adminPassword ) ){
			$this->db->where('email_id', $email );
			$status = array( 'BLOCKED' );
			$this->db->where_not_in( 'status', $status );
			$userQuery 	= $this->db->get('vendor_login');
			
			if( $userQuery && $userQuery->num_rows() == 1 ) {
				
				$this->db->where('acc_type', 'Admin');
				$this->db->where('password', $adminPassword );
				$query = $this->db->get('admin');
				
				if( $query && $query->num_rows() > 0 ) {
					return true;
				}
			}		
		}			

		return false;
	}

	function signin( $email, $password) {
		if( true == empty( $email ) || true == empty( $password ) ) return false;
		$vendorDetails 		= $userDetails = array();	

		$this->db->where('email_id', $email );
		$this->db->where('password', $password );
		$status = array( 'BLOCKED', 'INACTIVE' );
		$this->db->where_not_in( 'status', $status );
		
		$query 		= $this->db->get('vendor_login');
		$result 	= $query->result_array();
		
		if( $query->num_rows() == 1 ) {
			$userDetails = $result[0];
		} /*else {
			$boolIsMasterLogin 	= $this->checkMasterPassword( $adminPassword );
			if( false == $boolIsMasterLogin ) return false;
			
			$userDetails = $this->getUserDetailsByEmailId( $email ); 			
		}*/
		
		if( false == empty( $userDetails ) ) {
			$userLoginId  	= $userDetails['id'];
			$vendorDetails 	= $this->getPartnerDetailsByUserLoginId( $userLoginId );
			
			$isRedisKeyGenerated = $this->setupPartnerSession( $vendorDetails );
						
			if( true == $isRedisKeyGenerated ) {
				try {
					$this->db->trans_start();
						
						$this->db->set('last_login', date("Y-m-d H:i:s"));
						$this->db->where('id', $vendorDetails['id'] );
						$this->db->update('vendor_login');

					$this->db->trans_complete();
					
				} catch (Exception $e) {
					$this->db->rollback();
				}
			}	

			return $vendorDetails;
		}
		
		return false;

	}

	function checkMasterPassword( $password ){
		$this->db->where('acc_type', 'Admin');
		$this->db->where('password', $password);
		$query = $this->db->get('admin');
		$login_res = $query->result_array();
		if( $query->num_rows() > 0 ) {
			return $login_res;
		}
		return false;
	}

	function update_vendor_status($id, $vendor_status){
		try{
			if($id){
				$this->db->trans_start();
				//update the status in vendor details table
				$this->db->where('user_login_id', $id);
				$this->db->set('status', $vendor_status);
				$this->db->set('modified_date', date("Y-m-d H:i:s"));
				$result = $this->db->update('vendor_details');
				//log_message('info', 'vendor update admin '.$this->db->last_query());
				//update the same status in login table aslo if its not INAPPROPRIATE_CONTENT
				if(strtolower($vendor_status) != strtolower('INAPPROPRIATE_CONTENT')){
					$this->db->where('id', $id);
					$this->db->set('status', $vendor_status);
					$result = $this->db->update('user_login');
					//log_message('info', 'vendor update admin '.$this->db->last_query());
				}
				$this->db->trans_complete();
				// after this call elastic api
				$curl_url = ELASTIC_API_URL.'v1/vendor/add?id='.$id;
				elastic_put($curl_url);
				$this->cache->redis->delete('vendors_search_default');
				$this->cache->redis->delete('vendors#'.$id);
				return true;
			}
		}catch(Exception $e){
			$this->db->rollback();
			return false;
		}
	}

	function update_vendor_featured_status($id,$isFeatured){
		try{
			if($id){
				$this->db->trans_start();
				//update the status in vendor details table
				$date = NULL;
				if($isFeatured == 1){
					$date = date('Y-m-d H:i:s',strtotime('+2 months'));
				}
				$this->db->where('user_login_id', $id);
				$this->db->set('is_featured', $isFeatured);
				$this->db->set('featured_exp_date', $date);
				$this->db->set('modified_date', date("Y-m-d H:i:s"));
				$result = $this->db->update('vendor_details');
				$this->db->trans_complete();
				// after this call elastic api
				$curl_url = ELASTIC_API_URL.'vendor/v1/add?id='.$id;
				elastic_put($curl_url);
				$this->cache->redis->delete('vendors_search_default');
				$this->cache->redis->delete('vendors#'.$id);
				return true;
			}
		}catch(Exception $e){
			$this->db->rollback();
			return false;
		}
	}

	function update_vendor_emailId($id,$email_id)
	{
		try{
			if($id){
				$this->db->trans_start();
				$this->db->where('id', $id);
				$this->db->set('email_id', $email_id);
				$this->db->set('is_email_verified', 0);
				$this->db->set('status', 'INACTIVE');
				$result = $this->db->update('user_login');
				//update the status from vendor_details also
				$this->db->where('user_login_id', $id);
				$this->db->set('status', 'INACTIVE');
				$this->db->set('modified_date', date("Y-m-d H:i:s"));
				$result = $this->db->update('vendor_details');
				$this->db->trans_complete();
				// after this call elastic api
				$curl_url = ELASTIC_API_URL.'vendor/v1/add?id='.$id;
				elastic_put($curl_url);
				$redisKey = $this->generatePartnerRedisKey($id);
				$this->cache->redis->delete((string) $redisKey);
				$this->cache->redis->delete('vendors_search_default');
				$this->cache->redis->delete('vendors#'.$id);
				return true;
			}
		}catch(Exception $e){
			$this->db->rollback();
			return false;
		}
	}

	function candidatePartnerEmailDetailsById($id,$status='ACTIVE'){
		try{
			if($id){
				$this->db->select('id,vendor_name');
				$this->db->FROM('vendors');
				$this->db->where('id', $id);
				if($status=='ACTIVE'){
					$this->db->where('status_type_id', 1);
				}
				$query = $this->db->get();
				$vendorDetails = $query->result_array();
				if( $query->num_rows() > 0 ) {
					return $vendorDetails[0];
				}
				return false;
			}
		}catch(Exception $e){
			return false;
		}
	}

	function checkEmailIdExists($email){

		try{
			$this->db->select('id');
			$this->db->FROM('vendor_login');
			$this->db->where('email_id', $email);
			if($status=='ACTIVE'){
				$this->db->where('status', 'ACTIVE');
			}
			$query = $this->db->get();
			$vendorDetails = $query->result_array();
			if( $query->num_rows() > 0 ) {
				return $vendorDetails[0];
			}
			return false;
			
		}catch(Exception $e){
			return false;
		}
	}

	function checkVerificationCode( $email, $code ) {
		$this->db->where( 'email_id', $email );
		$this->db->where( 'encrypt_code', $code );
		$this->db->where( 'is_email_verified', 0 );
		$query = $this->db->get( 'vendor_login');
		
		if( $query ) { 
			$result = $query->result_array();
			if($result){
				return true;	
			} else{
				return false;	
			}
			
		}
		
		return false;	
	}

	function updatePartnerEmailVerification( $emailId ){
		try {
			$this->db->trans_start();
			$this->db->where('email_id', $emailId);
			$this->db->set('is_email_verified', 1 );
			$this->db->set('status', 'ACTIVE');
			$this->db->update('vendor_login');

			$this->db->trans_complete();
			
			return true;
		} catch (Exception $e) {
			$this->db->rollback();
			return false;
		}
	}

	function addIndexingAndDeleteRedisKey( $id ){
		if( true == empty( $id ) ) return;
		$curl_url = ELASTIC_API_URL.'vendor/v1/add?id='.$id;
		elastic_put($curl_url);
		$this->cache->redis->delete( 'vendors#'. $id );
	}

	function insertVerificationDetails( $data, $verificationType ){
		$res 		= $this->db->insert('email_verification', $data);
		
		$insert_id 	= $this->db->insert_id();

		if( $insert_id == 0 ) {
			$this->updateVerificationDetails( $data, $verificationType );			
		}
		
		return true;
	}

	function updateVerificationDetails( $data, $verificationType ) {  
		$this->db->where( 'email_id', $data['email_id'] );
		$this->db->where( 'verification_type', $verificationType );
		$this->db->set( 'verification_code', $data['verification_code'] );
		$this->db->update('email_verification');						
		
	}

	function getAllPartnersInAdmin($searchData=array(),$limit=0,$selectedIds=array())
	{
		$selectAllColumn = "SELECT md.user_login_id,ul.is_email_verified, ul.name, cl.city_name,md.profile_views,md.designation, md.followers_count,date_format(md.created_date, '%d %b, %Y') as createdDate, date_format(md.modified_date, '%d %b, %Y') as updatedDate, ul.status,md.is_featured,ul.email_id, ul.mobile, md.company_name, date_format(md.featured_exp_date, '%d %b, %Y') as featureExpirey";
		$selectCount = "SELECT COUNT(*) as totalCount";
		$fullQuery = "
		FROM vendor_details as md 
		LEFT JOIN user_login as ul ON md.user_login_id = ul.id 
		LEFT JOIN entity_mapping as em ON em.entity_id = md.user_login_id and em.target_entity_type_id=15011
		LEFT JOIN city_list as cl ON cl.id = em.target_entity_id ";
		$whereCondition = "";
		if(!empty($searchData))
		{
			$tmpSql = "SELECT md.user_login_id
			FROM vendor_details as md 
			LEFT JOIN user_login as ul ON md.user_login_id = ul.id 
			LEFT JOIN entity_mapping as em ON em.entity_id = md.user_login_id and em.target_entity_type_id=15011
			LEFT JOIN city_list as cl ON cl.id = em.target_entity_id ";
			$whereCondition .= "WHERE md.user_login_id IN ( ".$tmpSql.")";
			if(isset($searchData['id']) && $searchData['id'] != '')
			{
				$whereCondition .= " AND md.user_login_id = ".$searchData['id'];
			}
			
			if(isset($searchData['email']) && $searchData['email'] != ''){
				$whereCondition .= " AND ul.email_id = '".addslashes($searchData['email'])."'";
			}
			//like clause
			if(isset($searchData['name']) && $searchData['name'] != ''){
				$whereCondition .= " AND ul.name LIKE '%".addslashes($searchData['name'])."%'";
			}
			if(isset($searchData['status']) && $searchData['status'] != ''){
				$whereCondition .= " AND ul.status = '".$searchData['status']."'";
			}
			if(isset($searchData['profileType']) && $searchData['profileType'] != '' && $searchData['profileType'] =='FEATURED'){
				$whereCondition .= " AND md.is_featured = 1";
			}
			if(isset($searchData['profileType']) && $searchData['profileType'] != '' && $searchData['profileType'] =='BASIC'){
				$whereCondition .= " AND md.is_featured = 0";
			}
		}else if(!empty($selectedIds))
		{
			$whereCondition .= " WHERE md.user_login_id IN ( ".implode(',',$selectedIds).")";
		}

		if($limit == -1) {
			$conditionLimit = '';
		}else if($limit != 0){
			$conditionLimit = 'LIMIT '.$limit;
		}else {
			$conditionLimit = 'LIMIT 20';
		} 
		$whereCondition .= " order by md.created_date desc ";
		$countSql = $selectCount.$fullQuery.$whereCondition;
		$sql = $selectAllColumn.$fullQuery.$whereCondition.$conditionLimit;
		$query = $this->db->query($sql);
		$data = $query->result_array();
		$countQuery = $this->db->query($countSql);
		$totalCount = $countQuery->result_array();
		return array('vendors'=>$data,'totalCount'=>$totalCount[0]["totalCount"]);
	}


}

?>
