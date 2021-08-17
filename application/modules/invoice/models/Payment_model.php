<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {       
	function __construct(){            
    parent::__construct();
    $this->load->database();
		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->users_id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
	} 
	
	/**
      * This function is get table data by id
      * @param : $id is value of income_id
      */
	public function Get_data_id($id='') {
		 $this->db->select('*');
		 $this->db->from('payment');
		 $this->db->where('payment_id' , $id);
		 $query = $this->db->get();
		 return $result = $query->row();
	}
	

	public function Get_payment_by_invoice($invoiceID='') {
		 $this->db->select('*');
		 $this->db->from('payment');
		 $this->db->where('invoice_id' , $invoiceID);
		 $query = $this->db->get();
		 return $result = $query->result();
	}
	
	/**
      * This function is get data for front end datatable
      * @param : $con is where condition for select query
      */
	public function get_data($con=NULL) {
		if(CheckPermission('payment', "own_read") && CheckPermission('payment', "all_read")!=true){
			if($con != '') {
				$con .= " AND "; 
			}
			$con .= "  (`payment`.`user_id` = '".$this->user_id."') ";
		}
		$sql = "SELECT * FROM  `payment` ";
		if($con != '') {
			$sql .= ' WHERE '.$con;	
		}
		$qr = $this->db->query($sql);
		return $qr->result();
	}

	public function getTotalPaidAmount($invoiceID){
      $sql = "SELECT sum(amount) as total_paid FROM payment where invoice_id='{$invoiceID}'";
      $exe = $this->db->query($sql);
  		return $exe->row();
	}

	/**
      * This function is used to delete record from table
      * @param : $id record id which you want to delete
      */
	public function delete_data($id='') {
		$this->db->where('payment_id', $id);
    	$this->db->delete('payment');
	}

	/**
      * This function is used to Insert Record in table
      * @param : $table - table name in which you want to insert record 
      * @param : $data - record array 
      */
	public function insertRow($table, $data){
	  	$this->db->insert($table, $data);
	  	return  $this->db->insert_id();
	}

	/**
      * This function is used to Update Record in table
      * @param : $table - table name in which you want to update record 
      * @param : $col - field name for where clause 
      * @param : $colVal - field value for where clause 
      * @param : $data - updated array 
      */
  	public function updateRow($table, $col, $colVal, $data) {
  		$this->db->where($col,$colVal);
		$this->db->update($table,$data);
		return true;
  	}


  	public function getQrResult($qr) {
  		$exe = $this->db->query($qr);
  		return $exe->result();
  	}
}?>