 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ('Account.php');
class Branch extends Account {

	function __construct() {
        parent::__construct();
        $this->load->model('daycare_model');

        if( true == empty( $this->partnerData ) ) {
            redirect('/');
        }


    }

    function index(){

        $this->data['pageName']             = 'profile';
        $this->data['partnerDetails']       = $this->vendors_model->getVendorDetailsById( $this->vendorId );
        $this->data['isAdmin']              = $this->partnerData['is_admin'];
        $this->data['newCourses']           = $this->reskilling_model->getNewEntities(COURSE_TYPE_ID, 5, $this->vendorId );
        $this->data['newAssessments']       = $this->reskilling_model->getNewEntities(ASSESSMENT_TYPE_ID, 5, $this->vendorId );
        $this->data['newServices']          = $this->reskilling_model->getNewEntities(SERVICE_TYPE_ID, 5, $this->vendorId );

        $this->data['blogs']                = $this->partner_profile_model->getPartnerBlogs( $this->vendorId );        
        $this->data['events']               = $this->partner_profile_model->getPartnerEvents( $this->vendorId );        
        $this->data['testimonials']         = $this->partner_profile_model->getPartnerTestimonials( $this->vendorId, PARTNER_TYPE_ID );
        $this->data['galleryImages']        = $this->partner_profile_model->getPartnerImageGallery($this->vendorId, PARTNER_TYPE_ID);

        $this->displayPages( 'partner/profile/index', $this->data, true );
    }   

    function create(){
    	$this->data['pageName']        = 'create-branch';
        $this->data['daycareDetails']  = array(
                                            'id'            => '',
                                            'branch_name'   => ucwords($this->partnerData['vendor_name']),
                                            'featured_image' => '',
                                            'age_group'      => '',
                                            'fees'           => '',
                                            'description' => '', 
                                            'additional_information' => '',
                                            'is_featured' => 0,
                                            'logo'        => '',  
                                            'cover_image' => '',
                                            'city_id'     => '',  
                                            'area_id'     => '',
                                            'zip'         => '',
                                            'video_url'   => '',
                                            'address'     => '',
                                            'email'       => $this->partnerData['email_id'],
                                            'mobile'      => $this->partnerData['mobile'],
                                            'contact_name'=> ucwords($this->partnerData['contact_name']),
                                            'weekdays_start_time' => '',
                                            'weekdays_end_time' => '',
                                            'weekend_start_time' => '',
                                            'weekend_end_time' => '',
                                            'facebook_id'  => '',
                                            'twitter_id'   => '',
                                            'instagram_id'  => '',
                                            'is_food_available' => '',
                                            'is_doctor_on_call_available' => '',
                                            'is_open_on_weekends' => '',
                                            'are_activities_available' => '',
                                            'is_pick_drop_available' => '',
                                            'is_digital_payment_available' =>''

            );
    	$this->generateView( 'addEditBranch', $this->data);
    }   

    function edit($daycareId){
    	$this->data['pageName']        = 'edit-branch';
        $this->data['daycareDetails']  = $this->daycare_model->getDaycareDetailsById($daycareId); 
       	
        $this->generateView( 'addEditBranch', $this->data);
    }  

    function save(){
        
        $id                         = (int)$this->input->post('daycare-id');
        $branchName                 = $this->input->post('branch_name');
        $aboutUs                    = $this->input->post('aboutus');
        $additionalInformation      = $this->input->post('additional_information');
        $address                    = $this->input->post('address');

        $contactName                = $this->input->post('contact_name');
        $email                      = $this->input->post('email');
        $mobile                     = $this->input->post('mobile');

        $cityId                     = $this->input->post('city');
        $city                       = getCityNameById($cityId);
        $area                       = $this->input->post('area');
        $areaId                     = getAreaIdByName($this->input->post('area'));
        $zip                        = $this->input->post('zip');

        $ageGroup                   = $this->input->post('age_group');
        $fees                       = $this->input->post('fees');

        $weekdaysStartTime          = $this->input->post('weekdays_start_time');
        $weekdaysEndTime            = $this->input->post('weekdays_end_time');
        $weekendStartTime           = $this->input->post('weekend_start_time');
        $weekendEndTime             = $this->input->post('weekend_end_time');

        $isFoodAvailable            = (int)$this->input->post('food_provided');
        $isDoctorOnCallAvailable    = (int)$this->input->post('doctor_on_call');
        $isOpenOnWeekends           = (int)$this->input->post('open_on_weekends');
        $areActivitiesAvailable     = (int)$this->input->post('activities_available');
        $isPickDropAvailable        = (int)$this->input->post('pick_drop');
        $isDigitalPaymentAvailable  = (int)$this->input->post('credit_debit_card');

        $videoUrl                   = $this->input->post('video_url');
        $facebookId                 = $this->input->post('facebook_id');
        $twitterId                  = $this->input->post('twitter_id');
        $instagramId                = $this->input->post('instagram_id');

        /*var_dump($aboutUs,$additionalInformation,$registeredAddress,$contactName,$email,$mobile,$city,$area,$zip,$weekdaysStartTime,$weekdaysEndTime,$weekendStartTime,$weekendEndTime, $isFoodAvailable,$isDoctorOnCallAvailable,$isOpenOnWeekends,$areActivitiesAvailable,$isPickDropAvailable, $isDigitalPaymentAvailable,$videoUrl,$facebookId,$twiiterId, $instagramId);
        exit; 
        */

        $imageName = $this->input->post('profile_image');
        if(isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])){
            $imageName = uploadfile('logo', $this->partnerData['vendor_id']);
        }

        $coverImageName = $this->input->post('cover_image');
        if(isset($_FILES['featured_image']['name']) && !empty($_FILES['featured_image']['name'])){
            $coverImageName = uploadfile('featured_image', $this->partnerData['vendor_id']);
        }
        $slug = $city . '/' .  $area . '/' . generateSlug($branchName);
                
        $daycareData = array(
            'vendor_id'                         => $this->partnerData['vendor_id'],
            'branch_name'                       => $branchName,
            'seo_name'                          => urlencode( strtolower( $slug ) ),
    		'description' 			            => $aboutUs,
            'additional_information'            => $additionalInformation,
    		'address' 	                        => $address,
            'contact_name'                      => $contactName,
            'email'                             => $email, 
            'mobile'                            => $mobile,
            'fees'                              => $fees,
            'age_group'                         => $ageGroup,
            'city_id'                           => $cityId,
            'area_id'                           => $areaId,
            'zip'                               => $zip,
            'weekdays_start_time'               => $weekdaysStartTime,
            'weekdays_end_time'                 => $weekdaysEndTime,
            'weekend_start_time'                => $weekendStartTime,
            'weekend_end_time'                  => $weekendEndTime,
            'is_food_available'                 => $isFoodAvailable,
            'is_doctor_on_call_available'       => $isDoctorOnCallAvailable,
            'is_open_on_weekends'               => $isOpenOnWeekends,
            'are_activities_available'          => $areActivitiesAvailable,
            'is_pick_drop_available'            => $isPickDropAvailable,
            'is_digital_payment_available'      => $isDigitalPaymentAvailable,
            'facebook_id' 			            => $facebookId,
    		'twitter_id' 			            => $twitterId,
    		'instagram_id' 			            => $instagramId,
    	    'video_url'                         => $videoUrl,
            'modified_date'                     => date('Y-m-d H:i:s'),
            'logo'                              => $imageName,   
            'featured_image'                    => $coverImageName,
            
        );

        if( $id ){
            unset( $daycareData['seo_name'], $daycareData['city_id'], $daycareData['area_id'], $daycareData['branch_name'] );
        }

    	$daycareId = $this->daycare_model->insertOrUpdateDaycareData($daycareData, $id);
    	
        if($daycareId){
    		$this->session->set_flashdata('set_flashdata', 'Saved successfully!!');
            $daycareLink = 'partner/edit-branch/' . $daycareId;
            redirect($daycareLink);
    	} else{
            $this->session->set_flashdata('set_flashdata', 'Something went wrong..');
            redirect('partner/create-branch');
            //redirect('partner/create-profile');
        }
    }

    /*protected function uploadfile( $type, $uploadedFilename = 'featured_image'  ){
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
    }*/

    public function createTestimonial(){
        /*if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }*/
            
        $this->data['pageName'] = 'create-testimonial';
        $this->data['testimonialDetails'] = array( 'id'=>'', 'parent_name' => '', 'child_name' => '', 'testimonial' => '');
        $this->data['branches'] = $this->daycare_model->getDaycaresByVendorId($this->partnerData['vendor_id']);
        $this->data['vendorId']          = $this->partnerData['vendor_id'];

        $this->generateView( 'addEditTestimonial', $this->data );
    }

    public function editTestimonial($testimonialId){
        /*if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }*/

        //check if this can be updated by logged in vendor id
        $isValidUser = $this->partner_profile_model->isValidEditUser( $testimonialId, 'reskilling_testimonials', $this->vendorId );

        if( false == $isValidUser ){
            $this->session->set_flashdata('set_flashdata', 'Not allowed to access this testimonial');    
            redirect('partner/profile');
        }

        $this->data['pageName']             = 'edit-testimonial';
        $this->data['testimonialDetails']   = $this->partner_profile_model->getFetauredContentByType( $testimonialId, 'reskilling_testimonials' );
        $this->data['branches'] = $this->daycare_model->getDaycaresByVendorId($this->partnerData['vendor_id']);
        $this->data['vendorId']             = $this->partnerData['vendor_id'];
        $this->generateView( 'addEditTestimonial', $this->data );
    } 

    public function insertOrUpdateTestimonials(){
        
        /*if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }
        */        
        $id             = (int) $this->input->post( 'testimonial-id' );
        $branchId       = (int) $this->input->post( 'branchId' );
        $parentName     = $this->input->post( 'parentName' );
        $childName      = $this->input->post( 'childName' );
        $testimonial    = $this->input->post( 'testimonial' ); 
        
        $insertData = array(
            'branch_id'         => $branchId,
            'parent_name'       => $parentName,
            'child_name'        => $childName,
            'testimonial'       => $testimonial,
            'created_date'      => date('Y-m-d H:i:s'),
            'modified_date'     => date('Y-m-d H:i:s')
        );
        
        $testimonialId = $this->daycare_model->insertOrUpdateTestimonial( $insertData, $id );
        
        $message = 'Testimonial updated successfully!';
        if(is_null($id)){
            $message = 'Testimonial created successfully!';
        }

        $this->session->set_flashdata('set_flashdata', $message);

        redirect('partner/create-testimonial', 'refresh'); 
        
    }


    function manageGallery(){
        $this->data['pageName'] = 'manage-gallery';
        $this->data['branches'] = $this->daycare_model->getDaycaresByVendorId($this->partnerData['vendor_id']);
              
        $this->generateView( 'manageGallery', $this->data); 
    }

    function getGalleryImagesByBranchId(){
        $branchId = $this->input->post('branchId');
        $images   = $this->daycare_model->getGalleryImagesByBranchId($branchId);
        
        echo json_encode($images);
    }

    function displayGalleryImages(){
        $galleryImagesJsonData = file_get_contents("php://input");
        
        if (strlen($galleryImagesJsonData) > 0 ){
            $galleryImages = json_decode($galleryImagesJsonData);
            $this->data['galleryImages']  = $galleryImages;
        
            $galleryImages = $this->load->view('partner/displayGalleryImages', $this->data, true);
            echo $galleryImages;
          //echo json_encode(true);  
        }
    } 

    function saveImageGallery(){
        $branchId   = $this->input->post('branchId');
        if($branchId < 0 ) redirect('partner/manage-gallery'); 
        $destinationPath    = 'uploads/admin/'. $this->partnerData['vendor_id'] . '/' . $branchId . '/gallery/' ;
        //if(isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])){
            $imageName = uploadfile('gallery-image', $this->partnerData['vendor_id'], $destinationPath);
        //}
        //$imageName          = $this->uploadImage($destinationPath); 
        
        $insertData = array(
            'vendor_id'         => $this->partnerData['vendor_id'],
            'branch_id'         => $branchId,
            'image_name'        => $imageName,
            'created_date'      => date('Y-m-d H:i:s')
        );
        
        $galleryId = $this->daycare_model->insertGalleryImages( $insertData );

        //json_encode(array($galleryId));
    }

    function deleteImage(){
        $id     = $this->input->post('imageId');
        $result = $this->daycare_model->deleteImage($id); 
        echo json_encode(true);
    }

    public function deleteFetauredContent(){
        $table  = $this->input->post('table');
        $id     = $this->input->post('id');
        $userId = $this->partnerData['user_login_id']; 
                
        if( true == empty( $table ) || true == empty( $id ) ) return false;

        $result = $this->partner_profile_model->deleteFetauredContent( $table, $id); 
        echo json_encode($result);
    }

    public function insertOrUpdateVideos(){
        $id             = $this->input->post( 'video-id' );
        $url            = $this->input->post( 'video-url' );
        $title          = $this->input->post( 'video-title' ); 
        $description    = $this->input->post( 'video-description' ); 
        $userId         = $this->mentorProfile['user_login_id']; 

        $insertData = array(
            'name'          => $title,
            'url'           => $url,
            'type'          => 'M',
            'entity_id'     => $this->data['id'],
            'description'   => $description,
            'cret_date'     => date('Y-m-d H:i:s')
        );
        
        $videoId = $this->mentor_profile_model->insertOrUpdateFetauredContent( $insertData, 'video', $id, $userId );

        redirect('mentor/profile', 'refresh'); 
        
    }

    public function createBlog(){
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }
            
        $this->data['pageName'] = 'add-blog';
        $this->data['blogDetails'] = array( 'id'=>'', 'title' => '', 'description' => '', 'blog_link' => '', 'image' => '');
        
        $this->displayPages( 'partner/profile/addEditBlog', $this->data, true );
    }

    public function editBlog($blogId){
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }

        $isValidUser = $this->partner_profile_model->isValidEditUser( $blogId, 'blogs', $this->vendorId );

        if( false == $isValidUser ){
            $this->session->set_flashdata('set_flashdata', 'Not allowed to access this blog');    
            redirect('partner/profile');
        }

        $this->data['pageName']     = 'edit-blog';
        $this->data['blogDetails']  = $this->partner_profile_model->getFetauredContentByType( $blogId, 'blogs' );
        
        $this->displayPages( 'partner/profile/addEditBlog', $this->data, true );
    } 

    public function insertOrUpdateBlogs(){
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }

        $id             = (int) $this->input->post( 'blog-id' );
        $link           = $this->input->post( 'blog-link' );
        if( false == empty( $link ) ){
            $link = addScheme( $link );
        }
        
        $title          = $this->input->post( 'blog-title' ); 
        $description    = $this->input->post( 'blog-description' ); 
        $imagePath      = $this->input->post( 'blog-image' );
        $userId         = $this->partnerData['user_login_id']; 

        $insertData = array(
            'blog_link'         => $link,
            'author_id'         => $this->partnerData['vendor_id'],
            'admin_id'          => $this->partnerData['user_login_id'],
            'title'             => $title,
            'image_path'        => $imagePath,
            'excerpt'           => $description,
            'status'            => 'PUBLISH',
            'blog_by'           => 'PARTNER',
            'description'       => $description,
            'created_date'      => date('Y-m-d H:i:s'),
            'publish_date'      => date('Y-m-d H:i:s')
        );
        
        $blogId = $this->partner_profile_model->insertOrUpdateFetauredContent( $insertData, 'blogs', $id, $userId );
        
        $message = 'Blog updated successfully!';
        if(is_null($id)){
            $message = 'Blog created successfully!';
        }

        $this->session->set_flashdata('set_flashdata', $message);

        redirect('partner/profile', 'refresh'); 
        
    }

    public function Quotes(){
        $id         = $this->input->post( 'quote-id' );
        $filePath   = '';
        $userId     = $this->mentorProfile['user_login_id']; 
        
        if( true == is_array( $_FILES['quote-image'] ) && false == empty($_FILES['quote-image']['name'] ) ) {
            $config['upload_path']          = APPPATH . '../uploads/mentors';
            $config['allowed_types']        = '*';
            //$config['max_size']             = 500;
        
            $this->load->library('upload', $config);

            if( false == $this->upload->do_upload( 'quote-image') ) {
                    $error = array('error' => $this->upload->display_errors());
                    show('error');
                    //$this->load->view('upload_form', $error);
            }else {
                    $data = array( 'upload_data' => $this->upload->data());
                    
                    $data['upload_data']['tmp_name'] = $data['upload_data']['full_path'];
                    $data['upload_data']['type']     = $data['upload_data']['file_type'];
                    
                    $mentorData = ( true == is_array( $this->mentorProfile ) ) ? $this->mentorProfile : $this->mentorData['mentor_details'];
                        
                    $mentorId       = $mentorData['user_login_id'];
                    $mentorName     = $mentorData['name'];
                    $fileExtension  = str_replace('.', '', $data['upload_data']['file_ext']);

                    $s3FileName = generateSlug( $mentorName .'-logo' ) . '-' . time() . '.' . $fileExtension;
                    $this->load->helper('s3_helper');
                    $filePath = uploadFilesS3Bucket( $this->data['id'], $s3FileName, $data['upload_data'], 3 );
                                            
                    if(!$filePath){
                        echo "error"; exit;
                    }

                    unlink( $data['upload_data']['full_path'] );
                    
                    $filePath = 'mentor/'.$mentorId.'/'. $filePath;
                    
                    //$res = $this->mentor_profile_model->updateQuoteImage( $filePath, $mentorId );
                    
                    
            }
        }

        $quote = $this->input->post( 'quote-text');
        
        $insertData = array(
            'quotes'        => $quote,
            'mentor_id'     => $this->data['id'],
            'created_date'  => date('Y-m-d H:i:s')
        );
        
        if( $id ){
            unset( $insertData['created_date'] );
        }

        if( false == empty( $filePath ) ){
            $insertData['image'] = $filePath;
        }

        $quoteId = $this->mentor_profile_model->insertOrUpdateFetauredContent( $insertData, 'mentor_quotes', $id, $userId );

        redirect('mentor/profile', 'refresh'); 
    }

    
    public function createEvent(){
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }
            
        $this->data['pageName'] = 'add-event';
        $this->data['eventDetails'] = array('id'=>'', 'title' => '', 'description' => '', 'event_url' => '', 'image' => '');
        
        $this->displayPages( 'profile/addEditEvent', $this->data, true );
    }

    public function editEvent($eventId){
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }

        $isValidUser = $this->partner_profile_model->isValidEditUser( $eventId, 'external_events', $this->vendorId );

        if( false == $isValidUser ){
            $this->session->set_flashdata('set_flashdata', 'Not allowed to access this event');    
            redirect('partner/profile');
        }

        $this->data['pageName']     = 'edit-event';
        $this->data['eventDetails']  = $this->partner_profile_model->getFetauredContentByType( $eventId, 'external_events' );
        
        $this->displayPages( 'partner/profile/addEditEvent', $this->data, true );
    } 


    public function insertOrUpdateEvents(){
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }

        $this->load->model('event_model');
        
        $id                     = $this->input->post( 'event-id' );     
        $title                  = $this->input->post( 'event-title' );
        $description            = $this->input->post( 'event-description' );
        $url                    = $this->input->post( 'event-url' );
        $imagePath              = $this->input->post( 'event-image' );
        
        if( false == empty( $url ) ){
            $url = addScheme( $url );
        }
        
        $insertData = array(
            'title'                 => $title,
            'description'           => $description,
            'image_name'            => $imagePath,
            'event_url'             => $url,
            'entity_id'             => $this->partnerData['vendor_id'],
            'entity_type'           => PARTNER_TYPE_ID,
            'created_date'          => date('Y-m-d H:i:s'),
            'created_by'            => $this->partnerData['user_login_id'],
            'modified_date'         => date('Y-m-d H:i:s'),
            'modified_by'           => $this->partnerData['user_login_id']
        );

        $eventId = $this->event_model->insertOrUpdateExternalEvents( $insertData, $id );

        $message = 'Event updated successfully!';
        if(is_null($id)){
            $message = 'Event created successfully!';
        }

        redirect('partner/profile', 'refresh');  
    }

    public function uploadProfileImage(){
        
        $config['upload_path']          = APPPATH . '../uploads/mentors';
        $config['new_path']             = APPPATH . '../uploads/mentors';
        $config['allowed_types']        = '*';
        //$config['max_size']             = 500;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;
        
        $this->load->library('upload', $config);

        if ( false == $this->upload->do_upload( 'profile-image') ) {
                
                $error = array('error' => $this->upload->display_errors());
                //show($error);
                //$this->load->view('upload_form', $error);
        }else {
                $mentorData = ( true == is_array( $this->mentorProfile ) ) ? $this->mentorProfile : $this->mentorData['mentor_details'];
                    
                $mentorId                           = $mentorData['user_login_id'];

                $mentorName                         = $mentorData['name'];
                $data                               = array( 'upload_data' => $this->upload->data());
                
                $data['upload_data']['type']        = $data['upload_data']['file_type'];

                $imageSizes     = array( 200, 88 );
                $fileExtension  = str_replace('.', '', $data['upload_data']['file_ext']);

                
                $this->load->helper('s3_helper');

                $this->load->library('image_lib');

                $s3FileName = generateSlug( $mentorName .'-logo' ) . '-' . time() . '.' . $fileExtension;

                foreach( $imageSizes as $imageSize ){
                    
                    $config['image_library']    = 'gd2';
                    $config['source_image']     = $data['upload_data']['full_path'];
                    $config['maintain_ratio']   = TRUE;
                    $config['width']            = $imageSize;   
                    $config['new_image']         = APPPATH . '../uploads/mentors/' . $imageSize ;
                    
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    if ( ! $this->image_lib->resize() ){
                        echo $this->image_lib->display_errors();
                    } 

                    
                    if( $imageSize == 88 ){
                        $s3FileName = 'thumb-' . $s3FileName;
                    }
    
                    $data['upload_data']['full_path']   = $config['new_image'] . '/' . $data['upload_data']['file_name'];
                    $data['upload_data']['tmp_name']    = $config['new_image'] . '/' . $data['upload_data']['file_name'];

                    //var_dump($data['upload_data']['full_path']);
                    $filePath = uploadFilesS3Bucket( $this->data['id'], $s3FileName, $data['upload_data'], 3 );
                    
                    if( !$filePath ){
                        echo "error"; exit;
                    }

                    if( $imageSize == 200 ){
                        $dbFilePath = $filePath;
                    }   
                    //var_dump($data['upload_data']['full_path']);
                    //unlink( $data['upload_data']['full_path'] );
                } 
                
                $filePath = 'mentor/'.$mentorId.'/'. $dbFilePath;
                
                $res    = $this->mentor_profile_model->updateProfileImage($filePath, $mentorId);
                $result = array();

                if( true == $res ){
                    $result['status']   = true;
                    $result['filepath'] = $filePath;
                    echo json_encode( $result );
                }else{
                    $result['status']   = false;
                    $result['filepath'] = '';
                    echo json_encode( $result );
                }
                
                //redirect('mentor/edit-profile');
        }
    }

    protected function uploadImage1( $destinationPath = '' ){
        $filename = strtolower($_FILES["featured-image"]["name"]);
        $rand = rand(10, 99999);
        $rand_alpha = $this->RandomString();
        //$db_location = 'images/reskilling/desktop/' . $type . '/';
        $s3DestinationDirectory = $destinationPath;
        $destinationPath = FCPATH.  'uploads/admin/';

        if(!file_exists($destinationPath)){
            $status = mkdir($destinationPath);
        }

        if ($_FILES['featured-image']['error'] == 0 && $_FILES['featured-image']['name'] != '') {
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
                $config['upload_path']  = FCPATH.'uploads/admin/';
                $config['new_path']     = $destinationPath;
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                if ( false == $this->upload->do_upload('featured-image') ) {
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
                    
                    //$file_path = uploadFilesAdminS3Bucket($s3Path, $originalImage);
                    //if($file_path != ''){
                        
                            //foreach ($imageSizes as $key => $value) {
                                /*$config['image_library']    = 'gd2';
                                $config['source_image']     = $originalImage['full_path'];
                                $config['new_image']        = $destinationPath;
                                $config['maintain_ratio']   = TRUE;
                                $config['width']            = $value;
                                $this->image_lib->clear();
                                $this->image_lib->initialize($config);
                                if ( ! $this->image_lib->resize() ){
                                    echo $this->image_lib->display_errors();
                                }*/

                                $originalImage['full_path']   = $destinationPath . $originalImage['file_name'];
                                $originalImage['tmp_name']    = $destinationPath .  $originalImage['file_name'];
                                //$dblocation = $db_location.'thumb-'.$value.'-'.$filename;
                                $s3Path     = $s3DestinationDirectory.$filename;
                                $file_path  = uploadFilesS3($s3Path, $originalImage);
                                show($file_path);
                                //var_dump($s3DestinationDirectory);
                                
                                unlink($config['upload_path'] . '/' . $originalImage['file_name'] );                    
                                unlink($destinationPath . $originalImage['file_name']);
                                rmdir($destinationPath);
                            //}
                        //}
                        return $value.'-'.$filename;
                    //}

                }
            }
        }
        return false;
    }
    

}
