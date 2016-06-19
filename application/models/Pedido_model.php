<?php 
defined('BASEPATH') OR exit("Not Allowed"); 

class Pedido_model extends CI_Model{
	
	public function __construct(){
		parent::__construct(); 
	}


	//Criando um novo pedido. 
	public function criar($pedido){
		$this->db->insert('pedido', $pedido);
		return $this->db->insert_id();  
	}


	//Pegar todos os pedidos em aberto. 
	public function todos(){
		$query = $this->db->get('pedido'); 
		return $query->result(); 
	}

	public function pedidoPeloId($id){
		$this->db->where('id', $id); 
		$query = $this->db->get('pedido'); 
		return $query->row(); 
	}

	public function retornarItens($idPedido){
		//select nome, descricao, valor from item as i, pedido_has_item as ph where i.id = ph.item_id and ph.pedido_id = 34; 
		$this->db
				 ->select('nome, descricao, valor, quantidade')
				 ->from('item as i, pedido_has_item as ph')
				 ->where('i.id = ph.item_id')
				 ->where('ph.pedido_id', $idPedido);

		$query = $this->db->get(); 

	   return $query->result(); 
	}

	public function mesaOcupada($numeroMesa){
		$this->db	
				 ->select('id')
				 ->from('pedido')
				 ->where('numero_mesa', $numeroMesa)
				 ->where('aberto', 1); 
		
		$query = $this->db->get(); 

		return ($query->num_rows() > 0 ); 
	}

	//Este método só funciona se a mesa estiver ocupada; 
	public function idPedidoPelaMesa($numeroMesa){
		$this->db
				 ->select('id')
				 ->from('pedido')
				 ->where('aberto', 1)
				 ->where('numero_mesa', $numeroMesa); 

	   $query = $this->db->get(); 

	   if($query->num_rows() < 1 )
	   		return -1; 

	   	return $query->row()->id; 
	}
}