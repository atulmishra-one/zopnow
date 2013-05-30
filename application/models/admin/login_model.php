<?php

class Login_Model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function doLogin(){
		
	 	$username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        
        // Prep the query
        $this->db->where('admin_username', $username);
        $this->db->where('admin_password', $password);
        
        // Run the query
        $query = $this->db->get('admin');
        // Let's check if there are any results
        if($query->num_rows == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();
			
			$date = date("Y-m-d H:i:s");
			
			$update = array(
			  'last_login' => $date,
			  'ip' => $_SERVER['REMOTE_ADDR']
			);
			
			$this->db->where('admin_id', $row->admin_id);
			
			$this->db->update('admin', $update);
			
            $data = array(
                    'admin_id' => $row->admin_id,
                    'validated' => true
                    );
            $this->session->set_userdata($data);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
		
	}
	
}
