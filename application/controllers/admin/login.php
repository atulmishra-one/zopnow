<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	*
	*
	*
	*
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/login_model');
	}
	
	public function index()
	{
		$this->load->view('admin/login');
		
	}
	
	public function doLogin(){
		
		if(!$this->login_model->doLogin()){
			$this->session->set_flashdata('message', '<div class="alert alert-error">Wrong username or password</div>');
			redirect(base_url().'admin','refresh');
		}
		else{
			redirect(base_url().'admin/dashboard','location');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */