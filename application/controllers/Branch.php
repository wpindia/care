 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ('Account.php');
class Branch extends Account {

	function __construct() {
        parent::__construct();
        //$this->load->model('partner_profile_model');

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
                                            'description' => '', 
                                            'additional-information' => '',
                                            'is_featured' => 0,
                                            'logo'        => '',  
                                            'cover_image' => '',
                                            'city_id'     => '',  
                                            'area'        => '',
                                            'zip'         => '',
                                            'video_url'   => '',
                                            'address'     => '',
                                            'email'       => '',
                                            'mobile'      => '',
                                            'contact_name'=> '',
                                            'weekdays_start_time' => '',
                                            'weekdays_end_time' => '',
                                            'weekend_start_time' => '',
                                            'weekend_end_time' => '',
      
            );
    	$this->generateView( 'addEditBranch', $this->data);
    }   

    function edit(){
    	$this->data['pageName'] = 'edit-profile';
    	$this->displayPages( 'partner/profile/addEditProfile', $this->data, true );
    }  

    function saveProfile(){
    	$aboutUs  			= $this->input->post('aboutus');
    	$registeredAddress  = $this->input->post('registered-address');
    	$pan  				= $this->input->post('pan');
    	$gst  				= $this->input->post('gst');
    	$sac  				= $this->input->post('sac');
    	$facebookId  		= $this->input->post('facebook-id');
    	$twitterId  		= $this->input->post('twitter-id');
    	$linkedinId  		= $this->input->post('linkedin-id');
        $videoId            = $this->input->post('video-id');
        
    	$vendorTypes        = $this->input->post('vendor-types');    

        $imageName          = $this->input->post('profile_image');
        if(isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])){
            $imageName = $this->uploadfile('vendors', 'logo');
        }

        $coverImageName          = $this->input->post('cover_image');
        if(isset($_FILES['featured_image']['name']) && !empty($_FILES['featured_image']['name'])){
            $coverImageName = $this->uploadfile('vendors');
        }
                
        $vendorData = array(
    		'description' 			=> $aboutUs,
    		'registered_address' 	=> $registeredAddress,
    		'pan' 					=> $pan,
    		'gst_id' 				=> $gst,
    		'sac_hsc_id' 			=> $sac,
    		'facebook_id' 			=> $facebookId,
    		'twitter_id' 			=> $twitterId,
    		'linkedin_id' 			=> $linkedinId,
    	    'logo'                  => $imageName,   
            'cover_image'           => $coverImageName,
            'video_url'             => $videoId,
            'modified_date'         => date('Y-m-d H:i:s')
        );

    	$isUpdated = $this->vendors_model->updateVendorProfile($vendorData, $this->vendorId, $vendorTypes);
    	if(true == $isUpdated){
    		$this->reskilling_model->addReskillingIndexing( $this->vendorId, PARTNER_TYPE_ID );
            $this->session->set_flashdata('set_flashdata', 'Saved successfully!!');
            redirect('partner/dashboard');
    	} else{
            $this->session->set_flashdata('set_flashdata', 'Something went wrong..');
            redirect('partner/create-profile');
        }
    }

    function createImageGallery(){
        $this->data['pageName'] = 'create-gallery';
        $this->data['images']   = $this->partner_profile_model->getPartnerImageGallery($this->vendorId, PARTNER_TYPE_ID);
       
        $this->displayPages( 'partner/profile/gallery', $this->data, true ); 
    }

    function handleUploadImageGallery(){
        
        $destinationPath    = 'uploads/admin/reskilling/gallery/'. $this->partnerData['vendor_id'] .'/';
        $imageName          = $this->uploadImage($destinationPath); 
        
        $insertData = array(
            'entity_id'         => $this->partnerData['vendor_id'],
            'entity_type_id'    => PARTNER_TYPE_ID,
            'image_name'        => $imageName,
            'created_date'      => date('Y-m-d H:i:s')
        );
        
        $galleryId = $this->partner_profile_model->insertOrUpdateFetauredContent( $insertData, 'reskilling_gallery', -1 );

        //json_encode(array($galleryId));
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

    public function createTestimonial(){
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }
            
        $this->data['pageName'] = 'add-testimonial';
        $this->data['testimonialDetails'] = array( 'id'=>'', 'name' => '', 'testimonial' => '', 'designation' => '', 'description' => '', 'image_name' => '');
        $this->data['vendorId']          = $this->partnerData['vendor_id'];

        $this->displayPages( 'partner/profile/addEditTestimonial', $this->data, true );
    }

    public function editTestimonial($testimonialId){
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }

        //check if this can be updated by logged in vendor id
        $isValidUser = $this->partner_profile_model->isValidEditUser( $testimonialId, 'reskilling_testimonials', $this->vendorId );

        if( false == $isValidUser ){
            $this->session->set_flashdata('set_flashdata', 'Not allowed to access this testimonial');    
            redirect('partner/profile');
        }

        $this->data['pageName']             = 'edit-testimonial';
        $this->data['testimonialDetails']   = $this->partner_profile_model->getFetauredContentByType( $testimonialId, 'reskilling_testimonials' );
        $this->data['vendorId']             = $this->partnerData['vendor_id'];
        $this->displayPages( 'partner/profile/addEditTestimonial', $this->data, true );
    } 

    public function insertOrUpdateTestimonials(){
        
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }
        
        $id             = (int) $this->input->post( 'testimonial-id' );
        $designation    = $this->input->post( 'testimonial-designation' );
        $name           = $this->input->post( 'testimonial-name' ); 
        $description    = $this->input->post( 'testimonial-description' ); 
        $imageName      = $this->input->post( 'featured-image' );
        $userId         = $this->partnerData['user_login_id']; 

        $destinationPath    = 'uploads/admin/reskilling/testimonials/'. $this->partnerData['vendor_id'] . '/';
        $imageName          = $this->uploadImage($destinationPath); 
        $insertData = array(
            'entity_id'         => $this->partnerData['vendor_id'],
            'entity_type'       => PARTNER_TYPE_ID,
            'name'              => $name,
            'designation'       => $designation,
            'image_name'        => $imageName,
            'description'       => $description,
            'updated_by'        => $userId, 
            'created_date'      => date('Y-m-d H:i:s'),
            'modified_date'     => date('Y-m-d H:i:s')
        );
        
        $testimonialId = $this->partner_profile_model->insertOrUpdateFetauredContent( $insertData, 'reskilling_testimonials', $id, $userId );
        
        $message = 'Testimonial updated successfully!';
        if(is_null($id)){
            $message = 'Testimonial created successfully!';
        }

        $this->session->set_flashdata('set_flashdata', $message);

        redirect('partner/profile', 'refresh'); 
        
    }

    public function createEvent(){
        if($this->partnerData['is_featured'] == 0) {
            redirect('partner/profile', 'refresh'); 
        }
            
        $this->data['pageName'] = 'add-event';
        $this->data['eventDetails'] = array('id'=>'', 'title' => '', 'description' => '', 'event_url' => '', 'image' => '');
        
        $this->displayPages( 'partner/profile/addEditEvent', $this->data, true );
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

    protected function uploadImage( $destinationPath, $isCreateOnlyThumbnails = false ){
        $filename = strtolower($_FILES["featured-image"]["name"]);
        $rand = rand(10, 99999);
        $rand_alpha = $this->RandomString();
        //$db_location = 'images/reskilling/desktop/' . $type . '/';
        $s3DestinationDirectory = $destinationPath;
        $destinationPath = FCPATH. $destinationPath;

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
                $config['upload_path']  = FCPATH.'uploads/admin/reskilling';
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
                                //var_dump($s3DestinationDirectory);
                                
                                unlink($config['upload_path'] . '/' . $originalImage['file_name'] );                    
                                unlink($destinationPath . $originalImage['file_name']);
                                rmdir($destinationPath);
                            }
                        }
                        return 'thumb-'.$value.'-'.$filename;
                    //}

                }
            }
        }
        return false;
    }

}