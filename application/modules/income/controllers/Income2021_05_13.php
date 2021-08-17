<?php defined("BASEPATH") OR exit("No direct script access allowed");
class Income extends CI_Controller {
  	function __construct() {
	    parent::__construct();
	    $this->load->model("Income_model"); 
	    $this->lang->load(strtolower('Income'), 'english');
		if(true==1){
			is_login(); 
			$this->user_id =isset($this->session->get_userdata()['user_details'][0]->users_id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
		}else{ 	
			$this->user_id =1;
		}
  	}
  	/**
      * This function is used to view page
      */
  	public function index() {   
  		if(CheckPermission("income", "all_read,own_read")){
  			$con = '';
  			
			$data["view_data"]= $this->Income_model->get_data($con);
			if($con == '') {
				$this->load->view("include/header");
			}
			$this->load->view("index",$data);
			if($con == '') {
				$this->load->view("include/footer");
			}
		} else {
			$art_msg['msg'] = lang('you_do_not_have_permission_to_access'); 
			$art_msg['type'] = 'warning'; 
			$this->session->set_userdata('alert_msg', $art_msg);
            redirect( base_url().'user/profile', 'refresh');
		}
  	}

  	

  	/**
      * This function is used to Add and update data
      */
	public function add_edit() {	
		$data = $this->input->post();
		$postoldfiles = array();
		foreach ($data as $okey => $ovalue) {
    		if(strstr($okey, "wpb_old_")) {
			$postoldfiles[$okey]=$ovalue;
    		}
		}
		foreach ($_FILES as $fkey => $fvalue) {
			foreach($fvalue['name'] as $key => $fileInfo) {
				if(!empty($_FILES[$fkey]['name'][$key])){
					$filename=$_FILES[$fkey]['name'][$key];
					$tmpname=$_FILES[$fkey]['tmp_name'][$key]; 
					$exp=explode('.', $filename);
					$ext=end($exp);
					$newname=  $exp[0].'_'.time().".".$ext; 
					$config['upload_path'] = 'assets/images/';
					$config['upload_url'] =  base_url().'assets/images/';
					$config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
					$config['max_size'] = '2000000'; 
					$config['file_name'] = $newname;
					$this->load->library('upload', $config);
					//move_uploaded_file($tmpname,"assets/images/".$newname);
					if ( ! $this->upload->do_upload($fkey)) {
			           /* $art_msg['msg'] = $this->upload->display_errors(); 
						$art_msg['type'] = 'success'; 
						$this->session->set_userdata('alert_msg', $art_msg);*/
						//return FALSE;
			        }
					$newfiles[$fkey][]=$newname;
				}
				else{
					$newfiles[$fkey]='';
			
				}
			}
			if(!empty($postoldfiles)) {

				if(!empty($postoldfiles['wpb_old_'.$fkey])){
					$oldfiles = $postoldfiles['wpb_old_'.$fkey];
				}
				else{
					$oldfiles = array();
				}
				if(!empty($newfiles[$fkey])){
					$all_files = array_merge($oldfiles,$newfiles[$fkey]);	
				}
				else{
					$all_files = $postoldfiles['wpb_old_'.$fkey];
				}
					
			}
			else{
				$all_files = $newfiles[$fkey];
			}
			if(is_array($all_files) && !empty($all_files)) {
				$data[$fkey] = implode(',', $all_files);
			}
		}
		if($this->input->post('id')) {
			foreach ($postoldfiles as $pkey => $pvalue) {
				unset($data[$pkey]);		
			}
			unset($data['submit']);
			unset($data['save']);
			unset($data['id']);

			if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
                if(!empty($custom_fields)) {
                    foreach ($custom_fields as $cfkey => $cfvalue) {
                    	if(is_array($cfvalue)) {
                    		$custom_fields[$cfkey] = implode(',', $cfvalue);
                    		$cfvalue = implode(',', $cfvalue);
                    	}
                        $qr = "SELECT * FROM `cf_values` WHERE `rel_crud_id` = '".$this->input->post('id')."' AND `cf_id` = '".$cfkey."'";
                        $cf_data = $this->Income_model->getQrResult($qr);
                        if(is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                        "value" => $custom_fields[$cf_data[0]->cf_id],
                                    );
                            $this->Income_model->updateRow('cf_values', 'cf_values_id', $cf_data[0]->cf_values_id, $d);
                        } else {
                            $d = array(
                                    "rel_crud_id" => $this->input->post('id'),
                                    "cf_id" => $cfkey,
                                    "curd" => 'income',
                                    "value" => $cfvalue,
                                );
                            $this->Income_model->insertRow('cf_values', $d);
                        }
                    }
                }
            }
			
			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue); 
				}
			}
			$this->Income_model->updateRow('income', 'income_id', $this->input->post('id'), $data);
      		echo $this->input->post('id'); 
			exit;
		} else { 
			unset($data['submit']);
			unset($data['save']);
			$data['user_id']=$this->user_id;
			if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
            }
			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue); 
				}
			}
			$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			$last_id = $this->Income_model->insertRow('income', $data);
			if(!empty($custom_fields)) {
                foreach ($custom_fields as $cfkey => $cfvalue) {
                	if(is_array($cfvalue)) {
                		$cfvalue = implode(',', $cfvalue);
                	}
                    $d = array(
                                "rel_crud_id" => $last_id,
                                "cf_id" => $cfkey,
                                "curd" => 'income',
                                "value" => $cfvalue,
                            );
                    $this->Income_model->insertRow('cf_values', $d);
                }
            }
            echo $last_id;
			exit;
			/*$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			redirect('income');*/
		}
	}
	
	/**
      * This function is used to show popup for add and update
      */
	public function get_modal() {
		if($this->input->post('id')){
			$data['data']= $this->Income_model->Get_data_id($this->input->post('id'));
      		echo $this->load->view('add_update', $data, true);
	    } else {
	      	echo $this->load->view('add_update', '', true);
	    }
	    exit;
	}
	
	/**
      * This function is used to delete multiple records form table
      * @param : $ids is array if record id
      */
  	public function delete($ids) {
		$idsArr = explode('-', $ids);
		foreach ($idsArr as $key => $value) {
			$this->Income_model->delete_data($value);		
		}
		echo json_encode($idsArr); 
		exit;
		//redirect(base_url().'income', 'refresh');
  	}
  	/**
      * This function is used to delete single record form table
      * @param : $id is record id
      */
  	public function delete_data($id) { 
		$this->Income_model->delete_data($id);
		$art_msg['msg'] = lang('your_data_deleted_successfully'); 
		$art_msg['type'] = 'warning'; 
		$this->session->set_userdata('alert_msg', $art_msg);
	    redirect('income');
  	}
	/**
      * This function is used to create data for server side datatable
      */
  	public function ajx_data(){
		$primaryKey = 'income_id';
		$table 		= 'income';
		$joinQuery  =  "FROM income LEFT JOIN  `income_category` AS `income_category0` ON (`income_category0`.`income_category_id` = `income`.`income_category`) LEFT JOIN  `users` AS `income_users` ON (`income_users`.`users_id` = `income`.`user_id`) 
		  LEFT JOIN  `client_management` AS `client_management` ON (`client_management`.`client_management_id` = `income`.`client_id`)
";
		$columns 	= array(
array( 'db' => '`income`.`income_id` AS `income_id`', 'dt' => 0, 'field' => 'income_id' 	 ),
array( 'db' => '`income`.`income_date` AS `income_date`', 'dt' => 1, 'field' => 'income_date' ),
array( 'db' => '`client_management`.`name` AS `client_name`', 'dt' => 2, 'field' => 'client_name' ),
array( 'db' => '`income`.`income_description` AS `income_description`', 'dt' => 3, 'field' => 'income_description' ),
array( 'db' => '`income`.`send_date` AS `send_date`', 'dt' => 4, 'field' => 'send_date' ),
array( 'db' => '`income`.`currency_type` AS `currency_type`', 'dt' => 5, 'field' => 'currency_type' ),
array( 'db' => '`income`.`income_amount` AS `income_amount`', 'dt' => 6, 'field' => 'income_amount' ),
array( 'db' => '`income_category0`.`income_category_category_name` AS `income_category_category_name`', 'dt' => 7, 'field' => 'income_category_category_name' ),
array( 'db' => '`income_users`.`name` AS `user_name`', 'dt' => 8, 'field' => 'user_name' ),

);
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
	        $cf = get_cf('income');
	        if(is_array($cf) && !empty($cf)) {
	            foreach ($cf as $cfkey => $cfvalue) {
	                array_push($columns, array( 'db' => "cf_values_".$cfkey.".value AS cfv_".$cfkey, 'field' => "cfv_".$cfkey, 'dt' => count($columns) ));    
	                $joinQuery  .=  " LEFT JOIN `cf_values` AS cf_values_".$cfkey."  ON  `income`.`income_id` = `cf_values_".$cfkey."`.`rel_crud_id` AND `cf_values_".$cfkey."`.`cf_id` =  '".$cfvalue->custom_fields_id."' ";
	            }
	        }
			array_push($columns, array( 'db' => 'income.income_id AS income_id', 'field' => 'income_id', 'dt' => count($columns) ));
		$where = '';
		$j = 0;
		if(strpos($joinQuery, 'JOIN') > 0) {
			$j = 1;
		}
		$where = SSP::mkaFilter( $_GET, $columns, $j);
		if($this->input->get('dateRange')) {
			$date = explode(' - ', $this->input->get('dateRange'));
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		
		if(CheckPermission($table, "all_read")){}
		else if(CheckPermission($table, "own_read") && CheckPermission($table, "all_read")!=true){
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			//$where .= $and."`$table`.`user_id`=".$this->user_id." ";
			$where .= $and."`$table`.`user_id`!=1";//
		}
		
		$group_by = "";
		$having = "";

		$limit = SSP::limit( $_GET, $columns );
		$order = SSP::mkaorder( $_GET, $columns, $j );
		$col = SSP::pluck($columns, 'db', $j);

	   $query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$having." ".$order." ".$limit." ";
		$res = $this->db->query($query);
		$res = $res->result_array();
		$recordsTotal = $this->db->select("count('income') AS c")->get('income')->row()->c;
		$res = SSP::mka_data_output($columns, $res, $j);

		$output_arr['draw'] 			= intval( $_GET['draw'] );
		$output_arr['recordsTotal'] 	= intval( $recordsTotal );
		$output_arr['recordsFiltered'] 	= intval( $recordsTotal );
		$output_arr['data'] 			= $res;
		//$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where, $group_by, $having);
		foreach ($output_arr['data'] as $key => $value) 
		{
			$output_arr['data'][$key][0] = '
					<input type="checkbox" name="selData" id="mka_'.$key.'" value="'.$output_arr['data'][$key][0].'">
					<label for="mka_'.$key.'"></label>
				';
			$key_id = @array_pop(array_keys($output_arr['data'][$key]));
			$id = $output_arr['data'][$key][$key_id];
			$output_arr['data'][$key][$key_id] = '';
			
			if(CheckPermission($table, "all_update")){
			$output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
			}else if(CheckPermission($table, "own_update") && (CheckPermission($table, "all_update")!=true)){
				$user_id =getRowByTableColomId($table,$id,'id');
				if($user_id->user_id==$this->user_id){
			$output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
				}
			}
			
			if(CheckPermission($table, "all_delete")){
			$output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$id.', \''.$table.'\')"><i class="material-icons col-red font-20">delete</i></a>';}
			else if(CheckPermission($table, "own_delete") && (CheckPermission($table, "all_delete")!=true)){
				$user_id =getRowByTableColomId($table,$id,'id');
				if($user_id->user_id==$this->user_id){
			$output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$id.', \''.$table.'\')"><i class="material-icons col-red font-20">delete</i></a>';
				}
			}
			
		}
		echo json_encode($output_arr);
  	}
  	/**
      * This function is used to filter list view data by date range
      */
  	public function getFilterdata(){
  		$where = '';
		if($this->input->post('dateRange')) {
			$date = explode(' - ', $this->input->post('dateRange'));
			$where = " DATE_FORMAT(`income`.`".$this->input->post('colName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`income`.`".$this->input->post('colName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		$data["view_data"]= $this->Income_model->get_data($where);
		echo $this->load->view("tableData",$data, true);
		die;
  	}
}
?>