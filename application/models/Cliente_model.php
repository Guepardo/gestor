<?php 
defined("BASEPATH") OR exit("Not Allowed"); 


class Cliente_model extends CI_Model{

	public function __construct (){
		parent::__construct(); 
	}

	//Cadastra um novo cliente na base de dados 
	public function cadastrar($cliente){
		$this->db->insert('cliente', $cliente); 
	}

	public function peloId($id){
		$this->db->where('id', $id); 
		$query = $this->db->get('cliente'); 

		if($query->num_rows() < 1 )
			return -1;

		return $query->row(); 
	}
	
	//Lista todos os clientes na base dados; 
	public function todos(){
		//retorna uma variável chamada query; 
		$query = $this->db->get('cliente'); 
		return $query->result(); 
	}
}