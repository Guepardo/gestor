<?php 
defined('BASEPATH') OR exit("Not Allowed"); 


class Cliente extends CI_Controller{

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

	}

	public function cadastrar(){
		//Dados do usuário: 
		//nome; 
		//e-mail; 
		//idade; 
		//endereco; 

		//Carregando biblioteca de validação de input. 
		$this->load->library('form_validation'); 

		$val = $this->form_validation; 

		//Administrando nome de variáveis, nome do label de saída e regra de validação. 
		$val->set_rules('nome'    , 'Nome'     , 'required|max_length[50]');
		$val->set_rules('email'   , 'Email'    , 'required|trim|valid_email|max_length[400]|is_unique[cliente.email]');
		$val->set_rules('idade'   , 'Idade'    , 'required|less_than[150]|greater_than[0]');
		$val->set_rules('endereco', 'Endereco' , 'required|trim|max_length[1500]');

		//Enviado informações via Ajax case aconteça algum erro. 
		if(!$val->run()) 
			die(json_encode(array("status" => false, "msg" => $val->error_array()))); 
		
		//Carregando dados para inserção no cliente
		$cliente['nome'    ] = $this->input->post('nome'); 
		$cliente['email'   ] = $this->input->post('email'); 
		$cliente['idade'   ] = $this->input->post('idade'); 
		$cliente['endereco'] = $this->input->post('endereco'); 

		//Carregando modelo do cliente. 
		$this->load->model('cliente_model'); 

		//Manipulando um posssível erro na persistência dos dados. 
		if(!$this->cliente_model->cadastrar($cliente))
			die(json_encode(array('status' => true, 'msg' => "cliente cadastrado com sucessso.")));
		else 
		 	die(json_encode(array("status" => false, "msg" => "Erro na persistência de cliente"))); 
	}
}