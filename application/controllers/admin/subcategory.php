<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subcategory extends CI_Controller {

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
		$this->load->model('admin/subcategory_model', 'scat');
	}
	
	public function index($where = false, $order = 'subcategory_id', $desc = 'desc')
	{
		
		if($this->scat->moveTotrash()){
			exit;
		}
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		
		
		$data = array(
				'username' => $val[0]['admin_username'],
				'scategory' => $na = $this->scat->get_subcategory($where, $order, $desc),
				'total' => $this->scat->total()
		
		);
		if($where){
			if(count($na)) {
			$data['cname'] = 'of '.$na[0]['category_name'];
			$data['cid'] = $na[0]['category_id'];
			}else{
				
				redirect(base_url().'admin/category','refresh');
				exit;
			}
			
		}
		else{
			$data['cid']= '';
			$data['cname'] = '';
		}
		$this->parser->parse('admin/subcategory/subcategory',$data);
	}//
	
	function new_subcategory($cid = false){
		
		if($cid){
			$data['cid'] = $cid;
			//$data['info'] = '';//
		}
		else{
			$data['cid'] = '';
			//$data['info'] = '';
		}
		
		if(isset($_POST['btn'])){
		 if($this->scat->add_subcategory()){
			$this->session->set_flashdata('message', '<div class="alert alert-success">Sub Category Added Successfully</div>');
			redirect(base_url().'admin/subcategory/new_subcategory', 'refresh');
			}
		else{
			$this->session->set_flashdata('message', '<div class="alert alert-error">Could not proccess/Category might exists</div>');
			redirect(base_url().'admin/category/new_category', 'refresh');
			}
		}
		
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		$data = array(
				'username' => $val[0]['admin_username'],
				'categoryList' => $this->scat->get_category()
		
		);
		
		if($cid){
			$data['info'] = $this->scat->info($cid);
		}
		
		$this->parser->parse('admin/subcategory/new_subcategory',$data);
		
	}// 
	
	
	public function edit_subcategory($id){
		if(isset($_POST['btn'])){
		 if($this->scat->edit_subcategory($id)){
			$this->session->set_flashdata('message', '<div class="alert alert-success">Category Edit Successfully</div>');
			redirect(base_url().'admin/subcategory/edit_subcategory/'.$id.'/', 'refresh');
			}
		else{
			$this->session->set_flashdata('message', '<div class="alert alert-error">Could not proccess</div>');
			redirect(base_url().'admin/subcategory/edit_subcategory/'.$id.'/', 'refresh');
			}
		}
		
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		$data = array(
				'username' => $val[0]['admin_username'],
				'categoryList' => $this->scat->get_category(),
				'info' => $this->scat->info($id)
		
		);
		$this->parser->parse('admin/subcategory/edit_subcategory',$data);
	}
}