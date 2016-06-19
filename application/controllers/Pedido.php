<?php
defined('BASEPATH') OR exit("Not Allowed"); 

class Pedido extends CI_Controller{

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
	
	//Carrega a página index para o cadastro de um pedido; 
	public function index(){
		$this->load->model('pedido_model' , 'pedido');  
		$this->load->model('item_model'   , 'item'); 
		$this->load->model('cliente_model', 'cliente');

		$pedidos = $this->pedido->todos(); 

		$lista = array(); 

		foreach($pedidos as $pedido){
			$itemLista['id'] = $pedido->id; 

			$itens = $this->pedido->retornarItens($pedido->id);

			$valor = 0; 
			foreach($itens as $item)
				$valor += $item->valor * $item->quantidade; 

			$itemLista['valor'      ] = "R$ ".$valor; 
			$itemLista['status'     ] = ($pedido->aberto) ? "Ocupada no momento" : "Arquivo"; 
			$itemLista['numero_mesa'] = $pedido->numero_mesa; 

			array_push($lista, $itemLista); 
		}
		
		$data['pedidos'      ] = $lista; 
		$data['todosItens'   ] = $this->item->todos(); 
		$data['todosClientes'] = $this->cliente->todos(); 

		$this->load->view("pedido_view", $data); 
	}

	public function criar(){
		//Dados do pedido: 
		//descricao;
		//aberto; (é opcional)
		//numero_mesa;
		//cliente_id

		//Carregando modelo do cliente. 
		$this->load->model('pedido_model', 'pedido'); 

		//Validação para ver se a mesa está vazia: 
		if($this->pedido->mesaOcupada($this->input->post('numero_mesa')))
			die(json_encode(array('status' => false, 'msg' => "Mesa ocupada no momento, Tente outra."))); 

		//Carregando biblioteca de validação de input. 
		$this->load->library('form_validation'); 

		$val = $this->form_validation; 

		//Administrando nome de variáveis, nome do label de saída e regra de validação. 
		$val->set_rules('cliente_id' , 'Id do Cliente'   , 'required|numeric');
		$val->set_rules('descricao'  , 'Descrição'       , 'required|max_length[1500]'); 
		$val->set_rules('numero_mesa', 'Número da Mesa'  , 'required|less_than[1000]|greater_than[0]'); 

		//Enviado informações via Ajax case aconteça algum erro. 
		if(!$val->run())
			die(json_encode(array('status' => false, 'msg' => $val->error_string()))); 

		//Carregando dados para inserção no cliente
		$pedido['descricao'  ] = $this->input->post('descricao'); 
		$pedido['numero_mesa'] = $this->input->post('numero_mesa'); 
		$pedido['cliente_id' ] = $this->input->post('cliente_id'); 
		$pedido['carcom_id'  ] = $this->session->userdata('id'); 
		$pedido['aberto'     ] = true; 

		//Capturando o id do pedido recém cadastrado; 
		$idPedido = $this->pedido->criar($pedido); 

		if($idPedido == -1 )//Não sei ao certo qual é a condição de erro aqui, and then.. 
			die(json_encode(array('status' => false, 'msg' => "Erro na persistência do pedido"))); 
		

		//Obtendo array de itens do método post
		$itens = $this->input->post('item'); 

		//Carregando modelo do pedido_has_item: 
		$this->load->model('pedidotem_model','tem'); 

		//Registrando cada item ao pedido recém cadastrado; 
		foreach ($itens as $item){
			$pedaco = explode('-', $item); 
			
			$itemTemp['pedido_id' ] = $idPedido;
			$itemTemp['item_id'   ] = $pedaco[0];
			$itemTemp['quantidade'] = $pedaco[1]; 

			$this->tem->adicionarItem($itemTemp); 
		}

		//Enviando informação de que tudo ocorreu bem; 
		die(json_encode(array('status' => true, 'msg' => 'Pedido cadastrado com sucesso.'))); 
	}
} 