<?php 
defined('BASEPATH') OR exit("Not Allowed"); 


class Garcom extends CI_Controller{

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
		$this->load->model('garcom_model', 'garcom');
		
		$data['garcons'] = $this->garcom->todos(); 

		$this->load->view('garcom_view', $data); 
	} 

	public function cadastrar(){
		//Dados do garçom: 
		//login; 
		//senha. 

		//Carregando biblioteca de validação de input. 
		$this->load->library('form_validation'); 

		$val = $this->form_validation; 

		//Administrando login de variáveis, login do label de saída e regra de validação. 
		$val->set_rules('login'      , 'login'      , 'required|min_length[3]|max_length[45]|is_unique[garcom.login]'); 
		$val->set_rules('senha'      , 'Senha'      , 'required'); 
		$val->set_rules('confirmacao', 'Confirmação', 'matches[senha]'); 

		//Enviado informações via Ajax case aconteça algum erro. 
		if(!$val->run())
			die(json_encode(array('status' => false, 'msg' => $val->error_string()))); 

		//Carregando dados para inserção no cliente
		$garcom['login' ] = $this->input->post('login');
		$garcom['senha' ] = $this->input->post('senha'); 

		//Carregando modelo do cliente. 
		$this->load->model('garcom_model'); 

		//Manipulando um posssível erro na persistência dos dados. 
		if(!$this->garcom_model->cadastrar($garcom))
			die(json_encode(array('status' => true, 'msg' => 'Garcom cadastrado com sucesso.'))); 
		else
			die(json_encode(array('status' => false, 'msg' => "Erro na persistência do Garcom"))); 
	}

	//Deleta um garçom pelo id; 
	public function deletar(){
		$this->load->model('garcom_model', 'garcom'); 

		$id = $this->input->post('id'); 

		if( !is_numeric($id) )
			die(json_encode(array('status' => false, 'msg' => "Valor da id é vazia"))); 

		if($this->garcom->delete($id))
			die(json_encode(array('status' => true, 'msg' => 'Garcom deletado com sucesso.'))); 
		else
			die(json_encode(array('status' => false, 'msg' => "Erro na persistência do Garcom"))); 
	}

}