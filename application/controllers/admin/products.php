<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	/**
	*
	*
	*
	*
	*/
	public function __construct()
	{
		parent::__construct();
		
		 if(! $this->session->userdata('validated')){
            redirect(base_url().'admin');
         }
		$this->load->model('admin/dashboard_model', 'dash');
		$this->load->model('admin/products_model', 'pro');
		$this->load->model('admin/category_model', 'cat');
	}
	
	function index(){
		
		if($this->pro->moveTotrash()){
			exit;
		}
		
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		$data = array(
				'username' => $val[0]['admin_username'],
				'total'=> $this->pro->total(),
				'products' => $this->pro->get_products()
		
		);
		$this->parser->parse('admin/products/products',$data);
	}
	
	//
	
	function new_products(){
		
		if(isset($_POST['btn'])){
			if(isset($_FILES['image']['name'])){
					$this->do_upload('image');
					$n = $this->upload->data();
				}
			if($this->pro->add_product($n['file_name'])){
				
				$this->session->set_flashdata('message', '<div class="alert alert-success">Product Added Successfully</div>');
			redirect(base_url().'admin/products/new_products', 'refresh');
			exit;
			}
			else{
			
				$this->session->set_flashdata('message', '<div class="alert alert-error">Error: Product ID exists/An Error Occurred</div>');
			redirect(base_url().'admin/products/new_products', 'refresh');
			exit;	
				
			}
		}
		
		
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		$data = array(
				'username' => $val[0]['admin_username'],
				'categoryList' => $this->pro->get_category()
		
		);
		
		$this->parser->parse('admin/products/new_products',$data);
	}//
	
	function do_upload($image)
	{
		$config['upload_path'] = './public/uploads/product_images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']    = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
 
		// You can give video formats if you want to upload any video file.
 
		$this->load->library('upload', $config);
 		$this->upload->do_upload($image);
	}//
	
	function edit_products($id, $file=false){
		
		if(isset($_POST['btn'])){
			
			if(isset($_FILES['image']['name'])){
					$this->do_upload('image');
					$n = $this->upload->data();
			}
			if($this->pro->edit_product($id, $n['file_name'])){
				
				
				
				$this->session->set_flashdata('message', '<div class="alert alert-success">Product Updated Successfully</div>');
			redirect(base_url().'admin/products/edit_products/'.$id, 'refresh');
			exit;
			}
			else{
			
				$this->session->set_flashdata('message', '<div class="alert alert-error">Error: An Error Occurred</div>');
			redirect(base_url().'admin/products/edit_products/'.$id, 'refresh');
			exit;	
				
			}
		}
		
		
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		$data = array(
				'username' => $val[0]['admin_username'],
				'categoryList' => $this->pro->get_category(),
				'info' => $this->pro->info($id)
		
		);
		
		$this->parser->parse('admin/products/edit_products',$data);
	}//
	
	function subList(){
		if($this->pro->get_subcategory()){
		echo '<option value="0">--Select Sub Category--</option>';
		foreach($this->pro->get_subcategory() as $sl){
			$selected = '';
			if(isset($_POST['g'])){
				$n = $this->pro->info($_POST['g']);
				if($sl['subcategory_id'] == $n[0]['subcategory_id']){
					$selected = 'selected';
				}
			}
			
			echo '<option value="'.$sl['subcategory_id'].'" '.$selected.'>'.$sl['subcategory_name'].'</option>';
		}
		}
		else{
			echo $this->input->post('ID');
		}
	}//
	
	function checkPiD(){
		if($this->pro->checkPiD()){
			echo 's';
		}
		else{
			echo 'e';
		}
	}
	
	
	function tree($order = 'category_id', $desc = 'desc')
	{
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		$data = array(
				'username' => $val[0]['admin_username'],
				'total' => $this->cat->total()
		
		);
		$data['category'] = '';
		
		foreach($this->cat->get_category($order, $desc) as $c){
			$data['category'] .= '<li>
        <img src="'.base_url().'public/js/jtree/images/folder.gif" />  
		<a href="'.base_url().'admin/category/edit_category/'.$c['category_id'].'">'.$c['category_name'].'</a></span>
			<ul>
				<li> 
				
				<a href="'.base_url().'admin/subcategory/new_subcategory/'.$c['category_id'].'">'.$this->cat->getSub($c['category_id']).'</a> 
					<ul>
						<li></li>
					</ul>
				
				
				</li>
			</ul>
		</li>';
		}
		
		$this->parser->parse('admin/products/tree_products',$data);
	}
	
	
}