<?php 
defined('BASEPATH') OR exit('Not Allowed'); 

class Item extends CI_Controller{
	
	public function __construct(){
		parent::__construct(); 
		//Carregando modelo de autenticação
		$this->load->model('autenticar_model', 'autenticar'); 

		//Verificando se o usuário está logado ou não
		if(!$this->autenticar->statusLogin()){
			//Aplicando valor a uma flashdata para utilização na home
			$this->session->set_flashdata('bloqueado', true); 
			//Redirecionando para a tela de login
			redirect('login'); 
		}else
			$this->session->set_flashdata('bloqueado', false);
	}

	public function index(){
		$this->load->model('item_model', 'item'); 
		
		$data['itens'] = $this->item->todos(); 
		
		$this->load->view('item_view', $data);
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
		$val->set_rules('nome'     , 'Nome'     , 'required|max_length[45]|min_length[3]|is_unique[item.nome]'); 
		$val->set_rules('descricao', 'Descrição', 'required|max_length[1400]|min_length[3]'); 
		$val->set_rules('valor'    , 'Valor'    , 'required|numeric'); 

		//Enviado informações via Ajax case aconteça algum erro. 
		if(!$val->run())
			die(json_encode(array('status' => false, 'msg' => $val->error_string()))); 

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


	//Deleta um garçom pelo id; 
	public function deletar(){
		$this->load->model('item_model', 'item'); 

		$id = $this->input->post('id'); 

		if( !is_numeric($id) )
			die(json_encode(array('status' => false, 'msg' => "Valor da id é vazia"))); 

		if($this->item->delete($id))
			die(json_encode(array('status' => true, 'msg' => 'Item deletado com sucesso.'))); 
		else
			die(json_encode(array('status' => false, 'msg' => "Erro na persistência do Item"))); 
	}
}