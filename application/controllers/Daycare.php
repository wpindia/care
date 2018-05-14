<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daycare extends CI_Controller {

    protected $path = '';
    protected $partnerData;
    protected $vendorId;
    protected $vendorAssociationIds;
    
    function __construct() {
        parent::__construct();
        $this->load->helper('common_helper');
        $this->load->model('daycare_model');
        $this->load->model('common_model');
        
        $this->data['showSearch'] = true;
        //$this->load->model('partner_account_model');
        /*$this->load->helper('partner_helper');
        $this->load->helper('common');
        $this->load->library('redis');
        $this->load->model('vendors_model');
        $this->load->model('city_model');
        
        $this->load->model('partner_profile_model');
        $this->load->model('encryption_model');
        $this->key_emailer = '6751483920';

        //$vendorId  = 1;
        */
        /*$this->data['logged']   = 0;
        $this->partnerData      = $this->partner_account_model->getPartnerData(); 
        //var_dump($this->partnerData);
       if( false == empty( $this->partnerData ) ) {
            
            $this->data['logged'] = 1;
            $this->data['id']     = (int) $this->partnerData['user_login_id'];
            $this->data['name']   = $this->partnerData['contact_name'];
            $this->vendorId       = $this->partnerData['vendor_id'];
            $this->data['partnerData'] = $this->partnerData;
        }*/

        /*$this->check_device();
        $this->data['device'] = $this->device;
        */  
    }

    /*********************
    ********Actions******    
    *********************/

    public function index() {
        //404 page
        /*$this->data['pageName'] = 'user-daycare-view';

        $this->generateView('user_daycare_view.php',$this->data);
        *///$this->generateView('home',$this->data);
    }

    public function cityListing($city){

    }

    public function search($city,$areaName){
        $this->data['pageName'] = 'search-results';
        $this->data['selectedArea'] = ucwords(urldecode($areaName));
        $cityId = getCityIdByName($city);
        $areaId = getAreaIdByName($areaName);
        $this->data['daycares'] = $this->common_model->getDaycaresByCityIdByAreaId($cityId,$areaId);
        //show($this->data['daycares']);

        $this->generateView('search_results.php',$this->data);
        //show($daycares); 
    }

    public function displayDaycare($city,$area,$slug){
        $this->data['pageName'] = 'user-daycare-view';
        $this->data['selectedArea'] = ucwords(urldecode($area));
        $url = $city . '/' .  $area . '/' . $slug;
        $seoName = urlencode( strtolower( $url ) );
        
        $this->data['daycareDetails']   = (array)$this->daycare_model->getDaycareDetailsBySeoName($seoName);
        $this->data['daycares']         = $this->daycare_model->getDaycaresByVendorId($this->data['daycareDetails']['vendor_id']);
        $this->data['galleryImages']    = $this->daycare_model->getGalleryImagesByBranchId($this->data['daycareDetails']['id']);

        $this->daycare_model->updateProfileViews($this->data['daycareDetails']['id']);

        $this->data['showSearch'] = false;
        $this->generateView('user_daycare_view.php',$this->data);
    }

    public function deleteSampleDocs(){
        $this->load->model('reskilling_model');
        $id         = $this->input->post('id');
        $entityId   = $this->input->post('entity_id');
        
        //$isValidUser = $this->reskilling_model->isValidEditUser( $id, $entityId );
        $this->reskilling_model->deleteSampleDocs($id, $entityId);        
        echo json_encode(true);
    }

    function handleUploadImageGallery(){
        $destinationPath    = 'uploads/admin/reskilling/samples/'. $this->partnerData['vendor_id'] .'/';
        $imageName          = $this->uploadImage($destinationPath); 
        
        $insertData = array(
            'entity_id'         => $this->partnerData['vendor_id'],
            'entity_type_id'    => COURSE_TYPE_ID,
            'image_name'        => $imageName,
            'created_date'      => date('Y-m-d H:i:s')
        );
        
        $galleryId = $this->reskilling_model->insertOrUpdateSamples( $insertData );

        //json_encode(array($galleryId));
    }


    public function signin(){
        $this->data['pageName'] = 'signin'; 

        $this->generateView( 'signin', $this->data);
    }

    public function signup(){
        $this->data['pageName'] = 'signup'; 
        //$this->data['cities']   = $this->city_model->getAllCitiesForSearch();
        $this->generateView( 'signup', $this->data );
    }

    public function changeUserStatus(){
        if( $this->partnerData['is_admin'] == 0 ){
            redirect('partner/dashboard');
        }

        $status         = $this->input->post('status');
        $userLoginId    = $this->input->post('userLoginId');
        $vendorId       = $this->vendorId;

        $status = ( $status == 'ACTIVATE' ) ? 'ACTIVE' : 'INACTIVE';

        $isRecordUpdated = $this->partner_account_model->updateUserStatus($status, $userLoginId, $vendorId);
        
        echo json_encode($isRecordUpdated);
    }

    public function manageUsers(){
        if( $this->partnerData['is_admin'] == 0 ){
            redirect('partner/dashboard');
        }

        $this->data['pageName']     = 'manage-users';
        $this->data['userDetails']  = $this->partner_account_model->getAllUsersByVendorId($this->vendorId);
        
        $this->displayPages( 'partner/manage-users', $this->data, true );   
    }

    public function addUser(){
        if( $this->partnerData['is_admin'] == 0 ){
            redirect('partner/dashboard');
        }

        $this->data['pageName'] = 'add-user';
        $this->displayPages( 'partner/add-user', $this->data, true );   
    }

    public function createUser(){
        $coUserName    = $this->input->post('couser-name');
        $coUserMobile   = $this->input->post('couser-mobile');
        $coUserEmail    = $this->input->post('couser-email');

        //$totalUsers = count( $coUserEmail );
        $users = array();
        //for($counter = 0;$counter< $totalUsers; $counter++ ){
            $users = array(
                'name'      => $coUserName,
                'email_id'  => $coUserEmail,
                'mobile'    => $coUserMobile,
                'vendor_id' => $this->vendorId,
                'status'    => 'ACTIVE',
                'password'  => md5($this->randomPassword(8))
            );
        //}

        $isUserCreated = $this->partner_account_model->createUsers($users);

        if(true == $isUserCreated){
            $this->session->set_flashdata('set_flashdata', 'Users created successfully!!');
            redirect('partner/manage-users');
        } else{
            $this->session->set_flashdata('set_flashdata', 'Something went wrong..');
            redirect('partner/manage-users');
        }
    }

    private function randomPassword( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }


    public function updateProfile(){
        $this->data['pageName'] = 'update-profile';
        $type           = $this->input->post('type');
        $changedValue   = $this->input->post('changedValue');
        
        $updateData = array(
            $type  => $changedValue
        );
        
        $isRecordUpdated = $this->partner_profile_model->updateAccountDetails( $updateData, $this->data['id'] );

        echo json_encode( $isRecordUpdated ); 

    }

    public function settings(){
        if($this->data['logged'] == 0){
            redirect('partner/');
        }

        $this->data['partnerData']   = $this->partnerData;
        $this->data['pageName']     = 'settings'; 

        $this->displayPages('partner/settings', $this->data, true);
    
    }

    public function dashboard() {
        if($this->data['logged'] == 0){
            redirect('partner/');
        }
        
        $this->data['pageName'] = 'dashboard'; 

        $profieViewCount = 0;
                
        $this->data['vendorData']         = $this->vendors_model->getVendorDetailsById( $this->vendorId );
        $this->data['profileViewCount']   = $profieViewCount;

        $this->data['totalCourses']     = 0;
        $this->data['totalAssessments'] = 0;
        $this->data['totalServices']    = 0;

        if( true == in_array(1, $this->vendorAssociationIds) ){
            $this->data['totalCourses']         = $this->reskilling_model->getTotalEntities(COURSE_TYPE_ID, $this->vendorId);
            $this->data['topViewedCourses']     = $this->reskilling_model->getTopEntitiesByViews(COURSE_TYPE_ID, 5, $this->vendorId);
            $this->data['topClickedCourses']    = $this->reskilling_model->getTopEntitiesByClicks(COURSE_TYPE_ID, 5, $this->vendorId );
            $this->data['newCourses']           = $this->reskilling_model->getNewEntities(COURSE_TYPE_ID, 5, $this->vendorId );
        }

        if( true == in_array(2, $this->vendorAssociationIds) ){
            $this->data['totalAssessments']      = $this->reskilling_model->getTotalEntities(ASSESSMENT_TYPE_ID, $this->vendorId);
            $this->data['topViewedAssessments']  = $this->reskilling_model->getTopEntitiesByViews(ASSESSMENT_TYPE_ID,5, $this->vendorId);
            $this->data['topClickedAssessments'] = $this->reskilling_model->getTopEntitiesByClicks(ASSESSMENT_TYPE_ID,5, $this->vendorId);
            $this->data['newAssessments']        = $this->reskilling_model->getNewEntities(ASSESSMENT_TYPE_ID,5, $this->vendorId);
        }

        if( true == in_array(3, $this->vendorAssociationIds) ){
            $this->data['totalServices']         = $this->reskilling_model->getTotalEntities(SERVICE_TYPE_ID, $this->vendorId);
            $this->data['topViewedServices']     = $this->reskilling_model->getTopEntitiesByViews(SERVICE_TYPE_ID, 5, $this->vendorId);
            $this->data['topClickedServices']    = $this->reskilling_model->getTopEntitiesByClicks(SERVICE_TYPE_ID, 5, $this->vendorId );
            $this->data['newServices']           = $this->reskilling_model->getNewEntities(SERVICE_TYPE_ID, 5, $this->vendorId );
        }
        //$this->data['profileCompletePercentage']    = $this->getProfilePercentage();
        $this->displayPages( 'partner/dashboard', $this->data, true );
        
    }

    function __validateEmailPassword( $password ){
        $email          = $this->input->post('email');
        $adminPassword  = base64_encode( $password );
        $password       = md5( $password );
        
        $isValidLogin   = $this->partner_account_model->validateLoginCredentails( $email, $password, $adminPassword );
    
        return $isValidLogin;
    }    

    function validateSignInForm(){
        $signinRules = array(
            array(
                'field' => 'email',
                'label' => 'Email ID',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|xss_clean|callback___validateEmailPassword'
            )
        );

        $this->form_validation->set_message('__validateEmailPassword', "Email Id/Password incorrect! Try again!");
        $this->form_validation->set_rules($signinRules);
        $this->form_validation->set_error_delimiters('<div class="formerror center-align">', '</div>');
        
        $isValidForm = $this->form_validation->run();
        
        return $isValidForm;

    }

    public function getLocationByCityId(){
        show('123');
        $cityId = $this->input->post('city_id');
        $array = array('Kothrud','Shivaji Nagar'); 
        echo json_encode($array);
    }

    public function signinProcess(){
        
        $this->data['pageName'] = 'signin-process';
        
        $isValidLogin = $this->validateSignInForm();
        if( false == $isValidLogin ) {
            $this->data['signinErrors'] = validation_errors();
            redirect('signin');
        }

        $currentURL     = $this->input->post('current_url');
        $loginEmail     = $this->input->post('email');
        $loginPassword  = md5( $this->input->post('password') );
        $partnerDetails  = $this->partner_account_model->signin( $loginEmail, $loginPassword);
        
        if( true == is_array( $partnerDetails ) ) {
            $this->data['logged'] = 1;
            redirect('dashboard', 'refresh');
        } else {
            $this->data['signinErrors'] = 'Account is Inactive/Blocked!';
            $this->signin();
        }
         
    }    

    // validate partner details

    // add partner_details
    // add partner to elastic search
    // send verification email 
    // setup partner session
    function validateSignUpForm(){
        $signupRules = array(
            array(
                'field' => 'vendor_name',
                'label' => 'Day Care Name',
                'rules' => 'trim|required|xss_clean|is_unique[vendor.name]'
            ),
            array(
                'field' => 'mobile_no',
                'label' => 'Mobile No',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email|is_unique[vendor_login.email_id]',
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'contact_name',
                'label' => 'Contact Name',
                'rules' => 'trim|required',
            ),

        );

        $this->form_validation->set_message('is_unique', 'Email Id/Day Care Name already exists');
        $this->form_validation->set_rules($signupRules);
        $this->form_validation->set_error_delimiters('<div class="formerror">', '</div>');
        
        $isValidForm = $this->form_validation->run();
        
        return $isValidForm;
    }

    function validateChangePasswordForm(){
        
        $changePasswordRules = array(
            array(
                'field' => 'old-password',
                'label' => 'Current Password',
                'rules' => 'trim|required|xss_clean|callback___validatePassword'
            ),
            array(
                'field' => 'new-password',
                'label' => 'New Password',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'confirm-password',
                'label' => 'Confirm Password',
                'rules' => 'trim|required|matches[new-password]',
                    
            )
        );

        $this->form_validation->set_message('__validatePassword','Current Password does not match');
        $this->form_validation->set_rules($changePasswordRules);
        $this->form_validation->set_error_delimiters('<div class="formerror">', '</div>');
        
        $isValidForm = $this->form_validation->run();
        
        return $isValidForm;
    }

    function __validatePassword( $password ){
        $isValidPassword = $this->partner_account_model->checkPassword( md5( $password ), $this->data['id'] );
        return $isValidPassword;
    }

    public function changePassword(){
        $isValidForm = $this->validateChangePasswordForm();
        
        if( false == $isValidForm ) {
            $errors = validation_errors();
            $this->session->set_flashdata('set_flashdata','Error Occured' . $errors);
            redirect('partner/my-account');
        }

        $password   = md5( $this->input->post('new-password') );
        $email      = $this->partnerData['email_id']; 

        $status = $this->partner_account_model->updatePassword( $email, $password );

        if($status){
            $this->session->set_flashdata('set_flashdata', 'Password updated successfully!');
            redirect('partner/my-account', 'refresh');
        }else{
            $this->session->set_flashdata('set_flashdata','Error Occured' . $errors);
            redirect('partner/my-account');
            
        }         
    }

    public function signupProcess(){
        $isValidForm = $this->validateSignUpForm();

        $this->data['pageName'] = 'signup-process'; 
        //$this->data['cities']   = $this->city_model->getAllCitiesForSearch();

        if( false == $isValidForm ) {
            $this->data['pageName'] = 'signup'; 
            $this->generateView( 'signup', $this->data);
            return;
        } else{
            $vendorName         = trim( $this->input->post('vendor_name') );
            $mobileNumber       = $this->input->post('mobile_no');
            $emailId            = trim( strtolower( $this->input->post('email') ) );
            $password           = md5( $this->input->post('password') );
            $seoName            = generateSlug($vendorName); 
            $contactName        = $this->input->post('contact_name'); 
            $cityId             = $this->input->post('city');
            //$randomKey       = random_string( 'alnum', 50 );
            //$text            = $emailId . '#' . $randomKey . '#' . $emailId;
            //$encryptedCode   = $this->encryption_model->encryptNET3DES( $this->key_emailer, $text );

            $partnerLoginData = array(
                'contact_name'              => $contactName,
                'email_id'          => $emailId,
                'password'          => $password,
                'mobile'            => $mobileNumber,
                'last_login'        => date('Y-m-d H:i:s'),
                'is_admin'          => 1,
                'created_date'      => date('Y-m-d H:i:s'),
                //'encrypt_code'      => $randomKey 
            );

            $partnerDetailsData = array(
                'name'                  => $vendorName,
                'city_id'               => $cityId,
                'created_date'          => date('Y-m-d H:i:s'),
                'modified_date'         => date('Y-m-d H:i:s')
            );
            //var_dump($partnerLoginData);
            //var_dump($partnerDetailsData);
            //exit;
            $userLoginId = $this->partner_account_model->insertUserData( $partnerLoginData, $partnerDetailsData );
            
            if( 0 == $userLoginId ) {
                log_message('INFO', 'unable to store in database ' . $emailId . ' name ' . $legalName );
                /*$this->data['error_message'] = 'Issue with db! Please try agaian after sometime.';
                $this->data['pageName'] = 'signup'; 
                $this->displayPages( 'partner/signup', $this->data, true );*/
                $this->session->set_flashdata('set_flashdata', 'Some error occurred. Please try again after sometime!');
                redirect('signup', 'refresh');
                return; 
            }
            
            $this->partnerData  = $this->partner_account_model->getPartnerDetailsByUserLoginId( $userLoginId );
            $redisData    = $this->partner_account_model->setupPartnerSession( $this->partnerData );
            
            if( false == $redisData ) {
                log_message('INFO', 'unable to store in redis ' . $userLoginId );
                $this->session->set_flashdata('set_flashdata', 'Some error occurred. Please try again after sometime!');
                redirect('signup', 'refresh');
            }
            
            $this->partnerData = $redisData;    
            
            //send partner emails
                                
            /*$data['encrypt_code'] = urlencode( $encryptedCode );

            $message    = $this->load->view('/emailer/partner/verify-emailid', $data, TRUE); 
            $subject    = 'Verify your email id to complete your registration';       
            $mailStatus = $this->send_verifymail( $emailId, $subject, $message);      */

            //$this->sendPartnerVerificationEmail( $email, Account::SIGNUP_VERIFICATION );                 
            
            $this->data['logged']   = 1;
            //$this->data['id']       = $this->partnerData['partner_id'];  
            //$this->data['pageName'] = 'signup-success';
            redirect( 'welcome', 'refresh' );
        } 
    }

    public function welcome(){
        if($this->data['logged'] == 0){
            redirect('/');
        }
        $this->data['pageName']     = 'signup-success';
        $this->data['partnerData']   = $this->partnerData;        
        $this->generateView( 'welcome', $this->data );
        //$this->generateView( 'account/signup-success', $this->data );
    }

    function validateResetPasswordForm(){
        
        $changePasswordRules = array(
            array(
                'field' => 'new-password',
                'label' => 'New Password',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'confirm-password',
                'label' => 'Confirm Password',
                'rules' => 'trim|required|matches[new-password]',
                    
            )
        );

        $this->form_validation->set_rules($changePasswordRules);
        $this->form_validation->set_error_delimiters('<div class="formerror">', '</div>');
        
        $isValidForm = $this->form_validation->run();
        
        return $isValidForm;
    }


    public function updatePassword(){
        $isValidForm = $this->validateResetPasswordForm();
        $email       = $this->input->post('email');
       
        if( false == $isValidForm ) {
            $this->data['pageName'] = 'reset-password';
            $this->data['email']    = $email;
            $this->generateView( 'account/reset-password', $this->data );               
            return false;
        }
                
        $password   = md5( $this->input->post('new-password') );

        $isPasswordUpdated = $this->partner_account_model->updatePassword( $email, $password ); 
        $this->session->set_flashdata('success_message', 'Password updated successfully! Sign in with new password entered.');

        $this->data['pageName'] = 'reset-password';
        $this->data['email']    = $email;
        $this->generateView( 'account/reset-password', $this->data );               

    }

    public function verifyAccount(){
        
        $this->data['pageName']     = 'verify-account';
        
        $encryptionCode = $_GET['hash'];
        $decryptedCode  = $this->encryption_model->decryptNET3DES( $this->key_emailer, $encryptionCode );
        $decryptedCode  = explode( "#", $decryptedCode );
        $email          = $decryptedCode[0];
        $code           = $decryptedCode[1];
        $result         = $this->partner_account_model->checkVerificationCode( $email, $code );
        
        if( true == $result ) {
            $partnerData        = $this->partner_account_model->getUserDetailsByEmailId( $email );
            $isRecordUpdated    = $this->partner_account_model->updatePartnerEmailVerification( $email );
            
            if( true == $isRecordUpdated ) {
                $this->partner_profile_model->updatePartnerUserDetailsRedisData( $partnerData['id'] );
                $data['partner_name']  = $partnerData['name'];      
                
                $message    = $this->load->view('/emailer/partner/welcome', $data, TRUE); 
                $subject    = 'Thank you for partnering with us';       
                $mailStatus = $this->send_verifymail( $email, $subject, $message);      
                                
                $this->session->set_flashdata('set_flashdata', 'Your account is now verified!');
                redirect('partner/dashboard', 'refresh');
                
            } else {
                if( true == empty( $this->partnerData ) ) {
                    $this->session->set_flashdata('set_flashdata', 'Link is broken!');   
                    redirect('partner/','refresh');
                    return;
                } else{
                    $this->session->set_flashdata('set_flashdata', 'Link is broken!');
                    redirect('partner/dashboard', 'refresh');
                }        
            }
        } else{
            if( true == empty( $this->partnerData ) ) {
                $this->session->set_flashdata('set_flashdata', 'Link is broken!');                                
                redirect('partner/','refresh');
                return;
            } else{
                $this->session->set_flashdata('set_flashdata', 'Link is broken!');
                redirect('partner/dashboard', 'refresh');
            }
        }
    }

    public function logout(){
        /*$redisKey           = $this->partner_account_model->generatePartnerRedisKey($this->partnerData['user_login_id']);
        $status             = $this->cache->redis->delete((string) $redisKey);*/
        $sess_out           = $this->session->sess_destroy();
        
        redirect(base_url());
    }

    public function checkEmailIdExists(){
        
        $partnerEmail    = $this->input->post('email');
        
        if( true == empty( $partnerEmail ) ) return false;

        $result         = $this->partner_account_model->checkEmailIdExists( $partnerEmail );
        
        echo json_encode( $result );
    }

    public function setPassword($hashKey='')
    {
        if($this->data['logged'] == 1){
            redirect('partner/dashboard');
        }

        $token = trim($this->input->post('token'));
        $this->data['user_details'] = array();
        if($hashKey != ''){
            $token = trim($hashKey);
        }
        
        if($token != ''){
            $hashDetails = $this->partner_account_model->checkHashSignature($token);
            if(!empty($hashDetails)){
                $this->data['user_details'] = $this->partner_account_model->getPartnerUserDetailsById($hashDetails['user_id']);
                
                if(!empty($this->data['user_details'])){
                    $this->data['token'] = $token;
                    $this->data['email'] = $this->data['user_details']['email_id'];
                }
                $today = strtotime(date("Y-m-d H:i:s"));
                $expired_time = strtotime($hashDetails['expiration_date']);
                if($hashDetails['used'] == 1){
                    $this->data['setupMessage'] = 'This Link is expired.';
                }else if($today > $expired_time){
                    $this->data['setupMessage'] = 'This Link is expired.';
                }
            }
            if ($this->input->post('token') != '' && !empty($this->data['user_details'])){
                $user_id = $this->data['user_details']['id'];
                $email_id = $this->data['user_details']['email_id'];
                $setPwd = array(
                    array(
                        'field' => 'new_pswd',
                        'label' => 'new password',
                        'rules' => 'trim|required|xss_clean'
                    )
                );
                $this->form_validation->set_rules($setPwd);
                $this->form_validation->set_error_delimiters('<div class="formerror error">', '</div>');
                if ($this->form_validation->run() == TRUE) {
                    $new_password   = $this->input->post('new_pswd');
                    $login_password = md5($new_password);
                    $data = array(
                        'password' => $login_password
                    );
                    $pwd_update = $this->partner_account_model->updatePassword($this->data['user_details']['email_id'], $login_password);
                    $this->partner_account_model->updatePasswordHashSignature($token);
                    
                    $this->data['setupMessage'] = 'Password changed successfully.';
                    //$this->session->set_userdata('sessionFlashMessage', '<span class="flash-message success">Password changed successfully.</span>');
                    /*$login_res = $this->account_model->user_signin($email_id, $login_password, $new_password);
                    // login and redirect it to dashboard
                    $this->loginUserAction($login_res,'signin','email');*/
                }else {
                    $this->data['loginErrors'] = array(
                        'email'  => form_error('email'),
                        'password'  => form_error('new_pswd'),
                    );
                }
            }
        }else {
            $this->data['setupMessage'] = 'Hash key is not valid.';
        }
        $this->data['form_url'] = partner_base_url('setpassword');
        $this->data['setPassword'] = true;
        $this->data['pageName'] = 'setpassword';
        $this->displayPages('partner/password-reset',$this->data,true);
    }

    function resetPassword($email = ''){
        $return_status = 0;
        if ($this->input->is_ajax_request() || $email != '') {
            if($this->input->is_ajax_request()){
                $email = strtolower(trim($this->input->post('email_id')));
            }
            if($email != ''){
                $user_details = $this->partner_account_model->getUserDetailsByEmailId($email,1);
                
                if(!empty($user_details) && strtolower($user_details['status']) == 'active'){
                    $token = hash('sha256', bin2hex(random_bytes(64)));
                    $user_id = $user_details['id'];
                    $res = $this->partner_account_model->insertPasswordHashSignature($user_id, $token);
                    if (!empty($res)) {
                        $this->data['name'] = $res['full_name'];
                        $this->data['setPasswordUrl'] = partner_base_url('setpassword/'.$token);
                        $message = $this->load->view('emailer/partner/forgot_password', $this->data, TRUE);
                        $subject = 'Password Reset';
                        $this->send_verifymail($email, $subject, $message);
                        $return_status = 1;
                    }
                    $return_status = 1;
                }elseif(!empty($user_details)){
                    $return_status = 2;
                }else {
                    $return_status = 0;
                }
            }
        }
        if($this->input->is_ajax_request()){
            echo $return_status; exit;
        }else {
            return $return_status;
        }
    }

    public function handleQuery(){ 

        $name   = $this->input->post('name');
        $email  = $this->input->post('email');
        $query  = $this->input->post('query');
        if( true == empty( $name )  || true == empty( $email ) || true == empty( $query ) ) {
            redirect('partner/account/index');
            exit;
        }

        $data = array(
            'name'      => $name,
            'email'     => $email,
            'query'     => $query,
            'cret_date' => date('Y-m-d H:i:s'),
            'type'      => 'partner',
        );

        $this->load->model('common_model');
        $this->data['result'] = $this->common_model->insertQuestions( $data );

        $this->session->set_flashdata('success_message', 'Thank you. We will be get back to you soon');
        
        redirect('partner/account/index#contact', 'refresh');
    }

    public function upgradeMentorProfile(){
        $this->data['partner_id']         = $this->partnerData['partner_details']['user_login_id'];
        $this->data['name']              = $this->partnerData['partner_name'];
        $this->data['email']             = $this->partnerData['partner_email'];
        $this->data['designation']       = ( false == empty( $this->partnerData['partner_details']['designation'] ) ) ? $this->partnerData['partner_details']['designation'] : '';
        $this->data['company_name']      = ( false == empty( $this->partnerData['partner_details']['company_name'] ) ) ? $this->partnerData['partner_details']['company_name'] : '';

        $this->data['mobile']            = $this->partnerData['partner_mobile'];
        
        $message   = $this->load->view('emailer/partner/upgrade-profile', $this->data, TRUE); 
        $subject   = 'A partner has applied to become a Featured Mentor.';
        $result    = $this->send_verifymail( REPLYTO_EMAILID, $subject, $message);

        $this->session->set_flashdata('success_message', 'We will get back to you shortly!');

        redirect('partner/dashboard');
    }

    public function aboutUs() {
        $this->data['pageName'] = 'about-us';
        $this->generateView('static_pages/about-us', $this->data, true);
    }

    public function contactUs() {
        //$this->load->model('account');
        $this->data['flash_data'] = $this->account_model->get_flashdata('account_contact_us_flash', TRUE);
        $this->data['pageName'] = 'contact-us';
        $this->generateView('static_pages/contact-us', $this->data, true);
    }

    public function termsAndCondition() {
        $this->data['pageName'] = 'terms-of-use';
        $this->generateView('static_pages/terms-of-use', $this->data, true);
    }

    public function privacyPolicy() {
        $this->data['pageName'] = 'privacy-policy';
        $this->generateView('static_pages/privacy-policy', $this->data, true);
    }

    public function resendVerificationEmail(){
        $emailId = $this->partnerData['email_id'];

        if( false == empty( $emailId ) ) {
            $randomKey       = random_string( 'alnum', 50 );
            $text            = $emailId . '#' . $randomKey . '#' . $emailId;
            $encryptedCode   = $this->encryption_model->encryptNET3DES( $this->key_emailer, $text );
            
            $this->partner_account_model->updateEncryptedCode($randomKey,$this->partnerData['user_login_id']);
            
            $data['encrypt_code'] = urlencode( $encryptedCode );
            $message    = $this->load->view('/emailer/partner/verify-emailid', $data, TRUE); 
            $subject    = 'Verify your email id to complete your registration';       
            $mailStatus = $this->send_verifymail( $emailId, $subject, $message);

            $successMessage = 'Email sent successfully!';
            $this->session->set_flashdata('set_flashdata', $successMessage );        
            echo json_encode(true);
        } else{
            $successMessage = 'Unable to send email currently. Please try again!';
            $this->session->set_flashdata('set_flashdata', $successMessage );
            echo json_encode(false);
        }


    }

    /**************************
    *****Other functions*******
    ***************************/

    private function sendPartnerVerificationEmail( $email, $verificationType = Account::SIGNUP_VERIFICATION ) {
        
        $partnerEmail    = $email;
        $randomKey      = random_string( 'alnum', 50 );
        $text           = $partnerEmail . '#' . $randomKey . '#' . $partnerEmail;
        $encrptedCode   = $this->encryption_model->encryptNET3DES( $this->key_emailer, $text );
        
        $verifyData = array(
                                'email_id'          => $partnerEmail,
                                'verification_code' => $randomKey,
                                'verification_type' => $verificationType
                            );

        $isRecordInserted = $this->partner_account_model->insertVerificationDetails( $verifyData, $verificationType );
        log_message('info', 'Mentor Account controller ' . __METHOD__ . ' called ' . $isRecordInserted );
        if( true == $isRecordInserted ) {

            $this->data['partner_email']      = $this->partnerData['partner_email'];
            $this->data['encrypt_code']      = urlencode( $encrptedCode );

            if( $verificationType == Account::SIGNUP_VERIFICATION ) {
                $this->data['partner_id']         = $this->partnerData['partner_id'];
                $this->data['partner_name']       = $this->partnerData['partner_name'];
            
                $message   = $this->load->view('emailer/partner/signup-verification', $this->data, TRUE); 
                $subject   = 'Please Verify Your Email Address to Activate Your Account';
            }elseif( $verificationType = Account::FORGOT_PASSWORD_VERIFICATION ){
                $message   = $this->load->view('emailer/partner/forgot-password', $this->data, TRUE); 
                $subject   = 'JFH - Forgot Password';
            } else{
                log_message('info', 'verification type missing' . $this->partnerData['partner_id'] );
                return;
            }   

            $result    = $this->send_verifymail( $partnerEmail, $subject, $message);
        } else{
            echo 'unable to insert verification details';
            // log error
        }
       
    } 

    public function send_verifymail($user_email, $subject, $message, $cc_email = '')
    {
        /* send grid api loaded */
        $user_email = trim($user_email);
        if(ENVIRONMENT != 'production'){
            $user_email = TESTING_EMAIL;
            $cc_email   = TESTING_CC_EMAIL;
            //$user_email = 'ninad@jobsforher.com';
        }

        $email_status = 0;
        if(isset($user_email)){
            $sendgrid = new \SendGrid(MILLION_DOLLER_KEY);
            $to = new \SendGrid\Email(null,$user_email);
            $from = new \SendGrid\Email(FROM_NAME,FROM_EMAILID);
            $content = new \SendGrid\Content("text/html", $message);
            $mail = new \SendGrid\Mail($from, $subject, $to, $content);
            $reply_to = new \SendGrid\ReplyTo(REPLYTO_EMAILID);
            $mail->setReplyTo($reply_to);
            $email_status = 1;
        }

        if( false == empty( $cc_email ) ) {
            $personalization = new \SendGrid\Personalization();
            $cc = new \SendGrid\Email( null, $cc_email);
            $personalization->addCc($cc);
            $personalization->addTo($to);
            $mail->addPersonalization($personalization);
        }

        $response = $sendgrid->client->mail()->send()->post($mail);
        
        if(ENVIRONMENT == 'production'){
            //$this->createOfflineLogger( $subject, $user_email, $email_status);
        }
        return true;
    }



    private function check_device() {
        $this->load->library('user_agent');
        log_message('info', __METHOD__ . ' called');
        $this->path = 'candidate-mobile/';
        $this->device = 'mobile';
        if ($this->agent->is_robot()) {
            log_message('info', 'Robot Try to access - ' . $this->agent->robot());
        } elseif ($this->agent->is_mobile()) {
            log_message('info', 'User using Mobile ' . $this->agent->mobile());
            $this->path = 'candidate-mobile/';
            $this->device = 'mobile';
        } else {
            if ($this->agent->is_browser()) {
                log_message('info', 'User browser ' . $this->agent->browser());
            }
            log_message('info', 'User palteform ' . $this->agent->platform());
            if ($this->agent->is_referral()) {
                log_message('info', 'User coming from referrer - ' . $this->agent->referrer());
            }
            $this->path = 'candidate-desktop/';
            $this->device = 'desktop';
        }
    }

    protected function displayPages($viewName, $data, $static = false, $headerName = '', $menuName = '', $footerName = '')
    {
        if ($this->device == 'desktop' || $this->device == 'mobile' || $static == true) 
        {
            //$this->path = 'candidate-mobile/';
            if ($headerName != '') 
            {
            } else 
            {
                $this->load->view('partner/header', $data);
            }
            
            if( false == $static ) 
            {
                $this->load->view($this->path . $viewName, $data);
            } else 
            {
                $this->load->view( $viewName, $data);
            }
            
            if ($footerName != '') 
            {
            } else 
            {
                $this->load->view('partner/footer', $data);
            }
        } else 
        {
            $this->load->view($this->path . $viewName, $data);
        }
    }    

    
    protected function generateView( $viewName,$data = '' ) {
        $this->load->view('header', $data);
        $this->load->view('header-menu', $data);
        $this->load->view($viewName, $data);
        $this->load->view('footer', $data );
    
    }

    private function _mail_provider($email) {
        
        $email_provider = array( 
                                'gmail.com', 
                                'yahoo.com', 
                                'outlook.com', 
                                'hotmail.com', 
                                'rediffmail.com', 
                                'msn.com',
                                'yahoo.co.in', 
                                'yahoo.in'
                                );
        
        $email_exten = explode( '@', $email );
        
        $email_p = ( true == in_array( $email_exten[1], $email_provider) ? $email : FALSE );

        return $email_p;
    }

    protected function getProfilePercentage(){
        $percentage = 0;
        $partnerId   = $this->data['id']; 

        if( false == $partnerId ) return 0;        

        $this->load->model('partner_profile_model');
        
        $partnerDetails = $this->partner_profile_model->getMentorFullDetailsById($this->data['id'], FALSE);
        //show($partnerDetails);
        
        $percentage = ( true == $partnerDetails['is_featured'] ) ? $this->getFeaturedProfilePercentage( $partnerDetails ) : $this->getBasicProfilePercentage( $partnerDetails );

        return round( $percentage );

    }    

    function getBasicProfilePercentage( $partnerDetails ) {    
        $percentage = 0;
        
        if( false == empty( $partnerDetails['name'] ) ) $percentage +=10;
        
        if( false == empty( $partnerDetails['profile_image'] ) ) $percentage +=10;
        if( false == empty( $partnerDetails['company_name'] ) ) $percentage +=10;
        if( false == empty( $partnerDetails['designation'] ) ) $percentage +=10;
        if( false == empty( $partnerDetails['summary'] ) ) $percentage +=20;
        
        if( false == empty( $partnerDetails['professionalDetails']['City'] ) ) $percentage +=10;
        if( false == empty( $partnerDetails['professionalDetails']['FunctionalAreas'] ) ) $percentage +=10;
        if( false == empty( $partnerDetails['professionalDetails']['Industry'] ) ) $percentage +=10;
        if( false == empty( $partnerDetails['skills'] ) ) $percentage +=10;
        
        return $percentage;
    }


    function getFeaturedProfilePercentage( $partnerDetails ) {
        $percentage = 0;
        //show( $partnerDetails );
        if( false == empty( $partnerDetails['name'] ) ) $percentage +=4;
        if( false == empty( $partnerDetails['alternate_mobile'] ) ) $percentage +=1;
        
        if( false == empty( $partnerDetails['profile_image'] ) ) $percentage +=5;
        if( false == empty( $partnerDetails['company_name'] ) ) $percentage +=5;
        if( false == empty( $partnerDetails['designation'] ) ) $percentage +=5;
        if( false == empty( $partnerDetails['summary'] ) ) $percentage +=10;
        
        if( false == empty( $partnerDetails['professionalDetails']['City'] ) ) $percentage +=2;
        if( false == empty( $partnerDetails['professionalDetails']['FunctionalAreas'] ) ) $percentage +=5;
        if( false == empty( $partnerDetails['professionalDetails']['Industry'] ) ) $percentage +=5;
        if( false == empty( $partnerDetails['skills'] ) ) $percentage +=5;

        if( false == empty( $partnerDetails['cover_image'] ) ) $percentage +=5;
        if( false == empty( $partnerDetails['quotes'] ) ) $percentage +=12;
        if( false == empty( $partnerDetails['blogs'] ) ) $percentage +=12;
        if( false == empty( $partnerDetails['events'] ) ) $percentage +=12;
        if( false == empty( $partnerDetails['videos'] ) ) $percentage +=12;

        return $percentage;
        
    }

    protected function uploadfile( $type, $uploadedFilename = 'featured_image'  ){
        log_message('info', __METHOD__ . ' called');
        $filename = strtolower($_FILES[$uploadedFilename]["name"]);
        $rand = rand(10, 99999);
        $rand_alpha = $this->RandomString();
        $db_location = 'images/reskilling/desktop/' . $type . '/';
        
        if ($_FILES[$uploadedFilename]['error'] == 0 && $_FILES[$uploadedFilename]['name'] != '') {
            if (strpos($filename, '.jpeg') !== false) {
                $file_ext = 'jpeg';
            } else if (strpos($filename, '.jpg') !== false) {
                $file_ext = 'jpg';
            } else if (strpos($filename, '.png') !== false) {
                $file_ext = 'png';
            }else if (strpos($filename, '.gif') !== false) {
                $file_ext = 'gif';
            }
            if (strpos($filename, '.gif') !== false || strpos($filename, '.png') !== false || strpos($filename, '.jpeg') !== false || strpos($filename, '.jpg') !== false) {
                $config['upload_path'] = FCPATH.'uploads/admin/reskilling';
                $config['new_path'] = FCPATH.'images/reskilling/desktop/' . $type . '/';
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                if ( false == $this->upload->do_upload($uploadedFilename) ) {
                    $error = array('error' => $this->upload->display_errors());
                    show($error);
                }else {
                    $filename = $rand_alpha . '-'.time(). '.' . $file_ext;
                    $dblocation = $db_location . $filename; // Full path
                    $this->load->helper('s3_helper');
                    $originalImage = $this->upload->data();
                    $originalImage['type'] = $originalImage['file_type'];
                    $this->load->library('image_lib');
                    $originalImage['tmp_name'] = $originalImage['full_path'];
                    $file_path = uploadFilesAdminS3Bucket($dblocation, $originalImage);
                    if($file_path != ''){
                        $imageSizes = array(100);
                        if(!empty($imageSizes)){
                            foreach ($imageSizes as $key => $value) {
                                $config['image_library'] = 'gd2';
                                $config['source_image'] = $originalImage['full_path'];
                                $config['new_image'] = FCPATH.'uploads/admin/reskilling';
                                $config['maintain_ratio'] = TRUE;
                                $config['width'] = $value;
                                $this->image_lib->clear();
                                $this->image_lib->initialize($config);
                                if ( ! $this->image_lib->resize() ){
                                    echo $this->image_lib->display_errors();
                                }
                                $dblocation = $db_location.'thumb-'.$value.'-'.$filename;
                                $file_path = uploadFilesAdminS3Bucket($dblocation, $originalImage);
                                                    
                            }
                        }
                        return $filename;
                    }

                }
            }
        }
        return false;
    }

    protected function uploadSampleFiles($destinationImagePath,$entityId,$entityTypeId){
        $filesArr = array();
        //show(count($_FILES["sampleFiles"]['name']));
        $totalFiles = count($_FILES['sampleFiles']['name']);
        
        for($counter=0;$counter<$totalFiles;$counter++) {
            /*var_dump($totalFiles);
            show($_FILES['sampleFiles']['name'][$counter]);
            */
            $filename = strtolower($_FILES['sampleFiles']['name'][$counter]);
            $rand = rand(10, 99999);
            $rand_alpha = $this->RandomString();
            //$db_location = 'images/reskilling/desktop/' . $type . '/';
            $s3DestinationDirectory = $destinationImagePath;
            $destinationPath = FCPATH. $destinationImagePath;
            if(!file_exists($destinationPath)){
                $status = mkdir($destinationPath, 0777, true);
                if(false == $status){
                    log_message('Directory not created' . $destinationImagePath, __METHOD__ . ' called');
                    return false;
                } 
            }

            if($_FILES['sampleFiles']['error'][$counter] == 0 && $_FILES['sampleFiles']['name'][$counter] != '') {
                if (strpos($filename, '.jpeg') !== false) {
                    $file_ext = 'jpeg';
                } else if (strpos($filename, '.jpg') !== false) {
                    $file_ext = 'jpg';
                } else if (strpos($filename, '.png') !== false) {
                    $file_ext = 'png';
                }else if (strpos($filename, '.gif') !== false) {
                    $file_ext = 'gif';
                }else if (strpos($filename, '.pdf') !== false) {
                    $file_ext = 'pdf';
                }
                
                if (strpos($filename, '.gif') !== false || strpos($filename, '.png') !== false || strpos($filename, '.jpeg') !== false || strpos($filename, '.jpg') !== false || strpos($filename, '.pdf') !== false) {
                    $config['upload_path']  = FCPATH.'uploads/admin/reskilling';
                    $config['new_path']     = $destinationPath;
                    $config['allowed_types'] = '*';
                    
                    $_FILES['sampleFile']['name'] = $_FILES['sampleFiles']['name'][$counter];
                    $_FILES['sampleFile']['type'] = $_FILES['sampleFiles']['type'][$counter];
                    $_FILES['sampleFile']['tmp_name'] = $_FILES['sampleFiles']['tmp_name'][$counter];
                    $_FILES['sampleFile']['error'] = $_FILES['sampleFiles']['error'][$counter];
                    $_FILES['sampleFile']['size'] = $_FILES['sampleFiles']['size'][$counter];

                    $this->load->library('upload', $config);
                    if ( false == $this->upload->do_upload('sampleFile') ) {
                        $error = array('error' => $this->upload->display_errors());
                        show($error);
                    }else {
                        $filename = $rand_alpha . '-'.time(). '.' . $file_ext;
                        //$dblocation = $db_location . $filename;
                        $s3Path = $s3DestinationDirectory . $filename; 
                         // Full path
                        $this->load->helper('s3_helper');
                        $originalImage = $this->upload->data();
                        $originalImage['type'] = $originalImage['file_type'];
                        $this->load->library('image_lib');
                        $originalImage['tmp_name'] = $originalImage['full_path'];
                        $file_path = uploadFilesAdminS3Bucket($s3Path, $originalImage);
                        if($file_path != ''){
                            $imageSizes = array(200);
                            if(!empty($imageSizes)){
                                foreach ($imageSizes as $key => $value) {
                                    $config['image_library'] = 'gd2';
                                    $config['source_image']     = $originalImage['full_path'];
                                    $config['new_image']        = $destinationPath;
                                    $config['maintain_ratio']   = TRUE;
                                    $config['width']            = $value;
                                    $this->image_lib->clear();
                                    $this->image_lib->initialize($config);
                                    if ( ! $this->image_lib->resize() ){
                                        echo $this->image_lib->display_errors();
                                    }

                                    $originalImage['full_path']   = $destinationPath . $originalImage['file_name'];
                                    $originalImage['tmp_name']    = $destinationPath .  $originalImage['file_name'];
                                    //$dblocation = $db_location.'thumb-'.$value.'-'.$filename;
                                    $s3Path     = $s3DestinationDirectory.'thumb-'.$value.'-'.$filename;
                                    $file_path  = uploadFilesAdminS3Bucket($s3Path, $originalImage);
                                                  
                                    unlink($config['upload_path'] . '/' . $originalImage['file_name'] );                    
                                    unlink($destinationPath . $originalImage['file_name']);
                                    //rmdir($destinationPath);
                                }
                            }

                            $filesArr[] = 'thumb-'.$value.'-'.$filename;
                            
                        }

                    }
                }
            }
        }
        return $filesArr;
    }

    protected function RandomString(){
        log_message('info', __METHOD__ . ' called');
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    function contactForm(){
        $this->load->model('staticpages_model');
        if(isset($_POST) && !empty($_POST)){
            $this->session->set_userdata('thankyoupage', 1 );
        }else {
            $this->session->unset_userdata('thankyoupage');
        }

        $form_rules = array(
            array(
                'field' => 'name',
                'label' => 'name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email_id',
                'label' => 'email id',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'company_name',
                'label' => 'company name',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'mobile_no',
                'label' => 'mobile no',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($form_rules);
        $this->form_validation->set_message('required', 'Please enter your {field}');
        $this->form_validation->set_message('emailExists', 'You are not registered with us. Please Sign up first.');
        $this->form_validation->set_error_delimiters('<div class="formerror error">', '</div>');
        if ($this->form_validation->run() == TRUE) {
            $name = trim($this->input->post('name'));
            $email_id = trim($this->input->post('email_id'));
            $company_name = trim($this->input->post('company_name'));
            $mobile = trim($this->input->post('mobile_no'));
            $message = $this->input->post('message');
            $query_type = $this->input->post('user_type');
            $data = array(
                'name'          => $name,
                'email_id'      => $email_id,
                'company_name'  => $company_name,
                'mobile'        => $mobile,
                'message'       => $message,
                'query_type'    => 'from partner page' 
            );

            if($message == ''){
                $message = 'No message';
            }
            
            $status = $this->staticpages_model->store_data_into_table('lead_btob',$data);
            $subject = 'Reskilling Query - ' . ' from partner page';
            $messageContent = '<br>Hi,<br><br><strong>Name:</strong> '.$name.'<br><strong>Email-id:</strong> '.$email_id.'<br><strong>Company name:</strong> '.$company_name
            .'<br><strong>Mobile:</strong> '.$mobile.'<br><strong>Message:</strong> '.$message .'<br><strong>Type:</strong> from partner page';
            
            $this->send_verifymail('divya@jobsforher.com', $subject, $messageContent, $email_id);
            
            $this->data['thankyou'] = array(
                'name' => $name
            );
            unset($_POST);
        }else {
            $this->data['thankyou'] = array();
        }
        
        $this->index();
        
    }
      
}

