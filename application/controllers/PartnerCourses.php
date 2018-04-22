<?php
/**
 * Admin Events Controller
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('Account.php');
class PartnerCourses extends Account {

	function __construct() {
		parent::__construct();
		
		$this->load->model('reskilling_model');
		$this->load->model('account_model');
		$this->load->model('courses_model');
		$this->load->model('city_model');
		$this->load->library('customTypes' );		
	}

	public function index(){
		$this->data['pageName'] = 'courses';
		$this->data['courses'] 	= $this->courses_model->getCoursesByVendorId($this->vendorId);
		$this->displayPages( 'partner/courses/display_courses', $this->data, true );
	}


	public function editCourse($courseId){
		
		$isValidUser = $this->reskilling_model->isValidEditUser( $courseId, COURSE_TYPE_ID, $this->vendorId );

		if( false == $isValidUser ){
			$this->session->set_flashdata('set_flashdata', 'Not allowed to access this course');	
			redirect('partner/offerings');
		}

		$this->data['page_title'] 			= 'Edit Course';
		$this->data['pageName'] 			= 'edit-course';
		$this->data['courseDetails']    	= $this->courses_model->getCourseDetailsById($courseId);
		$this->data['partnerDetails']       = $this->vendors_model->getVendorDetailsById( $this->vendorId );
		$this->data['functional_areas'] 	= $this->account_model->getCoursesFunctionalAreas();
		$this->data['revenueTypes']			= $this->reskilling_model->getRevenueTypes();
		$this->data['reskillingLevelTypes']	= $this->reskilling_model->getReskillingLevelTypes();
		$this->data['reskilling_cities']    = $this->city_model->getAllCitiesForSearch();

		$this->data['selected_cities']    	= $this->reskilling_model->getCitiesByEntityIdEntityTypeId($courseId,COURSE_TYPE_ID);	
		$this->data['selected_cities']      = explode(",", $this->data['selected_cities'] );

		$this->data['sampleImages'] 		= $this->reskilling_model->getSamples( $courseId, COURSE_TYPE_ID );

		$this->displayPages( 'partner/courses/addEditCourse', $this->data, true);	
	}	

	public function addCourse(){
		
		$this->data['page_title'] 			= 'Add New Course';
		$this->data['pageName'] 			= 'add-course';
		$this->data['partnerDetails']       = $this->vendors_model->getVendorDetailsById( $this->vendorId );
		$this->data['courseDetails']   		= array();
		$this->data['functional_areas'] 	= $this->account_model->getCoursesFunctionalAreas();
		$this->data['revenueTypes']			= $this->reskilling_model->getRevenueTypes();
		$this->data['reskillingLevelTypes']	= $this->reskilling_model->getReskillingLevelTypes();
		$this->data['reskilling_cities']    = $this->city_model->getAllCitiesForSearch();

		$this->data['selected_cities']    	= array();	
		
		$this->displayPages( 'partner/courses/addEditCourse', $this->data, true );	
	}

	public function validateForm(){
		$formRules = array(
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'reskilling_level_type_id',
                'label' => 'Level',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'revenue_type_id',
                'label' => 'Revenue Type',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'functional_area',
                'label' => 'Functional Area',
                'rules' => 'trim|required|xss_clean'
            ),
        );

        //$this->form_validation->set_message('__validateEmailPassword', "Email Id/Password incorrect! Try again!");
        $this->form_validation->set_rules($formRules);
        $this->form_validation->set_error_delimiters('<div class="formerror">', '</div>');
        
        $isValidForm = $this->form_validation->run();
        
        return $isValidForm;

	}

	public function insertOrUpdateCourse(){
		$courseId = (int)$this->input->post('course-id');
		$isValidData = $this->validateForm();
        if( false == $isValidData ) {
            $this->data['form_errors'] = validation_errors();
                        
            $this->data['page_title']  = 'Add/Edit Course';
			$this->data['pageName']    = 'add-course';
			$this->data['partnerDetails']       = $this->vendors_model->getVendorDetailsById( $this->vendorId );
			$this->data['courseDetails'] = array();
			if( 0 < $courseId ){
				$this->data['courseDetails'] = $this->courses_model->getCourseDetailsById($courseId);
			}
			
			$this->data['functional_areas'] 	= $this->account_model->getCoursesFunctionalAreas();
			$this->data['revenueTypes']			= $this->reskilling_model->getRevenueTypes();
			$this->data['reskillingLevelTypes']	= $this->reskilling_model->getReskillingLevelTypes();
            
            //redirect('admin/courses/addCourse');
            $this->displayPages( 'partner/courses/addEditCourse', $this->data, true );
            //$this->generateView('reskilling/addEditCourse', $this->data );
            return;
        }

		$vendorId 					= (int)$this->vendorId;
		$revenueTypeId 				= (int)$this->input->post('revenue_type_id');
		$reskillingLevelTypeId 		= $this->input->post('reskilling_level_type_id');
		$reskillingModeTypeId 		= (int)$this->input->post('reskilling_mode_type_id');
		$reskillingModeTypeId       = ( 0 == $reskillingModeTypeId ) ? 2 : 1;
		$reskillingIsPaid 			= (int)$this->input->post('is_paid_course');
		//$reskillingIsFeatured 		= (int)$this->input->post('is_featured');
		$externalLink  				= $this->input->post('external_link');
		$startDateTime  			= convertToDateTimeDB( $this->input->post('start_date_time') );
		$endDateTime  				= convertToDateTimeDB( $this->input->post('end_date_time') );
		$reskillingStatus			= (int)$this->input->post('reskilling_status');
		$price						= $this->input->post('price');
		$offerPrice					= $this->input->post('offer_price');
		$offerStartDateTime			= convertToDateTimeDB( $this->input->post('offer_start_date_time') );
		$offerEndDateTime			= convertToDateTimeDB( $this->input->post('offer_end_date_time') );
		$functionalArea				= (int)$this->input->post('functional_area');
		$courseVideo 				= $this->input->post('course_video');
		$reskillingCities           = $this->input->post('cities');

		$courseDescription  	= $this->input->post('description');
		$courseOutline  		= $this->input->post('outline');
		
		$courseTakeaways  		= $this->input->post('take_aways');
		$courseTermsConditions  = $this->input->post('terms_and_conditions');
		
		$imageName = $this->input->post('post_image');
		if(isset($_FILES['featured_image']['name']) && !empty($_FILES['featured_image']['name'])){
			$imageName = $this->uploadfile('courses');
		}

		$courseData = array(
			'vendor_id'					=> $vendorId,
			'revenue_type_id'			=> $revenueTypeId,
			'reskilling_level_type_id'  => $reskillingLevelTypeId,
			'reskilling_mode_type_id'	=> $reskillingModeTypeId,
			'is_paid_course'			=> $reskillingIsPaid,
			//'is_featured'				=> $reskillingIsFeatured,
			'external_link'				=> $externalLink,
			'start_date_time'			=> $startDateTime,
			'end_date_time'				=> $endDateTime,
			'status_type_id'			=> $reskillingStatus,
			'youtube_video_url'			=> $courseVideo,
			'price'						=> $price,
			/*'offer_price'               => $offerPrice,
			'offer_start_date_time'     => $offerStartDateTime,
			'offer_end_date_time'       => $offerEndDateTime,*/ 
			'description' 				=> $courseDescription,
			'details'					=> $courseOutline,
			'take_aways'  				=> $courseTakeaways,
			'terms_and_conditions' 		=> $courseTermsConditions,
			'priority_order'			=> $priorityOrder,
			'start_date_time'			=> $startDateTime,
			'end_date_time'				=> $endDateTime,
			'logo'						=> $imageName,
			'created_date_time'			=> date('Y-m-d H:i:s')
		);

		if( $courseId ){
			unset( $courseData['created_date_time'] );
		}
			
		$title 		= $this->input->post('title');
		$vendorName = generateSlug( strtolower( $this->reskilling_model->getVendorNameById($courseData['vendor_id'] ) ) );
		
		$slug  = $vendorName . '/' . generateSlug( strtolower( $title ) );

		$courseData['title'] 	= $title;
		$courseData['slug'] 	= $slug;

		$courseId = $this->courses_model->insertOrUpdateReskillingData($courseData,$courseId,15013,'courses', false );
		if($courseId){
			$this->reskilling_model->updateFunctionalAreaByEntityIdByEntityTypeId( $functionalArea, $courseId, COURSE_TYPE_ID );
			$this->reskilling_model->insertOrUpdateReskillingCities( $reskillingCities, $courseId, COURSE_TYPE_ID );
			
			if( $courseData['status_type_id'] == 1 ){
				$this->reskilling_model->addReskillingIndexing( $courseId, COURSE_TYPE_ID );
			}else{
				$this->reskilling_model->deleteReskillingIndexing( $courseId, COURSE_TYPE_ID );
			}

			if(isset($_FILES['sampleFiles']['name']) && !empty($_FILES['sampleFiles']['name'])){
				$destinationPath    = 'uploads/admin/reskilling/samples/'. $this->partnerData['vendor_id'] .'/courses/';
				$filesArr 			= $this->uploadSampleFiles($destinationPath,$courseId,COURSE_TYPE_ID);
				$insertData = array();
				foreach($filesArr as $file){
					$insertData[] = array(
			            'entity_id'         => $courseId,
			            'entity_type_id'    => COURSE_TYPE_ID,
			            'image_name'        => $file,
			            'created_date'      => date('Y-m-d H:i:s')
			        );
	           	}
	           	
	           	$this->reskilling_model->insertSamples( $insertData );	
			}

			$this->session->set_flashdata('set_flashdata', 'Saved successfully!!');
			$courseLink = 'partner/courses/edit-course/' . $courseId;
        	redirect($courseLink);
		}else{
			$this->data['page_title']  = 'Add/Edit Course';
			$this->data['pageName']    = 'add-course';
			$this->data['courseDetails'] = array();
			if( 0 < $courseId ){
				$this->data['courseDetails'] = $this->courses_model->getCourseDetailsById($courseId);
			}
			
			$this->data['functional_areas'] 	= $this->account_model->getCoursesFunctionalAreas();
			$this->data['vendors']				= $this->reskilling_model->getAllVendors();
			$this->data['revenueTypes']			= $this->reskilling_model->getRevenueTypes();
			$this->data['reskillingLevelTypes']	= $this->reskilling_model->getReskillingLevelTypes();
			
			$this->displayPages( 'partner/courses/addEditCourse', $this->data, true );
			//$this->generateView('reskilling/addEditCourse', $this->data );
            return;	
		}
	
	}

}