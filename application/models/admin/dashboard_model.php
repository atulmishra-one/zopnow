<?php

class Dashboard_Model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function _get_session( $id ){
		
		$this->db->where( 'admin_id', $id );
		
		$query = $this->db->get( 'admin' );
		
		return $query->result_array();
	}
	
	
}