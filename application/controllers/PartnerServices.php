<?php
/**
 * Admin Events Controller
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('Account.php');
class PartnerServices extends Account {

	function __construct() {
		parent::__construct();
		$this->load->model('city_model');
		$this->load->model('reskilling_model');
		$this->load->model('services_model');
		$this->load->model('account_model');
		$this->load->library('customTypes' );		
		
	}

	public function index(){
		$this->data['pageName'] = 'services';
		$this->data['services'] = $this->services_model->getServicesByVendorId($this->vendorId);
		
		$this->displayPages( 'partner/services/display_services', $this->data, true );
	}

	public function editService($serviceId){
		$isValidUser = $this->reskilling_model->isValidEditUser( $serviceId, SERVICE_TYPE_ID, $this->vendorId );

		if( false == $isValidUser ){
			$this->session->set_flashdata('set_flashdata', 'Not allowed to access this service');	
			redirect('partner/offerings');
		}

		$this->data['page_title'] 			= 'Edit Service';
		$this->data['pageName'] 			= 'edit-service';
		$this->data['serviceDetails']   	= $this->services_model->getServiceDetailsById($serviceId);
		$this->data['partnerDetails']       = $this->vendors_model->getVendorDetailsById( $this->vendorId );
		$this->data['functional_areas'] 	= $this->account_model->getServicesFunctionalAreas();
		$this->data['vendors']				= $this->reskilling_model->getAllVendors();
		$this->data['revenueTypes']			= $this->reskilling_model->getRevenueTypes();
		$this->data['reskillingLevelTypes']	= $this->reskilling_model->getReskillingLevelTypes();
		
		$this->data['reskilling_cities']    = $this->city_model->getAllCitiesForSearch();
		$this->data['selected_cities']    	= $this->reskilling_model->getCitiesByEntityIdEntityTypeId($serviceId,SERVICE_TYPE_ID);	
		$this->data['selected_cities']      = explode(",", $this->data['selected_cities'] );

		$this->data['sampleImages'] 		= $this->reskilling_model->getSamples( $serviceId, SERVICE_TYPE_ID );

		$this->displayPages( 'partner/services/addEditService', $this->data, true );
	}	

	public function addService(){
		$this->data['page_title'] 			= 'Add New Service';
		$this->data['pageName'] 			= 'add-service';
		$this->data['serviceDetails']   	= array();
		$this->data['partnerDetails']       = $this->vendors_model->getVendorDetailsById( $this->vendorId );
		$this->data['functional_areas'] 	= $this->account_model->getServicesFunctionalAreas();
		$this->data['vendors']				= $this->reskilling_model->getAllVendors();
		$this->data['revenueTypes']			= $this->reskilling_model->getRevenueTypes();
		$this->data['reskillingLevelTypes']	= $this->reskilling_model->getReskillingLevelTypes();
		
		$this->data['reskilling_cities']    = $this->city_model->getAllCitiesForSearch();
		$this->data['selected_cities']    	= array();
		$this->data['sampleImages'] 		= array();
				
		$this->displayPages( 'partner/services/addEditService', $this->data, true );
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

	public function insertOrUpdateService(){
		$serviceId = (int)$this->input->post('service-id');
		$isValidData = $this->validateForm();
        
        if( false == $isValidData ) {
            $this->data['form_errors'] = validation_errors();
            $this->data['page_title']  = 'Add/Edit Service';
			$this->data['pageName']    = 'add-service';
			$this->data['serviceDetails'] = array();
			$this->data['partnerDetails']       = $this->vendors_model->getVendorDetailsById( $this->vendorId );
			if( 0 < $serviceId ){
				$this->data['serviceDetails'] = $this->services_model->getServiceDetailsById($serviceId);
			}
			
			$this->data['functional_areas'] 	= $this->account_model->getServicesFunctionalAreas();
			$this->data['vendors']				= $this->reskilling_model->getAllVendors();
			$this->data['revenueTypes']			= $this->reskilling_model->getRevenueTypes();
			$this->data['reskillingLevelTypes']	= $this->reskilling_model->getReskillingLevelTypes();
            
            //redirect('admin/services/addService');
            $this->displayPages( 'partner/services/addEditService', $this->data, true );
            return;
        }

		$vendorId 					= (int)$this->vendorId;
		$revenueTypeId 				= (int)$this->input->post('revenue_type_id');
		$reskillingLevelTypeId 		= $this->input->post('reskilling_level_type_id');
		$reskillingModeTypeId 		= (int)$this->input->post('reskilling_mode_type_id');
		$reskillingModeTypeId       = ( 0 == $reskillingModeTypeId ) ? 2 : 1;
		$reskillingIsPaid 			= (int)$this->input->post('is_paid_service');
		//$reskillingIsFeatured 		= (int)$this->input->post('is_featured');
		$externalLink  				= $this->input->post('external_link');
		$startDateTime  			= convertToDateTimeDB( $this->input->post('start_date_time') );
		$endDateTime  				= convertToDateTimeDB( $this->input->post('end_date_time') );
		$reskillingStatus			= (int)$this->input->post('reskilling_status');
		$price						= $this->input->post('price');
		/*$offerPrice					= $this->input->post('offer_price');
		$offerStartDateTime			= convertToDateTimeDB( $this->input->post('offer_start_date_time') );
		$offerEndDateTime			= convertToDateTimeDB( $this->input->post('offer_end_date_time') );*/
		$functionalArea				= (int)$this->input->post('functional_area');
		
		$serviceVideo 				= $this->input->post('service_video');
		$reskillingCities           = $this->input->post('cities');
										
		$serviceDescription  		= $this->input->post('description');
		$serviceTakeaways  			= $this->input->post('take_aways');
		$serviceTermsConditions  	= $this->input->post('terms_and_conditions');
		
		$imageName = $this->input->post('post_image');
		if(isset($_FILES['featured_image']['name']) && !empty($_FILES['featured_image']['name'])){
			$imageName = $this->uploadfile('services');
		}

		$serviceData = array(
			'vendor_id'					=> $vendorId,
			'revenue_type_id'			=> $revenueTypeId,
			'reskilling_level_type_id'  => $reskillingLevelTypeId,
			'reskilling_mode_type_id'	=> $reskillingModeTypeId,
			'is_paid_service'			=> $reskillingIsPaid,
			//'is_featured'				=> $reskillingIsFeatured,
			'external_link'				=> $externalLink,
			'start_date_time'			=> $startDateTime,
			'end_date_time'				=> $endDateTime,
			'status_type_id'			=> $reskillingStatus,
			'youtube_video_url'			=> $serviceVideo,
			'price'						=> $price,
			'jfh_costing'				=> $jfhCosting,
			'offer_price'               => $offerPrice,
			'offer_start_date_time'     => $offerStartDateTime,
			'offer_end_date_time'       => $offerEndDateTime,
			'description' 				=> $serviceDescription,
			'take_aways'  				=> $serviceTakeaways,
			'terms_and_conditions' 		=> $serviceTermsConditions,
			'priority_order'			=> $priorityOrder,
			'start_date_time'			=> $startDateTime,
			'end_date_time'				=> $endDateTime,
			'logo'						=> $imageName,
			'created_date_time'			=> date('Y-m-d H:i:s')
		);

		if( $serviceId ){
			unset( $serviceData['created_date_time'] );
		}
			
		$title = $this->input->post('title');
		
		$vendorName = generateSlug( strtolower( $this->reskilling_model->getVendorNameById($serviceData['vendor_id'] ) ) );
		$slug  		= $vendorName . '/' . generateSlug(strtolower( $title ));

		$serviceData['title'] 	= $title;
		$serviceData['slug'] 	= $slug;

		$serviceId = $this->services_model->insertOrUpdateReskillingData($serviceData,$serviceId,15015,'services',false);
		if($serviceId){
			$this->reskilling_model->updateFunctionalAreaByEntityIdByEntityTypeId( $functionalArea, $serviceId, SERVICE_TYPE_ID );
			$this->reskilling_model->insertOrUpdateReskillingCities( $reskillingCities, $serviceId, SERVICE_TYPE_ID );
			
			if( $serviceData['status_type_id'] == 1 ){
				$this->reskilling_model->addReskillingIndexing( $serviceId, SERVICE_TYPE_ID );
			}else{
				$this->reskilling_model->deleteReskillingIndexing( $serviceId, SERVICE_TYPE_ID );
			}
			
			if(isset($_FILES['sampleFiles']['name']) && !empty($_FILES['sampleFiles']['name'])){
				$destinationPath    = 'uploads/admin/reskilling/samples/'. $this->partnerData['vendor_id'] .'/services/';
				$filesArr 			= $this->uploadSampleFiles($destinationPath,$serviceId,SERVICE_TYPE_ID);
				$insertData = array();
				if($filesArr){
					foreach($filesArr as $file){
						$insertData[] = array(
				            'entity_id'         => $serviceId,
				            'entity_type_id'    => SERVICE_TYPE_ID,
				            'image_name'        => $file,
				            'created_date'      => date('Y-m-d H:i:s')
				        );
		           	}
	           	}
	           	
	           	$this->reskilling_model->insertSamples( $insertData );	
			}

			$this->session->set_flashdata('set_flashdata', 'Saved successfully!!');
		}

		$serviceLink = 'partner/services/edit-service/' . $serviceId;
        redirect($serviceLink);
	}
}