<?php 
defined('BASEPATH') OR exit('Not Allowed'); 

class Pedidotem_model extends CI_Model{
	public function __construct(){
		parent::__construct(); 
	}

	public function adicionarItem($item){
		$this->db->insert('pedido_has_item', $item);
		return $this->db->insert_id();  
	}

}