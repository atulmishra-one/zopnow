<?php

class Subcategory_Model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function total(){
		return $this->db->count_all_results('category');
	}
	
	function get_category(){
		$this->db->where('trashed', 0); 
		$query = $this->db->get('category');
		return $query->result_array();
	}//
	
	function add_subcategory(){
		$category_id = $this->input->post('category_id');
		$subcategoryname = $this->input->post('subcategoryname');
		$subcategory_details = $this->input->post('subcategory_details');
		$status = $this->input->post('status');
		$date = date('Y-m-d');
		
		$data = array(
		'subcategory_name' => $subcategoryname,
		'subcategory_details' => $subcategory_details,
		'subcategory_status' => $status,
		'category_id' => $category_id,
		'date_added' => $date
		);
		
		if($this->db->insert('subcategory', $data)){
			return true;
		}
		
		return false;
		
	}//
	
	function edit_subcategory($id){
		
		$category_id = $this->input->post('category_id');
		$subcategoryname = $this->input->post('subcategoryname');
		$subcategory_details = $this->input->post('subcategory_details');
		$status = $this->input->post('status');
		$date = date('Y-m-d');
		
		$data = array(
		'subcategory_name' => $subcategoryname,
		'subcategory_details' => $subcategory_details,
		'subcategory_status' => $status,
		'category_id' => $category_id,
		'date_added' => $date
		);
		$this->db->where('subcategory_id', $id);
		if($this->db->update('subcategory', $data)){
			return true;
		}
		
		return false;
		
	}//
	
	
	
	
	function get_subcategory($where, $order, $desc){
		if($where){
			$where = "WHERE B.category_id=$where and A.trashed=0";
		}
		else{
			$where = "WHERE A.trashed=0";
		}
		$query = $this->db->query("
		select *
		from
		subcategory as A
		INNER JOIN category as B ON 
		A.category_id=B.category_id
		$where
		GROUP BY A.subcategory_name
		ORDER BY $order $desc
		");
		return $query->result_array();
	
	}//
	
	function moveTotrash(){
		$id = $this->input->post('ID');
		$data = array('trashed' => 1);
		$this->db->where('subcategory_id', $id);
		$this->db->update('subcategory', $data);
	}//
	
	function info($id){
		$this->db->where('subcategory_id', $id);
		$query = $this->db->get('subcategory');
		return $query->result_array();
		
	}
	
	
	
	
}