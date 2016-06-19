<?php 
defined('BASEPATH') OR 	exit('Note Allowed'); 


class Home extends CI_Controller{

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
		$this->load->view('home_view');
	}
}