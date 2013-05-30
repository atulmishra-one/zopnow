<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		 if(! $this->session->userdata('validated')){
            redirect(base_url().'admin');
         }
		$this->load->model('admin/dashboard_model', 'dash');
		//$this->load->model('admin/import_model', 'import');
		//$this->load->model('admin/subcategory_model', 'scat');
	}
	
	function index(){
		
		//include APPPATH.'third_party/Excel/reader.php';
		
		$val = $this->dash->_get_session($this->session->userdata('admin_id'));
		$data = array(
				'username' => $val[0]['admin_username']
		
		);
		$this->parser->parse('admin/export/export',$data);
	}
	
	function cleanData(&$str)
  	{
    	$str = preg_replace("/\t/", "\\t", $str);
    	$str = preg_replace("/\r?\n/", "\\n", $str);
    	if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  	}
	function getDownload(){
		
		//$out= 'Main Head\tSub Head\tProduct Id';
		
		$filename = 'products_data'."_".date("d-m-Y_H-i",time());

		//Generate the CSV file header
		
		
		/*foreach($q->result_array() as $p){
			echo $p['products_name'];
		}*/
		header("Content-type: application/xls");
		header("Content-disposition: csv" . date("d-m-Y") . ".xls");
		header("Content-disposition: filename=".$filename.".xls");
		
		$sep = "\t";
		echo "Main Head\tSub Head\tProduct ID\tProduct name\tWeight\tUnit\tMRP\tOur Price\t";
		
		echo "\n";
		$q = $this->db->query("select * from products LEFT JOIN category ON products.category_id LEFT join 
		subcategory ON products.subcategory_id=subcategory.subcategory_id
		 ");
		foreach($q->result_array() as $j=>$p){
			$schema_insert = "";
			
			if(!isset($p))
	
                $schema_insert = "NULL".$sep;
	
            elseif ($p != "")

                $schema_insert = $p['category_name'].$sep.$p['subcategory_name'].$sep.$p['products_no'].$sep.$p['products_name'].$sep.$p['products_qty'].$sep.$p['products_unit'].$sep.$p['products_mrp'].$sep.$p['products_ourprice'];

            else{

                $schema_insert = "".$sep;
			}
			
			$schema_insert = str_replace($sep."$", "", $schema_insert);
			$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
			$schema_insert .= "\t";
			print(trim($schema_insert));

	        print "\n";
		}
		
		
		
		
	}
}