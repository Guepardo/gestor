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

	//Lista todos os clientes na base dados; 
	public function listar(){
		//retorna uma variável chamada query; 
		$query = $this->db->get('cliente'); 
		return $query->result(); 
	}
}