<?php 
defined("BASEPATH") OR exit("not direct script access allowed"); 

class Teste extends CI_Controller{

	function _construtor(){

	}

	function get($segmento){
		$data = $this->uri->uri_to_assoc(1); //Pego todos os parâmetros dessa forma; 
		var_dump($data); 
		var_dump($segmento); 
		//$this->load->view('clientes'); 
	}

	function post(){
		//Funcionando bem. 
		var_dump($this->input->post());
	}

}