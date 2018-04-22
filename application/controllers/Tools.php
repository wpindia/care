<?php
/**
 * Admin Events Controller
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('Account.php');
class Tools extends Account {

	function __construct() {
		parent::__construct();
		$this->load->model('reskilling_model');
		$this->load->model('reskillingReports_model');
		$this->load->library('customTypes' );		
		
	}

	public function index(){
		$this->data['page_title'] 		= 'Bulk Upload';
		$this->data['pageName'] 		= 'reskilling-bulk-upload';
		
		$this->displayPages('partner/offerings/bulkUpload', $this->data,true);
	}

	function handeBulkUploadData(){
		$filePath = '';
		if(isset($_FILES['bulk-upload']['name']) && !empty($_FILES['bulk-upload']['name'])){
			$filePath = $this->bulkUploadFile();
		}

		if( false == $filePath ){
			show('Error');
		}

		$reskillingType = $this->input->post('reskilling-type');
		switch($reskillingType){
			case 15013:
			default:
				$this->bulkUploadCourses($filePath);				
				break;
		}

	}

	function bulkUploadCourses($filePath){
		//load the excel library
		$this->load->library('excel');
	
		try{
			$objPHPExcel 	= PHPExcel_IOFactory::load($filePath);
			$sheetData 		= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		} catch(Exception $e) {
            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        $data 			= array();
        $errorMessage 	= '';
		$failedRows     = 0;
		$successfulRows = 0;
		$totalRows      = count($sheetData) - 1;

		foreach($sheetData as $key =>$row){
			if($key == 1) continue;
			
			$vendorName = generateSlug( strtolower( $this->reskilling_model->getVendorNameById($this->vendorId) ) );
			$slug  		= $vendorName . '/' . generateSlug( strtolower( $row["G"] ) );
			
			$data = array( 
              'vendor_id' 					=> $this->vendorId,
			  'reskilling_mode_type_id' 	=> ("online" == strtolower($row["E"])) ? 1 : 0,
			  'title' 						=> $row["G"],
			  'slug' 						=> $slug,
			  'logo' 						=> generateSlug( strtolower( $row["G"] ) ) . '.png',
			  'instructor_name' 			=> '',
			  'city' 						=> "",
			  'address' 					=> '' ,
			  'description' 				=> $row["I"],
			  'price' 						=> $row["N"],
			  'offer_price' 				=> '0.0',
			  'offer_start_date_time' 		=> '',
			  'offer_end_date_time' 		=> '',
			  'external_link' 				=> $row["K"],
			  'take_aways' 					=> $row["J"],
			  'details' 					=> $row["L"],
			  'terms_and_conditions'		=> $row["Q"],
			  'remarks' 					=> '',
			  'start_date_time' 			=> date("Y-m-d H:i:s"),
			  'end_date_time' 				=> date('Y-m-d H:m:s', strtotime("+365 days")),
			  'is_paid_course' 				=> ("yes" == strtolower( $row["T"] ) ) ? 1 : 0,
			  'is_featured'					=> 0,
			  'accept_payment_on_jfh' 		=> 0,
			  'is_certification_provided' 	=> (true == empty($row["U"])) ? "" : $row["U"],
			  'reskilling_level_type_id' 	=> (true == empty($row["V"])) ? "" : $row["V"],
			  'jfh_costing' 				=> '0.0',
			  'revenue_type_id'				=> 2,
			  'status_type_id' 				=> 2,
			  'youtube_video_url' 			=> $row["W"],
			  'created_date_time' 			=> date("Y-m-d H:i:s"),
			  'modified_date_time' 			=> date("Y-m-d H:i:s"),
			  'priority_order' 				=> 1,
			  'created_by' 					=> 999 
            );
          	$functionalAreaId = $this->getFunctionalAreaByName($row['B']);
			$courseId = $this->db->insert( 'courses', $data );
            
            if($courseId){
				$this->load->model('reskilling_model');
				$this->reskilling_model->updateFunctionalAreaByEntityIdByEntityTypeId( $functionalAreaId, $courseId, COURSE_TYPE_ID );
			}

            if( false == $courseId ) { 
            	$dbError = $this->db->error()['message'];
            	$errorMessage .= 'Row ' . $key . ' was not inserted due to error - ' . $dbError . '  <br/>'; 
            	$failedRows   += 1;
            	continue; 
            }

            $successfulRows += 1;
		}

		$this->data['totalRows'] 		= $totalRows;
		$this->data['failedRows'] 		= $failedRows;
		$this->data['successfulRows'] 	= $successfulRows;
		$this->data['errorMessage'] 	= $errorMessage;
		$this->data['page_title'] 		= 'Bulk Upload Notification';
		$this->data['pageName'] 		= 'reskilling-bulk-upload-notification';

		$this->logBulkUploadData(15013,$filePath,$totalRows,$successfulRows,$failedRows);

		$this->displayPages('partner/offerings/bulkUploadNotification', $this->data,true );		
	
	}

	function logBulkUploadData($reskillingType,$filePath,$totalRows,$successfulRows,$failedRows){
		$userId 		= $this->partnerData['user_login_id'];

		$insertedData = array(
			 'admin_id' 		=> $userId,
			 'entity_type_id' 	=> $reskillingType,
			 'file_name' 		=> $filePath,
			 'total_rows' 		=> $totalRows,
			 'successful_rows' 	=> $successfulRows,
			 'failed_rows' 		=> $failedRows,
			 'createtd_date' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert( 'reskilling_bulk_upload', $insertedData );
	}

	function bulkUploadFile(){
		$filename = time() . '_' . strtolower($_FILES["bulk-upload"]["name"]) ;

		if ($_FILES['bulk-upload']['error'] == 0 && $_FILES['bulk-upload']['name'] != '') {
			
			if (strpos($filename, '.xls') !== false || strpos($filename, '.xlsx') !== false ) {
				$config['upload_path'] 		= FCPATH.'uploads/admin/reskilling/bulk-uploads';
				$config['new_path'] 		= FCPATH.'uploads/admin/reskilling/bulk-uploads/';
				$config['allowed_types'] 	= '*';
				$config['file_name'] 		= $filename;

				$this->load->library('upload', $config);
				if ( false == $this->upload->do_upload('bulk-upload') ) {
					$error = array('error' => $this->upload->display_errors());
					show($error);
					//return false;
				}else {
					$filePath = FCPATH . 'uploads/admin/reskilling/bulk-uploads/' . $filename;
					return $filePath;
				}
			}
		}
		return false;
	}
	function getFunctionalAreaByName($functionalAreaName){
				$functional_areas  = array(
				  '1' => 'Airline/Reservation/Ticketing/Travel',
				  '2' => 'Research/Analytics/Business Intelligence/Big data',
				  '3' => 'Anchoring/TV/Films/Production',
				  '4' => 'Fashion Designer',
				  '5' => 'Architect/Interior Design',
				  '6' => 'Art Director/Graphic/Web Designer',
				  '7' => 'Investment/Corporate/Retail Banking/ Insurance',
				  '8' => 'Content Writer/Editor/Journalist',
				  '9' => 'Web Designer/ UX/UI Designer',
				  '10' => 'Consulting/ Strategy management',
				  '11' => 'Front Office Staff/Secretarial',
				  '12' => 'Computer Operator/Data Entry',
				  '13' => 'Hotel/Restaurant Management',
				  '14' => 'HR - Recruiter',
				  '15' => 'HR - Payroll/Business Partner/General',
				  '16' => 'Admin',
				  '17' => 'Customer Service/ Telecalling/ Back Office Operations',
				  '18' => 'Legal/Law',
				  '19' => 'Medical Professional/Healthcare Practitioner/ Technician',
				  '20' => 'Marketing/Advertising/MR/Media Planning',
				  '21' => 'Digital Marketing/SEM/SEO',
				  '22' => 'PR/Corporate Communication/Event management',
				  '23' => 'Production/Service Engineering/Manufacturing/Maintenance',
				  '24' => 'Project Management/Site engineering',
				  '25' => 'Purchase/Supply chain/Logistics',
				  '26' => 'RnD/Engineering',
				  '27' => 'Sales/Business Development/Client Servicing',
				  '28' => 'Security',
				  '29' => 'Teaching/Education/Language Specialist',
				  '30' => 'Other',
				  '31' => 'Accounting / Finance / Tax / CS / Audit',
				  '33' => 'Database Administrator/ Data warehousing',
				  '34' => 'Software Development',
				  '35' => 'Network Administrator',
				  '36' => 'QA/Testing',
				  '37' => 'Medical Representative',
				  '38' => 'Pharmacist/Bio-Technologist',
				  '39' => 'HR - Learning and development/Training',
				  '40' => 'Product management',
				  '41' => 'Operations',
				  '42' => 'Technical staff/Support',
				  '43' => 'General Management',
				  '44' => 'Soft Skills',
				  '45' => 'Career Assessment',
				  '46' => 'Resume writing',
				  '47' => 'Career Counselling'
				);

		$key = array_search( $functionalAreaName, $functional_areas);
		
		return $key;
	}
}			