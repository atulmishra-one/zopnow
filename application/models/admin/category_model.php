<?php

class Category_Model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function total(){
		return $this->db->count_all_results('category');
	}
	
	function add_category(){
		
		$name = $this->input->post('category_name', true);
		
		$category_details = $this->input->post('category_details', true);
		
		$status = $this->input->post('status', true);
		
		$featured = isset($_POST['featured'])? 1 : 0;
		
		$date = date('Y-m-d');
		
		
		$data = array(
		  
		  'category_name' => $name,
		  'category_details' => $category_details,
		  'category_status' => $status,
		  'featured' => $featured,
		  'date_added' => $date
		
		);	
		
		//$this->db->where('category_name', $_POST['category_name']);
        
        // Run the query
        //$query = $this->db->get('category');
        // Let's check if there are any results
        //if($query->num_rows == 1)
        //{
            // If there is a user, then create session data
           // $row = $query->row();
		
			if($this->db->insert('category', $data)){
				return true;
			}
		//}
		return false;
		
	}// 
	
	function edit_category($id){
		
		$name = $this->input->post('category_name', true);
		
		$category_details = $this->input->post('category_details', true);
		
		$status = $this->input->post('status', true);
		
		$featured = isset($_POST['featured'])? 1 : 0;
		
		$date = date('Y-m-d');
		
		
		$data = array(
		  
		  'category_name' => $name,
		  'category_details' => $category_details,
		  'category_status' => $status,
		  'featured' => $featured,
		  'date_added' => $date
		
		);	
		$this->db->where('category_id', $id);
		if($this->db->update('category', $data)){
			return true;
		}
		
		return false;
		
	}//
	
	function get_category($order, $desc){
		
		$this->db->where('trashed', 0);
		$this->db->order_by($order, $desc); 
		$query = $this->db->get('category');
		return $query->result_array();
	}//
	
	function moveTotrash(){
		$id = $this->input->post('ID');
		$data = array('trashed' => 1);
		$this->db->where('category_id', $id);
		$this->db->update('category', $data);
	}//
	
	function info($id){
		$this->db->where('category_id', $id);
		$query = $this->db->get('category');
		return $query->result_array();
		
	}
	
	function getSub($id){
		$this->db->where('category_id',$id);
		$query = $this->db->get('subcategory');
		$row = $query->row();
		return @$row->subcategory_name;
	}
	
	
}