<?php 
defined('BASEPATH') OR 	exit('Note Allowed'); 


class Home extends CI_Controller{

	//Número fixo de mesas para procura; 

	private $maxNumMesas = 10; 

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
		$this->load->model('cliente_model'    , 'cliente');
		$this->load->model('garcom_model'     , 'garcom');
		$this->load->model('item_model'       , 'item');
		$this->load->model('pedido_model'     , 'pedido');
		$this->load->model('pedidotem_model'  , 'tem');

		$mesasStatus = array(); 
		//Verificar quais mesas estão ocupadas ou vazias: 
		for($a = 1; $a <= $this->maxNumMesas; $a++ ){
			$temp['mesa_num'   ] = $a; 
			$temp['mesa_status'] = $this->pedido->mesaOcupada($a); 

			array_push($mesasStatus, $temp); 
		}

		$mesas = array(); 
		//Carregar status de uma mesa aqui
		foreach($mesasStatus as $mesaStatus){
			
			//Se a mesa está ocupada, pequeo o id do pedido referente; 
			$idPedido = -1; 			
			if($mesaStatus['mesa_status'])
				$idPedido = $this->pedido->idPedidoPelaMesa($mesaStatus['mesa_num']); 
			
			//Se o id for diferente de -1, retorne os dados do pedido; 
			$pedido = null; 
			if($idPedido != -1)
				$pedido = $this->pedido->pedidoPeloId($idPedido);

			//Se o pedido for nullo, não execute o restante do código. 
			if($pedido == null)
				continue; 

			//capturando dados adicionais 
			$itensPedido = $this->pedido->retornarItens($pedido->id); 
			$cliente     = $this->cliente->peloId($pedido->cliente_id); 

			$temp['pedido'     ] = $pedido; 
			$temp['itensPedido'] = $itensPedido; 
			$temp['cliente'    ] = $cliente; 

			array_push($mesas, $temp); 
		}

		$data['mesas'     ] = $mesas; 
		$data['todosItens'] = $this->item->todos(); 
		
		$this->load->view('home_view', $data);
	}

	public function liberar(){
		$this->load->model('pedido_model', 'pedido'); 

		$data['aberto'] = false; 

		$idPedido = $this->input->post('id_pedido'); 

		if($this->pedido->atualizar($data, $idPedido))
			die(json_encode(array('status' => true, 'msg' => 'Mesa liberada com sucesso.'))); 
		else
			die(json_encode(array('status' => false, 'msg' => "Erro na persistência do Pedido."))); 
	}
}