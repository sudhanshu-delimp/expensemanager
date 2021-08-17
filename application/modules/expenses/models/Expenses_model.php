<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses_model extends CI_Model {       
	function __construct(){            
    parent::__construct();
    $this->load->database();
		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->users_id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
	} 
	
	/**
      * This function is get table data by id
      * @param : $id is value of expenses_id
      */
	public function Get_data_id($id='') {
		 $this->db->select('*');
		 $this->db->from('expenses');
		 $this->db->where('expenses_id' , $id);
		 $query = $this->db->get();
		 return $result = $query->row();
	}
	
	/**
      * This function is get data for front end datatable
      * @param : $con is where condition for select query
      */
	public function get_data($con=NULL) {
		if(CheckPermission('expenses', "own_read") && CheckPermission('expenses', "all_read")!=true){
			if($con != '') {
				$con .= " AND "; 
			}
			$con .= "  (`expenses`.`user_id` = '".$this->user_id."') ";
		}
		$sql = "SELECT *, `expense_category0`.expense_category_category_name as expense_category_expense_category_category_name FROM  `expenses` LEFT JOIN `expense_category` AS `expense_category0` ON (`expense_category0`.`expense_category_id` = `expenses`.`expenses_category`)";
		if($con != '') {
			$sql .= ' WHERE '.$con;	
		}
		$qr = $this->db->query($sql);
		return $qr->result();
	}

	/**
      * This function is used to delete record from table
      * @param : $id record id which you want to delete
      */
	public function delete_data($id='') {
		$this->db->where('expenses_id', $id);
    	$this->db->delete('expenses');
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