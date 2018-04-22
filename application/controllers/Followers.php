 <?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once ('Account.php');
class Followers extends Account {

	function __construct() {
        parent::__construct();
        $this->load->model('followers_model');
        $this->load->model('vendors_model');
	}        

	public function index() {
		$this->data['pageName'] = 'followers';    

	    if( 0 == $this->data['logged'] ) {
	        redirect('partner/');
	    } else {
	        
	        $this->load->model('city_model');
	        
	        $this->data['cities']           = $this->city_model->getAllCitiesForSearch();
	        $this->data['vendorData']       = $this->vendors_model->getVendorDetailsById( $this->vendorId );
	        $this->displayPages( 'partner/followers', $this->data, true );
	    }
	}

	public function viewCandidateProfile( $id ){
		if( true == empty( $id ) ) {
			redirect( 'mentor/followers' );
		}

		$this->data['pageName'] 	= 'candidate-profile';    		
		$this->data['user_details'] = $this->getAllUserDetails( $id );
		
		$this->displayPages( 'profiles/profile-candidate' ,$this->data, true );
	}

	private function getAllUserDetails($user_id) {
        $this->load->model('profile_model');
        $this->load->model('account_model');

        $this->data['user_data'] = $this->profile_model->get_user_basic_details($user_id);
        
        if(isset($this->data['user_data']) && !empty($this->data['user_data'])){
            $this->data['user_data']['city_details'] = $this->profile_model->getUserCities($this->data['user_data']['id'], 1);
        }
        $this->data['preference_data'] = $this->profile_model->get_user_preference_details($user_id);
        $this->data['match_data'] = $this->profile_model->get_user_matching_details($user_id);
        $this->data['experience_data'] = $this->profile_model->get_user_experience_details($user_id);
        $this->data['profile_sum'] = $this->profile_model->get_user_profile_summary($user_id);
        $this->data['certificates'] = $this->profile_model->get_user_certificates($user_id);

        $this->data['user_skills'] = $this->profile_model->get_user_skill_details($user_id);
        $this->data['languages'] = $this->profile_model->get_user_language_details($user_id);
        $this->data['portfolios'] = $this->profile_model->get_user_portfolio_details($user_id);
        $this->data['hobbies'] = $this->profile_model->get_user_hobby_details($user_id);
        $this->data['videos'] = $this->profile_model->get_user_myvideo_details($user_id);
        $this->data['work_experience'] = $this->profile_model->get_user_work_experience($user_id);
        $this->data['education'] = $this->profile_model->get_user_education($user_id);
        $this->data['profile_cnt'] = $this->profile_model->profile_view_count($user_id);
        $this->data['job_types'] = $this->account_model->get_job_types();
        $this->data['functional_areas'] = $this->account_model->get_functional_areas();
        $this->data['industry'] = $this->account_model->get_industries();

        return $this->data;
    }
}
