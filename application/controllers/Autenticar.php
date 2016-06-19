<?php 
defined('BASEPATH') OR exit('Not Allowed'); 

class Autenticar extends CI_Controller{
	
	public function index(){
		$this->load->view('login_view'); 
	}

	//Método para autenticação
	public function auth(){
		//Dados para o login: 
		//login; 
		//senha. 

		//Carregando modelo de login e adicionando um alias (login)
		$this->load->model('autenticar_model'); 

		$login = $this->input->post('login'); 
		$senha = $this->input->post('senha'); 

		$id = $this->autenticar_model->validarUsuario($login, $senha); 

		if($id == -1)
			die(json_encode(array('status' => false, 'msg' => 'Usuário ou senha não existem'))); 

		$this->autenticar_model->registrarLogin($login, $id); 

		die(json_encode(array('status' => true, 'msg' => $id))); 
	}

	//Limpar os dados da sessão do usuário;
	public function sair(){
		$this->load->model('autenticar_model', 'autenticar');
		$this->autenticar->limparLogin();  
		redirect('login'); 
	}

}