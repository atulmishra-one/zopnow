<?php

class Import_Model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function checkcategory($name)
	{
		$this->db->where('category_name', $name);
		$q = $this->db->get('category');
		
		if($q->num_rows == 1){
			return true;
		}
		return false;
	}
	
	function add_category(){
		$this->db->insert('category', $data);
	}
	
	function get_category($name){
		$this->db->where('category_name', trim($name));
		$q = $this->db->get('category');
		
		if($q->num_rows == 1){
			$row = $q->row();
			
			return $row->category_id;
			
		}
		return false;
	}
	
	function get_subcategory($name){
		$this->db->where('subcategory_name', trim($name));
		$q = $this->db->get('subcategory');
		
		if($q->num_rows == 1){
			$row = $q->row();
			
			return $row->subcategory_id;
			
		}
		return false;
	}
	
	function get_product_id($id){
		$this->db->where('products_no', $id);
		$q = $this->db->get('products');
		
		if($q->num_rows == 1){
			return true;
		}
		return false;
	}
	
	function add_product(){
		
	}
}