<?php defined("BASEPATH") OR exit("No direct script access allowed");
class Client_management extends CI_Controller {
  	function __construct() {
	    parent::__construct();
	    $this->load->model("Client_management_model"); 
	    $this->lang->load(strtolower('Client_management'), 'english');
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
  		if(CheckPermission("client_management", "all_read,own_read")){
  			$con = '';
  			
			$data["view_data"]= $this->Client_management_model->get_data($con);
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
		
		if($this->input->post('id')) {
			foreach ($postoldfiles as $pkey => $pvalue) {
				unset($data[$pkey]);		
			}
			unset($data['submit']);
			unset($data['save']);
			unset($data['id']);

			
			
			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue); 
				}
			}
			$this->Client_management_model->updateRow('client_management', 'client_management_id', $this->input->post('id'), $data);
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
			$last_id = $this->Client_management_model->insertRow('client_management', $data);			
            echo $last_id;
			exit;
			/*$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			redirect('income_category');*/
		}
	}
	
	/**
      * This function is used to show popup for add and update
      */
	public function get_modal() {
		//print_r($this->input->post('id'));
		if($this->input->post('id')){			
			$data['data']= $this->Client_management_model->Get_data_id($this->input->post('id'));
			//$print_r($data);
			//exit;
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
			$this->Client_management_model->delete_data($value);		
		}
		echo json_encode($idsArr); 
		exit;
		//redirect(base_url().'income_category', 'refresh');
  	}
  	/**
      * This function is used to delete single record form table
      * @param : $id is record id
      */
  	public function delete_data($id) { 
		$this->Client_management_model->delete_data($id);
		$art_msg['msg'] = lang('your_data_deleted_successfully'); 
		$art_msg['type'] = 'warning'; 
		$this->session->set_userdata('alert_msg', $art_msg);
	    redirect('income_category');
  	}
	/**
      * This function is used to create data for server side datatable
      */
  	public function ajx_data(){
		$primaryKey = 'client_management_id';
		$table 		= 'client_management';
		$joinQuery  =  "FROM client_management LEFT JOIN  `users` AS `added_users` ON (`added_users`.`users_id` = `client_management`.`user_id`)
";
		$columns 	= array(
array( 'db' => '`client_management`.`client_management_id` AS `client_management_id`', 'dt' => 0, 'field' => 'client_management_id' 	 ),
array( 'db' => '`client_management`.`name` AS `name`', 'dt' => 1, 'field' => 'name' ),
array( 'db' => '`client_management`.`description` AS `description`', 'dt' => 2, 'field' => 'description' ),
array( 'db' => '`client_management`.`status` AS `status`', 'dt' => 3, 'field' => 'status' ),
array( 'db' => '`added_users`.`name` AS `user_name`', 'dt' => 4, 'field' => 'user_name' ),
);
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
	       
			array_push($columns, array( 'db' => 'client_management.client_management_id AS client_management_id', 'field' => 'client_management_id', 'dt' => count($columns) ));
		$where = '';
		$j = 0;
		if(strpos($joinQuery, 'JOIN') > 0) {
			$j = 1;
		}
		$where = SSP::mkaFilter( $_GET, $columns, $j);
		/*if($this->input->get('dateRange')) {
			$date = explode(' - ', $this->input->get('dateRange'));
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}*/
		
		if(CheckPermission($table, "all_read")){}
		else if(CheckPermission($table, "own_read") && CheckPermission($table, "all_read")!=true){
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."`$table`.`user_id`=".$this->user_id." ";
		}
		
		$group_by = "";
		$having = "";

		$limit = SSP::limit( $_GET, $columns );
		$order = SSP::mkaorder( $_GET, $columns, $j );
		$col = SSP::pluck($columns, 'db', $j);

		$query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$having." ".$order." ".$limit." ";
		$res = $this->db->query($query);
		$res = $res->result_array();
		$recordsTotal = $this->db->select("count('client_management') AS c")->get('client_management')->row()->c;
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
  

  	public function checkClientName(){
  		$data = $this->input->post();
  		//print_r($data);
  		if($data['name']!=''){
		      $table = 'client_management';
		      $sql = "SELECT client_management_id, name FROM client_management WHERE name = '{$data['name']}'";

		      if($data['id']!==''){
                 $sql = $sql." AND client_management_id!='{$data['id']}'";
		      }
             
             $result = $this->Client_management_model->getQrResult($sql);
             //print_r($result);
             if(count($result))
             	echo 'false';
             else
             	echo 'true';
             exit;
		  }

  	}
}
?>