<?php 
defined('BASEPATH') OR exit('Not Allowed'); 

class Item extends CI_Controller{
	
	public function index(){

	}

	public function cadastrar(){
		//dados de um Item
		//nome; 
		//descricao; 
		//valor

		//Carregando biblioteca de validação de input. 
		$this->load->library('form_validation'); 

		$val = $this->form_validation; 

		//Administrando nome de variáveis, nome do label de saída e regra de validação. 
		$val->set_rules('nome'     , 'Nome'     , 'required|max_length[45]|min_length[3]'); 
		$val->set_rules('descricao', 'Descrição', 'required|max_length[1400]|min_length[3]'); 
		$val->set_rules('valor'    , 'Valor'    , 'required|numeric'); 

		//Enviado informações via Ajax case aconteça algum erro. 
		if(!$val->run())
			die(json_encode(array('status' => false, 'msg' => $val->error_array()))); 

		//Carregando dados para inserção no cliente
		$item['nome']      = $this->input->post('nome');
		$item['descricao'] = $this->input->post('descricao');
		$item['valor']     = $this->input->post('valor'); 

		//Carregando modelo do cliente. 
		$this->load->model('item_model'); 

		//Manipulando um posssível erro na persistência dos dados. 
		if(!$this->item_model->cadastrar($item))
			die(json_encode(array('status' => true, 'msg' => 'Item cadastrado com sucesso.'))); 
		else
			die(json_encode(array('status' => false, 'msg' => "Erro na persistência do Item"))); 
	}
}