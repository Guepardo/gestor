<?php 
defined('BASEPATH') OR exit("Not Allowed"); 

class Pedido_model extends CI_Model{
	
	public function __construct(){
		parent::__construct(); 
	}


	//Criando um novo pedido. 
	public function criar($pedido){
		$this->db->insert('pedido', $pedido); 
	}


	//Pegar todos os pedidos em aberto. 
	public function todosAbertos(){
		$query = $this->db
						  ->select('*')
						  ->from('pedido')
						  //Somente se o pedido está aberto
						  ->where('aberto = 1'); 

		return $query->result(); 
	}

}