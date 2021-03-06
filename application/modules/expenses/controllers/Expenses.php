<?php defined("BASEPATH") OR exit("No direct script access allowed");
class Expenses extends CI_Controller {
  	function __construct() {
	    parent::__construct();
	    $this->load->model("Expenses_model");
	    $this->lang->load(strtolower('Expenses'), 'english');
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
  		if(CheckPermission("expenses", "all_read,own_read")){
  			$con = '';

			$data["view_data"]= $this->Expenses_model->get_data($con);
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
                        $cf_data = $this->Expenses_model->getQrResult($qr);
                        if(is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                        "value" => $custom_fields[$cf_data[0]->cf_id],
                                    );
                            $this->Expenses_model->updateRow('cf_values', 'cf_values_id', $cf_data[0]->cf_values_id, $d);
                        } else {
                            $d = array(
                                    "rel_crud_id" => $this->input->post('id'),
                                    "cf_id" => $cfkey,
                                    "curd" => 'expenses',
                                    "value" => $cfvalue,
                                );
                            $this->Expenses_model->insertRow('cf_values', $d);
                        }
                    }
                }
            }

			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue);
				}
			}
			$this->Expenses_model->updateRow('expenses', 'expenses_id', $this->input->post('id'), $data);
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
			$last_id = $this->Expenses_model->insertRow('expenses', $data);
			if(!empty($custom_fields)) {
                foreach ($custom_fields as $cfkey => $cfvalue) {
                	if(is_array($cfvalue)) {
                		$cfvalue = implode(',', $cfvalue);
                	}
                    $d = array(
                                "rel_crud_id" => $last_id,
                                "cf_id" => $cfkey,
                                "curd" => 'expenses',
                                "value" => $cfvalue,
                            );
                    $this->Expenses_model->insertRow('cf_values', $d);
                }
            }
            echo $last_id;
			exit;
			/*$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			redirect('expenses');*/
		}
	}

	/**
      * This function is used to show popup for add and update
      */
	public function get_modal() {
		if($this->input->post('id')){
			$data['data']= $this->Expenses_model->Get_data_id($this->input->post('id'));
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
			$this->Expenses_model->delete_data($value);
		}
		echo json_encode($idsArr);
		exit;
		//redirect(base_url().'expenses', 'refresh');
  	}
  	/**
      * This function is used to delete single record form table
      * @param : $id is record id
      */
  	public function delete_data($id) {
		$this->Expenses_model->delete_data($id);
		$art_msg['msg'] = lang('your_data_deleted_successfully');
		$art_msg['type'] = 'warning';
		$this->session->set_userdata('alert_msg', $art_msg);
	    redirect('expenses');
  	}
	/**
      * This function is used to create data for server side datatable
      */
  	public function ajx_data(){
		$primaryKey = 'expenses_id';
		$table 		= 'expenses';
		$joinQuery  =  "FROM expenses LEFT JOIN  `expense_category` AS `expense_category0` ON (`expense_category0`.`expense_category_id` = `expenses`.`expenses_category`) LEFT JOIN  `users` AS `expense_users` ON (`expense_users`.`users_id` = `expenses`.`user_id`)
";
		$columns 	= array(
array( 'db' => '`expenses`.`expenses_id` AS `expenses_id`', 'dt' => 0, 'field' => 'expenses_id' 	 ),
array( 'db' => '`expenses`.`expenses_date` AS `expenses_date`', 'dt' => 1, 'field' => 'expenses_date' ),
array( 'db' => '`expenses`.`expenses_description` AS `expenses_description`', 'dt' => 2, 'field' => 'expenses_description' ),
array( 'db' => '`expenses`.`expenses_amount` AS `expenses_amount`', 'dt' => 3, 'field' => 'expenses_amount' ),
array( 'db' => '`expense_category0`.`expense_category_category_name` AS `expense_category_category_name`', 'dt' => 4, 'field' => 'expense_category_category_name' ),
array( 'db' => '`expense_users`.`name` AS `user_name`', 'dt' => 5, 'field' => 'user_name' ),
);
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
	        $cf = get_cf('expenses');
	        if(is_array($cf) && !empty($cf)) {
	            foreach ($cf as $cfkey => $cfvalue) {
	                array_push($columns, array( 'db' => "cf_values_".$cfkey.".value AS cfv_".$cfkey, 'field' => "cfv_".$cfkey, 'dt' => count($columns) ));
	                $joinQuery  .=  " LEFT JOIN `cf_values` AS cf_values_".$cfkey."  ON  `expenses`.`expenses_id` = `cf_values_".$cfkey."`.`rel_crud_id` AND `cf_values_".$cfkey."`.`cf_id` =  '".$cfvalue->custom_fields_id."' ";
	            }
	        }
			array_push($columns, array( 'db' => 'expenses.expenses_id AS expenses_id', 'field' => 'expenses_id', 'dt' => count($columns) ));
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
			$where .= $and."`$table`.`user_id`=".$this->user_id." ";
			//$where .= $and."`$table`.`user_id`!=1";//
		}

		$group_by = "";
		$having = "";

		$limit = SSP::limit( $_GET, $columns );
		$order = SSP::mkaorder( $_GET, $columns, $j );
		$col = SSP::pluck($columns, 'db', $j);

		$query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$having." ".$order." ".$limit." ";
		$res = $this->db->query($query);
		$res = $res->result_array();
		$recordsTotal = $this->db->select("count('expenses') AS c")->get('expenses')->row()->c;
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
			$where = " DATE_FORMAT(`expenses`.`".$this->input->post('colName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`expenses`.`".$this->input->post('colName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		$data["view_data"]= $this->Expenses_model->get_data($where);
		echo $this->load->view("tableData",$data, true);
		die;
  	}
}
?>
