<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
        $this->load->helper('common_helper');
        $this->load->model('common_model');
	}

	public function index(){
		$this->load->library('email'); // Note: no $config param needed
		$this->email->from('info@day-care.in', 'info@day-care.in');
		$this->email->to('ninadajnikar@gmail.com');
		$this->email->subject('Test email from CI and Gmail');
		$this->email->message('This is a test.');
		$test = $this->email->send();
		show($this->email->print_debugger());
		exit;


		$this->data['pageName'] = 'home';
		$this->data['daycares'] = $this->common_model->getStarredDaycares();

		$this->generateView('home',$this->data);	
	}

	protected function generateView( $viewName,$data = '' ) {
        $this->load->view('header', $data);
        $this->load->view('header-menu', $data);
        $this->load->view($viewName, $data);
        $this->load->view('footer', $data );
    
    }

    public function getLocationByCityId(){
        
        $cityId 	= $this->input->get('city_id');
        $areaName 	= $this->input->get('area_name');
        $areas  	= $this->common_model->getActiveAreasByCityIdByAreaName($cityId,$areaName);
        
        $areas = explode(",",$areas);

        echo json_encode($areas);
    }
}
