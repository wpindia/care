<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Common_model extends CI_Model{

	function __construct() {
		parent::__construct();
		$this->load->driver("cache");
	}

	function getActiveCities(){
		try{
			$this->db->select('c.*');
			$this->db->from('cities as c');
			$this->db->where('is_active', 1);

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

	function getActiveAreasByCityId($cityId){
		try{
			$this->db->select('caa.area_name,caa.id');
			$this->db->from('city_area_association as caa');
			$this->db->where('is_active', 1);
			$this->db->where('city_id', $cityId);

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

	function getActiveAreasByCityIdByAreaName($cityId,$areaName){
		try{
			$this->db->select('GROUP_CONCAT(caa.area_name) as area_name');
			$this->db->from('city_area_association as caa');
			$this->db->where('is_active', 1);
			$this->db->where('city_id', $cityId);
			$this->db->like('area_name', $areaName, 'after');   
			
			$query 	= $this->db->get();
			if($query){
				$result = $query->result_array();
				return $result[0]['area_name'];
				
			}
			return array();	
		}catch(Exception $e){		
            log_message('error', __METHOD__ . ' called '.$e->getMessage());		
            return NULL;		
        }	
	}

	function getDaycaresByCityIdByAreaId($cityId,$areaId){
		try{
			$this->db->select('d.*');
			$this->db->from('daycare as d');
			$this->db->where('city_id', $cityId);
			$this->db->where('area_id', $areaId);
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

	function getStarredDaycares(){
		try{
			$this->db->select('d.*');
			$this->db->from('daycare as d');
			$this->db->where('is_starred', 1);
			$this->db->where('is_active', 1);
			$this->db->limit(16);
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


	
}	
