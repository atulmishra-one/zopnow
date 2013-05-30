<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		 if(! $this->session->userdata('validated')){
            redirect(base_url().'admin');
         }
		$this->load->model('admin/dashboard_model', 'dash');
		$this->load->model('admin/import_model', 'import');
		//$this->load->model('admin/subcategory_model', 'scat');
	}
	
	function index(){
		
		//include APPPATH.'third_party/Excel/reader.php';
		
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		$data = array(
				'username' => $val[0]['admin_username']
		
		);
		$this->parser->parse('admin/import/import',$data);
	}
	
	function do_import(){
		if(isset($_POST['btn'])){
			
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			
			$header = 0;
			$i= 0;
			while (($data = fgetcsv($handle, 1024, ",")) !== FALSE) {
				
				if( $header > 0 )
				{
					$num = count($data);
					if($num > 0 && !empty($data[2])){
						
					if(!$this->import->get_product_id($data[2])){
						
						if($this->import->get_category($data[0])){
							$cid = $this->import->get_category($data[0]);
						
						
						if($this->import->get_subcategory($data[1])){
							$scid = $this->import->get_subcategory($data[1]);
						}
						
						
						
						
						
						$status = ($data[8] == 'N')? '0': '1';
						$new = ($data[9] == 'N')? '0': '1';
						$free = ($data[10] == 'N')? '0': '1';
						$date = date('Y-m-d');
						$data = array(
							
							'products_no' => $data[2],
							'products_name' => $data[3],
							'products_qty' => $data[4],
							'products_unit' => $data[5],
							'products_mrp' => $data[6],
							'products_ourprice' => $data[7],
							'products_status' => $status,
							'products_new_launch' => $new,
							'products_free' => $free,
							'category_id' => $cid,
							'subcategory_id' => $scid,
							'date_added' => $date
							
						
						);
						
						$this->db->insert('products', $data);
						}
						
					}else{
						
						//echo $data[3] , '-' , $data[2], 'Duplicate Product ID<br />';
						//$this->session->set_flashdata('message', '<div class="alert alert-error">Error Duplicate Entry<br /></div>');
						//redirect(base_url().'admin/import/', 'refresh');
						//exit;
					}
					
					}
					$i++;
				}$header = 1;
				
				
			}fclose($handle);
			$this->session->set_flashdata('message', '<div class="alert alert-success">Data Imported</div>');
			redirect(base_url().'admin/import/', 'refresh');
			exit;
		}
	}// close function 
}












