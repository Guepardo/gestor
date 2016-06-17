<?php 
defined('BASEPATH') OR exit('Not Allowed'); 


class Item_model extends CI_Model{

	public function __construct(){
		parent::__construct(); 
	}


	//Cadastrar num novo item. 
	public function cadastrar($item){
		$this->db->insert('item', $item); 
	}

	//Pegar todos os itens. 
	public function todosItens(){
		$query = $this->db->get('item'); 
		return $query->result(); 
	}
}