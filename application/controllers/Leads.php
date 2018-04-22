<?php
/**
 * Admin Events Controller
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('Account.php');
class Leads extends Account {

	function __construct() {
		parent::__construct();
		$this->load->model('reskilling_model');
		$this->load->model('account_model');
		$this->load->model('courses_model');
		$this->load->model('assessments_model');
		$this->load->model('services_model');
		$this->load->model('leads_model');
		$this->load->library('customTypes' );		
		
	}

	public function index(){
		$this->data['pageName'] 	= 'leads';
		$this->data['courses'] = $this->data['assessments'] = $this->data['services']  = array();
		if( true == in_array(1, $this->vendorAssociationIds) ){
			$this->data['courses'] 		= $this->courses_model->getCPLCoursesByVendorId($this->vendorId);
		}

		if( true == in_array(2, $this->vendorAssociationIds) ){
			$this->data['assessments'] 	= $this->assessments_model->getCPLAssessmentsByVendorId($this->vendorId);
		}

		if( true == in_array(3, $this->vendorAssociationIds) ){
			$this->data['services'] 	= $this->services_model->getCPLServicesByVendorId($this->vendorId);
		}
		
		$this->displayPages( 'partner/leads/index', $this->data, true );
	}

	function getInterestedLeadDetailsByEntityIdByEntityTypeId(){
		$entityId 		= $this->input->post('entityId');
		$entityTypeId 	= $this->input->post('entityTypeId');
		//$vendorId       = $this->logged->in['id'];
		//$vendorId       = 6;
		$pageNo         = $this->input->post('pageNo');

		$data['totalRecords']		= $this->leads_model->getTotalInterestedLeads($entityId,$entityTypeId);	
		$data['interestedLeads'] 	= $this->leads_model->getInterestedLeadDetailsByEntityIdByEntityTypeId($entityId,$entityTypeId,$pageNo);
		
		echo json_encode( $data );
	}

	function displayInterestedLeads(){
		$interestedLeadsJsonData = file_get_contents("php://input");
        if( strlen($interestedLeadsJsonData) > 0 ){
          $interestedLeadsData = json_decode($interestedLeadsJsonData);
          
          $this->data['interestedLeads']  	= $interestedLeadsData->interestedLeads;
          $this->data['totalRecords']  		= $interestedLeadsData->totalRecords;
        
          $interestedLeads = $this->load->view('partner/leads/view-interested-leads', $this->data, true);
          echo $interestedLeads;
          
        }
	}

	function downloadLeads( $entityId,$entityTypeId ){
		$interestedLeads 	= $this->leads_model->getInterestedLeadDetailsByEntityIdByEntityTypeId($entityId,$entityTypeId,0, true);
		
		$this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('InterestedLeads');
        
        $this->excel->getActiveSheet()->fromArray(array_keys($interestedLeads[0]),null,'A1');
 		$this->excel->getActiveSheet()->fromArray($interestedLeads, null,'A2');
 		$filename='InterestedLeads.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
        $objWriter->save('php://output');

	}

	
}