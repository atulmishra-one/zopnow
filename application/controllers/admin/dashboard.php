<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
	}
	
	
	public function index()
	{
		//$this->load->view('admin/dashboard/dashboard');
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		
		$data = array(
				'username' => $val[0]['admin_username'],
				'lastLogin' => date('D d M Y  - h:i a', strtotime($val[0]['last_login'])),
				'ip' => $val[0]['ip'] 
		
		);
		$this->parser->parse('admin/dashboard/dashboard',$data);
		
	}
}