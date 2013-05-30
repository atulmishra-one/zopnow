<?php

class Products_Model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function total()
	{
		$this->db->where('trashed', 0);
		return $this->db->count_all_results('products');
	}
	function get_category(){
		$this->db->where('trashed', 0); 
		$query = $this->db->get('category');
		return $query->result_array();
	}//
	
	function getPro($c, $s){
		$this->db->where('category_id', $c);
		$this->db->where('subcategory_id', $s);
		
		$query = $this->db->get('products');
		$row = $query->rows();
		return $row->products_name;
	}
	
	function get_subcategory(){
		$id = $this->input->post('ID');
		$this->db->where('subcategory_id', $id); 
		$this->db->where('trashed', 0); 
		$query = $this->db->get('subcategory');
		return $query->result_array();
	}//
	
	function info($id){
		$this->db->where('products_id', $id);
		$query = $this->db->get('products');
		return $query->result_array();
		
	}//
	
	function checkPiD(){
		$id = $this->input->post('ID');
		$this->db->where('products_no', $id);
		$q = $this->db->get('products');
		if($q->num_rows == 1){
			return false;
		}
		
		return true;
	}//
	
	function moveTotrash(){
		$id = $this->input->post('ID');
		$data = array('trashed' => 1);
		$this->db->where('products_id', $id);
		$this->db->update('products', $data);
	}//
	
	function get_products(){
		$q = $this->db->query("select
		 * 
		 from
		 products
		 LEFT JOIN category ON products.category_id=category.category_id
		 LEFT JOIN subcategory ON subcategory.subcategory_id=products.subcategory_id
		 WHERE products.trashed=0
		 ");
		 
		 return $q->result_array();
	}
	
	function add_product($file){
		error_reporting(0);
		$cat = $this->input->post('category_id');
		
		$scat = $this->input->post('subcategory');
		
		$pro_id = (float)$this->input->post('product_id');
		
		$pro_name = $this->input->post('product_name', true);
		
		$qty = (int)$this->input->post('qty', true);
		
		$unit = $this->input->post('unit', true);
		
		$mrp = (float)$this->input->post('mrp', true);
		
		$oprice = (float)$this->input->post('ourprice', true);
		
		$status = $this->input->post('status', true);
		
		$new = $this->input->post('newlaunch', true);
		
		$free = $this->input->post('free', true);
		
		$products_details = $this->input->post('products_details', true);
		
		$date = date('Y-m-d');
		
		//$image = isset($_FILES['image']['name'])? $_FILES['image']['name']: '';
		
		
		
		$this->db->where('products_no', $pro_id);
		$q = $this->db->get('products');
		if($q->num_rows == 0){
			
			$data = array(
			
				'products_no' => $pro_id,
				'products_name' => $pro_name,
				'products_qty' => $qty,
				'products_unit' => $unit,
				'products_mrp' => $mrp,
				'products_ourprice' => $oprice,
				'products_status' => $status,
				'products_new_launch' => $new,
				'products_free' => $free,
				'products_image' => $file,
				'products_details' => $products_details,
				'category_id' => $cat,
				'subcategory_id' => $scat,
				'date_added' => $date
			
			);
			
			$this->db->insert('products', $data);
			
			return true;
			
		}
		
		return false;
	}
	
	function edit_product($id,$file){
		error_reporting(0);
		$cat = $this->input->post('category_id');
		
		$scat = $this->input->post('subcategory');
		
		$pro_name = $this->input->post('product_name', true);
		
		$qty = (int)$this->input->post('qty', true);
		
		$unit = $this->input->post('unit', true);
		
		$mrp = (float)$this->input->post('mrp', true);
		
		$oprice = (float)$this->input->post('ourprice', true);
		
		$status = $this->input->post('status', true);
		
		$new = $this->input->post('newlaunch', true);
		
		$free = $this->input->post('free', true);
		
		$products_details = $this->input->post('products_details', true);
		
		$date = date('Y-m-d');
		
		if(isset($_FILES['image']['name'])){
			if(!empty($file)){
				$up = array(
				'products_image' => $file
				);
				$this->db->where('products_id', $id);
				$this->db->update('products', $up);
			}
		}
		//$image = isset($_FILES['image']['name'])? $_FILES['image']['name']: '';
		
			$data = array(
				'products_name' => $pro_name,
				'products_qty' => $qty,
				'products_unit' => $unit,
				'products_mrp' => $mrp,
				'products_ourprice' => $oprice,
				'products_status' => $status,
				'products_new_launch' => $new,
				'products_free' => $free,
				'products_details' => $products_details,
				'category_id' => $cat,
				'subcategory_id' => $scat,
				'date_added' => $date
			
			);
			$this->db->where('products_id', $id);
			$this->db->update('products', $data);
			
			return true;
			
		
		return false;
	}
	
	
}















