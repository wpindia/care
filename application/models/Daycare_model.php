<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Daycare_model extends CI_Model{

	function __construct() {
		parent::__construct();
		$this->load->driver("cache");
	}

	function insertOrUpdateDaycareData($data, $id){
		try {
			$this->db->trans_start();
			if( 0 < $id ){
				$this->db->where('id', $id);
				$this->db->update('daycare', $data);
			} else{
				$this->db->insert('daycare', $data);
				$id = $this->db->insert_id();
			}
			
			$this->db->trans_complete();
			//show($this->db->last_query());
			return $id;
		} catch (Exception $e) {
			$this->db->rollback();
			return false;
		}
	}

	function getDaycareDetailsById($daycareId){
		try{
			$this->db->select('d.*');
			$this->db->from('daycare as d');
			$this->db->where('d.id', $daycareId );
			
			$query 	= $this->db->get();
			if($query){
				$result = $query->result_array();
				if($result)
					return $result[0];
				else 
					return array();
				
			}
			return array();	
		}catch(Exception $e){		
            log_message('error', __METHOD__ . ' called '.$e->getMessage());		
            return NULL;		
        }	
	}

	function getDaycaresByVendorId($vendorId){
		try{
			$this->db->select('d.*');
			$this->db->from('daycare as d');
			$this->db->where('d.vendor_id', $vendorId );
			
			$query 	= $this->db->get();
			if($query){
				$result = $query->result_array();
				if($result)
					return $result;
				else 
					return array();
				
			}
			return array();	
		}catch(Exception $e){		
            log_message('error', __METHOD__ . ' called '.$e->getMessage());		
            return NULL;		
        }	
	}

	function getDaycareDetailsBySeoName($seoName){
		try{
			$this->db->select('d.*');
			$this->db->from('daycare as d');
			$this->db->where('d.seo_name', $seoName );
			
			$query 	= $this->db->get();
			
			if($query){
				$result = $query->result_array();
				if($result)
					return $result[0];
				else 
					return array();
				
			}
			return array();	
		}catch(Exception $e){		
            log_message('error', __METHOD__ . ' called '.$e->getMessage());		
            return NULL;		
        }	
	}


	function getVendors(){
		try{
			$this->db->select('v.*');
			//$this->db->where('c.status_type_id', CustomTypes::ACTIVE_STATUS_TYPE );
			$this->db->from('vendors as v');
			$query 	= $this->db->get();
			if($query){
				$result = $query->result_array();
				return $result;
			}
			return array();
		}catch(Exception $e){		
            log_message('error', __METHOD__ . ' called '.$e->getMessage());		
            return NULL;		
        }	

	}

	function getVendorLegalNames(){
		try{
			$this->db->select('v.id,v.legal_name');
			//$this->db->where('c.status_type_id', CustomTypes::ACTIVE_STATUS_TYPE );
			$this->db->from('vendors as v');
			$query 	= $this->db->get();
			if($query){
				$result = $query->result_array();
				return $result;
			}
			return array();
		}catch(Exception $e){		
            log_message('error', __METHOD__ . ' called '.$e->getMessage());		
            return NULL;		
        }	

	}

	
	function updateVendorLoginDetails($vendorId,$vendorLoginDetails){
		try {
			$this->db->trans_start();
			$this->db->where('vendor_id', $vendorId);
			$status = $this->db->update('vendor_login', $vendorLoginDetails);
			$this->db->trans_complete();
			return true;
		} catch (Exception $e) {
			$this->db->rollback();
			return false;
		}
	}

	function insertOrUpdateVendorData($data,$id){
        try {
			$this->db->trans_start();
				if( 0 < $id ){
					$this->db->where('id', $id);
			        $status = $this->db->update('vendors', $data);
			        $status = ( $this->db->affected_rows() > 0 ) ? true : false;
			        
				} else{
					$status = $this->db->insert('vendors', $data);
					$id 	= $this->db->insert_id();

				}

			$this->db->trans_complete();
			return $id;
		} catch (Exception $e) {
			$insert_id = 0;
			$this->db->rollback();
			return false;
		}

	}

	function insertOrUpdateVendorAssociation($vendorId,$vendorTypeIds){
		if(false == is_array($vendorTypeIds)) return false;

		try {
			$this->db->trans_start();
			$this->db->where('vendor_id',$vendorId);
			$this->db->delete('vendor_association');
			
			foreach($vendorTypeIds as $vendorTypeId){
				$data = array('vendor_id'=>$vendorId, 'vendor_type_id'=>$vendorTypeId); 
				$status = $this->db->insert('vendor_association', $data);
			}	

			$this->db->trans_complete();
			return true;
		} catch (Exception $e) {
			$this->db->rollback();
			return false;
		}		
	}

	function getVendorAssociation($vendorId){
		try{
			$this->db->select('GROUP_CONCAT(va.vendor_type_id) AS vendor_type_ids');
			//$this->db->where('c.status_type_id', CustomTypes::ACTIVE_STATUS_TYPE );
			$this->db->from('vendor_association as va');
			$this->db->where('va.vendor_id', $vendorId);
			$query 	= $this->db->get();
			if($query){
				$result = $query->result_array();
				return $result[0]['vendor_type_ids'];
			}
			return array();
		}catch(Exception $e){		
            log_message('error', __METHOD__ . ' called '.$e->getMessage());		
            return NULL;		
        }
	}

	function getVendorAssociationByVendorTypeId($vendorTypeId){
		try{
			$this->db->select('v.vendor_name,v.id');
			//$this->db->where('c.status_type_id', CustomTypes::ACTIVE_STATUS_TYPE );
			$this->db->from('vendor_association as va');
			$this->db->join('vendors v', 'v.id=va.vendor_id');
			$this->db->where('va.vendor_type_id', $vendorTypeId);
			$this->db->where('v.status_type_id', CustomTypes::ACTIVE_STATUS_TYPE );
			$query 	= $this->db->get();
			if($query){
				$result = $query->result_array();
				return $result;
			}
			return array();
		}catch(Exception $e){		
            log_message('error', __METHOD__ . ' called '.$e->getMessage());		
            return NULL;		
        }
	}

	function getVendorDetailsAndAssociationById($vendorId){
		try{
			$this->db->select('v.*,group_concat(va.vendor_type_id) as vendor_type_ids');
			$this->db->from('vendors as v');
			$this->db->join('vendor_association as va', 'v.id = va.vendor_id' );
			$this->db->where('v.id', $vendorId );
			
			$query 	= $this->db->get();
			if($query){
				$result = $query->result_array();
				return $result[0];
			}
			return array();	
		}catch(Exception $e){		
            log_message('error', __METHOD__ . ' called '.$e->getMessage());		
            return NULL;		
        }	

	}
}	
