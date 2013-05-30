<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

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
		$this->load->model('admin/category_model', 'cat');
	}
	
	public function index($order = 'category_id', $desc = 'desc')
	{
		
		if($this->cat->moveTotrash()){
			exit;
		}
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		$data = array(
				'username' => $val[0]['admin_username'],
				'category' => $this->cat->get_category($order, $desc),
				'total' => $this->cat->total()
		
		);
		$this->parser->parse('admin/category/category',$data);
	}
	
	public function new_category(){
		
		if(isset($_POST['btn'])){
		 if($this->cat->add_category()){
			$this->session->set_flashdata('message', '<div class="alert alert-success">Category Added Successfully</div>');
			redirect(base_url().'admin/category/new_category', 'refresh');
			}
		else{
			$this->session->set_flashdata('message', '<div class="alert alert-error">Could not proccess/Category might exists</div>');
			redirect(base_url().'admin/category/new_category', 'refresh');
			}
		}
		
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		$data = array(
				'username' => $val[0]['admin_username']
		
		);
		$this->parser->parse('admin/category/new_category',$data);
		
		
	}
	
	public function edit_category($id){
		if(isset($_POST['btn'])){
		 if($this->cat->edit_category($id)){
			$this->session->set_flashdata('message', '<div class="alert alert-success">Category Edit Successfully</div>');
			redirect(base_url().'admin/category/edit_category/'.$id.'/', 'refresh');
			}
		else{
			$this->session->set_flashdata('message', '<div class="alert alert-error">Could not proccess</div>');
			redirect(base_url().'admin/category/edit_category/'.$id.'/', 'refresh');
			}
		}
		
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		$data = array(
				'username' => $val[0]['admin_username'],
				'info' => $this->cat->info($id)
		
		);
		$this->parser->parse('admin/category/edit_category',$data);
	}// close 
	
	
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
				<li> <a href="'.base_url().'admin/subcategory/new_subcategory/'.$c['category_id'].'">'.$this->cat->getSub($c['category_id']).'</a> </li>
			</ul>
		</li>';
		}
		
		$this->parser->parse('admin/category/tree_category',$data);
	}
	
	
}









