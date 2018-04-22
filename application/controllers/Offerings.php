 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ('Account.php');
class Offerings extends Account {


	function __construct() {
        parent::__construct();
        $this->load->model('vendors_model');

        if( true == empty( $this->partnerData ) ) {
            redirect('partner');
        }
    }

    function index(){

        $this->data['pageName']          = 'offerings';
        $this->data['partnerDetails']    = $this->vendors_model->getVendorDetailsById( $this->vendorId );
        $this->data['courses']           = $this->reskilling_model->getNewEntities(COURSE_TYPE_ID, -1, $this->vendorId, 0 );
        $this->data['assessments']       = $this->reskilling_model->getNewEntities(ASSESSMENT_TYPE_ID, -1, $this->vendorId, 0 );
        $this->data['services']          = $this->reskilling_model->getNewEntities(SERVICE_TYPE_ID, -1, $this->vendorId, 0 );
        
        $this->displayPages( 'partner/offerings/index', $this->data, true );
    }   

}