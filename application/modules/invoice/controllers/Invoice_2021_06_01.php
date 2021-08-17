<?php defined("BASEPATH") OR exit("No direct script access allowed");
class Invoice extends CI_Controller {
  	function __construct() {
	    parent::__construct();
	    $this->load->model("Invoice_model");
	    $this->load->model('invoice/Payment_model');
	    $this->lang->load(strtolower('Invoice'), 'english');
		if(true==1){
			is_login();
			$this->user_id =isset($this->session->get_userdata()['user_details'][0]->users_id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
		}else{
			$this->user_id =1;
		}
    $this->invoice_currency = array('USD'=>'USD','INR'=>'INR','AED'=>'AED','QAR'=>'QAR','GBP'=>'GBP','CAD'=>'CAD','SAR'=>'SAR','HKD'=>'HKD');
  	}
  	/**
      * This function is used to view page
      */
  	public function index() {
  		if(CheckPermission("invoice", "all_read,own_read")){
  			$con = '';

			$data["view_data"]= $this->Invoice_model->get_data($con);
			$data['payment'] = $this->Payment_model->get_data($con);
			/*$totalPaid = $this->Payment_model->getTotalPaidAmount(6);
			$data['totalPaid'] = $totalPaid;*/

			//print_r($data['payment']);
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

		$ajaxRateDataHour = $this->input->post('mainDataHourly');
		$ajaxRateDataMonth = $this->input->post('mainDataMonthly');
		$ajaxRateDataAtonce = $this->input->post('mainDataAtOnce');
    $invoice_currency= $this->input->post('invoice_currency');
    $created_at= $this->input->post('created_at');
		$clientInfo = $this->input->post('clientInfo');
    $is_paid = $this->input->post('is_paid');
    $note = $this->input->post('note');
		// ===
		$client_id = $this->input->post('client_id');
		// $project_description = $this->input->post('project_description');
		// $payment_type = $this->input->post('payment_type');
		$taxPercent = $this->input->post('taxPercent');
		$taxBoxPercent = $this->input->post('taxBoxPercent');
		// $amount = $this->input->post('amount');
	    $ajaxRateDataHourJson =	json_encode($ajaxRateDataHour);
	    $ajaxRateDataMonthJson = json_encode($ajaxRateDataMonth);
	    $ajaxRateDataAtonceJson = json_encode($ajaxRateDataAtonce);
      $data['is_paid'] = $is_paid;
      $data['note'] = $note;
      $data['invoice_date'] =  date('Y-m-d', strtotime($created_at));
      $data['invoice_currency'] = $invoice_currency;
	    $data['datajsonhour'] = $ajaxRateDataHourJson;
	    $data['datajsonmonth'] = $ajaxRateDataMonthJson;
	    $data['datajsonatonce'] = $ajaxRateDataAtonceJson;
	    $data['clientInfo'] = $clientInfo;
	    $data['client_id'] = $client_id;
      $data['customer_option'] = $this->input->post('customer_option');
	    // $data['project_description'] = $project_description;
	    // $data['payment_type'] = $payment_type;
	    $data['taxPercent'] = $taxPercent;
	    $data['taxBoxPercent'] = $taxBoxPercent;
	    // $data['amount'] = $amount;
	    // echo "<pre>";
	    // print_r($data);die;
    //  echo json_encode($data);die;
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
                        $cf_data = $this->Invoice_model->getQrResult($qr);
                        if(is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                        "value" => $custom_fields[$cf_data[0]->cf_id],
                                    );
                            $this->Invoice_model->updateRow('cf_values', 'cf_values_id', $cf_data[0]->cf_values_id, $d);
                        } else {
                            $d = array(
                                    "rel_crud_id" => $this->input->post('id'),
                                    "cf_id" => $cfkey,
                                    "curd" => 'income',
                                    "value" => $cfvalue,
                                );
                            $this->Invoice_model->insertRow('cf_values', $d);
                        }
                    }
                }
            }

			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue);
				}
			}
			$this->Invoice_model->updateRow('invoice', 'invoice_id', $this->input->post('id'), $data);
			/************Update Due Amount **********/
			$invoice_id = $this->input->post('id');
			$totalPaid = $this->Payment_model->getTotalPaidAmount($invoice_id);
			// if($totalPaid->total_paid!=''){
   //                  $dueamount = $data['amount'] - $totalPaid->total_paid;
   //                  $dueData = array('due_amount'=>$dueamount);
   //                  $this->Invoice_model->updateRow('invoice', 'invoice_id', $invoice_id, $dueData);

			// }
      		echo $this->input->post('id');
			exit;
		} else {
			// print_r($data); die;
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
      // echo '<pre>';
      // print_r($data);die;
			// if ($data['taxPercent'] != 0) {
			// 	$amount = $data['amount'];
			// 	$pecrentOfTax = $data['taxBoxPercent'];
			// 	$taxAmount = ($amount*$pecrentOfTax)/100;
			// 	$data['amount'] =$data['amount'] + $taxAmount;
			// }
			// $data['due_amount'] = $data['amount'];
			$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			$last_id = $this->Invoice_model->insertRow('invoice', $data);
      //echo $this->db->last_query(); echo '<br>'.$last_id;die;
			$invoice_id =  str_pad($last_id, 8, "0", STR_PAD_LEFT);
			$invoiceData = array('invoice_no'=>'INV#'.$invoice_id);
			$this->Invoice_model->updateRow('invoice', 'invoice_id', $last_id, $invoiceData);
			if(!empty($custom_fields)) {
                foreach ($custom_fields as $cfkey => $cfvalue) {
                	if(is_array($cfvalue)) {
                		$cfvalue = implode(',', $cfvalue);
                	}
                    $d = array(
                                "rel_crud_id" => $last_id,
                                "cf_id" => $cfkey,
                                "curd" => 'invoice',
                                "value" => $cfvalue,
                            );
                    $this->Invoice_model->insertRow('cf_values', $d);
                }
            }
            $arrayName = array('sucess' => 'Data Inserted Successfully !!');

            $returnData = json_encode($arrayName);
            echo "Inserted";
           die;
            // return $returnData;
            // echo $last_id;
			// return 0;
			/*$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			redirect('income');*/
		}
	}

	/**
      * This function is used to show popup for add and update
      */
	public function get_modal() {
    $data['currency'] = $this->invoice_currency;
		if($this->input->post('id')){
			$data['data']= $this->Invoice_model->Get_data_id($this->input->post('id'));
      		echo $this->load->view('add_update', $data, true);
	    } else {
	      	echo $this->load->view('add_update', $data, true);
	    }
	    exit;
	}

	public function add_payment(){
		$data = $this->input->post();
		if($data['invoice_id']!=''){
			unset($data['submit']);
			unset($data['save']);

			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue);
				}
			}
			$data['user_id']=$this->user_id;
			//$data['due_amount'] = $data['amount'];
			$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			$last_id = $this->Payment_model->insertRow('payment', $data);

			$due_amount = 0;
			$invoice_id = $data['invoice_id'];
			$totalPaid = $this->Payment_model->getTotalPaidAmount($invoice_id);
			if($totalPaid->total_paid!=''){
				$invoiceData = $this->Invoice_model->Get_data_id($invoice_id);
				if($invoiceData->invoice_id){
                    $dueamount = $invoiceData->amount - $totalPaid->total_paid;
                    $dueData = array('due_amount'=>$dueamount);
                    $this->Invoice_model->updateRow('invoice', 'invoice_id', $invoice_id, $dueData);
				}

			}

            echo $last_id;
			exit;
		}
	}


	public function get_payment_modal() {
		if($this->input->post('id')){
			$data['data']= $this->Invoice_model->Get_data_id($this->input->post('id'));
			$data['payment']= $this->Payment_model->Get_payment_by_invoice($this->input->post('id'));
      		echo $this->load->view('add_payment', $data, true);
	    } else {
	      	echo $this->load->view('add_payment', '', true);
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
			$this->Invoice_model->delete_data($value);
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
		$this->Invoice_model->delete_data($id);
		$art_msg['msg'] = lang('your_data_deleted_successfully');
		$art_msg['type'] = 'warning';
		$this->session->set_userdata('alert_msg', $art_msg);
	    redirect('income');
  	}
	/**
      * This function is used to create data for server side datatable
      */
  	public function ajx_data(){
    $user_detail = $this->session->get_userdata()['user_details'][0];
		$primaryKey = 'invoice_id';
		$table 		= 'invoice';
		$joinQuery  =  "FROM invoice LEFT JOIN  `users` AS `users` ON (`users`.`users_id` = `invoice`.`user_id`)
		  LEFT JOIN  `client_management` AS `client_management` ON (`client_management`.`client_management_id` = `invoice`.`client_id`)
";
		$columns 	= array(
array( 'db' => '`invoice`.`invoice_id` AS `invoice_id`', 'dt' => 0, 'field' => 'invoice_id' 	 ),
array( 'db' => '`invoice`.`invoice_no` AS `invoice_no`', 'dt' => 1, 'field' => 'invoice_no' ),
array( 'db' => '`invoice`.`created_at` AS `created_at`', 'dt' => 2, 'field' => 'created_at' ),
array( 'db' => '`invoice`.`invoice_date` AS `invoice_date`', 'dt' => 3, 'field' => 'invoice_date' ),
array( 'db' => '`client_management`.`name` AS `client_name`', 'dt' => 4, 'field' => 'client_name' ),

// array( 'db' => '`invoice`.`payment_type` AS `payment_type`', 'dt' => 4, 'field' => 'payment_type' ),
// array( 'db' => '`invoice`.`amount` AS `amount`', 'dt' => 5, 'field' => 'amount' ),
// array( 'db' => '`invoice`.`due_amount` AS `due_amount`', 'dt' => 6, 'field' => 'due_amount' ),
array( 'db' => '`users`.`name` AS `user_name`', 'dt' => 5, 'field' => 'user_name' ),
array( 'db' => '`invoice`.`is_paid` AS `is_paid`', 'dt' => 6, 'field' => 'is_paid' ),
);

			error_reporting(E_ALL);
			ini_set('display_errors', 1);

			array_push($columns, array( 'db' => 'invoice.invoice_id AS invoice_id', 'field' => 'invoice_id', 'dt' => count($columns) ));
      array_push($columns, array( 'db' => '`invoice`.`clientInfo` AS `clientInfo`', 'dt' => 7, 'field' => 'clientInfo'));
      array_push($columns, array( 'db' => '`invoice`.`customer_option` AS `customer_option`', 'dt' => 8, 'field' => 'customer_option'));

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
      if(!empty($user_detail->visible_user_invoice)){
          $other_users_id = $user_detail->visible_user_invoice.','.$this->user_id;
          $where .= $and."`$table`.`user_id` IN ($other_users_id)";
      }
      else{
        $where .= $and."`$table`.`user_id`=".$this->user_id." ";
      }
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
    foreach($res as $key_s => $resValue){
      if(isset($resValue['customer_option']) && $resValue['customer_option'] == 1){
          $clientInfo = json_decode($resValue['clientInfo']);
          $res[$key_s]['client_name'] = $clientInfo->client_name;
          unset($res[$key_s]['clientInfo']);unset($res[$key_s]['customer_option']);
      }

    }
    // echo json_encode($res);
     unset($columns[8]);unset($columns[9]);
     $columns = array_values($columns);
    // print_r($columns);die;
		$recordsTotal = $this->db->select("count('invoice') AS c")->get('invoice')->row()->c;
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

			// if(CheckPermission($table, "all_update")){
			// $output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
			// }else if(CheckPermission($table, "own_update") && (CheckPermission($table, "all_update")!=true)){
			// 	$user_id =getRowByTableColomId($table,$id,'id');
			// 	if($user_id->user_id==$this->user_id){
			// $output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
			// 	}
			// }

			// if(CheckPermission($table, "all_delete")){
			// $output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$id.', \''.$table.'\')"><i class="material-icons col-red font-20">delete</i></a>';
		// }
			// else if(CheckPermission($table, "own_delete") && (CheckPermission($table, "all_delete")!=true)){
				$user_id =getRowByTableColomId($table,$id,'id');
				if($user_id->user_id==$this->user_id || $user_detail->user_type == 'admin'){
			       $output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$id.', \''.$table.'\')"><i class="material-icons col-red font-20">delete</i></a>';
				}
			// }

			// if(CheckPermission($table, "add_payment")){
				$user_id =getRowByTableColomId($table,$id,'id');
			// 	if($user_id->user_id==$this->user_id){
			// $output_arr['data'][$key][$key_id] .= '<a sty id="btnAddPaymentRow" class="mClass add_payment"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('add_payment').'"><i class="material-icons">add</i></a>';
			// 	}
        $output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
				$output_arr['data'][$key][$key_id] .= '<a sty id="btnDownloadPdf" class="mClass download_pdf"  href="http://delimp.co.in/delimp_expense/index.php/invoice/get_pdf?id='.$id.'" type="button" target="_blank" data-src="'.$id.'" title="'.'PDF Download'.'"><i class="fa fa-file-pdf-o" style="font-size:24px"></i></a>';
			}

		// }
		echo json_encode($output_arr);
  	}
  	/**
      * This function is used to filter list view data by date range
      */
  	public function getFilterdata(){
  		$where = '';
		if($this->input->post('dateRange')) {
			$date = explode(' - ', $this->input->post('dateRange'));
			$where = " DATE_FORMAT(`invoice`.`".$this->input->post('colName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`invoice`.`".$this->input->post('colName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		$data["view_data"]= $this->Invoice_model->get_data($where);
		echo $this->load->view("tableData",$data, true);
		die;
  	}

  	public function get_pdf() {
  	//header('Content-Type: application/pdf');
  		$id = $_REQUEST['id'];
		if(isset($id))
		{
			$data['data']= $this->Invoice_model->Get_data_id($id);
      // echo '<pre>';print_r($data['data']);die;
			$htmlArrayData = (array)$data['data'];
			$clientId = $htmlArrayData['client_id'];
			$data['client']= $this->Invoice_model->Get_client_data($clientId);

	        //load the view and saved it into $html variable
	        $htmlView=$this->load->view('invoice_pdf', $data, true);
	 		// echo $this->load->view('invoice_pdf', $data, true);
	        //this the the PDF filename that user will get to download
	        $pdfFilePath = "output_pdf_name.pdf";

	        //load mPDF library
	        $this->load->library('m_pdf');

	       //generate the PDF from the given htmlView
	        $this->m_pdf->pdf->WriteHTML($htmlView);

	        //download it.
	        //$this->m_pdf->pdf->Output();
          $file_name = $data['data']->invoice_no.'.pdf';
          $this->m_pdf->pdf->Output($file_name, 'I');
	         // $this->m_pdf->pdf->Output('test.pdf','D');
	         exit;
	    } else {
	      	echo $this->load->view('invoice_pdf', '', true);
	    }
	    exit;
	}
}
?>
