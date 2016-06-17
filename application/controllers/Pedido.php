<?php
defined('BASEPATH') OR exit("Not Allowed"); 

class Pedido extends CI_Controller{
	
	public function index(){

	}

	public function criar(){
		//Dados do pedido: 
		//descricao;
		//aberto; (é opcional)
		//numero_mesa;
		//cliente_id

		//Carregando biblioteca de validação de input. 
		$this->load->library('form_validation'); 

		$val = $this->form_validation; 

		//Administrando nome de variáveis, nome do label de saída e regra de validação. 
		$val->set_rules('cliente_id' , 'Id do Cliente'   , 'required|numeric');
		$val->set_rules('descricao'  , 'Descrição'       , 'required|max_length[1500]'); 
		$val->set_rules('numero_mesa', 'Número da Mesa'  , 'required|less_than[1000]|greater_than[0]'); 

		//Enviado informações via Ajax case aconteça algum erro. 
		if(!$val->run())
			die(json_encode(array('status' => false, 'msg' => $val->error_array()))); 

		//Carregando dados para inserção no cliente
		$pedido['descricao'  ] = $this->input->post('descricao'); 
		$pedido['numero_mesa'] = $this->input->post('numero_mesa'); 
		$pedido['cliente_id' ] = $this->input->post('cliente_id'); 

		//Carregando modelo do cliente. 
		$this->load->model('pedido_model'); 

		//Manipulando um posssível erro na persistência dos dados. 
		if(!$this->pedido_model->criar($pedido))
			die(json_encode(array('status' => true, 'msg' => 'Pedido cadastrado com sucesso.'))); 
		else
			die(json_encode(array('status' => false, 'msg' => "Erro na persistência do pedido"))); 
	}
} 