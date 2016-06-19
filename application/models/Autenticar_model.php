<?php 
defined('BASEPATH') OR exit('Not Allowed'); 

class Autenticar_model extends CI_Model{
	
	public function __construct(){
		parent::__construct(); 
	}

	//Retorna verdade se o usuário está cadastrado no banco de dados; 
	public function validarUsuario($login, $senha){
		$this->db->select('id')
							   ->from('garcom')
							   ->where("login", $login)
							   ->where("senha", $senha); 

		$query = $this->db->get(); 

		if($query->num_rows() == 1 )
		 	return $query->first_row()->id;
		 else
		 	return -1;  
	}

	//Registra as informações do usuário na sessão corrente
	public function registrarLogin($login, $id){
		$data = array(
						 'login' => $login, 
						 'id'    => $id,
						 'logado'=> true
					 ); 

		$this->session->set_userdata($data); 
	}

	//Vereficar status de login
	//Obs: Esse método não ficou muito elegante, no entanto, irá funcionar; 
	public function statusLogin(){
		$logado = $this->session->userdata('logado'); 

		if( is_null($logado) || !$logado )
			return false; 

		return true; 
	}

	public function limparLogin(){
		$this->session->sess_destroy(); 
	}

}