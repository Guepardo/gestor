<?php 
defined('BASEPATH') OR exit('Not Allowed'); 

class Garcom_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}


	//Cadastra um garçom
	public function cadastrar($garcom){
		$this->db->insert('garcom', $garcom); 
	}

	//Retorna todos os garçons 
	public function todos(){
		$query = $this->db->get('garcom'); 
		return $query->result(); 
	}	

	public function delete($id){
		$this->db->where("id = $id"); 
		return $this->db->delete('garcom'); 
	}

	public function nomePeloId($id){
		$this->db
				->select('login')
				->where("id = $id"); 

		$query = $this->db->get('garcom'); 
		return $query->result(); 
	}
	
}